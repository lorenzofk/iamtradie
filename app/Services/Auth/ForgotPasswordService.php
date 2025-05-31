<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Password;

class ForgotPasswordService
{
    /**
     * Send a password reset link to the given user.
     */
    public function sendResetLink(array $data): void
    {
        Password::sendResetLink(['email' => $data['email']]);
    }
}