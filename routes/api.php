<?php

declare(strict_types=1);

use App\Http\Controllers\TwilioController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'twilio', 'as' => 'twilio.'], function (): void {
    Route::post('/text', [TwilioController::class, 'incomingText'])->middleware(\App\Http\Middleware\PreventChattySMS::class)->name('incoming-text');
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
