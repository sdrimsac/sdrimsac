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

/* Route::prefix('restobar')->group(function() {
    Route::get('/', 'RestobarController@index');
}); */


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

use Illuminate\Support\Str;
use App\Events\MessageEvent;
use App\Http\Controllers\Tenant\DocumentController;
use App\Http\Controllers\Tenant\GenerateController;
use App\Http\Controllers\Tenant\SaleNoteController;
use App\Models\Tenant\Configuration;
use Illuminate\Support\Facades\Route;
use Modules\Restobar\Http\Controllers\AreaController;
use Modules\Restobar\Http\Controllers\BoxesController;
use Modules\Restobar\Http\Controllers\BoxesDetailController;
use Modules\Restobar\Http\Controllers\CashController;
use Modules\Restobar\Http\Controllers\CashTransferController;
use Modules\Restobar\Http\Controllers\DashboardController;
use Modules\Restobar\Http\Controllers\FoodController;
use Modules\Restobar\Http\Controllers\PosController;
use Modules\Restobar\Http\Controllers\IncomesController;
use Modules\Restobar\Http\Controllers\ObservationController;
use Modules\Restobar\Http\Controllers\OrdenController;
use Modules\Restobar\Http\Controllers\OrdenItemController;
use Modules\Restobar\Http\Controllers\RestaurantController;
use Modules\Restobar\Http\Controllers\PromocionPorItemController;
use Modules\Restobar\Http\Controllers\RestobarController;
use Modules\Restobar\Http\Controllers\StatusOrdenController;
use Modules\Restobar\Http\Controllers\StatusTableController;
use Modules\Restobar\Http\Controllers\TableController;
use Modules\Restobar\Http\Controllers\WorkerController;
use Modules\Restobar\Http\Controllers\WorkersTypeController;

