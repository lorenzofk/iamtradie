<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwilioController;

Route::group(['prefix' => 'twilio', 'as' => 'twilio.'], function () {
    Route::post('/text', [TwilioController::class, 'text'])->name('text');
    Route::post('/voice', [TwilioController::class, 'voice'])->name('voice');
    Route::post('/no-answer', [TwilioController::class, 'missedCall'])->name('missed-call');
    Route::post('/transcription', [TwilioController::class, 'transcription'])->name('transcription');
    Route::post('/after-record', [TwilioController::class, 'afterRecord'])->name('after-record');
});