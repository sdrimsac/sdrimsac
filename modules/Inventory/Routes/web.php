<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventory\Http\Controllers\TransferController;
use Modules\Inventory\Http\Controllers\TransferPlaceController;
use Modules\Inventory\Models\TransferPlace;

Route::get('reports/valued/excel', 'ReportValuedStockController@exportExcel');

Route::middleware(['auth', 'redirect.module', 'locked.tenant'])->group(function () {
    // Config inventory

    Route::prefix('warehouses')->group(function () {
        Route::get('/', 'WarehouseController@index')->name('warehouses.index');
        Route::get('records', 'WarehouseController@records');
        Route::get('columns', 'WarehouseController@columns');
        Route::get('tables', 'WarehouseController@tables');
        Route::get('record/{warehouse}', 'WarehouseController@record');
        Route::post('/', 'WarehouseController@store');
        Route::get('initialize', 'WarehouseController@initialize');
    });

    Route::prefix('inventory')->group(function () {
        Route::get('/', 'InventoryController@index')->name('inventory.index');
        Route::get('records', 'InventoryController@records');
        Route::get('columns', 'InventoryController@columns');

        Route::get('tables/transaction/{type}', 'InventoryController@tables_transaction');
        Route::get('record/{inventory}', 'InventoryController@record');
        Route::post('/', 'InventoryController@store');
        Route::post('/transaction', 'InventoryController@store_transaction');
        Route::post('move', 'InventoryController@move');
        Route::post('stock', 'InventoryController@stock');

        Route::get('moves', 'MovesController@index')->name('inventory.moves.index');

        Route::post('remove', 'InventoryController@remove');
        Route::get('initialize', 'InventoryController@initialize');
        Route::get('initinventory', 'InventoryController@updateinventory')->name('inventory.initinventory.index');
        Route::post('storeupdate', 'InventoryController@updatestore');
    });

    Route::middleware(['just.admin'])->group(function () {
        Route::prefix('reports')->group(function () {
            Route::get('inventory', 'ReportInventoryController@index')->name('reports.inventory.index');
            Route::get('inventory/records', 'ReportInventoryController@records');
            Route::get('inventory/tables', 'ReportInventoryController@tables');
            Route::post('inventory/search', 'ReportInventoryController@search')->name('reports.inventory.search');
            Route::get('inventory/pdf', 'ReportInventoryController@pdf')->name('reports.inventory.pdf');
            Route::get('inventory/excel', 'ReportInventoryController@excel')->name('reports.inventory.report_excel');

            // Route::get('kardex', 'ReportKardexController@index')->name('reports.kardex.index');
            // Route::get('kardex/search', 'ReportKardexController@search')->name('reports.kardex.search');
            // Route::post('kardex/pdf', 'ReportKardexController@pdf')->name('reports.kardex.pdf');
            // Route::post('kardex/excel', 'ReportKardexController@excel')->name('reports.kardex.report_excel');



            Route::get('kardex', 'ReportKardexController@index')->name('reports.kardex.index');
            Route::get('kardex/pdf', 'ReportKardexController@pdf')->name('reports.kardex.pdf');
            Route::get('kardex/excel', 'ReportKardexController@excel')->name('reports.kardex.excel');
            Route::get('kardex/filter', 'ReportKardexController@filter')->name('reports.kardex.filter');
            Route::get('kardex_lots/filter', 'ReportKardexController@filter');
            Route::get('kardex_series/filter', 'ReportKardexController@filter');

            Route::get('kardex/records', 'ReportKardexController@records')->name('reports.kardex.records');
            Route::get('kardex/lots/filter', 'ReportKardexController@records_lots');
            Route::get('kardex_lots/records', 'ReportKardexController@records_lots_kardex')->name('reports.kardex_lots.records');
            Route::get('kardex_series/records', 'ReportKardexController@records_series_kardex')->name('reports.kardex_series.records');

            Route::get('inventorykardex/pdf', 'ReportKardexController@pdf_inventory_sunat');
            Route::get('inventorykardex/excel', 'ReportKardexController@excel_inventory_sunat');
            Route::get('inventorykardex/txt', 'ReportKardexController@txt_inventory_sunat');



            Route::get('valued-kardex', 'ReportValuedKardexController@index')->name('reports.valued_kardex.index');
            Route::get('valued-kardex/excel', 'ReportValuedKardexController@excel');
            Route::get('valued-kardex/filter', 'ReportValuedKardexController@filter');
            Route::get('valued-kardex/records', 'ReportValuedKardexController@records');

            Route::get('stockmin', 'ReportStockMinController@index')->name('reports.stockmin.index');
            Route::get('stockmin/records/{values}', 'ReportStockMinController@records');
            Route::get('stockmin/recordsProveedor/{id}', 'ReportStockMinController@recordsProveedor');
            Route::post('stockmin/insertAprovisionar', 'ReportStockMinController@insertAprovisionar');
            Route::post('stockmin/deletefromlist', 'ReportStockMinController@deletefromlist');
            Route::post('stockmin/genOrdenCompra', 'ReportStockMinController@genOrdenCompra');
            Route::get('stockmin/recordsOrden', 'ReportStockMinController@recordsOrden');
            Route::get('stockmin/exportExcel/{id}', 'ReportStockMinController@exportExcel');
            Route::get('stockmin/listOrdenCompra', 'ReportStockMinController@listOrdenCompra');
            Route::get('stockmin/productosDetalle/{id}', 'ReportStockMinController@productosDetalle');
            Route::get('stockmin/getListProv', 'ReportStockMinController@getListProv');
            Route::post('stockmin/genOrdenCompraMasiva', 'ReportStockMinController@genOrdenCompraMasiva');

            Route::get('valued', 'ReportValuedStockController@index')->name('reports.valued.index');
            Route::get('valued/records', 'ReportValuedStockController@report_cash');


            Route::get('series/', 'VentaSeriesController@index')->name('reports.series.index');
            Route::post('series/getDataSeries', 'VentaSeriesController@getDataSeries');
            Route::post('series/getDataSeriesSalesnotes', 'VentaSeriesController@getDataSeriesSalesnotes');
            Route::get('series/getPersonas', 'VentaSeriesController@getPersonas');
            Route::get('series/reporteexcel', 'VentaSeriesController@reporteexcel');
            Route::post('series/envioReportWhastap', 'VentaSeriesController@envioReportWhastap');
        });
    });


    Route::prefix('inventories')->group(function () {

        Route::get('configuration', 'InventoryConfigurationController@index')->name('tenant.inventories.configuration.index');
        Route::get('configuration/record', 'InventoryConfigurationController@record');
        Route::post('configuration', 'InventoryConfigurationController@store');
    });

    Route::prefix('moves')->group(function () {

        Route::get('/', 'MovesController@index')->name('moves.index');
        Route::get('records', 'MovesController@records');
        Route::get('columns', 'MovesController@columns');
    });


    Route::prefix('transfers')->group(function () {
        Route::get('/', 'TransferController@index')->name('transfers.index');

        Route::get('records', 'TransferController@records');
        Route::get('columns', 'TransferController@columns');
        Route::get('tables', 'TransferController@tables');
        Route::get('record/{inventory}', 'TransferController@record');
        Route::post('/', 'TransferController@store');

        //accept_transfer
        // Route::middleware(['just.admin'])->group(function () {
        Route::get('/transfer_place', [TransferPlaceController::class, 'index'])->name('transfers_place.index')
            ->middleware(['just.admin']);
        Route::post('/place', [TransferPlaceController::class, 'place_transfer']);
        Route::get('/places', [TransferPlaceController::class, 'get_place_transfer']);
        Route::post('/accept_transfer', [TransferPlaceController::class, 'accept_transfer']);
        Route::get('/transfer_place/records', [TransferPlaceController::class, 'records']);
        Route::get('/transfer_place/columns', [TransferPlaceController::class, 'columns']);
        Route::get('/transfer_place/tables', [TransferPlaceController::class, 'tables']);
        // });

        Route::delete('{inventory}', 'TransferController@destroy');

        Route::get('create', 'TransferController@create')->name('transfer.create');

        Route::get('stock/{item_id}/{warehouse_id}', 'TransferController@stock');

        Route::get('items/{warehouse_id}', 'TransferController@items');
    });
});
