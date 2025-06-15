<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\QuoteStatus;
use App\Models\Quote;
use App\Services\TwilioService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class QuoteController extends Controller
{
    public function __construct(
        private readonly TwilioService $twilioService
    ) {}

    /**
     * Display a listing of the quotes.
     */
    public function index(): Response
    {
        $quotes = Auth::user()->quotes()->latest()->get();

        $props = [
            'quotes' => fn () => $quotes,
        ];

        return Inertia::render('Quotes/index', $props);
    }

    /**
     * Display the specified quote.
     */
    public function show(Quote $quote): Response
    {
        $props = [
            'quote' => fn () => $quote,
        ];

        return Inertia::render('Quotes/Show', $props);
    }

    /**
     * Delete the specified quote.
     */
    public function destroy(Quote $quote): JsonResponse
    {
        try {
            $quote->delete();
        } catch (Exception) {
            return response()->json(['message' => 'Error deleting quote'], status: 500);
        }

        return response()->json(status: 204);
    }

    /**
     * Update the specified quote.
     */
    public function update(Quote $quote, Request $request): JsonResponse
    {
        $request->validate([
            'edited_response' => 'required|string',
        ]);

        $quote->update([
            'edited_response' => $request->edited_response,
        ]);

        return response()->json($quote);
    }

    /**
     * Send a quote to the customer via SMS
     */
    public function send(Quote $quote): JsonResponse
    {
        try {
            $this->twilioService->send(to: $quote->from_number, from: $quote->to_number, message: $quote->edited_response ?? $quote->ai_response);
        } catch (Exception) {
            return response()->json(['message' => 'Error sending quote'], status: 500);
        }

        $quote->update([
            'status' => QuoteStatus::SENT,
            'sent_at' => now(),
        ]);

        return response()->json();
    }
}
