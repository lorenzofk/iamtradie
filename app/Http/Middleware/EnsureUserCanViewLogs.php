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

        // In production/staging, require authentication
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access the log viewer.');
        }

        // Additional Gate authorization check
        if (! Gate::allows('viewLogViewer', Auth::user())) {
            abort(403, 'Unauthorized access to log viewer.');
        }

        return $next($request);
    }
}
