<?php

use Illuminate\Support\Facades\Route;
use Modules\Services\Http\Controllers\ServiceController;


Route::middleware(['auth', 'locked.tenant'])->group(function () {
    Route::prefix('service')->group(function () {
        Route::get('{type}/{number}', [ServiceController::class, 'service']);
        Route::get('exchange', [ServiceController::class, 'exchange']);
    });
});
