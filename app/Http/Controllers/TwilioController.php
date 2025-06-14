<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\OpenAIService;
use App\Services\TwilioService;
use Exception;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Voicemail;
use App\Enums\QuoteSource;
use App\Enums\QuoteStatus;
use Twilio\TwiML\VoiceResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
        
        $user = User::whereHas('settings', fn ($query) => 
            $query->where('agent_sms_number', $data['Called'])
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

            $response->say("Sorry, we have a technical issue. Please try again later.");

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

        $user = User::whereHas('settings', 
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
     */
    public function incomingText(Request $request): Response
    {
        Log::withContext(['action' => 'incoming-text', 'data' => $request->all()]);

        $body = $request->input('Body');
        $twilioNumber = $request->input('To');
        $leadNumber = $request->input('From');
        $smsId = $request->input('SmsMessageSid');

        $user = User::whereHas('settings', fn ($query) => $query->where('agent_sms_number', $twilioNumber))->firstOrFail();

        $settings = $user->settings;

        throw_if(empty($settings), new Exception('Twilio number not configured for user'));

        Log::info('[INCOMING TEXT] - Generating quote response...');

        $aiResponse = $this->openAIService->generateQuoteResponse(
            message: $body,
            industryType: $settings->industry_type->value,
            calloutFee: $settings->callout_fee,
            hourlyRate: $settings->hourly_rate,
            responseTone: $settings->response_tone->value,
            firstName: $user->first_name
        );

        Log::info('[INCOMING TEXT] - Quote response generated', ['quote' => $aiResponse]);

        $data = [
            'user_id' => $user->id,
            'message' => $body,
            'industry_type' => $settings->industry_type,
            'ai_response' => $aiResponse,
            'from_number' => $leadNumber,
            'to_number' => $twilioNumber,
            'sms_id' => $smsId,
            'source' => QuoteSource::SMS,
            'status' => $settings->auto_send_sms ? QuoteStatus::SENT : QuoteStatus::PENDING,
            'sent_at' => $settings->auto_send_sms ? now() : null,
        ];

        Quote::create($data);

        Log::info('[INCOMING TEXT] - Quote created', ['quote' => $data]);

        if ($settings->auto_send_sms) {
            Log::info('[INCOMING TEXT] - Auto send SMS is enabled. Sending SMS...');

            try {
                $this->twilioService->send(to: $leadNumber, from: $twilioNumber, message: $aiResponse);
            } catch (Exception $e) {
                Log::error('[INCOMING TEXT] - Error sending SMS', ['message' => $e->getMessage()]);
                return response('error', 500);
            }

            Log::info('[INCOMING TEXT] - SMS sent', ['to' => $leadNumber, 'from' => $twilioNumber, 'message' => $aiResponse]);
        }

        return response()->noContent();
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
            $response->say("Sorry, we have a technical issue. Please try again later.");
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