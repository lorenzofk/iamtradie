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

class FilterIncomingSMS
{
    private const LOG_PREFIX = '[FILTER SMS MIDDLEWARE]';

    public function __construct(private readonly OpenAIService $openAIService) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->isFilteringEnabled()) {
            return $next($request);
        }

        $messageBody = $this->extractMessageBody($request);

        if ($this->isEmptyMessage($messageBody)) {
            return $next($request);
        }

        $this->setLogContext($request);

        $this->logProcessingStart($messageBody);

        if ($this->isBlockedByKeywords($messageBody)) {
            return response()->noContent();
        }

        if ($this->isBlockedByAI($messageBody)) {
            return response()->noContent();
        }

        $this->logFilteringSuccess();

        return $next($request);
    }

    private function isFilteringEnabled(): bool
    {
        return config('pingmate.enable_sms_content_filter', false);
    }

    private function extractMessageBody(Request $request): string
    {
        return $request->input('Body', '');
    }

    private function isEmptyMessage(string $messageBody): bool
    {
        return empty(trim($messageBody));
    }

    private function setLogContext(Request $request): void
    {
        Log::withContext([
            'from' => $request->input('From'),
            'to' => $request->input('To'),
        ]);
    }

    private function logProcessingStart(string $messageBody): void
    {
        $keywords = config('pingmate.sms_filter_keywords', []);
        $enableAiClassification = config('pingmate.enable_ai_sms_classification', false);

        Log::info(self::LOG_PREFIX.' - Processing incoming SMS', [
            'message_length' => mb_strlen($messageBody),
            'keyword_filter_enabled' => ! empty($keywords),
            'ai_classification_enabled' => $enableAiClassification,
        ]);
    }

    private function isBlockedByKeywords(string $messageBody): bool
    {
        $keywords = config('pingmate.sms_filter_keywords', []);

        $matchedKeyword = $this->findMatchingKeyword($messageBody, $keywords);

        if ($matchedKeyword) {
            $this->logKeywordBlock($messageBody, $matchedKeyword);

            return true;
        }

        return false;
    }

    private function findMatchingKeyword(string $messageBody, array $keywords): ?string
    {
        $lowercaseMessage = mb_strtolower($messageBody);

        foreach ($keywords as $keyword) {
            if (str_contains($lowercaseMessage, mb_strtolower($keyword))) {
                return $keyword;
            }
        }

        return null;
    }

    private function logKeywordBlock(string $messageBody, string $matchedKeyword): void
    {
        Log::warning(self::LOG_PREFIX.' - SMS blocked by keyword filter', [
            'body' => $messageBody,
            'keyword_matched' => $matchedKeyword,
        ]);
    }

    private function isBlockedByAI(string $messageBody): bool
    {
        if (! config('pingmate.enable_ai_sms_classification', false)) {
            return false;
        }

        try {
            $classification = $this->classifyMessage($messageBody);

            if ($classification->isBlocked()) {
                $this->logAiBlock($messageBody, $classification);

                return true;
            }

            $this->logAiSuccess($classification);
        } catch (Exception $e) {
            $this->logAiFailure($e, $messageBody);
        }

        return false;
    }

    private function classifyMessage(string $message): SmsClassification
    {
        $model = config('pingmate.ai_sms_classification_model', 'gpt-4o-mini');
        $prompt = config('pingmate.ai_sms_classification_prompt_instructions');

        return $this->openAIService->classifyContentForSMS($message, $model, $prompt);
    }

    private function logAiBlock(string $messageBody, SmsClassification $classification): void
    {
        Log::warning(self::LOG_PREFIX.' - SMS blocked by AI classification', [
            'body' => $messageBody,
            'classification' => $classification->value,
        ]);
    }

    private function logAiSuccess(SmsClassification $classification): void
    {
        Log::info(self::LOG_PREFIX.' - SMS passed AI classification', [
            'classification' => $classification->value,
        ]);
    }

    private function logAiFailure(Exception $e, string $messageBody): void
    {
        Log::error(self::LOG_PREFIX.' - AI classification failed, allowing message through', [
            'error' => $e->getMessage(),
            'body' => $messageBody,
        ]);
    }

    private function logFilteringSuccess(): void
    {
        Log::info(self::LOG_PREFIX.' - SMS passed all filters');
    }
}
