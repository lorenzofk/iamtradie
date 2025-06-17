<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\VoicemailQuoteRequested;
use App\Jobs\SendVoicemailQuoteResponseJob;
use Illuminate\Support\Facades\Log;

class SendVoicemailQuoteResponse
{
    /**
     * Handle the event.
     */
    public function handle(VoicemailQuoteRequested $event): void
    {
        Log::info('[VOICEMAIL QUOTE LISTENER] - Event received. Dispatching job to generate and send quote response.', [
            'listener' => self::class,
            'call_sid' => $event->callSid,
            'caller' => $event->callerNumber,
            'user_id' => $event->user->id,
        ]);

        SendVoicemailQuoteResponseJob::dispatch(
            callerNumber: $event->callerNumber,
            agentNumber: $event->agentNumber,
            transcription: $event->transcription,
            callSid: $event->callSid,
            userId: $event->user->id
        );
    }
} 