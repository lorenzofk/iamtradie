<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Voicemail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateVoicemailRecordJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $maxExceptions = 3;
    public int $backoff = 30;

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return 'create-voicemail-' . $this->callSid;
    }

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $callSid,
        private readonly string $fromNumber,
        private readonly string $callerCountry,
        private readonly string $direction,
        private readonly string $callStatus,
        private readonly ?string $recordingSid,
        private readonly ?string $recordingUrl,
        private readonly ?int $recordingDuration,
        private readonly ?string $digits,
        private readonly int $userId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::withContext([
            'job' => self::class,
            'call_sid' => $this->callSid,
            'user_id' => $this->userId,
        ]);

        try {
            // Check if voicemail already exists (idempotency)
            $existingVoicemail = Voicemail::where('call_sid', $this->callSid)->first();
            if ($existingVoicemail) {
                Log::info('[CREATE VOICEMAIL JOB] - Voicemail already exists, skipping', [
                    'call_sid' => $this->callSid,
                    'existing_voicemail_id' => $existingVoicemail->id,
                ]);
                return;
            }

            Log::info('[CREATE VOICEMAIL JOB] - Creating voicemail record', [
                'call_sid' => $this->callSid,
                'from_number' => $this->fromNumber,
                'recording_sid' => $this->recordingSid,
                'recording_duration' => $this->recordingDuration,
            ]);

            $voicemail = Voicemail::create([
                'user_id' => $this->userId,
                'call_sid' => $this->callSid,
                'from_number' => $this->fromNumber,
                'caller_country' => $this->callerCountry,
                'direction' => $this->direction,
                'call_status' => $this->callStatus,
                'recording_sid' => $this->recordingSid,
                'recording_url' => $this->recordingUrl,
                'recording_duration' => $this->recordingDuration,
                'digits' => $this->digits,
            ]);

            Log::info('[CREATE VOICEMAIL JOB] - Voicemail record created successfully', [
                'call_sid' => $this->callSid,
                'voicemail_id' => $voicemail->id,
            ]);

        } catch (Exception $e) {
            Log::error('[CREATE VOICEMAIL JOB] - Failed to create voicemail record', [
                'call_sid' => $this->callSid,
                'user_id' => $this->userId,
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
        Log::error('[CREATE VOICEMAIL JOB] - Job failed permanently', [
            'call_sid' => $this->callSid,
            'user_id' => $this->userId,
            'error' => $exception->getMessage(),
        ]);
    }
} 