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
use Modules\Etiquetas\Http\Controllers\CodesController;
use Modules\Etiquetas\Http\Controllers\EtiquetasController;
Route::get('/etiquetas/generate', [EtiquetasController::class, 'generate']);

Route::get('/codes/generate', [CodesController::class, 'generate']);

Route::middleware(['auth', 'locked.tenant'])->group(function () {
    Route::prefix('etiquetas')->group(function () {
        Route::get('/', [EtiquetasController::class, 'index'])->name('etiquetas.index');
        Route::get('/items', [EtiquetasController::class, 'items']);
        Route::get('/tables', [EtiquetasController::class, 'tables']);
        Route::post('/palabra', [EtiquetasController::class, 'save_word']);
        Route::post('/image', [EtiquetasController::class, 'image']);
        Route::get('/delete_image', [EtiquetasController::class, 'delete_image']);
        // Route::get('/', 'EtiquetasController@index')->name('tenant.etiquetas.index');
    });

    Route::prefix('codes')->group(function () {
        Route::get('/', [CodesController::class, 'index'])->name('codes.index');
        Route::get('/items', [CodesController::class, 'items']);
        Route::get('/tables', [CodesController::class, 'tables']);
        Route::post('/palabra', [CodesController::class, 'save_word']);
        Route::post('/image', [CodesController::class, 'image']);
        Route::get('/delete_image', [CodesController::class, 'delete_image']);
        // Route::get('/', 'EtiquetasController@index')->name('tenant.etiquetas.index');
    });
});
