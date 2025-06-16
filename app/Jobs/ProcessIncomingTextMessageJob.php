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
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessIncomingTextMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $maxExceptions = 3;
    public int $backoff = 30; // seconds

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
     * Execute the job.
     */
    public function handle(OpenAIService $openAIService): void
    {
        Log::withContext([
            'job' => self::class,
            'user_id' => $this->userId,
            'lead_number' => $this->leadNumber,
            'sms_id' => $this->smsId,
        ]);

        try {
            $user = User::with('settings')->findOrFail($this->userId);
            $settings = $user->settings;

            Log::info('[PROCESS TEXT JOB] - Generating AI quote response', [
                'message_body' => $this->messageBody,
                'industry_type' => $settings->industry_type->value,
            ]);

            // Generate AI response
            $aiResponse = $openAIService->generateQuoteResponse(
                message: $this->messageBody,
                industryType: $settings->industry_type->value,
                calloutFee: $settings->callout_fee,
                hourlyRate: $settings->hourly_rate,
                responseTone: $settings->response_tone->value,
                firstName: $user->first_name
            );

            Log::info('[PROCESS TEXT JOB] - AI response generated', ['ai_response' => $aiResponse]);

            // Create quote record
            $quote = Quote::create([
                'user_id' => $this->userId,
                'message' => $this->messageBody,
                'industry_type' => $settings->industry_type,
                'ai_response' => $aiResponse,
                'from_number' => $this->leadNumber,
                'to_number' => $this->twilioNumber,
                'sms_id' => $this->smsId,
                'source' => QuoteSource::SMS,
                'status' => $settings->auto_send_sms ? QuoteStatus::SENT : QuoteStatus::PENDING,
                'sent_at' => $settings->auto_send_sms ? now() : null,
            ]);

            Log::info('[PROCESS TEXT JOB] - Quote created', ['quote_id' => $quote->id]);

            // Dispatch event for quote creation (this will trigger SMS sending if auto-send is enabled)
            QuoteCreated::dispatch($quote, $settings->auto_send_sms);

        } catch (Exception $e) {
            Log::error('[PROCESS TEXT JOB] - Failed to process incoming text message', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e; // Re-throw to trigger job retry
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