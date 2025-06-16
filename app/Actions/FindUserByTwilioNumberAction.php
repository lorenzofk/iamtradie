<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class FindUserByTwilioNumberAction
{
    /**
     * Find a user by their Twilio SMS number.
     */
    public function execute(string $twilioNumber): User
    {
        Log::info('[FIND USER ACTION] - Looking up user by Twilio number', [
            'twilio_number' => $twilioNumber,
        ]);

        $user = User::with('settings')
            ->whereHas('settings', fn ($query) => $query->where('agent_sms_number', $twilioNumber))
            ->first();

        if (!$user) {
            Log::error('[FIND USER ACTION] - User not found for Twilio number', [
                'twilio_number' => $twilioNumber,
            ]);

            throw new Exception("User not found for Twilio number: {$twilioNumber}");
        }

        if (!$user->settings) {
            Log::error('[FIND USER ACTION] - User found but settings missing', [
                'user_id' => $user->id,
                'twilio_number' => $twilioNumber,
            ]);

            throw new Exception("Settings not configured for user");
        }

        Log::info('[FIND USER ACTION] - User found successfully', [
            'user_id' => $user->id,
            'twilio_number' => $twilioNumber,
        ]);

        return $user;
    }
} 