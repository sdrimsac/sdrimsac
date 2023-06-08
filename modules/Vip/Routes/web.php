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
use Modules\Vip\Http\Controllers\VipController;

Route::prefix('vip')->group(function () {
    Route::get('/', [VipController::class, 'index'])->name('vip.index');
    Route::get('clients', [VipController::class, 'clients'])->name('vip.clients');
    Route::get('categories/records', [VipController::class, 'records']);
    Route::get('categories/record/{id}', [VipController::class, 'record']);
    Route::get('categories/desactive/{id}', [VipController::class, 'desactive']);
    Route::post('category', [VipController::class, 'store']);
    Route::get('categories/columns', [VipController::class, 'columns']);
});
