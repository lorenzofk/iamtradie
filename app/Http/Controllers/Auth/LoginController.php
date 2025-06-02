<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    /**
     * Show the login page.
     */
    public function index(): Response
    {
        return Inertia::render('Auth/Login')->with($this->getLayoutData());
    }

    /**
     * Handle the login request.
     */
    public function authenticate(LoginRequest $request): RedirectResponse
    {
        $remember = $request->boolean('remember');
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return redirect()->back()->withErrors(['email' => __('auth.failed')])->onlyInput('email');
    }

    /**
     * Get the layout data.
     */
    private function getLayoutData(): array
    {
        return [
            'layout' => [
                'title' => 'Login',
            ],
        ];
    }
}
