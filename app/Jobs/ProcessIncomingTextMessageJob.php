<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\QuoteSource;
use App\Enums\QuoteStatus;
use App\Events\QuoteCreated;
use App\Models\Quote;
use App\Models\User;
use App\Services\OpenAIService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessIncomingTextMessageJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $maxExceptions = 3;

    public int $backoff = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $messageBody,
        private readonly string $leadNumber,
        private readonly string $twilioNumber,
        private readonly string $smsId,
        private readonly int $userId
    ) {}

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return 'process-text-'.$this->smsId;
    }

    /**
     * Execute the job.
     */
    public function handle(OpenAIService $openAIService): void
    {
        $logPrefix = '[PROCESS TEXT JOB]';

        Log::withContext([
            'job' => self::class,
            'sms_id' => $this->smsId,
            'message' => $this->messageBody,
            'lead_number' => $this->leadNumber,
            'twilio_number' => $this->twilioNumber,
            'user_id' => $this->userId,
        ]);

        try {
            $user = User::with('settings')->findOrFail($this->userId);
            $settings = $user->settings;

            Log::info("{$logPrefix} - Generating AI quote response.", ['industry_type' => $settings->industry_type->value]);

            $response = $openAIService->generateQuoteResponse(
                message: $this->messageBody,
                industryType: $settings->industry_type->value,
                calloutFee: $settings->callout_fee,
                hourlyRate: $settings->hourly_rate,
                responseTone: $settings->response_tone->value,
                firstName: $user->first_name
            );

            Log::info("{$logPrefix} - AI response generated. Creating the quote.", ['response' => $response]);

            $quote = Quote::create([
                'user_id' => $this->userId,
                'message' => $this->messageBody,
                'industry_type' => $settings->industry_type,
                'ai_response' => $response,
                'from_number' => $this->leadNumber,
                'to_number' => $this->twilioNumber,
                'sms_id' => $this->smsId,
                'source' => QuoteSource::SMS,
                'status' => QuoteStatus::PENDING,
                'sent_at' => null,
            ]);

            Log::info("{$logPrefix} - Quote created. Firing the event to send the quote.", ['quote_id' => $quote->id]);

            QuoteCreated::dispatch($quote, $settings->auto_send_sms);
        } catch (Exception $e) {
            Log::error("{$logPrefix} - Failed to process incoming text message.", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Exception $exception): void
    {
        Log::error('[PROCESS TEXT JOB] - Job failed permanently', [
            'user_id' => $this->userId,
            'lead_number' => $this->leadNumber,
            'sms_id' => $this->smsId,
            'error' => $exception->getMessage(),
        ]);
    }
}
