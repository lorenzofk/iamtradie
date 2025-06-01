<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('Home'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'reset'])->name('password.email')->middleware('throttle:6,1');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'index'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'update'])->name('password.update')->middleware('throttle:6,1');
});

Route::middleware('auth')->group(function () {
    Route::get('/', fn() => Inertia::render('Home'))->name('home');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Twilio routes
    Route::prefix('twilio')->name('twilio.')->group(function () {
        Route::post('/send-message', [App\Http\Controllers\TwilioController::class, 'sendMessage'])->name('send-message');
        Route::post('/send-quote', [App\Http\Controllers\TwilioController::class, 'sendQuote'])->name('send-quote');
        Route::post('/validate-phone', [App\Http\Controllers\TwilioController::class, 'validatePhone'])->name('validate-phone');
        Route::get('/account-info', [App\Http\Controllers\TwilioController::class, 'getAccountInfo'])->name('account-info');
    });
});

// Public webhook route (no auth required)
Route::post('/twilio/webhook', [App\Http\Controllers\TwilioController::class, 'webhook'])->name('twilio.webhook');