<?php

use Illuminate\Support\Facades\Route;
use Behin\TelegramBot\Controllers\TelegramController;

Route::prefix('telegram')->name('telegram.')->group(function () {
    Route::post('bot', [TelegramController::class, 'storeBot'])->name('bot.store');
    Route::post('webhook/{token}', [TelegramController::class, 'webhook'])->name('webhook');
    Route::get('bots/{bot}/messages', [TelegramController::class, 'messages'])->name('messages');
    Route::post('messages/{message}/reply', [TelegramController::class, 'reply'])->name('reply');
});
