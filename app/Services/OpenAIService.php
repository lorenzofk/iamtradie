<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class OpenAIService
{
    public function __construct(
        private string $model = 'gpt-4o',
        private int $maxTokens = 200,
        private float $temperature = 0.7,
    ) {}

    public function generateQuoteResponse(
        string $clientMessage,
        string $jobType,
        ?string $location = null,
        ?float $calloutFee = null,
        ?float $hourlyRate = null,
        string $responseTone = 'polite',
        ?string $preferredCta = null,
        ?string $tradieFirstName = null
    ): string {
        try {
            $prompt = $this->buildQuotePrompt(
                $clientMessage,
                $jobType,
                $location,
                $calloutFee,
                $hourlyRate,
                $responseTone,
                $preferredCta,
                $tradieFirstName
            );

            $response = OpenAI::chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
            ]);

            return $response->choices[0]->message->content ?? $this->getFallbackResponse($tradieFirstName, $calloutFee, $hourlyRate, $preferredCta);

        } catch (Exception $e) {
            Log::error('OpenAI quote generation failed', [
                'error' => $e->getMessage(),
                'client_message' => $clientMessage,
                'job_type' => $jobType
            ]);

            return $this->getFallbackResponse($tradieFirstName, $calloutFee, $hourlyRate, $preferredCta);
        }
    }

    public function improveQuoteResponse(string $originalResponse, string $improvements): string
    {
        $prompt = "Please improve this quote response based on the following feedback:\n\n" .
                  "Original response:\n{$originalResponse}\n\n" .
                  "Improvements requested:\n{$improvements}\n\n" .
                  "Return an improved version that addresses the feedback while maintaining the Australian tradie tone and keeping it suitable for SMS.";

        try {
            $response = OpenAI::chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
            ]);

            return $response->choices[0]->message->content ?? $originalResponse;
        } catch (Exception $e) {
            Log::error('OpenAI quote improvement failed', [
                'error' => $e->getMessage(),
                'original_response' => $originalResponse,
                'improvements' => $improvements
            ]);

            return $originalResponse;
        }
    }

    private function buildQuotePrompt(
        string $clientMessage,
        string $jobType,
        ?string $location,
        ?float $calloutFee,
        ?float $hourlyRate,
        string $responseTone,
        ?string $preferredCta,
        ?string $tradieFirstName
    ): string {
        $toneInstructions = [
            'casual' => 'Use relaxed Aussie slang — G\'day, mate, no worries, emojis OK.',
            'polite' => 'Friendly and clear with light Aussie flavour. Avoid heavy slang.',
            'professional' => 'Professional but still local Aussie tone. No slang or emojis, but human.'
        ];

        $defaultCta = match ($responseTone) {
            'casual' => "Let me know if you'd like to lock it in 👍",
            'polite' => "Let me know if you'd like to book it in",
            default => "Please let me know if you'd like to proceed",
        };

        $locationText = $location ?? 'Not specified';
        $ctaText = $preferredCta ?? $defaultCta;
        $toneText = $toneInstructions[$responseTone] ?? '';

        $prompt = <<<EOT
        🎯 Goal: Generate a short SMS-style message replying to a job inquiry from an Australian tradie.

        📥 Client Message: "{$clientMessage}"
        💰 Pricing: \${$calloutFee} callout + \${$hourlyRate}/hr
        🗣️ Tone: {$responseTone} - {$toneText}
        👤 Tradie: {$tradieFirstName}
        📍 Location: {$locationText}

        ✅ Requirements:
        - Sound like a real Australian tradie
        - Use pricing info to give rough cost estimate
        - Mention time estimate if possible (e.g. "takes 1–2 hrs")
        - Avoid repeating the client's message
        - Keep under 160 characters
        - End with: "{$ctaText}"

        🚫 Don't:
        - Repeat what the client wrote
        - Add long intros
        - Sound robotic or corporate

        Generate the SMS reply:
        EOT;


        return $prompt;
    }

    private function getFallbackResponse(
        ?string $tradieFirstName,
        ?float $calloutFee,
        ?float $hourlyRate,
        ?string $preferredCta
    ): string {
        return "G'day! " .
            ($tradieFirstName ? "This is {$tradieFirstName}. " : '') .
            "Thanks for your inquiry. I'd be happy to help with your job. " .
            ($calloutFee ? "My standard callout is \${$calloutFee}. " : '') .
            ($hourlyRate ? "My hourly rate is \${$hourlyRate}. " : '') .
            "I'll need to assess the job to give you an accurate quote. " .
            ($preferredCta ?: "Please give me a call to discuss your requirements.");
    }
}
