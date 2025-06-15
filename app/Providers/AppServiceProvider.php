<?php

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
        
        // Log Viewer Authorization Gate
        $this->registerLogViewerGate();
    }

    /**
     * Register the Log Viewer authorization gate
     * 
     * This provides an additional layer of security for the log viewer.
     * You can customize this based on your application's user roles/permissions.
     */
    protected function registerLogViewerGate(): void
    {
        Gate::define('viewLogViewer', function ($user = null) {
            // In local environment, allow access
            if (app()->environment('local')) {
                return true;
            }
            
            // In production, only allow authenticated users
            // You can add additional checks here, such as:
            // - User role checks: $user && $user->hasRole('admin')
            // - Specific user emails: in_array($user->email, ['admin@example.com'])
            // - Permission checks: $user && $user->can('view-logs')
            
            return $user !== null;
        });
    }
}
