<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\TwilioService;

class HomeController extends Controller
{
    /**
     * Display the home dashboard with stats and recent quotes.
     */
    public function index(): Response
    {
        $user = Auth::user();

        $today = now()->startOfDay();

        $newInquiries = $user->quotes()->where('status', 'pending')->count();
        $sentToday = $user->quotes()->where('status', 'sent')->whereDate('sent_at', $today)->count();
        $pendingReview = $user->quotes()->where('status', 'pending')->count();

        $recentQuotes = $user->quotes()->latest()->take(7)->get()->map(function ($quote) {
            return [
                'id' => $quote->id,
                'status' => $quote->status->value,
                'from_number' => $quote->from_number,
                'message' => $quote->message,
                'ai_response' => $quote->ai_response,
                'sent_at' => $quote->sent_at,
                'created_at' => $quote->created_at->diffForHumans(),
            ];
        });

        return Inertia::render('Home', [
            'stats' => [
                'sent_today' => $sentToday,
                'estimated_value' => '10,000',
                'new_inquiries' => $newInquiries,
                'pending_review' => $pendingReview,
            ],
            'quotes' => $recentQuotes,
        ]);
    }
} 