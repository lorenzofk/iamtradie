<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\OpenAIService;
use App\Services\TwilioService;
use Exception;
use Illuminate\Http\Request;
use App\Models\Quote;
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

    public function afterRecord(Request $request)
    {
        Log::info('Recording complete', $request->all());
    }

    public function missedCall(Request $request): Response
    {
        $called = $request->input('To');
        $user = User::whereHas('settings', fn ($query) => $query->where('agent_sms_number', $called))->firstOrFail();

        $settings = $user->settings;

        try {
            $response = new VoiceResponse();
    
            $response->say($settings->voicemail_message);
            $response->record([
                'transcribe' => true,
                'transcribeCallback' => route('twilio.transcription'),
                'action' => route('twilio.after-record'),
                'method' => 'POST',
                'maxLength' => 30,
                'timeout' => 3,
            ]);
            
    
            return response($response)->header('Content-Type', 'text/xml');
        } catch (Exception $e) {
            Log::error('Missed call error', ['message' => $e->getMessage()]);
            return response('<?xml version="1.0" encoding="UTF-8"?><Response><Say>We had an issue.</Say></Response>', 200)->header('Content-Type', 'text/xml');
        }
    }

    public function transcription(Request $request): Response
    {
        $caller = $request->input('From');
        $called = $request->input('Called');
        $text = $request->input('TranscriptionText');

        $user = User::whereHas('settings', fn ($query) => $query->where('agent_sms_number', $called))->firstOrFail();

        $settings = $user->settings;

        throw_if(empty($settings), new Exception('Twilio number not configured for user'));

        if ($settings->auto_send_sms_after_voicemail) {
            $quote = $this->openAIService->generateQuoteResponse(
                message: $text,
                industryType: $settings->industry_type->value,
                calloutFee: $settings->callout_fee,
                hourlyRate: $settings->hourly_rate,
                responseTone: $settings->response_tone->value,
                firstName: $user->first_name
            );

            $this->twilioService->send(to: $caller, from: $settings->agent_sms_number, message: $quote);
        }

        return response('OK', 200);
    }

    public function text(Request $request): Response
    {
        $body = $request->input('Body');
        $twilioNumber = $request->input('To');
        $leadNumber = $request->input('From');
        $smsId = $request->input('SmsMessageSid');

        $user = User::whereHas('settings', fn ($query) => $query->where('agent_sms_number', $twilioNumber))->firstOrFail();

        $settings = $user->settings;

        throw_if(empty($settings), new Exception('Twilio number not configured for user'));

        $aiResponse = $this->openAIService->generateQuoteResponse(
            message: $body,
            industryType: $settings->industry_type->value,
            calloutFee: $settings->callout_fee,
            hourlyRate: $settings->hourly_rate,
            responseTone: $settings->response_tone->value,
            firstName: $user->first_name
        );

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

        if ($settings->auto_send_sms) {
            $this->twilioService->send(to: $leadNumber, from: $twilioNumber, message: $aiResponse);
        }

        return response('OK', 200);
    }

    public function voice(Request $request): Response
    {
        $twilioNumber = $request->input('To');

        $user = User::whereHas('settings', fn ($query) => $query->where('agent_sms_number', $twilioNumber))->first();
        $settings = $user?->settings;

        $response = new VoiceResponse();

        if (empty($settings)) {
            $response->say("Sorry, we have a technical issue. Please try again later.");
            $response->hangup();

            return response($response)->header('Content-Type', 'text/xml');
        }

        if ($settings->call_forward_enabled) {
            Log::info('Forwarding call to', [
                'phoneNumber' => $settings->phone_number,
                'twilioNumber' => $twilioNumber,
                'route' => route('twilio.missed-call'),
            ]);

            $dial = $response->dial($settings->phone_number, [
                'timeout' => $settings->call_ring_duration,
                'maxLength' => 30,
                'action' => route('twilio.missed-call'),
                'method' => 'POST',
            ]);

            $dial->setCallerId($twilioNumber);
            
            return response($response)->header('Content-Type', 'text/xml');
        }

        $response->say($settings->voicemail_message);
        $response->record([
            'transcribe' => true,
            'transcribeCallback' => route('twilio.transcription'),
            'action' => route('twilio.after-record'),
            'method' => 'POST',
            'maxLength' => 30,
            'timeout' => $settings->call_ring_duration,
        ]);

        return response($response)->header('Content-Type', 'text/xml');
    }
}