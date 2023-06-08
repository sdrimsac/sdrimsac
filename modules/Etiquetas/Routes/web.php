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
use Modules\Etiquetas\Http\Controllers\EtiquetasController;

Route::middleware(['auth', 'locked.tenant'])->group(function () {
    Route::prefix('etiquetas')->group(function () {
        Route::get('/', [EtiquetasController::class, 'index'])->name('etiquetas.index');
        Route::get('/items', [EtiquetasController::class, 'items']);
        Route::get('/tables', [EtiquetasController::class, 'tables']);
        Route::post('/palabra', [EtiquetasController::class, 'save_word']);
        Route::post('/image', [EtiquetasController::class, 'image']);
        Route::get('/generate', [EtiquetasController::class, 'generate']);
        // Route::get('/', 'EtiquetasController@index')->name('tenant.etiquetas.index');
    });
});
