<?php

namespace App\Http\Controllers;

use App\Enums\QuoteStatus;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with stats and recent messages and voicemails.
     */
    public function index(): Response
    {
        $user = Auth::user();

        $today = now()->startOfDay();

        // Quote stats
        $pendingReview = $user->quotes()->whereStatus(QuoteStatus::PENDING)->count();
        $sentToday = $user->quotes()->whereStatus(QuoteStatus::SENT)->whereDate('sent_at', $today)->count();
        $newInquiries = $user->quotes()->whereStatus(QuoteStatus::PENDING)->whereDate('created_at', $today)->count();
        
        // Voicemail stats
        $todayVoicemails = $user->voicemails()->whereDate('created_at', $today)->count();
        $totalVoicemails = $user->voicemails()->count();
        $transcribedToday = $user->voicemails()->whereDate('created_at', $today)
            ->where('transcription_processed', true)->count();
        $responsesSentToday = $user->voicemails()->whereDate('sms_sent_at', $today)
            ->where('sms_sent', true)->count();
        
        $recentQuotes = $user->quotes()->latest()->take(5)->get()->map(function ($quote) {
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

        $recentVoicemails = $user->voicemails()->latest()->take(5)->get()->map(function ($voicemail) {
            return [
                'id' => $voicemail->id,
                'from_number' => $voicemail->from_number,
                'caller_country' => $voicemail->caller_country,
                'recording_url' => $voicemail->recording_url,
                'recording_duration' => $voicemail->recording_duration,
                'transcription_text' => $voicemail->transcription_text,
                'transcription_processed' => $voicemail->transcription_processed,
                'ai_response' => $voicemail->ai_response,
                'sms_sent' => $voicemail->sms_sent,
                'sms_sent_at' => $voicemail->sms_sent_at,
                'created_at' => $voicemail->created_at->diffForHumans(),
                'created_at_formatted' => $voicemail->created_at->format('M j, Y g:i A'),
            ];
        });

        return Inertia::render('Dashboard', [
            'stats' => [
                'sent_today' => $sentToday,
                'estimated_value' => '10,000',
                'new_inquiries' => $newInquiries,
                'pending_review' => $pendingReview,
            ],
            'voicemail_stats' => [
                'today_voicemails' => $todayVoicemails,
                'total_voicemails' => $totalVoicemails,
                'transcribed_today' => $transcribedToday,
                'responses_sent_today' => $responsesSentToday,
            ],
            'quotes' => $recentQuotes,
            'voicemails' => $recentVoicemails,
        ]);
    }
} 