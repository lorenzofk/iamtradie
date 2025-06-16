<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\IncomingTextMessageReceived;
use App\Events\QuoteCreated;
use App\Listeners\ProcessIncomingTextMessage;
use App\Listeners\SendQuoteViaTextMessage;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     */
    protected $listen = [
        IncomingTextMessageReceived::class => [
            ProcessIncomingTextMessage::class,
        ],
        QuoteCreated::class => [
            SendQuoteViaTextMessage::class,
        ],
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
} 