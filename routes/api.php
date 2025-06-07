<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwilioController;

Route::group(['prefix' => 'twilio', 'as' => 'twilio.'], function () {
    Route::post('/text', [TwilioController::class, 'text'])->name('text');
    Route::post('/voice', [TwilioController::class, 'voice'])->name('voice');
    Route::get('/no-answer', [TwilioController::class, 'missedCall'])->name('missed-call');
    Route::get('/transcription', [TwilioController::class, 'transcription'])->name('transcription');
    Route::get('/after-record', [TwilioController::class, 'afterRecord'])->name('after-record');
});