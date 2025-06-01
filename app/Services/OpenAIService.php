<?php

namespace App\Services;

use App\Enums\ResponseTone;
use Exception;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class OpenAIService
{
    public function __construct(private ?string $model, private ?int $maxTokens, private ?float $temperature)
    {
        $this->model = config('services.openai.model');
        $this->maxTokens = config('services.openai.max_tokens');
        $this->temperature = config('services.openai.temperature');
    }

    public function generateQuoteResponse(
        string $message,
        string $industryType,
        ?string $location = null,
        ?float $calloutFee = null,
        ?float $hourlyRate = null,
        string $responseTone = 'polite',
        ?string $preferredCta = null,
        ?string $firstName = null
    ): string {
        try {
            $prompt = $this->buildQuotePrompt(
                $message,
                $industryType,
                $location,
                $calloutFee,
                $hourlyRate,
                $responseTone,
                $preferredCta,
                $firstName
            );

            $response = OpenAI::chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
            ]);

            return $response->choices[0]->message->content ?? $this->getFallbackResponse($firstName, $calloutFee, $hourlyRate, $preferredCta, $responseTone);

        } catch (Exception $e) {
            Log::error('OpenAI quote generation failed', [
                'error' => $e->getMessage(),
                'message' => $message,
                'industry_type' => $industryType
            ]);

            return $this->getFallbackResponse($firstName, $calloutFee, $hourlyRate, $preferredCta, $responseTone);
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
        string $industryType,
        ?string $location,
        ?float $calloutFee,
        ?float $hourlyRate,
        string $responseTone,
        ?string $preferredCta,
        ?string $firstName
    ): string {
        $locationText = $location ?? 'Not specified';
        $toneText = $this->getToneInstructions($responseTone, $industryType);
        $callToActionText = $preferredCta ?? $this->getDefaultCta($responseTone);

        $prompt = <<<EOT
        🎯 Goal: Generate a short SMS-style message replying to a job inquiry from an Australian tradie.

        📥 Client Message: "{$clientMessage}"
        💰 Pricing: \${$calloutFee} callout + \${$hourlyRate}/hr
        🗣️ Tone: {$responseTone} - {$toneText}
        👤 Tradie: {$firstName}
        📍 Location: {$locationText}

        ✅ Requirements:
        - Sound like a real Australian tradie
        - Use pricing info to give rough cost estimate
        - Mention time estimate if possible (e.g. "takes 1–2 hrs")
        - Avoid repeating the client's message
        - Keep under 160 characters
        - End with: "{$callToActionText}"

        🚫 Don't:
        - Repeat what the client wrote
        - Add long intros
        - Sound robotic or corporate

        Generate the SMS reply:
        EOT;

        return $prompt;
    }

    private function getFallbackResponse(
        ?string $firstName,
        ?float $calloutFee,
        ?float $hourlyRate,
        ?string $preferredCta,
        string $responseTone
    ): string {
        $callToActionText = $preferredCta ?? $this->getDefaultCta($responseTone);

        $message = "G'day! " .
            ($firstName ? "This is {$firstName}. " : '') .
            "Thanks for your inquiry. I'd be happy to help with your job. " .
            ($calloutFee ? "My standard callout is \${$calloutFee}. " : '') .
            ($hourlyRate ? "My hourly rate is \${$hourlyRate}. " : '') .
            "I'll need to assess the job to give you an accurate quote. " .
            $callToActionText;

        return strlen($message) <= 160
            ? $message
            : "Hi, happy to help. Callout \${$calloutFee}, \${$hourlyRate}/hr. Call me to discuss the job";
    }

    private function getDefaultCta(string $responseTone): string
    {
        return match ($responseTone) {
            ResponseTone::CASUAL->value => "Let me know if you'd like to lock it in 👍",
            ResponseTone::PROFESSIONAL->value => "Let me know if you'd like to book it in",
            ResponseTone::POLITE->value => "Please let me know if you'd like to proceed",
            default => "Please let me know if you'd like to proceed",
        };
    }

    private function getToneInstructions(string $responseTone, string $industryType): string
    {
        $basePrompt = "You are an experienced Australian {$industryType} tradesperson with years of expertise. ";
        $basePrompt .= "You provide accurate, realistic quotes and communicate professionally with customers. ";
        $basePrompt .= "Use Australian terminology, pricing in AUD, and consider local market rates. ";

        return match ($responseTone) {
            ResponseTone::CASUAL->value => $basePrompt .= "Use a friendly, conversational tone with some Australian slang. Be approachable and relaxed in your communication style.",
            ResponseTone::PROFESSIONAL->value => $basePrompt .= "Use formal business language with technical terminology when appropriate. Maintain a corporate-level professional tone.",
            ResponseTone::POLITE->value => $basePrompt .= "Use respectful, courteous language that's professional but warm. Be clear and considerate in your messaging.",
            default => $basePrompt .= "Use respectful, courteous language that's professional but warm. Be clear and considerate in your messaging.",
        };
    }
}
