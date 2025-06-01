<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\OpenAIController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
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
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update')->middleware([HandlePrecognitiveRequests::class]);

    Route::get('/ai/quotes', fn () => Inertia::render('AI/QuoteGenerator'))->name('ai.quotes');

    Route::prefix('twilio')->name('twilio.')->group(function () {
        Route::post('/send-quote', [App\Http\Controllers\TwilioController::class, 'sendQuote'])->name('send-quote');
        Route::post('/send-message', [App\Http\Controllers\TwilioController::class, 'sendMessage'])->name('send-message');
    });

    Route::prefix('ai')->name('ai.')->group(function () {
        Route::post('/generate-quote', [OpenAIController::class, 'generateQuote'])->name('generate-quote');
        Route::post('/improve-quote', [OpenAIController::class, 'improveQuote'])->name('improve-quote');
    });
});