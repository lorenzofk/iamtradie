<?php

namespace App\Http\Controllers\Settings;

use App\Enums\IndustryType;
use App\Enums\ResponseTone;
use App\Http\Requests\UpdateSettingsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Exception;
use App\Http\Controllers\Controller;

class BasicSettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index(): Response
    {
        $user = auth()->user();

        $settings = $user->getOrCreateSettings()->toArray();

        return Inertia::render('Settings/Basic', [
            'settings' => $settings,
            'industry_types' => IndustryType::toDropdown(),
            'response_tones' => ResponseTone::toDropdown(),
        ]);
    }

    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
            ]);

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