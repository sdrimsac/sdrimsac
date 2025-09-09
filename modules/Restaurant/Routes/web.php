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

use Illuminate\Support\Str;
use App\Events\MessageEvent;
use App\Http\Controllers\Tenant\DocumentController;
use App\Http\Controllers\Tenant\GenerateController;
use App\Http\Controllers\Tenant\SaleNoteController;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\HotelRent;
use Illuminate\Support\Facades\Route;
use Modules\Restaurant\Http\Controllers\BoxesController;
use Modules\Restaurant\Http\Controllers\BoxesDetailController;
use Modules\Restaurant\Http\Controllers\CashController;
use Modules\Restaurant\Http\Controllers\EstilistaController;
use Modules\Restaurant\Http\Controllers\PosController;
use Modules\Restaurant\Http\Controllers\IncomesController;
use Modules\Restaurant\Http\Controllers\OrdenController;
use Modules\Restaurant\Http\Controllers\RestaurantController;
use Modules\Restaurant\Http\Controllers\PromocionPorItemController;
use Modules\Restaurant\Http\Controllers\TableMaintenanceController;
use Modules\Restaurant\Http\Controllers\TableRoomController;
use Modules\Restaurant\Http\Controllers\UserScheduleController;
use Modules\Restaurant\Http\Controllers\UserScheduleDayController;
use Modules\Restaurant\Http\Controllers\UserScheduleTimeSlotController;
use Modules\Restaurant\Http\Controllers\UserScheduleExceptionController;
use Modules\Restaurant\Http\Controllers\UserScheduleAppointmentController;
use Modules\Restaurant\Http\Controllers\WorkerController;

