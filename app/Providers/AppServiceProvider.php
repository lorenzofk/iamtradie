<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\IncomingTextMessageReceived;
use App\Events\QuoteCreated;
use App\Events\VoicemailQuoteRequested;
use App\Events\VoicemailTranscriptionReceived;
use App\Listeners\ProcessIncomingTextMessage;
use App\Listeners\ProcessVoicemailTranscription;
use App\Listeners\SendQuoteViaTextMessage;
use App\Listeners\SendVoicemailQuoteResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (
            $this->app->environment('local')
            && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)
            && class_exists(TelescopeServiceProvider::class)
        ) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::useBuildDirectory('build/vite');

        $this->registerEventListeners();
        $this->registerLogViewerGate();
    }

    /**
     * Register event listeners
     */
    protected function registerEventListeners(): void
    {
        Event::listen(IncomingTextMessageReceived::class, ProcessIncomingTextMessage::class);
        Event::listen(QuoteCreated::class, SendQuoteViaTextMessage::class);
        Event::listen(VoicemailTranscriptionReceived::class, ProcessVoicemailTranscription::class);
        Event::listen(VoicemailQuoteRequested::class, SendVoicemailQuoteResponse::class);
    }

    /**
     * Register the Log Viewer authorization gate
     */
    protected function registerLogViewerGate(): void
    {
        Gate::define('viewLogViewer', function ($user = null) {
            if (app()->environment('local')) {
                return true;
            }

            return ! empty($user);
        });
    }
}
