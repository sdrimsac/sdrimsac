<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventory\Http\Controllers\TransferController;
use Modules\Inventory\Http\Controllers\TransferPlaceController;
use Modules\Inventory\Models\TransferPlace;
use App\Http\Controllers\Tenant\ReportProductosController;

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
    //sdrimsac.test/inventory
    Route::prefix('inventory')->group(function () {
        Route::get('/', 'InventoryController@index')->name('inventory.index');
        Route::get('records', 'InventoryController@records');
        Route::get('columns', 'InventoryController@columns');
        /* Route::post('/regularizar-stock',  'InventoryController@regularizarStock')->name('regularizarstock'); */

        Route::get('tables/transaction/{type}', 'InventoryController@tables_transaction');
        Route::get('record/{inventory}', 'InventoryController@record');
        Route::post('/', 'InventoryController@store');
        Route::post('/transaction', 'InventoryController@store_transaction');
        Route::post('move', 'InventoryController@move');
        Route::get('tables', 'InventoryController@tables');
        Route::post('stock', 'InventoryController@stock');
        Route::post('regularizarStock', 'InventoryController@regularizarStock');
        Route::get('items', 'InventoryController@getItems');

        Route::get('moves', 'MovesController@index')->name('inventory.moves.index');

        Route::post('remove', 'InventoryController@remove');
        Route::get('initialize', 'InventoryController@initialize');
        Route::get('initinventory', 'InventoryController@updateinventory')->name('inventory.initinventory.index');
        Route::post('storeupdate', 'InventoryController@updatestore');
    });

    Route::prefix('productos')->group(function () {
        Route::get('/', 'ProductosController@index')->name('productos.index');
        Route::get('records', 'ProductosController@records');
        Route::get('columns', 'ProductosController@columns');

        Route::get('tables/transaction/{type}', 'SProductosController@tables_transaction');
        Route::get('record/{productos}', 'ProductosController@record');
        Route::post('/', 'ProductosController@store');
        Route::post('/transaction', 'ProductosController@store_transaction');
        Route::post('move', 'ProductosController@move');
        Route::get('tables', 'ProductosController@tables');
        Route::post('stock', 'ProductosController@stock');
        Route::get('items', 'ProductosController@getItems');

        Route::get('moves', 'MovesController@index')->name('inventory.moves.index');

        Route::post('remove', 'ProductosController@remove');
        Route::get('initialize', 'ProductosController@initialize');
        Route::get('initinventory', 'ProductosController@updateinventory')->name('inventory.initinventory.index');
        Route::post('storeupdate', 'ProductosController@updatestore');
    });



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
        /* agregado para la nueva ruta de entrda y salida de producto */

        /* Route::get('productos', [ReportProductosController::class, 'index'])->name('reports.productos.index');
        Route::get('productos/records', [ReportProductosController::class, 'records']);
        Route::get('productos/tables', [ReportProductosController::class, 'tables']);
        Route::post('productos/search', [ReportProductosController::class, 'search'])->name('reports.productos.search');
        Route::get('productos/pdf', [ReportProductosController::class, 'pdf'])->name('report.productos.pdf');
        Route::get('productos/excel', [ReportProductosController::class, 'excel'])->name('report.productos.report_excel'); */




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

    /* Route::prefix('tenant')->group(function () {
        Route::get('productos', [ReportProductosController::class, 'index'])->name('tenant.reports.productos.index');
        Route::get('productos/records', [ReportProductosController::class, 'records']);
        Route::get('productos/tables', [ReportProductosController::class, 'tables']);
        Route::post('productos/search', [ReportProductosController::class, 'search'])->name('tenant.reports.productos.search');
        Route::post('productos/pdf', [ReportProductosController::class, 'pdf'])->name('tenant.report.productos.pdf');
        Route::post('productos/excel', [ReportProductosController::class, 'excel'])->name('tenant.report.productos.report_excel');
    
    }); */


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


    Route::prefix('transactions')->group(function () {
        Route::get('/', 'InventoryTransactionController@index')->name('transactions.index');
        Route::get('records', 'InventoryTransactionController@records');
        Route::get('columns', 'InventoryTransactionController@columns');
        Route::get('tables', 'InventoryTransactionController@tables');
        Route::get('record/{inventory}', 'InventoryTransactionController@record');
        Route::post('/', 'InventoryTransactionController@store');
        Route::delete('{inventory}', 'InventoryTransactionController@destroy');
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
