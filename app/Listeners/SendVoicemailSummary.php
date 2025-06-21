<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\VoicemailSummaryRequested;
use App\Jobs\SendVoicemailSummaryJob;
use Illuminate\Support\Facades\Log;

class SendVoicemailSummary
{
    /**
     * Handle the event.
     */
    public function handle(VoicemailSummaryRequested $event): void
    {
        Log::info('[VOICEMAIL SUMMARY LISTENER] - Event received. Dispatching job to generate and send summary.', [
            'listener' => self::class,
            'call_sid' => $event->callSid,
            'caller' => $event->caller,
            'user_id' => $event->user->id,
        ]);

        SendVoicemailSummaryJob::dispatch(
            caller: $event->caller,
            called: $event->called,
            transcription: $event->transcription,
            callSid: $event->callSid,
            userId: $event->user->id
        );
    }
}
