<?php

use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;
use App\Http\Controllers\TwilioController;

Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook'])->name('stripe.webhook');

Route::group(['prefix' => 'twilio', 'as' => 'twilio.'], function () {
    Route::post('/text', [TwilioController::class, 'text'])->name('text');
    Route::post('/voice', [TwilioController::class, 'voice'])->name('voice');
    Route::get('/no-answer', [TwilioController::class, 'missedCall'])->name('missed-call');
    Route::get('/transcription', [TwilioController::class, 'transcription'])->name('transcription');
    Route::get('/after-record', [TwilioController::class, 'afterRecord'])->name('after-record');
});