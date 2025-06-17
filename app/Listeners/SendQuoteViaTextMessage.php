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
            'from_number' => $event->quote->from_number,
            'to_number' => $event->quote->to_number,
        ]);

        Log::info('[SEND QUOTE LISTENER] - Event received. Checking if auto-send is enabled.');

        if (! $event->shouldAutoSend) {
            Log::info('[SEND QUOTE LISTENER] - Auto-send is disabled. The quote will remain pending.');

            return;
        }

        Log::info('[SEND QUOTE LISTENER] - Auto-send is enabled. Dispatching the job to send the quote via SMS.');

        SendQuoteSMSJob::dispatch($event->quote->id);
    }
}
