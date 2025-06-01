
<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateQuoteRequest;
use App\Http\Requests\ImproveQuoteRequest;
use App\Services\OpenAIService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OpenAIController extends Controller
{
    private OpenAIService $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    /**
     * Generate a quote response using OpenAI
     */
    public function generateQuote(GenerateQuoteRequest $request): JsonResponse
    {
        $user = $request->user();
        $userSettings = $user->userSettings;

        $response = $this->openAIService->generateQuoteResponse(
            clientMessage: $request->input('client_message'),
            jobType: $userSettings->industry_type ?? 'general trades',
            location: $request->input('location'),
            calloutFee: $userSettings->callout_fee,
            hourlyRate: $userSettings->hourly_rate,
            responseTone: $userSettings->response_tone ?? 'polite',
            preferredCta: $userSettings->preferred_cta,
            tradieFirstName: $user->first_name
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

    /**
     * Analyze job complexity
     */
    public function analyzeJob(Request $request): JsonResponse
    {
        $request->validate([
            'client_message' => 'required|string|max:1000',
            'job_type' => 'required|string|max:100'
        ]);

        $analysis = $this->openAIService->analyzeJobComplexity(
            clientMessage: $request->input('client_message'),
            jobType: $request->input('job_type')
        );

        return response()->json([
            'success' => true,
            'analysis' => $analysis
        ]);
    }

    /**
     * Generate SMS-optimized response
     */
    public function generateSmsResponse(Request $request): JsonResponse
    {
        $request->validate([
            'client_message' => 'required|string|max:1000'
        ]);

        $user = $request->user();
        $userSettings = $user->userSettings;

        $response = $this->openAIService->generateSmsResponse(
            clientMessage: $request->input('client_message'),
            jobType: $userSettings->industry_type ?? 'general trades',
            calloutFee: $userSettings->callout_fee,
            hourlyRate: $userSettings->hourly_rate,
            responseTone: $userSettings->response_tone ?? 'polite',
            tradieFirstName: $user->first_name
        );

        return response()->json([
            'success' => true,
            'sms_response' => $response,
            'character_count' => strlen($response)
        ]);
    }
}
