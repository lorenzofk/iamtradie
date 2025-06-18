<?php

declare(strict_types=1);

namespace App\Providers;

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

        $this->registerLogViewerGate();
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
