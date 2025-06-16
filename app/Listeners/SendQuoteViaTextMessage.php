<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\QuoteCreated;
use App\Jobs\SendQuoteSMSJob;
use Illuminate\Support\Facades\Log;

class SendQuoteViaTextMessage
{
    /**
     * Handle the event.
     */
    public function handle(QuoteCreated $event): void
    {
        Log::withContext([
            'listener' => self::class,
            'quote_id' => $event->quote->id,
            'should_auto_send' => $event->shouldAutoSend,
        ]);

        if ($event->shouldAutoSend) {
            Log::info('[SEND QUOTE LISTENER] - Auto-send is enabled, dispatching SMS job', [
                'quote_id' => $event->quote->id,
                'from_number' => $event->quote->from_number,
                'to_number' => $event->quote->to_number,
            ]);

            SendQuoteSMSJob::dispatch($event->quote->id);
        } else {
            Log::info('[SEND QUOTE LISTENER] - Auto-send is disabled, quote will remain pending', [
                'quote_id' => $event->quote->id,
            ]);
        }
    }
}
