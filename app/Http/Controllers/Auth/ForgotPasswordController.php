<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\Auth\ForgotPasswordService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ForgotPasswordController extends Controller
{
    public function __construct(private ForgotPasswordService $forgotPasswordService) {}

    /**
     * Show the forgot password page.
     */
    public function index(): Response
    {
        return Inertia::render('Auth/ForgotPassword')->with($this->getLayoutData());
    }

    /**
     * Handle the forgot password request.
     */
    public function reset(ForgotPasswordRequest $request): RedirectResponse
    {
        try {
            $this->forgotPasswordService->sendResetLink($request->validated());
        } catch (Exception) {
            return redirect()->back()->withErrors(['error' => 'Error sending reset link']);
        }

        return redirect()->back()->with('success', 'If an account exists for this email address, you will receive a password reset link shortly.');
    }

    /**
     * Get the layout data.
     */
    private function getLayoutData(): array
    {
        return [
            'layout' => [
                'title' => 'Forgot Password',
            ],
        ];
    }
}
