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
use Modules\LotItem\Http\Controllers\LotItemController;

Route::prefix('lotitem')->group(function () {
    Route::get('/', [LotItemController::class, "index"])->name('itemlots');
    Route::get('records', [LotItemController::class, "records"]);
    Route::get('record/{id}', [LotItemController::class, "record"]);
    Route::get('delete/{id}', [LotItemController::class, "delete_record"]);
    Route::post('record', [LotItemController::class, "update_record"]);
    Route::get('excel', [LotItemController::class, "excel"]);
    Route::post('import', [LotItemController::class, "import"]);
    Route::get('pdf', [LotItemController::class, "pdf"]);
    Route::get('series-by-item', [LotItemController::class, "recordsByItem"]);
    Route::get('tables', [LotItemController::class, "tables"]);
});
