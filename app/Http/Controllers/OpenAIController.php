<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateQuoteRequest;
use App\Http\Requests\ImproveQuoteRequest;
use App\Services\OpenAIService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class OpenAIController extends Controller
{
    public function __construct(private readonly OpenAIService $openAIService) {}

    public function index(): Response
    {
        return Inertia::render('AI/QuoteGenerator');
    }

    /**
     * Generate a quote response using OpenAI
     */
    public function generateQuote(GenerateQuoteRequest $request): JsonResponse
    {
        $user = auth()->user();
        $userSettings = $user->getOrCreateSettings();

        $response = $this->openAIService->generateQuoteResponse(
            message: $request->input('message'),
            industryType: $userSettings->industry_type->value,
            calloutFee: $userSettings->callout_fee,
            hourlyRate: $userSettings->hourly_rate,
            responseTone: $userSettings->response_tone->value,
            preferredCta: $userSettings->preferred_cta,
            firstName: $user->first_name,
        );

        return response()->json([
            'success' => true,
            'response' => $response,
            'character_count' => strlen($response)
        ]);
    }

    /**
     * Improve an existing quote response
     */
    public function improveQuote(ImproveQuoteRequest $request): JsonResponse
    {
        $improvedResponse = $this->openAIService->improveQuoteResponse(
            originalResponse: $request->input('original_response'),
            improvements: $request->input('improvements')
        );

        return response()->json([
            'success' => true,
            'improved_response' => $improvedResponse,
            'character_count' => strlen($improvedResponse)
        ]);
    }
}
