<?php

namespace App\Services\Auth;

use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordService
{
    /**
     * Reset the user's password.
     */
    public function reset(array $data): void
    {
        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user
                    ->forceFill(['password' => Hash::make($password)])
                    ->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        throw_unless($status === Password::PASSWORD_RESET, Exception::class, trans($status));
    }
}