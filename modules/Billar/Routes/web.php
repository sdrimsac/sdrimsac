<?php

/* use App\Http\Controllers\Tenant\PosController; */
use Modules\Billar\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;
use Modules\Billar\Http\Controllers\BillarController;
use Modules\Billar\Http\Controllers\AreaController;
use Modules\Billar\Http\Controllers\BoxesController;
use Modules\Billar\Http\Controllers\CashController;
use Modules\Billar\Http\Controllers\IncomesController;
use Modules\Billar\Http\Controllers\OrdenController;
use Modules\Dashboard\Http\Controllers\DashboardController;
use Modules\Billar\Http\Controllers\ObservationController;
use Modules\Billar\Http\Controllers\OrdenItemController;
use Modules\Billar\Http\Controllers\StatusOrdenController;
use Modules\Billar\Http\Controllers\StatusTableController;
use Modules\Billar\Http\Controllers\TableController;
use Modules\Restaurant\Models\Billar;

/* Route::middleware(['auth'])->group(function () { */

Route::prefix('billar')->group(function () {

    Route::get('columns', [BillarController::class, 'columns']);

    Route::prefix('worker')->group(function () {
        Route::get('/dashboard-pos', [BillarController::class, 'pos'])->name('pos.billar');
        Route::post('pos/orden_payment', [PosController::class, 'payment']);
        Route::get('pos/search_orden', [PosController::class, 'search']);
        Route::get('pos/listtables', [PosController::class, 'listtables']);
        Route::get('pos/selecttabled/{idOrden}', [PosController::class, 'selecttabled']);
        Route::get('pos/foods', [PosController::class, 'foods']);
        Route::get('record/{id}', [OrdenController::class, 'record']);
        Route::get('record-worker/{id}', [OrdenController::class, 'recordWorker']);
        Route::post('pos/orden_payment', [PosController::class, 'payment']);
        Route::get('pos/search_orden', [PosController::class, 'search']);
        Route::get('pos/listtables', [PosController::class, 'listtables']);
        Route::get('pos/selecttabled/{idOrden}', [PosController::class, 'selecttabled']);
    /* Route::get('pos/foods', [PosController::class, 'foods']); */
    });
    Route::get('', [BillarController::class, 'index'])->name('billar.billar');
    /* Route::get('columns', [BillarController::class, 'columns']); */
    Route::get('check', [BillarController::class, 'check']);
    Route::get('records', [BillarController::class, 'records']);
    Route::get('tables', [BillarController::class, 'get_tables']);
    Route::get('orden/{id}', [BillarController::class, 'get_ordens']);
    Route::get('record/{id}', [BillarController::class, 'record']);
    Route::post('billar', [BillarController::class, 'store']);
    Route::post('disabled-table', [BillarController::class, 'disabled']);
    Route::post('enabled-table', [BillarController::class, 'enabled']);
    Route::post('massive', [BillarController::class, 'store_massive']);

    Route::post('detail_table', [BillarController::class, 'detail_table']);
    Route::get('detail_table', [BillarController::class, 'get_detail_table']);

    Route::get('status-tables', [StatusTableController::class, 'index'])->name('billar.status_table')->middleware("just.super");;
    Route::get('status-tables/records', [StatusTableController::class, 'records']);
    Route::get('status-tables/columns', [StatusTableController::class, 'columns']);
    Route::delete('status-tables/{id}', [StatusTableController::class, 'active']);
    Route::get('status-tables/record/{id}', [StatusTableController::class, 'record']);
    Route::post('status-tables', [StatusTableController::class, 'store']);

    /* Route::get('areas', [AreaController::class, 'index'])->name('billar.areas')->middleware("just.super");
    Route::get('areas/columns', [AreaController::class, 'columns']);
    Route::get('areas/records', [AreaController::class, 'records']);
    Route::get('areas/actives', [AreaController::class, 'actives']);
    Route::get('areas/record/{id}', [AreaController::class, 'record']);
    Route::delete('areas/{id}', [AreaController::class, 'active']);
    Route::post('areas', [AreaController::class, 'store']); */

    Route::get('status-orden', [StatusOrdenController::class, 'index']);
    Route::get('status-orden/records', [StatusOrdenController::class, 'records']);
    Route::get('status-orden/columns', [StatusOrdenController::class, 'columns']);
    Route::delete('status-orden/{id}', [StatusOrdenController::class, 'active']);
    Route::get('status-orden/record/{id}', [StatusOrdenController::class, 'record']);
    Route::post('status-orden', [StatusOrdenController::class, 'store']);
});

