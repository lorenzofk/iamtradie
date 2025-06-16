<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Quote;
use App\Services\TwilioService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendQuoteSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $maxExceptions = 3;
    public int $backoff = 30; // seconds

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly int $quoteId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(TwilioService $twilioService): void
    {
        Log::withContext([
            'job' => self::class,
            'quote_id' => $this->quoteId,
        ]);

        try {
            $quote = Quote::findOrFail($this->quoteId);

            Log::info('[SEND QUOTE SMS JOB] - Sending SMS', [
                'to' => $quote->from_number,
                'from' => $quote->to_number,
                'message_preview' => substr($quote->ai_response, 0, 100) . '...',
            ]);

            $twilioService->send(
                to: $quote->from_number,
                from: $quote->to_number,
                message: $quote->ai_response
            );

            // Update quote status
            $quote->update([
                'status' => \App\Enums\QuoteStatus::SENT,
                'sent_at' => now(),
            ]);

            Log::info('[SEND QUOTE SMS JOB] - SMS sent successfully', ['quote_id' => $quote->id]);

        } catch (Exception $e) {
            Log::error('[SEND QUOTE SMS JOB] - Failed to send SMS', [
                'quote_id' => $this->quoteId,
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
        Log::error('[SEND QUOTE SMS JOB] - Job failed permanently', [
            'quote_id' => $this->quoteId,
            'error' => $exception->getMessage(),
        ]);

        // Update quote status to failed
        try {
            $quote = Quote::find($this->quoteId);
            if ($quote) {
                $quote->update(['status' => \App\Enums\QuoteStatus::FAILED]);
            }
        } catch (Exception $e) {
            Log::error('[SEND QUOTE SMS JOB] - Failed to update quote status to failed', [
                'quote_id' => $this->quoteId,
                'error' => $e->getMessage(),
            ]);
        }
    }
} 