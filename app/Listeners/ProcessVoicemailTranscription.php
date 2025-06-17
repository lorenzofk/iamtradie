<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\VoicemailTranscriptionReceived;
use App\Jobs\ProcessVoicemailTranscriptionJob;
use Illuminate\Support\Facades\Log;

class ProcessVoicemailTranscription
{
    /**
     * Handle the event.
     */
    public function handle(VoicemailTranscriptionReceived $event): void
    {
        Log::info('[VOICEMAIL TRANSCRIPTION LISTENER] - Event received. Dispatching the job to process it.', [
            'listener' => self::class,
            'call_sid' => $event->callSid,
            'caller' => $event->caller,
            'called' => $event->called,
            'user_id' => $event->user->id,
        ]);

        ProcessVoicemailTranscriptionJob::dispatch(
            caller: $event->caller,
            called: $event->called,
            callSid: $event->callSid,
            transcription: $event->transcription,
            userId: $event->user->id
        );
    }
} 