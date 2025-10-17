<?php

use Illuminate\Support\Facades\Route;
use Modules\Grifo\Http\Controllers\CashController;
use Modules\Grifo\Http\Controllers\OrdenController;
use Modules\MeatShop\Http\Controllers\MeatShopController;
use Modules\Restaurant\Http\Controllers\RestaurantController;

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
Route::middleware(['auth'])->group(function () {
Route::prefix('meatshop')->group(function() {
    Route::get('/', 'MeatShopController@index');

        Route::prefix('worker')->group(function () {
            Route::get('/dashboard-pos', [MeatShopController::class, 'pos']);
            Route::get('print_last_document', [OrdenController::class, 'print_last_document']);
            Route::post('pos/last_number_documents', [App\Http\Controllers\Tenant\PosController::class, 'last_number_documents']);
            Route::get('expenses', [MeatShopController::class, 'expenses'])->name('grifo.expenses.index')->middleware('just.worker');
            Route::get('expenses/records', [MeatShopController::class, 'records']);
            Route::get('expenses/record/{id}', [MeatShopController::class, 'record']);
            Route::post('expenses', [MeatShopController::class, 'store']);
            Route::delete('expenses/{id}', [MeatShopController::class, 'destroy']);
            Route::get('expenses/columns', [MeatShopController::class, 'columns']);
            Route::get('expenses/tables', [MeatShopController::class, 'tables']);
            Route::post('pos/orden_payment', [MeatShopController::class, 'payment']);
            Route::get('pos/search_orden', [MeatShopController::class, 'search']);
            Route::get('pos/listtables', [MeatShopController::class, 'listtables']);
            Route::get('pos/selecttabled/{idOrden}', [MeatShopController::class, 'electtabled']);
            Route::get('pos/foods', [MeatShopController::class, 'foods']);
            Route::get('cash', [CashController::class, 'index'])->name('restaurant.cash.index')->middleware('just.worker');
            Route::get('cash/get-final-balance/{cash_id}', [CashController::class, 'getFinalBalance']);
            Route::get('cash/columns', [CashController::class, 'columns']);
            Route::get('cash/generate_reports/{cash_id}', [CashController::class, 'generate_reports']);
            Route::get('cash/records', [CashController::class, 'records']);
            Route::get('cash/records_closed', [CashController::class, 'recordsClosed']);
            Route::get('cash/create', [CashController::class, 'create'])->name('tenant.cash_pos.create')->middleware('just.worker');
            Route::get('cash/tables', [CashController::class, 'tables']);
            Route::get('cash/final_balance_last_principal', [CashController::class, 'final_balance_last_principal']);
            Route::get('cash/opening_cash', [CashController::class, 'opening_cash']);
            Route::get('cash/opening_cash_check/{user_id}', [CashController::class, 'opening_cash_check']);
            Route::post('cash', [CashController::class, 'store']);
            Route::post('cash/close', [CashController::class, 'close']);
            Route::get('cash/report/{cash}', [CashController::class, 'report']);
            Route::get('cash/get_printer/{area_id}', [CashController::class, 'get_printer']);
            Route::get('cash/get_last_documents', [CashController::class, 'get_last_documents']);
            Route::get('cash/incomes_expenses', [CashController::class, 'incomes_expenses']);
            Route::delete('cash/incomes_expenses/{id}/{type}', [CashController::class, 'incomes_expenses_delete']);
            Route::get('cash/report', [CashController::class, 'report_general']);
            Route::get('cash/record/{cash}', [CashController::class, 'record']);
            Route::delete('cash/{cash}', [CashController::class, 'destroy']);
            Route::get('cash/item/tables', [CashController::class, 'item_tables']);
            Route::get('cash/search/customers', [CashController::class, 'searchCustomers']);
            Route::get('cash/search/customer/{id}', [CashController::class, 'searchCustomerById']);
            Route::get('cash/report/products/{cash}', [CashController::class, 'report_products']);
            Route::get('search_customers', [RestaurantController::class, 'search_customer']);
            // promociones nuevo
            Route::post('pos/processPromo', 'PromocionPorItemController@processPromo');
            Route::get('pos/showCliePromos', 'PromocionPorItemController@showCliePromos');
            Route::post('pos/getPrductosPromo', 'PromocionPorItemController@getPrductosPromo');
            Route::post('pos/canjearPromo', 'PromocionPorItemController@canjearPromo');
            Route::post('pos/HistCanje', 'PromocionPorItemController@HistCanje');
        });
    });
});
