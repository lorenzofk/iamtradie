<?php

use Illuminate\Support\Facades\Route;

Route::post('twilio/webhook', [App\Http\Controllers\TwilioController::class, 'webhook'])->name('twilio.webhook');