<?php

use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;

Route::post('twilio/webhook', [App\Http\Controllers\TwilioController::class, 'webhook'])->name('twilio.webhook');
Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook'])->name('stripe.webhook');