<?php

namespace App\Http\Controllers;

use App\Enums\IndustryType;
use App\Enums\ResponseTone;
use App\Http\Requests\UpdateUserSettingsRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function show(): Response
    {
        $user = auth()->user();
        $settings = $user->settings;

        return Inertia::render('Settings/Index', [
            'user' => $user,
            'settings' => $settings,
            'industryTypes' => IndustryType::toDropdown(),
            'responseTones' => ResponseTone::toDropdown(),
        ]);
    }

    public function update(UpdateUserSettingsRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $validated = $request->validated();

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

        $user->settings()->updateOrCreate(
            ['user_id' => $user->id],
            $settingsData
        );

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}