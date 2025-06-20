<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Quote;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PreventChattySMS
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $chatPreventionTimeMinutes = config('pingmate.chat_prevention_time_minutes');

        $leadNumber = $request->input('From');
        $twilioNumber = $request->input('To');

        $user = User::whereHas('settings', fn ($query) => $query->where('agent_sms_number', $twilioNumber))->first();

        if (empty($user)) {
            return $next($request);
        }

        $totalMessagesInLastMinutes = Quote::query()
            ->where('from_number', $leadNumber)
            ->where('to_number', $twilioNumber)
            ->where('user_id', $user->id)
            ->whereBetween('sent_at', [now()->subMinutes($chatPreventionTimeMinutes), now()])
            ->count();

        if ($totalMessagesInLastMinutes === 0) {
            return $next($request);
        }

        Log::info('[CHAT PREVENTION MIDDLEWARE] - Chatty SMS detected.', [
            'lead_number' => $leadNumber,
            'user_id' => $user->id,
            'chat_prevention_minutes' => $chatPreventionTimeMinutes,
            'number_of_quotes_in_last_minutes' => $totalMessagesInLastMinutes
        ]);

        $request->attributes->add(['isChatty' => true]);

        return $next($request);
    }
} 