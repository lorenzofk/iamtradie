
<?php

namespace App\Http\Controllers;

use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TwilioController extends Controller
{
    public function __construct(
        private readonly TwilioService $twilioService
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

    public function validatePhone(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $isValid = $this->twilioService->validatePhoneNumber($request->input('phone'));

        return response()->json([
            'valid' => $isValid,
            'message' => $isValid ? 'Valid phone number' : 'Invalid phone number'
        ]);
    }

    public function getAccountInfo(): JsonResponse
    {
        $balance = $this->twilioService->getAccountBalance();
        $phoneNumbers = $this->twilioService->listPhoneNumbers();

        return response()->json([
            'balance' => $balance,
            'phone_numbers' => $phoneNumbers,
            'success' => true
        ]);
    }

    public function webhook(Request $request): JsonResponse
    {
        // Handle incoming Twilio webhooks (SMS replies, delivery receipts, etc.)
        $messageBody = $request->input('Body');
        $fromNumber = $request->input('From');
        $toNumber = $request->input('To');

        // Log the incoming message
        \Log::info('Twilio webhook received', [
            'from' => $fromNumber,
            'to' => $toNumber,
            'body' => $messageBody
        ]);

        // You can add custom logic here to handle incoming messages
        // For example, auto-replies, saving to database, etc.

        return response()->json(['status' => 'success']);
    }
}
