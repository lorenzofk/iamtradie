<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwilioController;

Route::group(['prefix' => 'twilio', 'as' => 'twilio.'], function () {
    Route::post('/text', [TwilioController::class, 'incomingText'])->name('incoming-text');
    Route::post('/voice', [TwilioController::class, 'incomingCall'])->name('incoming-call');

    if (app()->isLocal()) {
        Route::get('/no-answer', [TwilioController::class, 'missedCall'])->name('missed-call');
        Route::get('/transcription', [TwilioController::class, 'transcription'])->name('transcription');
        Route::get('/after-record', [TwilioController::class, 'afterRecord'])->name('after-record');
    } else {
        Route::post('/no-answer', [TwilioController::class, 'missedCall'])->name('missed-call');
        Route::post('/transcription', [TwilioController::class, 'transcription'])->name('transcription');
        Route::post('/after-record', [TwilioController::class, 'afterRecord'])->name('after-record');
    }
});