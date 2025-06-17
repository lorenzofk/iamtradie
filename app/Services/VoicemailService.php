<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Voicemail;
use Exception;
use Illuminate\Support\Facades\Log;

class VoicemailService
{
    /**
     * Create a voicemail record.
     */
    public function createVoicemailRecord(
        string $callSid,
        string $fromNumber,
        string $callerCountry,
        string $direction,
        string $callStatus,
        ?string $recordingSid,
        ?string $recordingUrl,
        ?int $recordingDuration,
        ?string $digits,
        int $userId
    ): ?Voicemail {
        Log::withContext([
            'service' => self::class,
            'call_sid' => $callSid,
            'user_id' => $userId,
        ]);

        try {
            $existingVoicemail = Voicemail::where('call_sid', $callSid)->first();

            if ($existingVoicemail) {
                Log::info('[VOICEMAIL SERVICE] - Voicemail already exists, skipping creation', ['existing_voicemail_id' => $existingVoicemail->id]);

                return $existingVoicemail;
            }

            Log::info('[VOICEMAIL SERVICE] - Creating voicemail record', [
                'call_sid' => $callSid,
                'from_number' => $fromNumber,
                'recording_sid' => $recordingSid,
                'recording_duration' => $recordingDuration,
            ]);

            $voicemail = Voicemail::create([
                'user_id' => $userId,
                'call_sid' => $callSid,
                'from_number' => $fromNumber,
                'caller_country' => $callerCountry,
                'direction' => $direction,
                'call_status' => $callStatus,
                'recording_sid' => $recordingSid,
                'recording_url' => $recordingUrl,
                'recording_duration' => $recordingDuration,
                'digits' => $digits,
            ]);

            Log::info('[VOICEMAIL SERVICE] - Voicemail record created successfully', ['voicemail_id' => $voicemail->id]);

            return $voicemail;

        } catch (Exception $e) {
            Log::error('[VOICEMAIL SERVICE] - Failed to create voicemail record', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }
}
