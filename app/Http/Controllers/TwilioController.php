<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\OpenAIService;
use App\Services\TwilioService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TwilioController extends Controller
{
    public function __construct(
        private readonly TwilioService $twilioService,
        private readonly OpenAIService $openAIService
    ) {}

    public function sendMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'to' => 'required|string|max:20',
            'message' => 'required|string|max:1600',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $success = $this->twilioService->sendCustomMessage(
                Auth::user(),
                $request->input('to'),
                $request->input('message')
            );

            return response()->json([
                'success' => $success,
                'message' => $success ? 'Message sent successfully' : 'Failed to send message'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function sendQuote(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'quote_details' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $success = $this->twilioService->sendQuoteSms(
            Auth::user(),
            $request->only(['customer_name', 'customer_phone', 'quote_details'])
        );

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Quote sent successfully' : 'Failed to send quote'
        ]);
    }

    public function webhook(Request $request): JsonResponse
    {
        $twilioNumber = $request->input('To');
        $leadNumber = $request->input('From');
        $body = $request->input('Body');

        $user = User::whereHas('twilioSettings', fn ($query) => $query->where('twilio_number', $twilioNumber))->firstOrFail();

        $settings = $user->getOrCreateSettings();

        throw_if(empty($settings), new Exception('Twilio number not configured for user'));
        throw_unless($settings->auto_send_sms, new Exception('Auto send SMS is not enabled'));

        $message = $this->openAIService->generateQuoteResponse(
            message: $body,
            industryType: $settings->industry_type->value,
            calloutFee: $settings->callout_fee,
            hourlyRate: $settings->hourly_rate,
            responseTone: $settings->response_tone->value,
            firstName: $user->first_name
        );

        $this->twilioService->send(to: $leadNumber, from: $twilioNumber, message: $message);

        return response()->json();
    }
}