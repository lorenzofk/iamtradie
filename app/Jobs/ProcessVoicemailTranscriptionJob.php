<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Events\VoicemailQuoteRequested;
use App\Events\VoicemailSummaryRequested;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessVoicemailTranscriptionJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $maxExceptions = 3;

    public int $backoff = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $caller,
        private readonly string $called,
        private readonly string $callSid,
        private readonly string $transcription,
        private readonly int $userId
    ) {}

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return 'process-voicemail-transcription-'.$this->callSid;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::withContext([
            'job' => self::class,
            'call_sid' => $this->callSid,
            'caller' => $this->caller,
            'called' => $this->called,
            'user_id' => $this->userId,
        ]);

        try {
            $user = User::with('settings')->findOrFail($this->userId);
            $settings = $user->settings;

            Log::info('[PROCESS VOICEMAIL TRANSCRIPTION JOB] - Processing voicemail transcription. Updating record and dispatching events.');

            // Update voicemail record with transcription
            $voicemail = $user->voicemails()->where('call_sid', $this->callSid)->first();
            if ($voicemail) {
                $voicemail->update([
                    'transcription_text' => $this->transcription,
                    'transcription_processed' => true,
                ]);
                Log::info('[PROCESS VOICEMAIL TRANSCRIPTION JOB] - Voicemail record updated with transcription.', ['voicemail_id' => $voicemail->id]);
            } else {
                Log::warning('[PROCESS VOICEMAIL TRANSCRIPTION JOB] - Voicemail record not found.', ['call_sid' => $this->callSid, 'user_id' => $this->userId]);
            }

            Log::info('[PROCESS VOICEMAIL TRANSCRIPTION JOB] - Firing event to generate and send summary to user.');

            // Always send summary to user
            VoicemailSummaryRequested::dispatch(
                $this->caller,
                $this->called,
                $this->transcription,
                $this->callSid,
                $user
            );

            // Conditionally send quote to customer
            if ($settings->auto_send_sms_after_voicemail) {
                Log::info('[PROCESS VOICEMAIL TRANSCRIPTION JOB] - Auto send SMS after voicemail is enabled. Firing event to generate and send quote response.');

                VoicemailQuoteRequested::dispatch(
                    $this->caller,
                    $settings->agent_sms_number,
                    $this->transcription,
                    $this->callSid,
                    $user
                );
            }

            Log::info('[PROCESS VOICEMAIL TRANSCRIPTION JOB] - Voicemail transcription processing completed successfully.');
        } catch (Exception $e) {
            Log::error('[PROCESS VOICEMAIL TRANSCRIPTION JOB] - Failed to process voicemail transcription.', [
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
        Log::error('[PROCESS VOICEMAIL TRANSCRIPTION JOB] - Job failed permanently.', [
            'call_sid' => $this->callSid,
            'user_id' => $this->userId,
            'error' => $exception->getMessage(),
        ]);
    }
}
