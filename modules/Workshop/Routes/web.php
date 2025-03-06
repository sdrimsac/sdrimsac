<?php

use Illuminate\Support\Facades\Route;
use Modules\Restaurant\Http\Controllers\RestaurantController;
use Modules\Workshop\Http\Controllers\CashController;
use Modules\Workshop\Http\Controllers\ExportarController;
use Modules\Workshop\Http\Controllers\ExportController;
use Modules\Workshop\Http\Controllers\ObservationController;
use Modules\Workshop\Http\Controllers\WorkshopController;
use Modules\Workshop\Http\Controllers\TipoController;
use Modules\Workshop\Http\Controllers\SellerController;
use Modules\Workshop\Http\Controllers\VehiculoController;
use Modules\Workshop\Http\Controllers\OrdenController;
use Modules\Workshop\Http\Controllers\PersonalController;
use Modules\Workshop\Http\Controllers\ServicesDetailsController;
use Modules\Workshop\Http\Controllers\ServicesController;
use Modules\Workshop\Http\Controllers\HistorialController;
use Modules\Workshop\Http\Controllers\HistorialItemController;
use Modules\Workshop\Models\ServicesDetails;

Route::get('vehiculo/check_pdf/{id}_{date}', [VehiculoController::class, 'check_pdf']);
Route::get('/vehiculo/view_pdf/{id}_{timestamp}', [VehiculoController::class, 'view_pdf']);
Route::get('workshop/vehiculo/format_vehicle/{id}', [VehiculoController::class, 'format_vehicle']);
Route::get('workshop/vehiculo/format-historial/{historial_id}', [VehiculoController::class, 'format_History']);
Route::get('workshop/vehiculo/print/{id}/{format}', [VehiculoController::class, 'toPrint']);
Route::get('workshop/vehiculo/reprint/{id}', [VehiculoController::class, 'RePrint']);
Route::get('workshop/vehiculo/excelVehicle', [VehiculoController::class, 'excelVehicle']);
Route::get('workshop/exportar/excelMechanic', [ExportarController::class, 'excelMechanic']);
Route::get('workshop/historial/format-complete/{vehiculo_id}', [HistorialController::class, 'generarPdf']);

Route::middleware(['auth'])->group(function () {
    Route::prefix('workshop')->group(function () {
        Route::get('/', 'WorkshopController@index');
        Route::get('observations', [ObservationController::class, 'index'])->name('workshop.observations');
        Route::get('observations/columns', [ObservationController::class, 'columns']);
        Route::get('observations/records', [ObservationController::class, 'records']);
        Route::post('observations', [ObservationController::class, 'store']);
        Route::get('observations/record/{id}', [ObservationController::class, 'record']);
        Route::get('observations/{id}', [ObservationController::class, 'active']);

        Route::get('/mecanico', [PersonalController::class, 'index'])->name('tenant.workshop.mecanico');
        /* Route::get('/mecanico/columns', [SellerController::class, 'columns']); */
        Route::get('mecanico/records', [PersonalController::class, 'records']);
        Route::post('mecanico', [PersonalController::class, 'store']);
        Route::get('mecanico/record/{id}', [PersonalController::class, 'record']);
        Route::delete('mecanico/{mecanico}', [PersonalController::class, 'destroy']);

        Route::get('/exportar', [ExportarController::class, 'index'])->name('tenant.workshop.exportar');
        Route::get('exportar/records', [ExportarController::class, 'records']);
        Route::get('exportar/tables', [ExportarController::class, 'tables']);
        
        Route::get('/tipo', [TipoController::class, 'index'])->name('tenant.workshop.tipo');
        Route::get('tipo/records', [TipoController::class, 'records']);
        Route::post('tipo', [TipoController::class, 'store']);
        Route::get('tipo/record/{id}', [TipoController::class, 'record']);
        Route::delete('tipo/{tipo}', [TipoController::class, 'destroy']);

        Route::get('/vehiculo', [VehiculoController::class, 'index'])->name('tenant.workshop.vehiculo');
        Route::get('vehiculo/records', [VehiculoController::class, 'records']);
        Route::post('vehiculo', [VehiculoController::class, 'store']);
        Route::post('new-history', [VehiculoController::class, 'storeHistory']);
        Route::get('vehiculo/record/{id}', [VehiculoController::class, 'record']);
        Route::get('vehiculo/record2/{id}', [VehiculoController::class, 'record2']);
        Route::get('vehiculo/payment/{id}', [VehiculoController::class, 'record_payment']);
        Route::delete('vehiculo/{tipo}', [VehiculoController::class, 'destroy']);

        

        Route::post('items', [VehiculoController::class, 'setItems']);

        Route::get('ticket-entrega/{historial_id}', [VehiculoController::class, 'generarTicketEntrega'])
            ->name('tipo.entrega');


        Route::get('/servicesdetails', [ServicesDetailsController::class, 'index'])->name('tenant.workshop.servicesdetails');
        Route::get('servicesdetails/records', [ServicesDetailsController::class, 'records']);
        Route::get('servicesdetails/tables', [ServicesDetailsController::class, 'tables']);
        Route::post('servicesdetails', [ServicesDetailsController::class, 'store']);
        Route::get('servicesdetails/record/{id}', [ServicesDetailsController::class, 'record']);
        Route::delete('servicesdetails/{servicesdetails}', [ServicesDetailsController::class, 'destroy']);

        Route::get('/services', [ServicesController::class, 'index'])->name('tenant.workshop.services');
        Route::get('services/records', [ServicesController::class, 'records']);
        Route::post('services', [ServicesController::class, 'store']);
        Route::get('services/record/{id}', [ServicesController::class, 'record']);
        Route::delete('services/{services}', [ServicesController::class, 'destroy']);

        Route::get('/historial', [HistorialController::class, 'index'])->name('tenant.workshop.historial');
        Route::get('historial/records', [HistorialController::class, 'records']);
        Route::post('historial', [HistorialController::class, 'store']);
        Route::get('historial/record/{id}', [HistorialController::class, 'record']);
        Route::get('historial/record2/{id}', [HistorialController::class, 'record2']);
        Route::delete('historial/{services}', [HistorialController::class, 'destroy']);

        Route::get('/historialItem', [HistorialItemController::class, 'index'])->name('tenant.workshop.historialItem');
        Route::get('historialItem/records', [HistorialItemController::class, 'records']);
        Route::post('historialItem', [HistorialItemController::class, 'store']);
        Route::get('historialItem/record/{id}', [HistorialItemController::class, 'record']);
        Route::delete('historialItem/{services}', [HistorialItemController::class, 'destroy']);

        Route::get('/customers', [WorkshopController::class, 'searchCustomers']);
        Route::get('/customer/{id}', [WorkshopController::class, 'searchCustomerById']);


        Route::prefix('worker')->group(function () {
            Route::get('/dashboard-pos', [WorkshopController::class, 'pos']);

            
            Route::get('print_last_document', [OrdenController::class, 'print_last_document']);
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
