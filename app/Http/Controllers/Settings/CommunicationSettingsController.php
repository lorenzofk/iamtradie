<?php

namespace App\Http\Controllers\Settings;

use App\Enums\QuoteStatus;
use App\Enums\QuoteSource;
use App\Enums\ResponseTone;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCommunicationSettingsRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Exception;

class CommunicationSettingsController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        $settings = $user->getOrCreateSettings();

        $quotesUsed = $settings->quotes_used ?? 0;
        $quotesLimit = $settings->quotes_limit ?? 100;
        $totalMessages = $user->quotes()->where('source', QuoteSource::SMS)->count();
        $pendingReview = $user->quotes()->where('source', QuoteSource::SMS)->where('status', QuoteStatus::PENDING)->count();
        $autoSent = $user->quotes()->where('source', QuoteSource::SMS)->where('status', QuoteStatus::SENT)->count();
        $responseRate = $totalMessages > 0 ? round(($autoSent / $totalMessages) * 100) . '%' : '0%';

        return Inertia::render('Settings/Communication', [
            'response_tones' => ResponseTone::toDropdown(),
            'sms_data' => [
                'agent_sms_number' => $settings->agent_sms_number,
                'quotes_used' => $quotesUsed,
                'quotes_limit' => $quotesLimit,
                'total_messages' => $totalMessages,
                'pending_review' => $pendingReview,
                'auto_sent_enabled' => $autoSent,
                'response_rate' => $responseRate,
            ],
            'settings' => [
                'agent_sms_number' => $settings->agent_sms_number,
                'auto_send_sms' => $settings->auto_send_sms,
                'callout_fee' => $settings->callout_fee,
                'hourly_rate' => $settings->hourly_rate,
                'call_forward_enabled' => $settings->call_forward_enabled,
                'call_ring_duration' => $settings->call_ring_duration,
                'voicemail_message' => $settings->voicemail_message,
                'auto_send_sms_after_voicemail' => $settings->auto_send_sms_after_voicemail,
                'response_tone' => $settings->response_tone?->value,
            ],
        ]);
    }

    public function update(UpdateCommunicationSettingsRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $settings = $user->getOrCreateSettings();

        $validated = $request->validated();

        try {
            $settings->update($validated);
        } catch (Exception $e) {
            throw $e;
        }

        return redirect()->back()->with('success', 'Communication settings updated successfully');
    }
}