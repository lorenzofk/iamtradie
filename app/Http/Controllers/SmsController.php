<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SmsController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        $settings = $user->getOrCreateSettings();
        $twilio = $user->twilioSettings;

        $quotesUsed = $settings->quotes_used ?? 0;
        $quotesLimit = $settings->quotes_limit ?? 100;
        $totalMessages = $user->quotes()->where('source', 'sms')->count();
        $pendingReview = $user->quotes()->where('source', 'sms')->where('status', 'pending')->count();
        $autoSent = $user->quotes()->where('source', 'sms')->where('status', 'sent')->count();
        $responseRate = $totalMessages > 0 ? round(($autoSent / $totalMessages) * 100) . '%' : '0%';

        return Inertia::render('Integrations/SMS/index', [
            'sms_data' => [
                'phone_number' => $twilio?->twilio_number,
                'quotes_used' => $quotesUsed,
                'quotes_limit' => $quotesLimit,
                'total_messages' => $totalMessages,
                'pending_review' => $pendingReview,
                'auto_sent_enabled' => $autoSent,
                'response_rate' => $responseRate,
            ],
            'sms_settings' => [
                'auto_send_sms' => $settings->auto_send_sms,
                'callout_fee' => $settings->callout_fee,
                'hourly_rate' => $settings->hourly_rate,
                'response_tone' => $settings->response_tone?->value,
            ],
        ]);
    }
}