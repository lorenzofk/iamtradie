<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\FindUserByTwilioNumberAction;
use App\Events\IncomingTextMessageReceived;
use App\Events\VoicemailTranscriptionReceived;
use App\Http\Requests\AfterRecordRequest;
use App\Http\Requests\IncomingTextRequest;
use App\Http\Requests\TranscriptionRequest;
use App\Models\User;
use App\Services\TwilioService;
use App\Services\VoicemailService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Twilio\TwiML\VoiceResponse;

class TwilioController extends Controller
{
    public function __construct(
        private readonly TwilioService $twilioService,
        private readonly VoicemailService $voicemailService
    ) {}

    /**
     * Receive the voicemail recording after a missed call.
     */
    public function afterRecord(AfterRecordRequest $request, FindUserByTwilioNumberAction $findUserAction)
    {
        Log::withContext(['action' => 'after-record', 'data' => $request->validated()]);

        try {
            $user = $findUserAction->execute($request->getCalledNumber());

            Log::info('[AFTER RECORD] - Creating voicemail record.', ['user_id' => $user->id]);

            $this->voicemailService->createVoicemailRecord(
                $request->getCallSid(),
                $request->getFromNumber() ?? '',
                $request->getCallerCountry() ?? '',
                $request->getDirection(),
                $request->getCallStatus(),
                $request->getRecordingSid(),
                $request->getRecordingUrl(),
                $request->getRecordingDuration(),
                $request->getDigits(),
                $user->id
            );

            Log::info('[AFTER RECORD] - Voicemail record created successfully.');
        } catch (Exception $e) {
            Log::error('[AFTER RECORD] - Error processing voicemail recording', [
                'call_sid' => $request->getCallSid() ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        // Always return success to prevent Twilio from retrying the request.
        return response()->noContent();
    }

    /**
     * Handle the missed call scenario.
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
     * Handle the transcription of the voicemail.
     */
    public function transcription(TranscriptionRequest $request, FindUserByTwilioNumberAction $findUserAction): Response
    {
        Log::withContext(['action' => 'transcription', 'data' => $request->validated()]);

        try {
            $user = $findUserAction->execute($request->getCalled());

            Log::info('[TRANSCRIPTION] - New voicemail transcription received. Firing the event to process it.', ['user_id' => $user->id]);

            VoicemailTranscriptionReceived::dispatch(
                $request->getCaller(),
                $request->getCalled(),
                $request->getCallSid(),
                $request->getTranscription(),
                $user
            );
        } catch (Exception $e) {
            Log::error('[TRANSCRIPTION] - Error processing voicemail transcription.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        // Always return success to prevent Twilio from retrying the request.
        return response()->noContent();
    }

    /**
     * Handle the incoming text message.
     */
    public function incomingText(IncomingTextRequest $request, FindUserByTwilioNumberAction $findUserAction): Response
    {
        Log::withContext(['action' => 'incoming-text', 'data' => $request->validated()]);

        try {
            $user = $findUserAction->execute($request->getTwilioNumber());

            Log::info('[INCOMING TEXT] - New incoming text message received. Firing the event to process it.', ['user_id' => $user->id]);

            IncomingTextMessageReceived::dispatch(
                $request->getMessageBody(),
                $request->getLeadNumber(),
                $request->getTwilioNumber(),
                $request->getSmsId(),
                $user
            );

            return response()->noContent();
        } catch (Exception $e) {
            Log::error('[INCOMING TEXT] - Error processing incoming text message.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response('error', 500);
        }
    }

    /**
     * Handle the incoming call.
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
