<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\ResetPasswordService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ResetPasswordController extends Controller
{
    public function __construct(private ResetPasswordService $resetPasswordService) {}

    /**
     * Show the reset password page.
     */
    public function index(string $token): Response
    {
        $props = [
            'token' => $token,
            'email' => request('email'),
        ];

        return Inertia::render('Auth/ResetPassword', $props)->with($this->getLayoutData());
    }

    /**
     * Handle the reset password request.
     */
    public function update(ResetPasswordRequest $request): RedirectResponse
    {
        try {
            $this->resetPasswordService->reset($request->validated());
        } catch (Exception) {
            return back()->withInput()->withErrors(['error' => 'Error resetting password']);
        }

        return redirect()->route('login')->with('success', 'Password reset successfully');
    }

    /**
     * Get the layout data.
     */
    private function getLayoutData(): array
    {
        return [
            'layout' => [
                'title' => 'Reset Password',
            ],
        ];
    }
}
