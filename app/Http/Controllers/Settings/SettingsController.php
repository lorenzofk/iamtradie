<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Enums\IndustryType;
use App\Enums\QuoteSource;
use App\Enums\QuoteStatus;
use App\Enums\ResponseTone;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingsRequest;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    /**
     * Display the unified settings page.
     */
    public function index(): Response
    {
        $user = Auth::user();
        $settings = $user->getOrCreateSettings();

        // SMS data for statistics display
        $quotesUsed = $settings->quotes_used ?? 0;
        $quotesLimit = $settings->quotes_limit ?? 100;
        $totalMessages = $user->quotes()->where('source', QuoteSource::SMS)->count();
        $pendingReview = $user->quotes()->where('source', QuoteSource::SMS)->where('status', QuoteStatus::PENDING)->count();
        $autoSent = $user->quotes()->where('source', QuoteSource::SMS)->where('status', QuoteStatus::SENT)->count();
        $responseRate = $totalMessages > 0 ? round(($autoSent / $totalMessages) * 100).'%' : '0%';

        return Inertia::render('Settings/Index', [
            'settings' => $settings->toArray(),
            'industry_types' => IndustryType::toDropdown(),
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
        ]);
    }

    /**
     * Update all settings.
     */
    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Update user profile information
            $user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
            ]);

            // Update settings (excluding user profile fields)
            $settingsData = collect($validated)->except(['first_name', 'last_name', 'email'])->toArray();
            $user->settings()->updateOrCreate(['user_id' => $user->id], $settingsData);

            DB::commit();
        } catch (Exception) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to update settings. Please try again.');
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
} 