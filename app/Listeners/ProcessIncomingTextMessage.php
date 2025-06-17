<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\IncomingTextMessageReceived;
use App\Jobs\ProcessIncomingTextMessageJob;
use Illuminate\Support\Facades\Log;

class ProcessIncomingTextMessage
{
    /**
     * Handle the event.
     */
    public function handle(IncomingTextMessageReceived $event): void
    {
        Log::info('[INCOMING TEXT LISTENER] - Event received. Dispatching the job to process it.', [
            'listener' => self::class,
        ]);

        ProcessIncomingTextMessageJob::dispatch(
            messageBody: $event->messageBody,
            leadNumber: $event->leadNumber,
            twilioNumber: $event->twilioNumber,
            smsId: $event->smsId,
            userId: $event->user->id
        );
    }
}