Route::prefix('caja')->group(function () {
    //Route::get('/', 'RestaurantController@index');
    //Route::get('documents', 'OrdenController@printTicket');

    Route::post('/override-session', [RestaurantController::class, 'window']);
    Route::post('/re-print', [RestaurantController::class, 'rePrint']);
    Route::get('rooms/print_service/{id}', [TableRoomController::class, 'print_service']);
    Route::get('rooms/print_warranty/{id}', [TableRoomController::class, 'print_warranty']);
    Route::get('sale-notes', [SaleNoteController::class, 'pos'])->name('pos.sale_notes.index')->middleware('redirect.level');
    Route::get('documents', [DocumentController::class, 'documents'])->name('restaurant.documents.index');
    Route::get('documents/create/{documents?}', [DocumentController::class, 'create_pos'])->name('tenant.documents_pos.create')->middleware(['redirect.level', 'tenant.internal.mode']);
    Route::get('documents/data_table', [DocumentController::class, 'data_table']);
    Route::get('documents/records', [DocumentController::class, 'records']);
    Route::get('worker/print-ticket', [OrdenController::class, 'printTicket']);

    Route::get('delivery/ticket', [OrdenController::class, 'DeliveryOrden']);
    //Route::get('delivery/DeliveryPrinter', [OrdenController::class, 'DeliveryPrinter']);

    Route::get('worker/cash/print-report', [CashController::class, 'print_report']);
    Route::get('worker/cash/print-report-usd', [CashController::class, 'print_report_usd']);
    Route::get('worker/expenses/print-box', [PosController::class, 'print_box']);
    Route::post('workers/uploads', [WorkerController::class, 'upload']);
    Route::get('workers/images/{workers}', [WorkerController::class, 'images']);
    Route::get('workers/authenticated-user', [WorkerController::class, 'getAuthenticatedUser']);

    Route::get('report-boxes', 'BoxesController@report')->name('restaurant.report.boxes');
    Route::get('report-boxes/tables', 'BoxesController@tables');

    Route::get('report-boxes/cashes_salud', 'BoxesController@cashes_salud');
    Route::get('report-boxes/cashes_salud_single', 'BoxesController@cashes_salud_single');
    Route::post('report-boxes/save_info_pharmacy/{id}', 'BoxesController@save_info_pharmacy');
    Route::get('report-boxes/reports_resumen_type', 'BoxesController@reports_resumen_type');
    Route::get('report-boxes/reports_resumen_type_usd', 'BoxesController@reports_resumen_type_usd');
    Route::get('report-boxes/reports_resumen_type_page', 'BoxesController@reports_resumen_type_page');

    Route::get('report-boxes/reports_resumen_yape', 'BoxesController@reports_resumen_yape');
    Route::get('cash/balance-final/{date_closed}', 'BoxesController@balance_final');

    Route::get('report-boxes/reports_categoria_type', 'BoxesController@reports_categoria_type');
    Route::get('report-boxes/reports_type', [BoxesController::class, 'reports_type']);
    Route::get('report-boxes/reports_bancario_type', 'BoxesController@reports_bancario_type');
    Route::get('report-boxes/reports', 'BoxesController@reports_results');
    Route::get('report-product-warehouse-w', [WorkerController::class, 'report_products_w']);

    Route::get('login', 'RestaurantController@loginWorker');
    Route::post('login', [RestaurantController::class, 'login']);

    Route::prefix('estilista')->group(function () {
        Route::get('appointment-comment/{uuid}', [UserScheduleAppointmentController::class, 'appointmentCommentIndex'])->name('estilista.appointment-comment');
        Route::post('appointment-comment', [UserScheduleAppointmentController::class, 'appointmentCommentStore'])->name('estilista.appointment-comment.store');
    });
    Route::middleware(['auth', 'locked.tenant'])->group(function () {

        Route::get('logoutget', 'RestaurantController@logout');

        Route::get('test-sender', function () {

            $keyword = request("message");
            event(new MessageEvent($keyword));
        });
        Route::prefix('estilista')->group(function () {
            Route::get('time-worker', [EstilistaController::class, 'index'])->name('estilista.worker.time');
            Route::get('workers', [EstilistaController::class, 'workers'])->name('estilista.workers');
            Route::post('schedule', [EstilistaController::class, 'schedule'])->name('estilista.schedule');
            Route::get('get-services/{category_id}', [EstilistaController::class, 'getServices'])->name('estilista.get-services');
            Route::get('get-individual-services', [EstilistaController::class, 'getIndividualServices'])->name('estilista.get-individual-services');
            Route::get('get-user-items/{user_id}', [EstilistaController::class, 'getUserItems'])->name('estilista.get-user-items');
            // Rutas para UserSchedule
            Route::get('current-user', [UserScheduleController::class, 'getCurrentUser'])->name('estilista.current-user');
            Route::get('schedules', [UserScheduleController::class, 'index'])->name('estilista.schedules.index');
            Route::get('schedules/create', [UserScheduleController::class, 'create'])->name('estilista.schedules.create');
            Route::post('schedules', [UserScheduleController::class, 'store'])->name('estilista.schedules.store');
            Route::get('schedules/records', [UserScheduleController::class, 'records'])->name('estilista.schedules.records');
            Route::post('schedules/create-default', [UserScheduleController::class, 'createDefault'])->name('estilista.schedules.create-default');        Route::get('schedules/{id}', [UserScheduleController::class, 'show'])->name('estilista.schedules.show');
            Route::get('schedules/{id}/edit', [UserScheduleController::class, 'edit'])->name('estilista.schedules.edit');
            Route::put('schedules/{id}', [UserScheduleController::class, 'update'])->name('estilista.schedules.update');
            Route::delete('schedules/{id}', [UserScheduleController::class, 'destroy'])->name('estilista.schedules.destroy');
        
            
            // Rutas para UserScheduleDay
            Route::get('schedule-days/{scheduleId}', [UserScheduleDayController::class, 'index'])->name('estilista.schedule-days.index');
            Route::post('schedule-days', [UserScheduleDayController::class, 'store'])->name('estilista.schedule-days.store');
            Route::get('schedule-days/working-days/{userId}', [UserScheduleDayController::class, 'workingDays'])->name('estilista.schedule-days.working-days');
    
            Route::get('schedule-days/{id}/edit', [UserScheduleDayController::class, 'edit'])->name('estilista.schedule-days.edit');
            Route::put('schedule-days/{id}', [UserScheduleDayController::class, 'update'])->name('estilista.schedule-days.update');
            Route::delete('schedule-days/{id}', [UserScheduleDayController::class, 'destroy'])->name('estilista.schedule-days.destroy');
            Route::get('schedule-days/records/{scheduleId}', [UserScheduleDayController::class, 'records'])->name('estilista.schedule-days.records');
            
            // Rutas para UserScheduleTimeSlot
            Route::get('time-slots/{dayId}', [UserScheduleTimeSlotController::class, 'index'])->name('estilista.time-slots.index');
            Route::post('time-slots', [UserScheduleTimeSlotController::class, 'store'])->name('estilista.time-slots.store');
            Route::get('time-slots/{id}/edit', [UserScheduleTimeSlotController::class, 'edit'])->name('estilista.time-slots.edit');
            Route::put('time-slots/{id}', [UserScheduleTimeSlotController::class, 'update'])->name('estilista.time-slots.update');
            Route::delete('time-slots/{id}', [UserScheduleTimeSlotController::class, 'destroy'])->name('estilista.time-slots.destroy');
            Route::get('time-slots/records/{dayId}', [UserScheduleTimeSlotController::class, 'records'])->name('estilista.time-slots.records');
            Route::get('time-slots/available/{userId}/{date}', [UserScheduleTimeSlotController::class, 'getAvailableSlots'])->name('estilista.time-slots.available');
            
            // Rutas para UserScheduleException
            Route::get('exceptions/{userId}', [UserScheduleExceptionController::class, 'index'])->name('estilista.exceptions.index');
            Route::post('exceptions', [UserScheduleExceptionController::class, 'store'])->name('estilista.exceptions.store');
            Route::get('exceptions/{id}/edit', [UserScheduleExceptionController::class, 'edit'])->name('estilista.exceptions.edit');
            Route::put('exceptions/{id}', [UserScheduleExceptionController::class, 'update'])->name('estilista.exceptions.update');
            Route::delete('exceptions/{id}', [UserScheduleExceptionController::class, 'destroy'])->name('estilista.exceptions.destroy');
            Route::get('exceptions/records/{userId}', [UserScheduleExceptionController::class, 'records'])->name('estilista.exceptions.records');
            
            // Rutas para UserScheduleAppointment
            Route::get('appointments', [UserScheduleAppointmentController::class, 'index'])->name('estilista.appointments.index');
            Route::get('appointments/create', [UserScheduleAppointmentController::class, 'create'])->name('estilista.appointments.create');
            Route::post('appointments', [UserScheduleAppointmentController::class, 'store'])->name('estilista.appointments.store');
            Route::get('appointments/records', [UserScheduleAppointmentController::class, 'records'])->name('estilista.appointments.records');
            Route::get('appointments/clients', [UserScheduleAppointmentController::class, 'clients'])->name('estilista.appointments.clients');
            Route::get('appointments/services', [UserScheduleAppointmentController::class, 'services'])->name('estilista.appointments.services');
            Route::post('appointments/change-status/{id}', [UserScheduleAppointmentController::class, 'changeStatus'])->name('estilista.appointments.change-status');
            Route::get('appointments/check-availability', [UserScheduleAppointmentController::class, 'checkAvailability'])->name('estilista.appointments.check-availability');
            Route::get('appointments/{id}', [UserScheduleAppointmentController::class, 'show'])->name('estilista.appointments.show');
            Route::get('appointments/{id}/edit', [UserScheduleAppointmentController::class, 'edit'])->name('estilista.appointments.edit');
            Route::put('appointments/{id}', [UserScheduleAppointmentController::class, 'update'])->name('estilista.appointments.update');
            Route::delete('appointments/{id}', [UserScheduleAppointmentController::class, 'destroy'])->name('estilista.appointments.destroy');
            Route::get('appointments/by-day/{date}', [UserScheduleAppointmentController::class, 'getByDay'])->name('estilista.appointments.by-day');
            Route::put('appointments/{id}/status', [UserScheduleAppointmentController::class, 'changeStatus'])->name('estilista.appointments.change-status');
        });
        Route::get('test', function () {
            $configuration = Configuration::first();
            if ($configuration->socket_channel == null) {
                $configuration->socket_channel = Str::random(25);
                $configuration->save();
                $event_name = $configuration->socket_channel;
            }
            return view('restaurant::restaurant', compact('configuration'));
        });
        Route::get('kitchen', function () {
            $configuration = Configuration::first();
            if ($configuration->socket_channel == null) {
                $configuration->socket_channel = Str::random(25);
                $configuration->save();
                $event_name = $configuration->socket_channel;
            }
            return view('restaurant::kitchen', compact('configuration'));
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
            Route::get('available-credit', 'CashTransferController@availableCredit');
            Route::get('records', 'CashTransferController@records');
            Route::get('cashes', 'CashTransferController@cashes');
            Route::get('cashes-principal', 'CashTransferController@cashes_principal');
            Route::get('record/{id}', 'CashTransferController@record');
            Route::post('', 'CashTransferController@store');
            Route::delete('{id}', 'CashTransferController@destroy');
        });

        Route::get('delivery/DeliveryPrinter', [OrdenController::class, 'DeliveryPrinter']);

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

        // Route::get('category-food', 'CategoryFoodController@index')->name('restaurant.category_food');
        // Route::get('category-food/records', 'CategoryFoodController@records');
        // Route::get('category-food/{id}', 'CategoryFoodController@active');
        // Route::get('category-food/record/{id}', 'CategoryFoodController@record');
        // Route::post('category-food', 'CategoryFoodController@store');
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
        Route::prefix('maintenance')->group(function () {
            Route::get('workers', [TableMaintenanceController::class, 'workers']);
            Route::get('records', [TableMaintenanceController::class, 'records']);
            Route::get('record/{id}', [TableMaintenanceController::class, 'record']);
            Route::post('change-state', [TableMaintenanceController::class, 'change_state']);
            Route::post('', [TableMaintenanceController::class, 'store']);
            Route::delete('delete/{id}', [TableMaintenanceController::class, 'destroy']);
        });
        Route::prefix('rooms/reports')
            ->group(function () {
                Route::get('', 'TableRoomReportController@index')->name('hotels.reports.rooms');
                Route::get('records', 'TableRoomReportController@records');
                Route::get('export', 'TableRoomReportController@export');
            });

        //**** MESAS ROOM*/
        Route::get('rooms', 'TableRoomController@index')->name('restaurant.rooms');
        Route::get('rooms/columns', 'TableRoomController@columns');
        Route::post('rooms/insumos', 'TableRoomController@setInsumo');
        Route::get('rooms/insumos/records', 'TableRoomController@getInsumos');
        Route::delete('rooms/insumos/record/{id}', 'TableRoomController@deleteInsumo');
        Route::post('rooms/insumos/record/update', 'TableRoomController@updateInsumo');
        Route::get('rooms/pdf/{rooms}', 'TableRoomController@pdf');
        Route::prefix('rent')->group(function () {
            Route::post('desoccupy-rent', [TableRoomController::class, 'desoccupyRent']);
            Route::post('set-room-rent', [TableRoomController::class, 'setRoomRent']);
            Route::get('get-tables', [TableRoomController::class, 'getTables']);
            Route::get('advance-document/{id}', [TableRoomController::class, 'rentDocument']);
            Route::get('get-documents/{id}', [TableRoomController::class, 'getDocuments']);
            Route::get('get-infractions/{id}', [TableRoomController::class, 'getInfractions']);
            Route::get('get-amount/{id}', [TableRoomController::class, 'getAmount']);
            Route::post('store-infraction', [TableRoomController::class, 'storeInfraction']);
            Route::post('prepare-payment', [TableRoomController::class, 'preparePayment']);
            Route::delete('remove-infraction/{id}', [TableRoomController::class, 'removeInfraction']);
            Route::get('get-infractions-debt/{id}', [TableRoomController::class, 'getInfractionsDebt']);
            Route::get('get-info/{id}', [TableRoomController::class, 'getInfo']);
            Route::prefix('penalties-settings')->group(function () {
                Route::get('', [TableRoomController::class, 'penaltiesSettings']);
                Route::post('', [TableRoomController::class, 'storePenaltiesSettings']);
                Route::delete('{id}', [TableRoomController::class, 'destroyPenaltiesSettings']);
            });

            Route::prefix('whatsapp-settings')->group(function () {
                Route::get('', [TableRoomController::class, 'whatsappSettings']);
                Route::post('', [TableRoomController::class, 'storeWhatsappSettings']);
                Route::post('toggle/{id}', [TableRoomController::class, 'toggleWhatsappSettings']);
                Route::post('upload-temp', [TableRoomController::class, 'uploadTempImage']);
                Route::delete('remove-image/{id}', [TableRoomController::class, 'removeWhatsappImage']);
            });
        });
        Route::get('rooms/tables_to_clean', 'TableRoomController@tablesToClean');
        Route::get('rooms/reports_rooms', 'TableRoomController@reportsRooms');
        Route::get('rooms/tables_to_leave', 'TableRoomController@tablesToLeave');
        Route::get('rooms/check', 'TableRoomController@check');
        Route::get('rooms/advance/{id}', 'TableRoomController@advanceDocument');
        Route::get('rooms/cleaned/{id}', 'TableRoomController@cleaned');
        Route::get('rooms/reserve_to_occupied/{id}', 'TableRoomController@reserve_to_occupied');
        Route::get('rooms/desocupied/{id}', 'TableRoomController@desocupied');
        Route::get('rooms/cancel_reserve/{id}', 'TableRoomController@cancel_reserve');
        Route::get('rooms/room/{id}', 'TableRoomController@getRoom');
        Route::get('rooms/get_hotel_rent/{id}', 'TableRoomController@get_hotel_rent');
        Route::get('rooms/records', 'TableRoomController@records');
        Route::get('rooms/add_days/{id}/{days}', 'TableRoomController@addDays');
        Route::get('rooms/tables', 'TableRoomController@get_tables');
        Route::get('rooms/tables_caja', 'TableRoomController@get_tables_caja');
        Route::get('rooms/tablas', 'TableRoomController@tables');
        Route::get('rooms/orden/{id}', 'TableRoomController@get_ordens');
        Route::get('rooms/send_to_clean/{id}', 'TableRoomController@sendToclean');
        Route::get('rooms/send_to_maintenance/{id}', 'TableRoomController@sendToMaintenance');
        Route::get('rooms/send_to_avaible/{id}', 'TableRoomController@sendToAvaible');
        Route::get('rooms/ordenById/{id}', 'TableRoomController@ordenById');
        Route::post('rooms/store/{type}', 'TableRoomController@storeType');
        Route::post('rooms/cancel/{id}', 'TableRoomController@cancelRoom');
        Route::post('rooms/check_reserve', 'TableRoomController@check_reserve');
        Route::get('rooms/change_room/{to}/{from}', 'TableRoomController@changeRoom');
        Route::get('rooms/record/{id}', 'TableRoomController@record');
        Route::post('rooms/all_ordens/{id}', 'TableRoomController@allOrdens');
        Route::get('rooms/types', 'TableRoomController@room_types');
        Route::delete('rooms/delete/{type}/{id}', 'TableRoomController@deleteItem');
        Route::delete('rooms/{id}', 'TableRoomController@delete');
        Route::post('rooms', 'TableRoomController@store');
        Route::delete('rooms/delete_image/{id}', 'TableRoomController@deleteImage');
        Route::post('rooms/set-guess', 'TableRoomController@setGuess');
        Route::post('rooms/massive', 'TableRoomController@store_massive');
        Route::post('rooms/detail_table', 'TableRoomController@detail_table');
        Route::get('rooms/detail_table', 'TableRoomController@get_detail_table');
        Route::get('rooms/get_reserve_date/{id}', 'TableRoomController@get_reserve_date');
        Route::post('rooms/set_reserve_date', 'TableRoomController@set_reserve_date');
        Route::get('rooms/services/{id}', 'TableRoomController@get_services');
        Route::get('rooms/promotion/{code}', 'TableRoomController@get_promotion');
        Route::delete('rooms/delete_service/{id}', 'TableRoomController@delete_service');
        Route::delete('rooms/hotel/rents/{id}', 'TableRoomController@delete_hotel_rent');
        Route::get('rooms/success_service/{id}', 'TableRoomController@success_service');
        Route::get('rooms/desactive_promotion/{code}', 'TableRoomController@desactive_promotion');

        Route::post('room_services', 'TableRoomServiceController@room_services');
        Route::get('room_services/records', 'TableRoomServiceController@records');
        Route::get('room_services/record/{id}', 'TableRoomServiceController@record');
        Route::delete('room_services/record/{id}', 'TableRoomServiceController@destroy');
        //MESAS BILLAR */

        //**** MESAS */
        Route::get('tables', 'TableController@index')->name('restaurant.tables');
        Route::get('tables/columns', 'TableController@columns');
        Route::get('tables/check', 'TableController@check');
        Route::get('tables/records', 'TableController@records');
        Route::get('tables/tables', 'TableController@get_tables');
        Route::get('tables/getTablesDelivery', 'TableController@get_tables_delivery');
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
        Route::post('generateYapeQR/{amount}', [GenerateController::class, 'generateYapeQR']);


        Route::get('search_customers', [RestaurantController::class, 'search_customer']);
        Route::get('search_customers/search_customer_delivery', [RestaurantController::class, 'search_customer_delivery']);
        Route::get('search_customer_by_id/{id}', [RestaurantController::class, 'search_customer_by_id']);
    });
    //VISTA TRABAJADORES

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

            Route::get('re-print-ticket/{id}', 'OrdenController@recordWorkerRePrint');



            //ORDERS
            Route::post('send-orden', 'OrdenController@store');
            //Route::get('send-verificate/{id}', 'OrdenController@getRealStock');
            Route::get('orden-new/{id}', 'OrdenController@order');
            Route::get('search_orden_document', 'PosController@search_orden_document');

            Route::post('cancel-orden', 'OrdenController@cancelOrden');
            Route::post('cancel-orden-hotel', 'OrdenController@cancelOrdenHotel');
            Route::post('cancel-hotel-items', 'OrdenController@cancelOrdenHotelItem');

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

            Route::get('tables/recordsByAreaDelivery/{area_id}', 'TableController@recordsByAreaDelivery');

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
