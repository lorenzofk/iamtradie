<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwilioController;

Route::group(['prefix' => 'twilio', 'as' => 'twilio.'], function () {
    Route::post('/text', [TwilioController::class, 'incomingText'])->name('incoming-text');
    Route::post('/call', [TwilioController::class, 'incomingCall'])->name('incoming-call');
    Route::post('/no-answer', [TwilioController::class, 'missedCall'])->name('missed-call');
    Route::post('/transcription', [TwilioController::class, 'transcription'])->name('transcription');
    Route::post('/after-record', [TwilioController::class, 'afterRecord'])->name('after-record');
});