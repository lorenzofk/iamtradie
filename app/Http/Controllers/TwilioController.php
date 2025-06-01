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

class TwilioController extends Controller
{
    public function __construct(
        private readonly TwilioService $twilioService,
        private readonly OpenAIService $openAIService
    ) {}

    public function webhook(Request $request): JsonResponse
    {
        $twilioNumber = $request->input('To');
        $leadNumber = $request->input('From');
        $body = $request->input('Body');
        $smsId = $request->input('SmsMessageSid');

        $user = User::whereHas('twilioSettings', fn ($query) => $query->where('twilio_number', $twilioNumber))->firstOrFail();
        $settings = $user->getOrCreateSettings();

        throw_if(empty($settings), new Exception('Twilio number not configured for user'));
        throw_unless($settings->auto_send_sms, new Exception('Auto send SMS is not enabled'));

        $aiResponse = $this->openAIService->generateQuoteResponse(
            message: $body,
            industryType: $settings->industry_type->value,
            calloutFee: $settings->callout_fee,
            hourlyRate: $settings->hourly_rate,
            responseTone: $settings->response_tone->value,
            firstName: $user->first_name
        );

        // Store the quote
        Quote::create([
            'user_id' => $user->id,
            'message' => $body,
            'location' => null, // You may extract from message or add logic
            'industry_type' => $settings->industry_type,
            'ai_response' => $aiResponse,
            'edited_response' => null,
            'sent_at' => now(),
            'from_number' => $leadNumber,
            'to_number' => $twilioNumber,
            'sms_id' => $smsId,
            'status' => QuoteStatus::SENT,
            'source' => QuoteSource::SMS,
        ]);

        $this->twilioService->send(to: $leadNumber, from: $twilioNumber, message: $aiResponse);

        return response()->json();
    }
}