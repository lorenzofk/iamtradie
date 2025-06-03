<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\Billing\GuestCheckoutController;
use App\Http\Middleware\Subscribed;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'reset'])->name('password.email')->middleware('throttle:6,1');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'index'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'update'])->name('password.update')->middleware('throttle:6,1');
});

Route::middleware(['auth', Subscribed::class])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update')->middleware([HandlePrecognitiveRequests::class]);

    Route::prefix('ai')->name('ai.')->group(function () {
        Route::get('/quote', [OpenAIController::class, 'index'])->name('index');
        Route::post('/generate-quote', [OpenAIController::class, 'generateQuote'])->name('generate-quote');
        Route::post('/improve-quote', [OpenAIController::class, 'improveQuote'])->name('improve-quote');
    });

    Route::prefix('quotes')->name('quotes.')->group(function () {
        Route::get('/', [QuoteController::class, 'index'])->name('index');
        Route::get('/{quote}', [QuoteController::class, 'show'])->name('show');
        Route::delete('/{quote}', [QuoteController::class, 'destroy'])->name('destroy');
        Route::put('/{quote}', [QuoteController::class, 'update'])->name('update');
        Route::post('/{quote}/send', [QuoteController::class, 'send'])->name('send');
    });

    Route::prefix('integrations')->name('integrations.')->group(function () {
        Route::get('/sms', [SmsController::class, 'index'])->name('sms.index');
    });
});

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/onboarding/{plan}', [OnboardingController::class, 'show'])->name('onboarding.show');

Route::post('/checkout', [GuestCheckoutController::class, 'create'])->name('checkout');
Route::get('/checkout/success', [GuestCheckoutController::class, 'success'])->name('checkout.success');
Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook'])->name('stripe.webhook');