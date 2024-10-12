<?php

use App\Http\Controllers\Tenant\PosController;
use Illuminate\Support\Facades\Route;
use Modules\Billar\Http\Controllers\BillarController;
use Modules\Restaurant\Http\Controllers\BoxesController;
use Modules\Restaurant\Http\Controllers\CashController;
use Modules\Restaurant\Http\Controllers\IncomesController;
use Modules\Restaurant\Http\Controllers\OrdenController;
use Modules\Restaurant\Models\Billar;

/* Route::middleware(['auth'])->group(function () { */
    Route::prefix('billar')->group(function () {

        Route::get('columns', [BillarController::class, 'columns']);

        Route::prefix('worker')->group(function () {
            Route::get('/dashboard-pos', [BillarController::class, 'pos'])->name('pos.billar');
        });
        Route::middleware(['auth', 'locked.tenant'])->group(function () {
            //**** MESAS */
            Route::prefix('worker')->group(function () {
    
    
                Route::get('cash_available/{cash_id}', [CashController::class, 'cash_avaible']);
                Route::get('data_reports', [BoxesController::class, 'data_reports']);
                Route::post('check_pin', [PosController::class, 'check_pin']);
                Route::post('logout', 'RestaurantController@logout');
                Route::get('print_last_document', [OrdenController::class, 'print_last_document']);
                Route::post('pos/last_number_documents', [App\Http\Controllers\Tenant\PosController::class, 'last_number_documents']);
                //Cleaner
                Route::get('cleaner', 'CleanerController@index')->name('restaurant.cleaner.index')->middleware('just.worker');;
                Route::get('tables', 'CleanerController@tables');
                //Mantenimiento
                Route::get('maintenance', 'MaintenanceController@index')->name('restaurant.maintenance.index')->middleware('just.worker');;
    
                Route::get('totales_sales', 'PosController@total_sales');
                Route::get('dashboard', 'DashboardController@index')->name('restaurant.workers.dashboard');
                Route::get('dashboard/foods', 'DashboardController@foods');
                Route::get('dashboard-kitchen', 'DashboardController@kitchen')->name('restaurant.kitchen.dashboard')->middleware('just.worker');
                /* Route::get('dashboard-pos', 'DashboardController@pos')->name('restaurant.pos.dashboard')->middleware('just.worker');; */
                Route::post('subcategories', [App\Http\Controllers\Tenant\SubcategoryController::class, 'store']);
                Route::post('category', [App\Http\Controllers\Tenant\CategoryController::class, 'store']);
                //Gastos
                Route::get('expenses', [PosController::class, 'expenses'])->name('restaurant.expenses.index')->middleware('just.worker');;
                Route::get('expenses/records', [PosController::class, 'records']);
                Route::get('expenses/record/{id}', [PosController::class, 'record']);
                Route::post('expenses', [PosController::class, 'store']);
                Route::delete('expenses/{id}', [PosController::class, 'destroy']);
                Route::get('expenses/columns', [PosController::class, 'columns']);
                Route::get('expenses/tables', [PosController::class, 'tables']);
    
                //Ingresos
                Route::get('incomes', [IncomesController::class, 'incomes'])->name('restaurant.incomes.index')->middleware('just.worker');;
                Route::get('incomes/records', [IncomesController::class, 'records']);
                Route::get('incomes/record/{id}', [IncomesController::class, 'record']);
                Route::post('incomes', [IncomesController::class, 'store']);
                Route::delete('incomes/{id}', [IncomesController::class, 'destroy']);
                Route::get('incomes/columns', [IncomesController::class, 'columns']);
                Route::get('incomes/tables', [IncomesController::class, 'tables']);
    
    
                Route::get('cash', [CashController::class, 'index'])->name('restaurant.cash.index')->middleware('just.worker');;
                Route::get('cash/columns', [CashController::class, 'columns']);
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
    
    
                Route::get('dashboard/tables/{area_id}', 'DashboardController@tables');
                //
                Route::post('pos/orden_payment', 'PosController@payment');
                Route::get('pos/search_orden', 'PosController@search');
                Route::get('pos/listtables', 'PosController@listtables');
                Route::get('pos/selecttabled/{idOrden}', 'PosController@selecttabled');
                Route::get('pos/foods', 'PosController@foods');
                Route::get('record/{id}', 'OrdenController@record');
                Route::get('record-worker/{id}', 'OrdenController@recordWorker');
    
                //ORDERS
                Route::post('send-orden', 'OrdenController@store');
                Route::get('search_orden_document', 'PosController@search_orden_document');
    
                Route::post('cancel-orden', 'OrdenController@cancelOrden');
                Route::post('cancel-orden-hotel', 'OrdenController@cancelOrdenHotel');
                Route::post('change-orden', 'OrdenController@changeOrder');
                Route::get('destroyorden/{ordenid}', 'OrdenController@destroyorden');
    
    
                Route::post('change-observation', 'OrdenItemController@updateObservation');
                Route::get('ordens-items', 'OrdenItemController@records');
                Route::get('ordens-list', 'OrdenController@ordenslist');
                Route::get('ordens-pending', 'OrdenController@ordenspending');
                // Route::get('ordens-areas', 'OrdenController@ordensareas');
    
                Route::get('list-ordens-items', 'OrdenItemController@list_ordens_items');
                Route::get('ordens-ready/{id}', 'OrdenItemController@ordenReady');
                Route::get('ordens-status', 'OrdenItemController@ordensStatus');
                Route::delete('delete-orden/{id}', 'OrdenItemController@ordenDelete');
                Route::post('delete-orden-pin', 'OrdenItemController@ordenDeletePin');
                //ACT. MESAS
                Route::get('tables/records-area/{area_id}', 'TableController@recordsByArea');
    
    
                //Promociones 
                Route::post('pos/processPromo', 'PromocionPorItemController@processPromo');
                Route::get('pos/showCliePromos', 'PromocionPorItemController@showCliePromos');
                Route::post('pos/getPrductosPromo', 'PromocionPorItemController@getPrductosPromo');
                Route::post('pos/canjearPromo', 'PromocionPorItemController@canjearPromo');
                Route::post('pos/HistCanje', 'PromocionPorItemController@HistCanje');

                // OBSERVACIONES
                Route::get('observations', 'ObservationController@index')->name('restaurant.observations');
                Route::get('observations/columns', 'ObservationController@columns');
                Route::get('observations/records', 'ObservationController@records');
                Route::post('observations', 'ObservationController@store');
                Route::get('observations/record/{id}', 'ObservationController@record');
                Route::get('observations/{id}', 'ObservationController@active');
            });
    
    
            Route::post('send-order', 'RestaurantController@sendOrder');
            Route::post('receive-order', 'RestaurantController@receiveOrder');
        });

        Route::get('', [BillarController::class, 'index'])->name('billar.billar');
        /* Route::get('columns', [BillarController::class, 'columns']); */
        Route::get('check', [BillarController::class, 'check']);
        Route::get('records', [BillarController::class, 'records']);
        Route::get('tables', [BillarController::class, 'get_tables']);
        Route::get('orden/{id}', [BillarController::class, 'get_ordens']);
        Route::get('record/{id}', [BillarController::class, 'record']);
        Route::post('billar', [BillarController::class, 'store']);
        // Route::post('billar', [BillarController::class, 'store2']);
        Route::post('disabled-table', [BillarController::class, 'disabled']);
        Route::post('enabled-table', [BillarController::class, 'enabled']);
        Route::post('massive', [BillarController::class, 'store_massive']);

        Route::post('detail_table', [BillarController::class, 'detail_table']);
        Route::get('detail_table', [BillarController::class, 'get_detail_table']);

        Route::post('pos/orden_payment', 'PosController@payment');
            Route::get('pos/search_orden', 'PosController@search');
            Route::get('pos/listtables', 'PosController@listtables');
            Route::get('pos/selecttabled/{idOrden}', 'PosController@selecttabled');
            Route::get('pos/foods', 'PosController@foods');
            Route::get('record/{id}', 'OrdenController@record');
            Route::get('record-worker/{id}', 'OrdenController@recordWorker');
    });
/* }); */
