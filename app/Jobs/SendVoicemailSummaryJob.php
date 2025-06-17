<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use App\Services\OpenAIService;
use App\Services\TwilioService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendVoicemailSummaryJob implements ShouldBeUnique, ShouldQueue
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
        private readonly string $transcription,
        private readonly string $callSid,
        private readonly int $userId
    ) {}

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return 'send-voicemail-summary-'.$this->callSid;
    }

    /**
     * Execute the job.
     */
    public function handle(OpenAIService $openAIService, TwilioService $twilioService): void
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

            Log::info('[SEND VOICEMAIL SUMMARY JOB] - Generating voicemail summary for the user.', [
                'transcription' => $this->transcription,
                'industry_type' => $settings->industry_type->value,
            ]);

            $aiSummary = $openAIService->generateVoicemailSummaryForUser(
                transcription: $this->transcription,
                industryType: $settings->industry_type->value,
                calloutFee: $settings->callout_fee,
                hourlyRate: $settings->hourly_rate,
                userFirstName: $user->first_name
            );

            $fullSummaryMessage = '📞 Missed Call from '.$this->caller."\n".$aiSummary;

            Log::info('[SEND VOICEMAIL SUMMARY JOB] - Summary generated. Sending SMS to user.', ['summary' => $fullSummaryMessage]);

            $twilioService->send(to: $settings->phone_number, from: $this->called, message: $fullSummaryMessage);

            Log::info('[SEND VOICEMAIL SUMMARY JOB] - Summary SMS sent successfully to user.', ['to' => $settings->phone_number]);

            // Update voicemail with summary
            $voicemail = $user->voicemails()->where('call_sid', $this->callSid)->first();
            if ($voicemail) {
                $voicemail->update(['summary_for_user' => $fullSummaryMessage]);
                Log::info('[SEND VOICEMAIL SUMMARY JOB] - Voicemail record updated with summary.', ['voicemail_id' => $voicemail->id]);
            }
        } catch (Exception $e) {
            Log::error('[SEND VOICEMAIL SUMMARY JOB] - Failed to generate or send summary.', [
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
        Log::error('[SEND VOICEMAIL SUMMARY JOB] - Job failed permanently.', [
            'call_sid' => $this->callSid,
            'user_id' => $this->userId,
            'error' => $exception->getMessage(),
        ]);
    }
} 