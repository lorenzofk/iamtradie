<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\QuoteStatus;
use App\Models\Quote;
use App\Services\TwilioService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendQuoteSMSJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $maxExceptions = 3;

    public int $backoff = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly int $quoteId) {}

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return 'send-sms-quote-'.$this->quoteId;
    }

    /**
     * Execute the job.
     */
    public function handle(TwilioService $twilioService): void
    {
        $logPrefix = '[SEND QUOTE SMS JOB]';

        Log::withContext([
            'job' => self::class,
            'quote_id' => $this->quoteId,
        ]);

        try {
            $quote = Quote::findOrFail($this->quoteId);

            Log::info("{$logPrefix} - Sending SMS.", [
                'quote_id' => $quote->id,
                'to' => $quote->from_number,
                'from' => $quote->to_number,
                'message' => $quote->ai_response,
                'sms_id' => $quote->sms_id,
                'initial_status' => $quote->status->value,
            ]);

            $twilioService->send(
                to: $quote->from_number,
                from: $quote->to_number,
                message: $quote->ai_response
            );

            $quote->update(['status' => QuoteStatus::SENT, 'sent_at' => now()]);

            Log::info("{$logPrefix} - SMS sent successfully.", ['final_status' => $quote->status->value]);
        } catch (Exception $e) {
            Log::error("{$logPrefix} - Failed to send SMS.", [
                'quote_id' => $this->quoteId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $quote->update(['status' => QuoteStatus::FAILED]);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Exception $exception): void
    {
        $logPrefix = '[SEND QUOTE SMS JOB]';

        Log::error("{$logPrefix} - Job failed permanently.", [
            'quote_id' => $this->quoteId,
            'error' => $exception->getMessage(),
        ]);

        try {
            $quote = Quote::findOrFail($this->quoteId);
            $quote->update(['status' => QuoteStatus::FAILED]);

            Log::info("{$logPrefix} - Quote status updated to failed.", ['final_status' => $quote->status->value]);
        } catch (Exception $e) {
            Log::error("{$logPrefix} - Failed to update quote status to failed.", [
                'quote_id' => $this->quoteId,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
