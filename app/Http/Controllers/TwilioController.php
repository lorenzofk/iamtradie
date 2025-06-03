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
}