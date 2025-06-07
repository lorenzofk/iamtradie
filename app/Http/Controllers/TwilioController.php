<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\OpenAIService;
use App\Services\TwilioService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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

    public function text(Request $request): JsonResponse
    {
        $twilioNumber = $request->input('To');
        $leadNumber = $request->input('From');
        $body = $request->input('Body');
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

        $quoteData = [
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

        Quote::create($quoteData);

        if ($settings->auto_send_sms) {
            $this->twilioService->send(to: $leadNumber, from: $twilioNumber, message: $aiResponse);
        }

        return response()->json();
    }

    public function voice(): Response
    {
        $tradieMobile = '+61492912358';

        $response = new VoiceResponse();
        $response->dial($tradieMobile, [
            'timeout' => 10,
            'maxLength' => 30,
            'action' => route('twilio.missedCall'),
            'method' => 'POST',
        ])->setCallerId('+61489279785');

        return response($response)->header('Content-Type', 'text/xml');
    }

    public function afterRecord(Request $request)
    {
        Log::info('Recording complete', $request->all());
    }

    public function missedCall(): Response
    {
        try {
            $response = new VoiceResponse();
    
            $response->say("Sorry I missed your call. Leave a quick message with the job and we’ll text asap.");
            $response->record([
                'transcribe' => 'true',
                'transcribeCallback' => route('twilio.transcription'),
                'action' => route('twilio.afterRecord'),
                'method' => 'POST',
                'maxLength' => '30',
                'timeout' => '3',
            ]);
            
    
            return response($response)->header('Content-Type', 'text/xml');
        } catch (Exception $e) {
            Log::error('Missed call error', ['message' => $e->getMessage()]);
            return response('<?xml version="1.0" encoding="UTF-8"?><Response><Say>We had an issue.</Say></Response>', 200)->header('Content-Type', 'text/xml');
        }
    }

    public function transcription(Request $request)
    {
        $caller = $request->input('From');
        $called = $request->input('Called');
        $text = $request->input('TranscriptionText');

        $user = User::whereHas('settings', fn ($query) => $query->where('agent_sms_number', $called))->firstOrFail();

        $settings = $user->settings;

        throw_if(empty($settings), new Exception('Twilio number not configured for user'));

        $quote = $this->openAIService->generateQuoteResponse(
            message: $text,
            industryType: $settings->industry_type->value,
            calloutFee: $settings->callout_fee,
            hourlyRate: $settings->hourly_rate,
            responseTone: $settings->response_tone->value,
            firstName: $user->first_name
        );

        $this->twilioService->send(to: $caller, from: $settings->agent_sms_number, message: $quote);

        return response('OK', 200);
    }

}