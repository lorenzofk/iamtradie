<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserCanViewLogs
{
    /**
     * Handle an incoming request.
     *
     * In production, only authenticated users can access the log viewer.
     * Uses both authentication and Gate authorization for multiple layers of security.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access in local environment without authentication
        if (app()->environment('local')) {
            return $next($request);
        }

        // Check if user is authenticated
        if (! Auth::check()) {
            // If it's an API or expects JSON (like Log Viewer frontend), abort
            if ($request->expectsJson() || $request->is('log-viewer/api/*')) {
                abort(403, 'Unauthorized access to log viewer.');
            }

            // Otherwise, allow redirect (e.g., if user directly opens /log-viewer)
            return redirect()->route('login')->with('error', 'Please log in to access the log viewer.');
        }

        // Additional Gate authorization check
        if (! Gate::allows('viewLogViewer', Auth::user())) {
            abort(403, 'Unauthorized access to log viewer.');
        }

        return $next($request);
    }
}