Route::prefix('restobar')->group(function () {
    //Route::get('/', 'RestaurantController@index');
    //Route::get('documents', 'OrdenController@printTicket');

    Route::post('/override-session', [RestaurantController::class, 'window']);
    Route::post('/re-print', [RestaurantController::class, 'rePrint']);
    Route::get('sale-notes', [SaleNoteController::class, 'pos'])->name('pos.sale_notes.index')->middleware('redirect.level');
    Route::get('documents', [DocumentController::class, 'documents'])->name('restobar.documents.index');
    Route::get('documents/create/{documents?}', [DocumentController::class, 'create_pos'])->name('tenant.documents_pos.create')->middleware(['redirect.level', 'tenant.internal.mode']);
    Route::get('documents/data_table', [DocumentController::class, 'data_table']);
    Route::get('documents/records', [DocumentController::class, 'records']);
    Route::get('worker/print-ticket', [OrdenController::class, 'printTicket']);

    Route::get('/delivery/ticket', [OrdenController::class, 'DeliveryOrden']);

    Route::get('worker/cash/print-report', [CashController::class, 'print_report']);
    Route::get('worker/cash/print-report-usd', [CashController::class, 'print_report_usd']);
    Route::get('worker/expenses/print-box', [RestobarController::class, 'print_box']);
    Route::post('workers/uploads', [WorkerController::class, 'upload']);
    Route::get('workers/images/{workers}', [WorkerController::class, 'images']);
    Route::get('workers/authenticated-user', [WorkerController::class, 'getAuthenticatedUser']);

    Route::get('report-boxes', 'BoxesController@report')->name('restobar.report.boxes');
    Route::get('report-boxes/tables', 'BoxesController@tables');

    Route::get('report-boxes/cashes_salud', 'BoxesController@cashes_salud');
    Route::get('report-boxes/cashes_salud_single', 'BoxesController@cashes_salud_single');
    Route::post('report-boxes/save_info_pharmacy/{id}', 'BoxesController@save_info_pharmacy');
    Route::get('report-boxes/reports_resumen_type', 'BoxesController@reports_resumen_type');
    Route::get('report-boxes/reports_resumen_type_usd', 'BoxesController@reports_resumen_type_usd');
    Route::get('report-boxes/reports_resumen_type_page', 'BoxesController@reports_resumen_type_page');

    Route::delete('report-boxes/delete-report/{id}', 'BoxesController@deleteReport');

    Route::get('report-boxes/reports_resumen_yape', 'BoxesController@reports_resumen_yape');
    Route::get('cash/balance-final/{date_closed}', 'BoxesController@balance_final');

    Route::get('report-boxes/reports_categoria_type', 'BoxesController@reports_categoria_type');
    Route::get('report-boxes/reports_type', [BoxesController::class, 'reports_type']);
    Route::get('report-boxes/reports_bancario_type', 'BoxesController@reports_bancario_type');
    Route::get('report-boxes/reports', 'BoxesController@reports_results');
    Route::get('report-product-warehouse-w', [WorkerController::class, 'report_products_w']);

    /* Route::get('login', 'RestaurantController@loginWorker');
    Route::post('login', [RestaurantController::class, 'login']); */

    Route::middleware(['auth', 'locked.tenant'])->group(function () {

        Route::get('logoutget', 'RestaurantController@logout');

        Route::get('test-sender', function () {

            $keyword = request("message");
            event(new MessageEvent($keyword));
        });
        Route::get('/delivery/DeliveryPrinter', [OrdenController::class, 'DeliveryPrinter']);
        Route::get('test', function () {
            $configuration = Configuration::first();
            if ($configuration->socket_channel == null) {
                $configuration->socket_channel = Str::random(25);
                $configuration->save();
                $event_name = $configuration->socket_channel;
            }
            return view('restobar::restobar', compact('configuration'));
        });
        Route::get('kitchen', function () {
            $configuration = Configuration::first();
            if ($configuration->socket_channel == null) {
                $configuration->socket_channel = Str::random(25);
                $configuration->save();
                $event_name = $configuration->socket_channel;
            }
            return view('restobar::kitchen', compact('configuration'));
        });

        Route::get('report-product-warehouse', [WorkerController::class, 'report_products']);

        //cash transfer

        Route::prefix('cash-transfer')->group(function () {
            Route::get('/', [CashTransferController::class, 'index'])->name('caja.cash_transfer');
            Route::prefix('report')->group(function () {
                Route::get('/', [CashTransferController::class, 'index_report'])->name('caja.cash_transfer_report');
                Route::get('/columns', [CashTransferController::class, 'columns_report']);
                Route::get('/records', [CashTransferController::class, 'records_report']);
                Route::get('/export', [CashTransferController::class, 'export_report']);
            });
            Route::get('/columns', [CashTransferController::class, 'columns']);
            Route::get('available', [CashTransferController::class, 'available']);
            Route::get('available-credit', [CashTransferController::class, 'availableCredit']);
            Route::get('records', [CashTransferController::class, 'records']);
            Route::get('cashes', [CashTransferController::class, 'cashes']);
            Route::get('cashes-principal', [CashTransferController::class, 'cashes_principal']);
            Route::get('record/{id}', [CashTransferController::class, 'record']);
            Route::post('', [CashTransferController::class, 'store']);
            Route::delete('{id}', [CashTransferController::class, 'destroy']);
        });

        Route::get('delivery/DeliveryPrinter', [OrdenController::class, 'DeliveryPrinter']);
        Route::get('cashes', [BoxesController::class, 'cashes'])->name('restobar.cash');
        Route::get('ordens', [OrdenController::class, 'index'])->name('restobar.ordens');
        Route::get('boxes/records/{id}', [BoxesController::class, 'get_boxes']);
        Route::post('boxes/validation', [BoxesController::class, 'validation_methods']);
        Route::get('ordens/records', [OrdenController::class, 'records']);
        // Route::get('ordens/record-by-id/{id}', 'OrdenController@recordById');
        Route::get('ordens/listfoods/{date}', [BoxesController::class, 'listfoods']);
        Route::get('ordens/payment/{type}/{document_id}/{orderid}', [BoxesController::class, 'paymentorden']);
        //**** COMIDAS / BEBIDAS */
        Route::get('food-list', [FoodController::class, 'index'])->name('restaurant.food_list');
        Route::get('food-list/records', [FoodController::class, 'records']);
        Route::get('food-list/record/{id}', [FoodController::class, 'record']);
        Route::get('food-list/delete-image/{id}', [FoodController::class, 'deleteImage']);
        Route::get('food-list/{id}', [FoodController::class, 'active']);
        Route::post('food-list/upload-image', [FoodController::class, 'uploadImage']);
        Route::post('food-list', [FoodController::class, 'store']);
        Route::get('observations', [ObservationController::class, 'index'])->name('restobar.observations');
        Route::get('observations/columns', [ObservationController::class, 'columns']);
        Route::get('observations/remove/{id}', [ObservationController::class, 'remove']);
        Route::get('observations/records', [ObservationController::class, 'records']);
        Route::get('observations/items', [ObservationController::class, 'tables']);
        Route::post('observations', [ObservationController::class, 'store']);
        Route::get('observations/record/{id}', [ObservationController::class, 'record']);
        Route::get('observations/{id}', [ObservationController::class, 'active']);
        //**** TIPO DE TRABAJADORES */
        Route::get('workers-type', [WorkersTypeController::class, 'index'])->name('restobar.workers_type')->middleware("just.super");
        Route::get('workers-type/columns', [WorkersTypeController::class, 'columns']);
        Route::get('workers-type/records', [WorkersTypeController::class, 'records']);
        Route::get('workers-type/actives', [WorkersTypeController::class, 'actives']);
        Route::get('workers-type/record/{id}', [WorkersTypeController::class, 'record']);
        Route::get('workers-type/{id}', [WorkersTypeController::class, 'active']);
        Route::post('workers-type', [WorkersTypeController::class, 'store']);
        Route::get('workers-type/recordsActivity', [WorkersTypeController::class, 'recordsActivity']);
        Route::get('areas', [AreaController::class, 'index'])->name('restobar.areas')->middleware("just.super");
        Route::get('areas/columns', [AreaController::class, 'columns']);
        Route::get('areas/records', [AreaController::class, 'records']);
        Route::get('areas/actives', [AreaController::class, 'actives']);
        Route::get('areas/record/{id}', [AreaController::class, 'record']);
        Route::delete('areas/{id}', [AreaController::class, 'active']);
        Route::post('areas', [AreaController::class, 'store']);
        Route::get('status-tables', [StatusTableController::class, 'index'])->name('restobar.status_table')->middleware("just.super");
        Route::get('status-tables/records', [StatusTableController::class, 'records']);
        Route::get('status-tables/columns', [StatusTableController::class, 'columns']);
        Route::delete('status-tables/{id}', [StatusTableController::class, 'active']);
        Route::get('status-tables/record/{id}', [StatusTableController::class, 'record']);
        Route::post('status-tables', [StatusTableController::class, 'store']);
        Route::get('status-orden', [StatusOrdenController::class, 'index'])->name('restobar.status_orden')->middleware("just.super");
        Route::get('status-orden/records', [StatusOrdenController::class, 'records']);
        Route::get('status-orden/columns', [StatusOrdenController::class, 'columns']);
        Route::delete('status-orden/{id}', [StatusOrdenController::class, 'active']);
        Route::get('status-orden/record/{id}', [StatusOrdenController::class, 'record']);
        Route::post('status-orden', [StatusOrdenController::class, 'store']);
        Route::get('tables', [TableController::class, 'index'])->name('restobar.tables');
        Route::get('tables/columns', [TableController::class, 'columns']);
        Route::get('tables/check', [TableController::class, 'check']);
        Route::get('tables/records', [TableController::class, 'records']);
        Route::get('tables/tables', [TableController::class, 'get_tables']);
        Route::get('tables/getTablesDelivery', [TableController::class, 'get_tables_delivery']);
        Route::get('tables/tables-zone', [TableController::class, 'tables_zones']);
        Route::post('tables/store/{type}', [TableController::class, 'store_zone']);
        Route::delete('tables/delete/{type}/{id}', [TableController::class, 'deleteItemZone']);
        Route::get('tables/orden/{id}', [TableController::class, 'get_ordens']);
        Route::get('tables/UserTable', [TableController::class, 'UserTable']);
        Route::get('tables/record/{id}', [TableController::class, 'record']);
        Route::get('tables/table-types', [TableController::class, 'tableTypes']);
        Route::post('tables', [TableController::class, 'store']);
        Route::post('tables/disabled-table', [TableController::class, 'disabled']);
        Route::post('tables/enabled-table', [TableController::class, 'enabled']);
        Route::post('tables/massive', [TableController::class, 'store_massive']);
        //**** TRABAJADORES */
        Route::get('workers', [WorkerController::class, 'index'])->name('restobar.workers');
        Route::get('workers/records', [WorkerController::class, 'records']);
        Route::get('workers/{id}', [WorkerController::class, 'active']);
        Route::get('workers/columns', [WorkerController::class, 'columns']);
        Route::post('workers/commercial_treatment', [WorkerController::class, 'commercial_treatment']);
        Route::get('workers/record/{id}', [WorkerController::class, 'record']);
        Route::post('workers', [WorkerController::class, 'store']);
        Route::get('pos', [RestobarController::class, 'index'])->name('restobar.pos');
        Route::get('pos/search_orden', [RestobarController::class, 'search']);
        Route::get('pos/update_items_warehouse', [RestobarController::class, 'updateItemWithWarehouse']);
        Route::get('pos/series', [RestobarController::class, 'series']);
        Route::post('pos/orden_payment', [RestobarController::class, 'payment']);
        Route::get('pos/foods', [RestobarController::class, 'foods']);
        //Route::get('pos/item/{id}', [PosController::class, 'itemNew']);
        Route::get('boxes', [BoxesController::class, 'index'])->name('restobar.boxes');
        Route::get('items_detail', [BoxesDetailController::class, 'items_detail']);
        Route::post('save_item', [BoxesDetailController::class, 'save_item']);
        Route::post('generateYapeQR/{amount}', [GenerateController::class, 'generateYapeQR']);
        Route::get('search_customers', [RestaurantController::class, 'search_customer']);
        Route::get('search_customers/search_customer_delivery', [RestaurantController::class, 'search_customer_delivery']);
        Route::get('search_customer_by_id/{id}', [RestaurantController::class, 'search_customer_by_id']);
    });

    Route::middleware(['auth', 'locked.tenant'])->group(function () {
        //**** MESAS */
        Route::prefix('worker')->group(function () {

            Route::get('cash_available/{cash_id}', [CashController::class, 'cash_avaible']);
            Route::get('data_reports', [BoxesController::class, 'data_reports']);
            Route::post('check_pin', [RestobarController::class, 'check_pin']);
            Route::post('logout', [RestaurantController::class, 'logout']);
            Route::get('print_last_document', [OrdenController::class, 'print_last_document']);
            Route::post('pos/last_number_documents', [App\Http\Controllers\Tenant\PosController::class, 'last_number_documents']);
            Route::get('totales_sales', [RestobarController::class, 'total_sales']);
            Route::get('totales_sales_usd', [RestobarController::class, 'total_sales_usd']);
            Route::get('dashboard', [DashboardController::class, 'index'])->name('restobar.workers.dashboard');
            Route::get('dashboard/foods', [DashboardController::class, 'foods']);
            Route::get('dashboard/ver/{id}', [DashboardController::class, 'ver']);
            Route::get('dashboard/data_table', [DashboardController::class, 'data_table']);
            Route::get('dashboard-kitchen', [DashboardController::class, 'kitchen'])->name('restobar.kitchen.dashboard')->middleware('just.worker');
            Route::get('dashboard-pos', [RestobarController::class, 'pos'])->name('restobar.pos.dashboard')->middleware('just.worker');
            Route::post('subcategories', [App\Http\Controllers\Tenant\SubcategoryController::class, 'store']);
            Route::post('category', [App\Http\Controllers\Tenant\CategoryController::class, 'store']);
            //Gastos
            Route::get('expenses', [RestobarController::class, 'expenses'])->name('restobar.expenses.index')->middleware('just.worker');
            Route::get('expenses/records', [RestobarController::class, 'records']);
            Route::get('expenses/record/{id}', [RestobarController::class, 'record']);
            Route::post('expenses', [RestobarController::class, 'store']);
            Route::delete('expenses/{id}', [RestobarController::class, 'destroy']);
            Route::get('expenses/columns', [RestobarController::class, 'columns']);
            Route::get('expenses/tables', [RestobarController::class, 'tables']);
            //Ingresos
            Route::get('incomes', [IncomesController::class, 'incomes'])->name('restobar.incomes.index')->middleware('just.worker');;
            Route::get('incomes/records', [IncomesController::class, 'records']);
            Route::get('incomes/record/{id}', [IncomesController::class, 'record']);
            Route::post('incomes', [IncomesController::class, 'store']);
            Route::delete('incomes/{id}', [IncomesController::class, 'destroy']);
            Route::get('incomes/columns', [IncomesController::class, 'columns']);
            Route::get('incomes/tables', [IncomesController::class, 'tables']);
            Route::get('cash', [CashController::class, 'index'])->name('restobar.cash.index')->middleware('just.worker');
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
            Route::get('dashboard/tables/{area_id}',  [DashboardController::class, 'tables']);
            Route::post('pos/orden_payment', [RestobarController::class, 'payment']);
            Route::get('pos/search_orden', [RestobarController::class, 'search_orden']);
            Route::get('pos/listtables', [RestobarController::class, 'listtables']);
            Route::get('pos/selecttabled/{idOrden}', [RestobarController::class, 'selecttabled']);
            Route::get('pos/foods', [RestobarController::class, 'foods']);
            Route::get('pos/item/{id}', [RestobarController::class, 'itemNew']);
            Route::get('record/{id}', [OrdenController::class, 'record']);
            Route::get('record-worker/{id}', [OrdenController::class, 'recordWorker']);
            Route::get('re-print-ticket/{id}', [OrdenController::class, 'recordWorkerRePrint']);

            //ORDERS
            Route::post('send-orden', [OrdenController::class, 'store']);
            //Route::get('send-verificate/{id}', 'OrdenController@getRealStock');
            Route::get('orden-new/{id}', [OrdenController::class, 'order']);
            Route::get('search_orden_document', [RestobarController::class, 'search_orden_document']);
            Route::post('cancel-orden', [OrdenController::class, 'cancelOrden']);
            Route::post('cancel-orden-hotel', [OrdenController::class, 'cancelOrdenHotel']);
            Route::post('cancel-hotel-items', [OrdenController::class, 'cancelOrdenHotelItem']);
            Route::post('change-orden', [OrdenController::class, 'changeOrder']);
            Route::get('destroyorden/{ordenid}', [OrdenController::class, 'destroyorden']);
            Route::post('change-observation', [OrdenItemController::class, 'updateObservation']);
            Route::get('ordens-items', [OrdenItemController::class, 'records']);
            Route::get('ordens-list', [OrdenController::class, 'ordenslist']);
            Route::get('ordens-pending', [OrdenController::class, 'ordenspending']);
            /* Route::get('ordens-kitchen', [OrdenController::class, 'ordenskitchen']); */
            Route::get('ordens-kitchen', [OrdenController::class, 'ordenskitchen']);
            Route::get('tables', [OrdenController::class, 'tables']);
            // Route::get('ordens-areas', [OrdenController::class, 'ordensareas']);
            Route::get('list-ordens-items', [OrdenItemController::class, 'list_ordens_items']);
            Route::get('ordens-ready/{id}', [OrdenItemController::class, 'ordenReady']);
            Route::get('ordens-status', [OrdenItemController::class, 'ordensStatus']);
            Route::delete('delete-orden/{id}', [OrdenItemController::class, 'ordenDelete']);
            Route::post('delete-orden-pin', [OrdenItemController::class, 'ordenDeletePin']);
            //ACT. MESAS
            Route::get('tables/records-area/{area_id}', [TableController::class, 'recordsByArea']);
            Route::get('tables/recordsByAreaDelivery/{area_id}', [TableController::class, 'recordsByAreaDelivery']);
            /* Route::get('tables/records-area/{area_id}', 'TableController@recordsByArea'); */
            //Promociones 
            Route::post('pos/processPromo', [PromocionPorItemController::class, 'processPromo']);
            Route::get('pos/showCliePromos', [PromocionPorItemController::class, 'showCliePromos']);
            Route::post('pos/getPrductosPromo', [PromocionPorItemController::class, 'getPrductosPromo']);
            Route::post('pos/canjearPromo', [PromocionPorItemController::class, 'canjearPromo']);
            Route::post('pos/HistCanje', [PromocionPorItemController::class, 'HistCanje']);
            Route::get('drivers/tables', [RestaurantController::class, 'tables']);
        });

        Route::post('send-order', [RestaurantController::class, 'sendOrder']);
        Route::post('receive-order', [RestaurantController::class, 'receiveOrder']);
    });
});

