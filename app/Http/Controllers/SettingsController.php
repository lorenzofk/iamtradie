<?php

namespace App\Http\Controllers;

use App\Enums\IndustryType;
use App\Enums\ResponseTone;
use App\Http\Requests\UpdateUserSettingsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Exception;

class SettingsController extends Controller
{
    public function show(): Response
    {
        $settings = auth()->user()->settings;

        return Inertia::render('Settings/Index', [
            'settings' => $settings,
            'industryTypes' => IndustryType::toDropdown(),
            'responseTones' => ResponseTone::toDropdown(),
        ]);
    }

    public function update(UpdateUserSettingsRequest $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Update user basic info
            $user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
            ]);

            // Update or create settings
            $settingsData = collect($validated)->except(['first_name', 'last_name', 'email'])->toArray();
            $settingsData['auto_send_sms'] = $request->boolean('auto_send_sms');
            $settingsData['auto_send_email'] = $request->boolean('auto_send_email');

            $user->settings()->updateOrCreate(['user_id' => $user->id], $settingsData);

            DB::commit();
        } catch (Exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update settings. Please try again.');
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}