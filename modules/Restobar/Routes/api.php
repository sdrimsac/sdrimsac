<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/restobar', function (Request $request) {
    return $request->user();
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
use App\Http\Controllers\Tenant\SaleNoteController;
use App\Models\Tenant\Configuration;
use Illuminate\Support\Facades\Route;
use Modules\Restobar\Http\Controllers\BoxesController;
use Modules\Restobar\Http\Controllers\BoxesDetailController;
use Modules\Restobar\Http\Controllers\CashController;
use Modules\Restobar\Http\Controllers\PosController;
use Modules\Restobar\Http\Controllers\IncomesController;
use Modules\Restobar\Http\Controllers\OrdenController;
use Modules\Restobar\Http\Controllers\RestaurantController;
use Modules\Restobar\Http\Controllers\WorkerController;
use Modules\Restobar\Http\Controllers\RestobarController;

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
    Route::get('worker/cash/print-report', [CashController::class, 'print_report']);
    Route::get('worker/cash/print-report-usd', [CashController::class, 'print_report_usd']);
    Route::get('worker/expenses/print-box', [RestobarController::class, 'print_box']);
    Route::post('workers/uploads', [WorkerController::class, 'upload']);
    Route::get('workers/images/{workers}', [WorkerController::class, 'images']);
    Route::get('workers/authenticated-user', [WorkerController::class, 'getAuthenticatedUser']);

    Route::get('report-boxes', [BoxesController::class, 'report'])->name('restobar.report.boxes');
    Route::get('report-boxes/tables', [BoxesController::class, 'tables']);

    Route::get('report-boxes/cashes_salud', [BoxesController::class, 'cashes_salud']);
    Route::get('report-boxes/cashes_salud_single', [BoxesController::class, 'cashes_salud_single']);
    Route::post('report-boxes/save_info_pharmacy/{id}', [BoxesController::class, 'save_info_pharmacy']);
    Route::get('report-boxes/reports_resumen_type', [BoxesController::class, 'reports_resumen_type']);
    Route::get('report-boxes/reports_resumen_type_usd', [BoxesController::class, 'reports_resumen_type_usd']);
    Route::get('report-boxes/reports_resumen_type_page', [BoxesController::class, 'reports_resumen_type_page']);

    Route::get('report-boxes/reports_resumen_yape', [BoxesController::class, 'reports_resumen_yape']);
    Route::get('cash/balance-final/{date_closed}', [BoxesController::class, 'balance_final']);

    Route::get('report-boxes/reports_categoria_type', [BoxesController::class, 'reports_categoria_type']);
    Route::get('report-boxes/reports_type', [BoxesController::class, 'reports_type']);
    Route::get('report-boxes/reports_bancario_type', [BoxesController::class, 'reports_bancario_type']);
    Route::get('report-boxes/reports', [BoxesController::class, 'reports_results']);
    Route::get('report-product-warehouse-w', [WorkerController::class, 'report_products_w']);

    Route::get('login', [RestaurantController::class, 'loginWorker']);
    Route::post('login', [RestaurantController::class, 'login']);
    Route::middleware(['auth:api', 'locked.tenant'])->group(function () {

        Route::get('logoutget', [RestaurantController::class, 'logout']);

        Route::get('test-sender', function () {

            $keyword = request("message");
            event(new MessageEvent($keyword));
        });
        Route::get('test', function () {
            $configuration = Configuration::first();
            if ($configuration->socket_channel == null) {
                $configuration->socket_channel = Str::random(25);
                $configuration->save();
                $event_name = $configuration->socket_channel;
            }
            return view('restobar::restaurant', compact('configuration'));
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
            Route::get('/', 'CashTransferController@index')->name('caja.cash_transfer');
            Route::prefix('report')->group(function () {
                Route::get('/', 'CashTransferController@index_report')->name('caja.cash_transfer_report');
                Route::get('/columns', 'CashTransferController@columns_report');
                Route::get('/records', 'CashTransferController@records_report');
                Route::get('/export', 'CashTransferController@export_report');
            });
            Route::get('/columns', 'CashTransferController@columns');
            Route::get('available', 'CashTransferController@available');
            Route::get('records', 'CashTransferController@records');
            Route::get('cashes', 'CashTransferController@cashes');
            Route::get('cashes-principal', 'CashTransferController@cashes_principal');
            Route::get('record/{id}', 'CashTransferController@record');
            Route::post('', 'CashTransferController@store');
            Route::delete('{id}', 'CashTransferController@destroy');
        });

        //*** ORDENS */
        Route::get('cashes', 'BoxesController@cashes')->name('restaurant.cash');
        Route::get('ordens', 'OrdenController@index')->name('restaurant.ordens');
        Route::get('boxes/records/{id}', 'BoxesController@get_boxes');
        Route::post('boxes/validation', 'BoxesController@validation_methods');
        Route::get('ordens/records', 'OrdenController@records');
        // Route::get('ordens/record-by-id/{id}', 'OrdenController@recordById');
        Route::get('ordens/listfoods/{date}', 'BoxesController@listfoods');
        Route::get('ordens/payment/{type}/{document_id}/{orderid}', 'BoxesController@paymentorden');
        //**** COMIDAS / BEBIDAS */
        Route::get('food-list', 'FoodController@index')->name('restaurant.food_list');
        Route::get('food-list/records', 'FoodController@records');
        Route::get('food-list/record/{id}', 'FoodController@record');
        Route::get('food-list/delete-image/{id}', 'FoodController@deleteImage');
        Route::get('food-list/{id}', 'FoodController@active');
        Route::post('food-list/upload-image', 'FoodController@uploadImage');
        Route::post('food-list', 'FoodController@store');

        //**OBSERVATIONS*
        Route::get('observations', 'ObservationController@index')->name('restaurant.observations');
        Route::get('observations/columns', 'ObservationController@columns');
        Route::get('observations/remove/{id}', 'ObservationController@remove');
        Route::get('observations/records', 'ObservationController@records');
        Route::get('observations/items', 'ObservationController@tables');
        Route::post('observations', 'ObservationController@store');
        Route::get('observations/record/{id}', 'ObservationController@record');
        Route::get('observations/{id}', 'ObservationController@active');
        //**** TIPO DE TRABAJADORES */
        Route::get('workers-type', 'WorkersTypeController@index')->name('restaurant.workers_type')->middleware("just.super");;
        Route::get('workers-type/columns', 'WorkersTypeController@columns');
        Route::get('workers-type/records', 'WorkersTypeController@records');
        Route::get('workers-type/actives', 'WorkersTypeController@actives');
        Route::get('workers-type/record/{id}', 'WorkersTypeController@record');
        Route::get('workers-type/{id}', 'WorkersTypeController@active');
        Route::post('workers-type', 'WorkersTypeController@store');
        Route::get('workers-type/recordsActivity', 'WorkersTypeController@recordsActivity');
        //**** AREAS */
        Route::get('areas', 'AreaController@index')->name('restaurant.areas')->middleware("just.super");
        Route::get('areas/columns', 'AreaController@columns');
        Route::get('areas/records', 'AreaController@records');
        Route::get('areas/actives', 'AreaController@actives');
        Route::get('areas/record/{id}', 'AreaController@record');
        Route::delete('areas/{id}', 'AreaController@active');
        Route::post('areas', 'AreaController@store');
        //**** ESTADO DE MESAS */
        Route::get('status-tables', 'StatusTableController@index')->name('restaurant.status_table')->middleware("just.super");;
        Route::get('status-tables/records', 'StatusTableController@records');
        Route::get('status-tables/columns', 'StatusTableController@columns');
        Route::delete('status-tables/{id}', 'StatusTableController@active');
        Route::get('status-tables/record/{id}', 'StatusTableController@record');
        Route::post('status-tables', 'StatusTableController@store');
        //**** ESTADO DE ORDEN */
        Route::get('status-orden', 'StatusOrdenController@index')->name('restaurant.status_orden')->middleware("just.super");;
        Route::get('status-orden/records', 'StatusOrdenController@records');
        Route::get('status-orden/columns', 'StatusOrdenController@columns');
        Route::delete('status-orden/{id}', 'StatusOrdenController@active');
        Route::get('status-orden/record/{id}', 'StatusOrdenController@record');
        Route::post('status-orden', 'StatusOrdenController@store');
        //***MANTENIMENTO */

        //**** MESAS ROOM*/
        //MESAS BILLAR */

        //**** MESAS */
        Route::get('tables', 'TableController@index')->name('restaurant.tables');
        Route::get('tables/columns', 'TableController@columns');
        Route::get('tables/check', 'TableController@check');
        Route::get('tables/records', 'TableController@records');
        Route::get('tables/tables', 'TableController@get_tables');
        Route::get('tables/tables-zone', 'TableController@tables_zones');

        Route::post('tables/store/{type}', 'TableController@store_zone');

        Route::delete('tables/delete/{type}/{id}', 'TableController@deleteItemZone');
        Route::get('tables/orden/{id}', 'TableController@get_ordens');
        Route::get('tables/UserTable', 'TableController@UserTable');
        Route::get('tables/record/{id}', 'TableController@record');
        Route::get('tables/table-types', 'TableController@tableTypes');
        Route::post('tables', 'TableController@store');
        Route::post('tables/disabled-table', 'TableController@disabled');
        Route::post('tables/enabled-table', 'TableController@enabled');
        Route::post('tables/massive', 'TableController@store_massive');


        //**** TRABAJADORES */
        Route::get('workers', 'WorkerController@index')->name('restaurant.workers');
        Route::get('workers/records', 'WorkerController@records');
        Route::get('workers/{id}', 'WorkerController@active');
        Route::get('workers/columns', 'WorkerController@columns');
        Route::post('workers/commercial_treatment', 'WorkerController@commercial_treatment');
        Route::get('workers/record/{id}', 'WorkerController@record');
        Route::post('workers', 'WorkerController@store');

        Route::get('pos', 'PosController@index')->name('restaurant.pos');
        Route::get('pos/search_orden', 'PosController@search');
        Route::get('pos/update_items_warehouse', 'PosController@updateItemWithWarehouse');
        Route::get('pos/series', 'PosController@series');
        Route::post('pos/orden_payment', 'PosController@payment');
        Route::get('pos/foods', 'PosController@foods');
        //Route::get('pos/item/{id}', 'PosController@itemNew');
        
        Route::get('boxes', 'BoxesController@index')->name('restaurant.boxes');
        Route::get('items_detail', [BoxesDetailController::class, 'items_detail']);
        Route::post('save_item', [BoxesDetailController::class, 'save_item']);

        Route::get('search_customers', [RestaurantController::class, 'search_customer']);
        Route::get('search_customer_by_id/{id}', [RestaurantController::class, 'search_customer_by_id']);
    });
    //VISTA TRABAJADORES

    Route::middleware(['auth:api', 'locked.tenant'])->group(function () {
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
            Route::get('rent-pos', 'DashboardController@rentPos')->name('restaurant.rent.pos.dashboard')->middleware('just.worker');;
            Route::get('salon-pos', 'DashboardController@salonPos')->name('restaurant.salon.pos.dashboard')->middleware('just.worker');;

            Route::get('totales_sales', 'PosController@total_sales');
            Route::get('totales_sales_usd', 'PosController@total_sales_usd');
            Route::get('dashboard', 'DashboardController@index')->name('restaurant.workers.dashboard');
            Route::get('dashboard/foods', 'DashboardController@foods');
            Route::get('dashboard/ver/{id}', 'DashboardController@ver');
            Route::get('dashboard/data_table', 'DashboardController@data_table');
            Route::get('dashboard-kitchen', 'DashboardController@kitchen')->name('restaurant.kitchen.dashboard')->middleware('just.worker');
            Route::get('dashboard-pos', 'DashboardController@pos')->name('restaurant.pos.dashboard')->middleware('just.worker');;
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


            Route::get('dashboard/tables/{area_id}', 'DashboardController@tables');
            //
            Route::post('pos/orden_payment', 'PosController@payment');
            Route::get('pos/search_orden', 'PosController@search');
            Route::get('pos/listtables', 'PosController@listtables');
            Route::get('pos/selecttabled/{idOrden}', 'PosController@selecttabled');
            Route::get('pos/foods', 'PosController@foods');
            Route::get('pos/item/{id}', [PosController::class, 'itemNew']);
            Route::get('record/{id}', 'OrdenController@record');
            Route::get('record-worker/{id}', 'OrdenController@recordWorker');

            //ORDERS
            Route::post('send-orden', 'OrdenController@store');
            //Route::get('send-verificate/{id}', 'OrdenController@getRealStock');
            Route::get('orden-new/{id}', 'OrdenController@order');
            Route::get('search_orden_document', 'PosController@search_orden_document');

            Route::post('cancel-orden', 'OrdenController@cancelOrden');
            Route::post('cancel-orden-hotel', 'OrdenController@cancelOrdenHotel');
            Route::post('change-orden', 'OrdenController@changeOrder');
            Route::get('destroyorden/{ordenid}', 'OrdenController@destroyorden');


            Route::post('change-observation', 'OrdenItemController@updateObservation');
            Route::get('ordens-items', 'OrdenItemController@records');
            Route::get('ordens-list', 'OrdenController@ordenslist');
            Route::get('ordens-pending', 'OrdenController@ordenspending');
            /* Route::get('ordens-kitchen', 'OrdenController@ordenskitchen'); */
            Route::get('ordens-kitchen', [OrdenController::class, 'ordenskitchen']);

            Route::get('tables', 'OrdenController@tables');

            // Route::get('ordens-areas', 'OrdenController@ordensareas');

            Route::get('list-ordens-items', 'OrdenItemController@list_ordens_items');
            Route::get('ordens-ready/{id}', 'OrdenItemController@ordenReady');
            Route::get('ordens-status', 'OrdenItemController@ordensStatus');
            Route::delete('delete-orden/{id}', 'OrdenItemController@ordenDelete');
            Route::post('delete-orden-pin', 'OrdenItemController@ordenDeletePin');
            //ACT. MESAS
            Route::get('tables/records-area/{area_id}', 'TableController@recordsByArea');

            /* Route::get('tables/records-area/{area_id}', 'TableController@recordsByArea'); */
            //Promociones 
            Route::post('pos/processPromo', 'PromocionPorItemController@processPromo');
            Route::get('pos/showCliePromos', 'PromocionPorItemController@showCliePromos');
            Route::post('pos/getPrductosPromo', 'PromocionPorItemController@getPrductosPromo');
            Route::post('pos/canjearPromo', 'PromocionPorItemController@canjearPromo');
            Route::post('pos/HistCanje', 'PromocionPorItemController@HistCanje');

            Route::get('drivers/tables', 'RestaurantController@tables');
        });

        Route::post('send-order', 'RestaurantController@sendOrder');
        Route::post('receive-order', 'RestaurantController@receiveOrder');
    });
});
