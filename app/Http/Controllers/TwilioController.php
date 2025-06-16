<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\FindUserByTwilioNumberAction;
use App\Enums\QuoteSource;
use App\Enums\QuoteStatus;
use App\Events\IncomingTextMessageReceived;
use App\Http\Requests\IncomingTextRequest;
use App\Models\Quote;
use App\Models\User;
use App\Models\Voicemail;
use App\Services\OpenAIService;
use App\Services\TwilioService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Twilio\TwiML\VoiceResponse;

class TwilioController extends Controller
{
    public function __construct(
        private readonly TwilioService $twilioService,
        private readonly OpenAIService $openAIService
    ) {}

    /**
     * This method handles the after record scenario.
     */
    public function afterRecord(Request $request)
    {
        Log::withContext(['action' => 'after-record', 'data' => $request->all()]);

        $data = $request->all();

        $user = User::whereHas(
            'settings',
            fn ($query) => $query->where('agent_sms_number', $data['Called'])
        )->first();

        throw_if(empty($user), new Exception('User not found for number'));

        $data = [
            'user_id' => $user->id,
            'call_sid' => $data['CallSid'],
            'from_number' => $data['From'] ?? $data['Caller'],
            'caller_country' => $data['CallerCountry'] ?? $data['FromCountry'],
            'direction' => $data['Direction'] ?? 'inbound',
            'call_status' => $data['CallStatus'] ?? 'completed',
            'recording_sid' => $data['RecordingSid'] ?? null,
            'recording_url' => $data['RecordingUrl'] ?? null,
            'recording_duration' => isset($data['RecordingDuration']) ? (int) $data['RecordingDuration'] : null,
            'digits' => $data['Digits'] ?? null,
        ];

        try {
            $voicemail = Voicemail::create($data);
            Log::info('[AFTER RECORD] - Voicemail record created', ['voicemail_id' => $voicemail->id]);
        } catch (Exception $e) {
            Log::error('[AFTER RECORD] - Failed to create voicemail record', ['error' => $e->getMessage(), 'data' => $data]);
        }

        return response()->noContent();
    }

    /**
     * This method handles the missed call scenario.
     */
    public function missedCall(Request $request): Response
    {
        Log::withContext(['action' => 'missed-call', 'data' => $request->all()]);

        $called = $request->input('To');
        $user = User::whereHas('settings', fn ($query) => $query->where('agent_sms_number', $called))->firstOrFail();

        $settings = $user->settings;
        $response = new VoiceResponse();

        try {
            $response->say($settings->voicemail_message);
            $response->record([
                'transcribe' => true,
                'transcribeCallback' => route('twilio.transcription'),
                'action' => route('twilio.after-record'),
                'method' => 'POST',
                'timeout' => $settings->call_ring_duration,
            ]);

            Log::info('[MISSED CALL] - Missed call response', ['response' => $response->asXML()]);

            return response($response->asXML())->header('Content-Type', 'text/xml');
        } catch (Exception $e) {
            Log::error('[MISSED CALL] - Error', ['message' => $e->getMessage()]);

            $response->say('Sorry, we have a technical issue. Please try again later.');

            return response($response->asXML())->header('Content-Type', 'text/xml');
        }
    }

