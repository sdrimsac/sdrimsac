<?php

use Illuminate\Support\Facades\Route;
use Modules\Dental\Http\Controllers\CashController;
use Modules\Dental\Http\Controllers\DentalController;
use Modules\Dental\Http\Controllers\ObservationController;
use Modules\Dental\Http\Controllers\OrdenController;
use Modules\Dental\Http\Controllers\SpecialtyController;
use Modules\Dental\Http\Controllers\TariffController;
use Modules\Restaurant\Http\Controllers\RestaurantController;

/* Route::prefix('dental')->group(function() {
    Route::get('/', 'DentalController@index');
}); */

Route::middleware(['auth'])->group(function () {
    Route::prefix('dental')->group(function () {
        Route::get('/', 'DentalController@index');
        Route::get('observations', [ObservationController::class, 'index'])->name('workshop.observations');
        Route::get('observations/columns', [ObservationController::class, 'columns']);
        Route::get('observations/records', [ObservationController::class, 'records']);
        Route::post('observations', [ObservationController::class, 'store']);
        Route::get('observations/record/{id}', [ObservationController::class, 'record']);
        Route::get('observations/{id}', [ObservationController::class, 'active']);

        Route::get('specialties', [SpecialtyController::class, 'index'])->name('tenant.dental.specialties');
        Route::get('specialties/record/{id}', [SpecialtyController::class, 'record']); //Admin
        /* Route::get('specialties/columns', [SpecialtyController::class, 'columns']); */
        Route::get('specialties/records', [SpecialtyController::class, 'records']);
        Route::post('specialties', [SpecialtyController::class, 'store']);
        Route::delete('specialties/{id}', [SpecialtyController::class, 'destroy']);

        
        Route::get('tariffs', [TariffController::class, 'index'])->name('tenant.dental.tariffs');
        Route::get('tariffs/record/{id}', [TariffController::class, 'record']);
        /* Route::get('tariffs/columns', [TariffController::class, 'columns']); */
        Route::get('tariffs/tables', [TariffController::class, 'tables']);
        Route::post('tariffs', [TariffController::class, 'store']);
        Route::get('tariffs/records', [TariffController::class, 'records']);
        Route::delete('tariffs/{id}', [TariffController::class, 'destroy']);



        Route::prefix('worker')->group(function () {
            Route::get('/dashboard-pos', [DentalController::class, 'pos']);
            Route::get('print_last_document', [OrdenController::class, 'print_last_document']);
            Route::post('pos/last_number_documents', [App\Http\Controllers\Tenant\PosController::class, 'last_number_documents']);
            Route::get('expenses', [DentalController::class, 'expenses'])->name('workshop.expenses.index')->middleware('just.worker');
            Route::get('expenses/records', [DentalController::class, 'records']);
            Route::get('expenses/record/{id}', [DentalController::class, 'record']);
            Route::post('expenses', [DentalController::class, 'store']);
            Route::delete('expenses/{id}', [DentalController::class, 'destroy']);
            Route::get('expenses/columns', [DentalController::class, 'columns']);
            Route::get('expenses/tables', [DentalController::class, 'tables']);
            Route::post('pos/orden_payment', [DentalController::class, 'payment']);
            Route::get('pos/search_orden', [DentalController::class, 'search']);
            Route::get('pos/listtables', [DentalController::class, 'listtables']);
            Route::get('pos/selecttabled/{idOrden}', [DentalController::class, 'electtabled']);
            Route::get('pos/foods', [DentalController::class, 'foods']);

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

            Route::get('search_customers', [RestaurantController::class, 'search_customer']);

            // promociones nuevo
            Route::post('pos/processPromo', 'PromocionPorItemController@processPromo');
            Route::get('pos/showCliePromos', 'PromocionPorItemController@showCliePromos');
            Route::post('pos/getPrductosPromo', 'PromocionPorItemController@getPrductosPromo');
            Route::post('pos/canjearPromo', 'PromocionPorItemController@canjearPromo');
            Route::post('pos/HistCanje', 'PromocionPorItemController@HistCanje');
        });
        /* Route::get('pos/foods', [WorkshopController::class, 'foods']); */
    });
});
