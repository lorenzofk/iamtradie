<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\QuoteController;
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

    Route::prefix('ai')->name('ai.')->group(function () {
        Route::get('/quotes', fn () => Inertia::render('AI/QuoteGenerator'))->name('quotes');
        Route::post('/generate-quote', [OpenAIController::class, 'generateQuote'])->name('generate-quote');
        Route::post('/improve-quote', [OpenAIController::class, 'improveQuote'])->name('improve-quote');
    });

    Route::prefix('quotes')->name('quotes.')->group(function () {
        Route::get('/', [QuoteController::class, 'index'])->name('index');
        Route::get('/{quote}', [QuoteController::class, 'show'])->name('show');
        Route::delete('/{quote}', [QuoteController::class, 'destroy'])->name('destroy');
        Route::put('/{quote}', [QuoteController::class, 'update'])->name('update');
    });
});