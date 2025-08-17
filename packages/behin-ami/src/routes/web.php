<?php

use Illuminate\Support\Facades\Route;
use Behin\Ami\Controllers\AmiSettingController;
use Behin\Ami\Controllers\AmiStatusController;

Route::prefix('ami')->name('ami.')->group(function () {
    Route::get('settings', [AmiSettingController::class, 'index'])->name('settings');
    Route::post('settings', [AmiSettingController::class, 'store'])->name('settings.store');
    Route::get('status', [AmiStatusController::class, 'index'])->name('status');
});
