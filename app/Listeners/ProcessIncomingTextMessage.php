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
        Log::withContext([
            'listener' => self::class,
            'user_id' => $event->user->id,
            'lead_number' => $event->leadNumber,
            'twilio_number' => $event->twilioNumber,
        ]);

        Log::info('[PROCESS TEXT LISTENER] - Dispatching processing job', [
            'message_preview' => substr($event->messageBody, 0, 100) . '...',
            'sms_id' => $event->smsId,
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