    /**
     * This method handles the transcription of the voicemail.
     */
    public function transcription(Request $request): Response
    {
        Log::withContext(['action' => 'transcription', 'data' => $request->all()]);

        $caller = $request->input('From');
        $called = $request->input('Called');
        $callSid = $request->input('CallSid');
        $transcription = $request->input('TranscriptionText');

        $user = User::whereHas(
            'settings',
            fn ($query) => $query->where('agent_sms_number', $called)
        )->firstOrFail();

        $settings = $user->settings;

        throw_if(empty($settings), new Exception('Twilio number not configured for user'));

        $voicemail = $user->voicemails()->where('call_sid', $callSid)->first();

        if ($voicemail) {
            $voicemail->update([
                'transcription_text' => $transcription,
                'transcription_processed' => true,
            ]);
            Log::info('[TRANSCRIPTION] - Voicemail record updated with transcription', ['voicemail_id' => $voicemail->id]);
        } else {
            Log::warning('[TRANSCRIPTION] - Voicemail record not found', ['call_sid' => $callSid, 'user_id' => $user->id]);
        }

        Log::info('[TRANSCRIPTION] - Generating voicemail summary for the user...');

        $aiSummary = $this->openAIService->generateVoicemailSummaryForUser(
            transcription: $transcription,
            industryType: $settings->industry_type->value,
            calloutFee: $settings->callout_fee,
            hourlyRate: $settings->hourly_rate,
            userFirstName: $user->first_name
        );

        $fullSummaryMessage = '📞 Missed Call from '.$caller."\n".$aiSummary;

        try {
            $this->twilioService->send(to: $settings->phone_number, from: $called, message: $fullSummaryMessage);
            Log::info('[TRANSCRIPTION] - Summary SMS sent to user', ['to' => $settings->phone_number, 'summary' => $fullSummaryMessage]);
        } catch (Exception $e) {
            Log::error('[TRANSCRIPTION] - Failed to send summary SMS to user', ['error' => $e->getMessage(), 'to' => $settings->phone_number]);
        }

        if ($voicemail) {
            $voicemail->update(['summary_for_user' => $fullSummaryMessage]);
            Log::info('[TRANSCRIPTION] - Voicemail record updated with summary', ['voicemail_id' => $voicemail->id]);
        }

        if ($settings->auto_send_sms_after_voicemail) {
            Log::info('[TRANSCRIPTION] - Auto send SMS after voice mail is enabled. Generating quote response...');

            $quote = $this->openAIService->generateQuoteResponse(
                message: $transcription,
                industryType: $settings->industry_type->value,
                calloutFee: $settings->callout_fee,
                hourlyRate: $settings->hourly_rate,
                responseTone: $settings->response_tone->value,
                firstName: $user->first_name
            );

            $this->twilioService->send(to: $caller, from: $settings->agent_sms_number, message: $quote);

            Log::info('[TRANSCRIPTION] - Quote response generated and SMS sent', ['quote' => $quote]);

            if ($voicemail) {
                $voicemail->update([
                    'ai_response' => $quote,
                    'sms_sent' => true,
                    'sms_sent_at' => now(),
                ]);

                Log::info('[TRANSCRIPTION] - Voicemail record updated with AI response', ['voicemail_id' => $voicemail->id]);
            }
        }

        return response()->noContent();
    }

    /**
     * This method handles the text message scenario.
     * Refactored to use event-driven architecture with jobs and actions.
     */
    public function incomingText(IncomingTextRequest $request, FindUserByTwilioNumberAction $findUserAction): Response
    {
        Log::withContext(['action' => 'incoming-text', 'data' => $request->validated()]);

        try {
            // Find user using dedicated action
            $user = $findUserAction->execute($request->getTwilioNumber());

            Log::info('[INCOMING TEXT] - Processing incoming text message', [
                'user_id' => $user->id,
                'lead_number' => $request->getLeadNumber(),
                'message_preview' => substr($request->getMessageBody(), 0, 100) . '...',
            ]);

            // Dispatch event to trigger async processing
            IncomingTextMessageReceived::dispatch(
                $request->getMessageBody(),
                $request->getLeadNumber(),
                $request->getTwilioNumber(),
                $request->getSmsId(),
                $user
            );

            Log::info('[INCOMING TEXT] - Event dispatched for async processing');

            // Return immediate response to Twilio
            return response()->noContent();

        } catch (Exception $e) {
            Log::error('[INCOMING TEXT] - Error processing incoming text', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response('error', 500);
        }
    }

    /**
     * This method handles the incoming call scenario.
     */
    public function incomingCall(Request $request): Response
    {
        Log::withContext(['action' => 'incoming-call', 'data' => $request->all()]);

        $twilioNumber = $request->input('To');

        $user = User::whereHas('settings', fn ($query) => $query->where('agent_sms_number', $twilioNumber))->first();
        $settings = $user?->settings;

        $response = new VoiceResponse();

        if (empty($settings)) {
            $response->say('Sorry, we have a technical issue. Please try again later.');
            $response->hangup();

            return response($response->asXML())->header('Content-Type', 'text/xml');
        }

        if ($settings->call_forward_enabled) {
            Log::info('[INCOMING CALL] - Forwarding call to', ['phoneNumber' => $settings->phone_number, 'twilioNumber' => $twilioNumber]);

            $dial = $response->dial($settings->phone_number, [
                'timeout' => $settings->call_ring_duration,
                'action' => route('twilio.missed-call'),
                'method' => 'POST',
            ]);

            $dial->setCallerId($twilioNumber);

            return response($response->asXML())->header('Content-Type', 'text/xml');
        }

        Log::info('[INCOMING CALL] - Voicemail message', ['message' => $settings->voicemail_message]);
        Log::info('[INCOMING CALL] - Call ring duration', ['duration' => $settings->call_ring_duration]);

        $response->say($settings->voicemail_message);
        $response->record([
            'transcribe' => true,
            'transcribeCallback' => route('twilio.transcription'),
            'action' => route('twilio.after-record'),
            'method' => 'POST',
            'timeout' => $settings->call_ring_duration,
        ]);

        return response($response->asXML())->header('Content-Type', 'text/xml');
    }
}
