<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\VoicemailRecordingCompleted;
use App\Jobs\CreateVoicemailRecordJob;
use Illuminate\Support\Facades\Log;

class ProcessVoicemailRecording
{
    /**
     * Handle the event.
     */
    public function handle(VoicemailRecordingCompleted $event): void
    {
        Log::withContext([
            'listener' => self::class,
            'call_sid' => $event->callSid,
            'user_id' => $event->user->id,
        ]);

        Log::info('[VOICEMAIL LISTENER] - Dispatching voicemail creation job', [
            'call_sid' => $event->callSid,
            'from_number' => $event->fromNumber,
            'recording_sid' => $event->recordingSid,
            'recording_duration' => $event->recordingDuration,
        ]);

        CreateVoicemailRecordJob::dispatch(
            $event->callSid,
            $event->fromNumber,
            $event->callerCountry,
            $event->direction,
            $event->callStatus,
            $event->recordingSid,
            $event->recordingUrl,
            $event->recordingDuration,
            $event->digits,
            $event->user->id
        );
    }
} 