<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Consignment\Http\Controllers\ConsignmentController;
use Modules\Consignment\Http\Controllers\ConsignmentPenaltyController;

Route::prefix('consignment')->group(function() {
    Route::get('/', [ConsignmentController::class,'index'])->name('tenant.consignment.index');
    Route::get('/records', [ConsignmentController::class,'records']);
    Route::post('/', [ConsignmentController::class,'store']);
    Route::get('/items/{consignment_id}', [ConsignmentController::class,'items']);
    Route::get('/columns', [ConsignmentController::class,'columns']);
    Route::get('/tables', [ConsignmentController::class,'tables']);
    Route::get('/stock', [ConsignmentController::class,'stock']);

    Route::prefix('penalty')->group(function (){
        Route::get('/', [ConsignmentPenaltyController::class,'penalties']);
        Route::get('/records', [ConsignmentPenaltyController::class,'records']);
        Route::post('/', [ConsignmentPenaltyController::class,'store']);
    });
});
