<?php

use Illuminate\Support\Facades\Route;
use Modules\Workshop\Http\Controllers\CashController;
use Modules\Workshop\Http\Controllers\ObservationController;
use Modules\Workshop\Http\Controllers\WorkshopController;
use Modules\Workshop\Http\Controllers\SellerController;

Route::prefix('workshop')->group(function() {
    Route::get('/', 'WorkshopController@index');
    Route::get('observations', [ObservationController::class, 'index'])->name('workshop.observations');
            Route::get('observations/columns', [ObservationController::class, 'columns']);
            Route::get('observations/records', [ObservationController::class, 'records']);
            Route::post('observations', [ObservationController::class, 'store']);
            Route::get('observations/record/{id}', [ObservationController::class, 'record']);
            Route::get('observations/{id}', [ObservationController::class, 'active']);

            /* Route::get('/mecanico', [SellerController::class, 'index'])->name('tenant.workshop.mecanico');
            Route::get('/mecanico/columns', [SellerController::class, 'columns']);
            Route::get('/mecanico/records', [SellerController::class, 'records']);
            Route::post('/mecanico', [SellerController::class, 'store']);
            Route::get('/mecanico/record/{id}', [SellerController::class, 'record']);
            Route::get('/mecanico/{id}', [SellerController::class, 'mecanico']); */
           

    Route::prefix('worker')->group(function () {
        Route::get('/dashboard-pos', [WorkshopController::class, 'pos']);
        Route::post('pos/last_number_documents', [App\Http\Controllers\Tenant\PosController::class, 'last_number_documents']);
        Route::get('expenses', [WorkshopController::class, 'expenses'])->name('workshop.expenses.index')->middleware('just.worker');;
            Route::get('expenses/records', [WorkshopController::class, 'records']);
            Route::get('expenses/record/{id}', [WorkshopController::class, 'record']);
            Route::post('expenses', [WorkshopController::class, 'store']);
            Route::delete('expenses/{id}', [WorkshopController::class, 'destroy']);
            Route::get('expenses/columns', [WorkshopController::class, 'columns']);
            Route::get('expenses/tables', [WorkshopController::class, 'tables']);
            Route::post('pos/orden_payment', [WorkshopController::class, 'payment']);
            Route::get('pos/search_orden', [WorkshopController::class, 'search']);
            Route::get('pos/listtables', [WorkshopController::class, 'listtables']);
            Route::get('pos/selecttabled/{idOrden}', [WorkshopController::class, 'electtabled']);
            Route::get('pos/foods', [WorkshopController::class, 'foods']);

            Route::get('cash', [CashController::class, 'index'])->name('restaurant.cash.index')->middleware('just.worker');;
            Route::get('cash/get-final-balance/{cash_id}', [CashController::class, 'getFinalBalance']);
            Route::get('cash/columns', [CashController::class, 'columns']);
            Route::get('cash/generate_reports/{cash_id}', [CashController::class, 'generate_reports']);
            Route::get('cash/records', [CashController::class, 'records']);
            Route::get('cash/records_closed', [CashController::class, 'recordsClosed']);
            Route::get('cash/create', [CashController::class, 'create'])->name('tenant.cash_pos.create')->middleware('just.worker');;
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

            
    });
    /* Route::get('pos/foods', [WorkshopController::class, 'foods']); */
});
