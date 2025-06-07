<?php

use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;
use App\Http\Controllers\TwilioController;

Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook'])->name('stripe.webhook');
Route::post('twilio/text', [TwilioController::class, 'text'])->name('twilio.text');
Route::post('/twilio/voice', [TwilioController::class, 'voice'])->name('twilio.voice');
Route::get('/twilio/no-answer', [TwilioController::class, 'missedCall'])->name('twilio.missedCall');
Route::get('/twilio/transcription', [TwilioController::class, 'transcription'])->name('twilio.transcription');
Route::get('/twilio/after-record', [TwilioController::class, 'afterRecord'])->name('twilio.afterRecord');