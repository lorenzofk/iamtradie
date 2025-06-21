<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\SmsClassification;
use App\Services\OpenAIService;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class FilterVoicemailTranscription
{
    private const LOG_PREFIX = '[FILTER VOICEMAIL MIDDLEWARE]';

    public function __construct(private readonly OpenAIService $openAIService) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->isFilteringEnabled()) {
            return $next($request);
        }

        $transcription = $this->extractTranscription($request);

        if ($this->isEmptyTranscription($transcription)) {
            return $next($request);
        }

        $this->setLogContext($request);

        $this->logProcessingStart($transcription);

        if ($this->isBlockedByKeywords($transcription)) {
            return response()->noContent();
        }

        if ($this->isBlockedByAI($transcription)) {
            return response()->noContent();
        }

        $this->logFilteringSuccess();

        return $next($request);
    }

    private function isFilteringEnabled(): bool
    {
        return config('pingmate.enable_voicemail_transcription_filter', true);
    }

    private function extractTranscription(Request $request): string
    {
        return $request->input('TranscriptionText', '');
    }

    private function isEmptyTranscription(string $transcription): bool
    {
        return empty(trim($transcription));
    }

    private function setLogContext(Request $request): void
    {
        Log::withContext([
            'from' => $request->input('From'),
            'called' => $request->input('Called'),
            'call_sid' => $request->input('CallSid'),
        ]);
    }

    private function logProcessingStart(string $transcription): void
    {
        $keywords = config('pingmate.sms_filter_keywords', []);
        $enableAiClassification = config('pingmate.enable_ai_voicemail_classification', true);

        Log::info(self::LOG_PREFIX.' - Processing voicemail transcription', [
            'transcription_length' => mb_strlen($transcription),
            'keyword_filter_enabled' => ! empty($keywords),
            'ai_classification_enabled' => $enableAiClassification,
        ]);
    }

    private function isBlockedByKeywords(string $transcription): bool
    {
        $keywords = config('pingmate.sms_filter_keywords', []);

        $matchedKeyword = $this->findMatchingKeyword($transcription, $keywords);

        if ($matchedKeyword) {
            $this->logKeywordBlock($transcription, $matchedKeyword);

            return true;
        }

        return false;
    }

    private function findMatchingKeyword(string $transcription, array $keywords): ?string
    {
        $lowercaseTranscription = mb_strtolower($transcription);

        foreach ($keywords as $keyword) {
            if (str_contains($lowercaseTranscription, mb_strtolower($keyword))) {
                return $keyword;
            }
        }

        return null;
    }

    private function logKeywordBlock(string $transcription, string $matchedKeyword): void
    {
        Log::warning(self::LOG_PREFIX.' - Voicemail blocked by keyword filter', [
            'transcription' => $transcription,
            'keyword_matched' => $matchedKeyword,
        ]);
    }

    private function isBlockedByAI(string $transcription): bool
    {
        if (! config('pingmate.enable_ai_voicemail_classification', false)) {
            return false;
        }

        try {
            $classification = $this->classifyTranscription($transcription);

            if ($classification->isBlocked()) {
                $this->logAiBlock($transcription, $classification);

                return true;
            }

            $this->logAiSuccess($classification);

            return false;

        } catch (Exception $e) {
            $this->logAiFailure($e, $transcription);

            return false;
        }
    }

    private function classifyTranscription(string $transcription): SmsClassification
    {
        $model = config('pingmate.ai_sms_classification_model', 'gpt-4o-mini');
        $prompt = config('pingmate.ai_voicemail_classification_prompt_instructions');

        return $this->openAIService->classifyContentForSMS($transcription, $model, $prompt);
    }

    private function logAiBlock(string $transcription, SmsClassification $classification): void
    {
        Log::warning(self::LOG_PREFIX.' - Voicemail blocked by AI classification', [
            'transcription' => $transcription,
            'classification' => $classification->value,
        ]);
    }

    private function logAiSuccess(SmsClassification $classification): void
    {
        Log::info(self::LOG_PREFIX.' - Voicemail passed AI classification', [
            'classification' => $classification->value,
        ]);
    }

    private function logAiFailure(Exception $e, string $transcription): void
    {
        Log::error(self::LOG_PREFIX.' - AI classification failed, allowing transcription through', [
            'error' => $e->getMessage(),
            'transcription' => $transcription,
        ]);
    }

    private function logFilteringSuccess(): void
    {
        Log::info(self::LOG_PREFIX.' - Voicemail passed all filters');
    }
}