/* Route::middleware(['auth', 'locked.tenant'])->group(function () { */
Route::prefix('worker')->group(function () {

    Route::get('cash_available/{cash_id}', [CashController::class, 'cash_avaible']);
    Route::get('data_reports', [BoxesController::class, 'data_reports']);
    Route::post('check_pin', [PosController::class, 'check_pin']);
    /* Route::post('logout', 'RestaurantController@logout'); */
    Route::get('print_last_document', [OrdenController::class, 'print_last_document']);
    Route::post('pos/last_number_documents', [App\Http\Controllers\Tenant\PosController::class, 'last_number_documents']);

    Route::get('totales_sales', [PosController::class, '@total_sales']);
    Route::get('dashboard', [DashboardController::class, '@index'])->name('billar.workers.dashboard');
    Route::get('dashboard/foods', [DashboardController::class, 'foods']);
    Route::get('dashboard-kitchen', [DashboardController::class, 'kitchen'])->name('billar.kitchen.dashboard')->middleware('just.worker');

    Route::post('subcategories', [App\Http\Controllers\Tenant\SubcategoryController::class, 'store']);
    Route::post('category', [App\Http\Controllers\Tenant\CategoryController::class, 'store']);
    //Gastos
    Route::get('expenses', [PosController::class, 'expenses'])->name('billar.expenses.index')->middleware('just.worker');;
    Route::get('expenses/records', [PosController::class, 'records']);
    Route::get('expenses/record/{id}', [PosController::class, 'record']);
    Route::post('expenses', [PosController::class, 'store']);
    Route::delete('expenses/{id}', [PosController::class, 'destroy']);
    Route::get('expenses/columns', [PosController::class, 'columns']);
    Route::get('expenses/tables', [PosController::class, 'tables']);

    //Ingresos
    Route::get('incomes', [IncomesController::class, 'incomes'])->name('billar.incomes.index')->middleware('just.worker');;
    Route::get('incomes/records', [IncomesController::class, 'records']);
    Route::get('incomes/record/{id}', [IncomesController::class, 'record']);
    Route::post('incomes', [IncomesController::class, 'store']);
    Route::delete('incomes/{id}', [IncomesController::class, 'destroy']);
    Route::get('incomes/columns', [IncomesController::class, 'columns']);
    Route::get('incomes/tables', [IncomesController::class, 'tables']);

    Route::get('cash', [CashController::class, 'index'])->name('billar.cash.index')->middleware('just.worker');;
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

    Route::get('record-worker/{id}', [OrdenController::class, 'recordWorker']);
    Route::post('send-orden', [OrdenController::class, 'store']);
    Route::post('cancel-orden', [OrdenController::class, 'cancelOrden']);
    Route::post('change-orden', [OrdenController::class, 'changeOrder']);
    Route::get('destroyorden/{ordenid}', [OrdenController::class, 'destroyorden']);
    Route::get('ordens-list', [OrdenController::class, 'ordenslist']);
    Route::get('ordens-pending', [OrdenController::class, 'ordenspending']);
    Route::post('change-observation', [OrdenItemController::class, 'updateObservation']);
    Route::get('ordens-items', [OrdenItemController::class, 'records']);
    Route::get('list-ordens-items', [OrdenItemController::class, 'list_ordens_items']);
    Route::get('ordens-ready/{id}', [OrdenItemController::class, '@ordenReady']);
    Route::get('ordens-status', [OrdenItemController::class, 'ordensStatus']);
    Route::delete('delete-orden/{id}', [OrdenItemController::class, 'ordenDelete']);
    Route::post('delete-orden-pin', [OrdenItemController::class, 'ordenDeletePin']);
    //ACT. MESAS
    Route::get('tables/records-area/{area_id}', [TableController::class, 'recordsByArea']); 

    //Promociones 
    Route::post('pos/processPromo', 'PromocionPorItemController@processPromo');
    Route::get('pos/showCliePromos', 'PromocionPorItemController@showCliePromos');
    Route::post('pos/getPrductosPromo', 'PromocionPorItemController@getPrductosPromo');
    Route::post('pos/canjearPromo', 'PromocionPorItemController@canjearPromo');
    Route::post('pos/HistCanje', 'PromocionPorItemController@HistCanje');

    // OBSERVACIONES
    Route::get('observations', [ObservationController::class, 'index'])->name('billar.observations');
    Route::get('observations/columns', [ObservationController::class, 'columns']);
    Route::get('observations/records', [ObservationController::class, 'records']);
    Route::post('observations', [ObservationController::class, 'store']);
    Route::get('observations/record/{id}', [ObservationController::class, 'record']);
    Route::get('observations/{id}', [ObservationController::class, 'active']);
});
/* }); */
/* }); */
