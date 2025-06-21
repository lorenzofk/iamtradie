<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\Checkout\GuestCheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\HowItWorksController;
use App\Http\Middleware\Subscribed;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;

Route::middleware('guest')->group(function (): void {
    Route::get('/', [LandingPageController::class, 'index'])->name('landing');
    Route::get('/onboarding', [OnboardingController::class, 'show'])->name('onboarding.show');
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'reset'])->name('password.email')->middleware('throttle:6,1');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'index'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'update'])->name('password.update')->middleware('throttle:6,1');
});

Route::middleware(['auth', Subscribed::class])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::prefix('quotes')->name('quotes.')->group(function (): void {
        Route::get('/', [QuoteController::class, 'index'])->name('index');
        Route::get('/{quote}', [QuoteController::class, 'show'])->name('show');
        Route::delete('/{quote}', [QuoteController::class, 'destroy'])->name('destroy');
        Route::put('/{quote}', [QuoteController::class, 'update'])->name('update');
        Route::post('/{quote}/send', [QuoteController::class, 'send'])->name('send');
    });

    Route::prefix('settings')->name('settings.')->group(function (): void {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/', [SettingsController::class, 'update'])->name('update')->middleware([HandlePrecognitiveRequests::class]);
    });

    Route::get('/how-it-works', [HowItWorksController::class, 'index'])->name('how-it-works');

    Route::prefix('billing')->name('billing.')->group(function (): void {
        Route::get('/', [BillingController::class, 'index'])->name('index');
        Route::get('/manage', [BillingController::class, 'manage'])->name('manage');
        Route::post('/cancel', [BillingController::class, 'cancel'])->name('cancel');
        Route::post('/resume', [BillingController::class, 'resume'])->name('resume');
        Route::post('/subscribe', [BillingController::class, 'subscription'])->name('subscribe');
    });
});

Route::post('/checkout', [GuestCheckoutController::class, 'create'])->name('checkout');
Route::get('/checkout/success', [GuestCheckoutController::class, 'success'])->name('checkout.success');
Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook'])->name('stripe.webhook');
