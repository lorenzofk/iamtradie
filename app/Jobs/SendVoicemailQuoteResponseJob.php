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

class SendVoicemailQuoteResponseJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $maxExceptions = 3;

    public int $backoff = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $callerNumber,
        private readonly string $agentNumber,
        private readonly string $transcription,
        private readonly string $callSid,
        private readonly int $userId
    ) {}

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return 'send-voicemail-quote-'.$this->callSid;
    }

    /**
     * Execute the job.
     */
    public function handle(OpenAIService $openAIService, TwilioService $twilioService): void
    {
        Log::withContext([
            'job' => self::class,
            'call_sid' => $this->callSid,
            'caller' => $this->callerNumber,
            'agent_number' => $this->agentNumber,
            'user_id' => $this->userId,
        ]);

        try {
            $user = User::with('settings')->findOrFail($this->userId);
            $settings = $user->settings;

            Log::info('[SEND VOICEMAIL QUOTE JOB] - Generating quote response for voicemail transcription.', [
                'transcription' => $this->transcription,
                'industry_type' => $settings->industry_type->value,
            ]);

            $quote = $openAIService->generateQuoteResponse(
                message: $this->transcription,
                industryType: $settings->industry_type->value,
                calloutFee: $settings->callout_fee,
                hourlyRate: $settings->hourly_rate,
                responseTone: $settings->response_tone->value,
                firstName: $user->first_name
            );

            Log::info('[SEND VOICEMAIL QUOTE JOB] - Quote response generated. Sending SMS to caller.', ['quote' => $quote]);

            $twilioService->send(to: $this->callerNumber, from: $this->agentNumber, message: $quote);

            Log::info('[SEND VOICEMAIL QUOTE JOB] - Quote response SMS sent successfully.');

            // Update the voicemail record with AI response details
            $voicemail = $user->voicemails()->where('call_sid', $this->callSid)->first();
            if ($voicemail) {
                $voicemail->update([
                    'ai_response' => $quote,
                    'sms_sent' => true,
                    'sms_sent_at' => now(),
                ]);

                Log::info('[SEND VOICEMAIL QUOTE JOB] - Voicemail record updated with AI response details.', ['voicemail_id' => $voicemail->id]);
            }
        } catch (Exception $e) {
            Log::error('[SEND VOICEMAIL QUOTE JOB] - Failed to generate or send quote response.', [
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
        Log::error('[SEND VOICEMAIL QUOTE JOB] - Job failed permanently.', [
            'call_sid' => $this->callSid,
            'caller' => $this->callerNumber,
            'user_id' => $this->userId,
            'error' => $exception->getMessage(),
        ]);
    }
} 