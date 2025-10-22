<?php

use App\CoreFacturalo\Services\Models\Person;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Tenant\ItemController;
use App\Http\Controllers\Tenant\PersonController;
use App\Http\Controllers\Tenant\CompanyController;
use App\Http\Controllers\Tenant\ConfigurationController;
use App\Http\Controllers\Tenant\StoreController;
use App\Http\Controllers\Tenant\WhatsappController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\ApiPeruDev\Http\Controllers\ServiceController as ControllersServiceController;
use Modules\Restaurant\Http\Controllers\RestaurantController;


Route::middleware('auth:api')->get('/productos', function (Request $request) {
    return $request->user();
});

// Route::post('whatsapp/qr', [WhatsappController::class, 'receiveQr']);
Route::get('qz/crt/override', function () {

    return file_get_contents('qz/crt/override.crt');
});

Route::post('qz/signing', function (Request $request) {
    $KEY = file_get_contents('qz/signing/key.pem');
    $req = $request->input('request');
    $privateKey = openssl_get_privatekey($KEY /*, $PASS */);
    $signature = null;
    openssl_sign($req, $signature, $privateKey);
    if ($signature) {
        header("Content-type: text/plain");
        return base64_encode($signature);
    }
    return '<h1>Error signing message</h1>';
});
$hostname = app(Hyn\Tenancy\Contracts\CurrentHostname::class);

if ($hostname) {
    Route::domain($hostname->fqdn)->group(function () {

        Route::post('/login-app', [RestaurantController::class, 'login']);
        Route::post('digital_payment', [App\Http\Controllers\Tenant\PosController::class, 'digital_payment']);
        // Route::get('/documents/series', 'Api\MobileController@getSeries');
        Route::get('categories/init', [ItemController::class, 'init_categories']);
        Route::post('store_file', [DocumentController::class, 'storeFile']);
        Route::post('whatsapp/qr', [WhatsappController::class, 'receiveQr']);
        Route::get('whatsapp/notification', [WhatsappController::class, 'notification']);
        Route::post('/login', 'Api\MobileController@login');
        Route::post('get_igv', [StoreController::class, 'getIgv']);
        //   Route::get('users/create', 'UserController@create')->name('tenant.users.create');
        Route::post('perfil', 'Api\MobileController@perfil');
        Route::get('users/type', 'UserController@usertype');
        Route::get('users/filter', 'UserController@filter');
        Route::get('configurations', 'Api\MobileController@configurations');
        //Users
        Route::get('users', 'UserController@index');
        Route::get('users/tables', 'UserController@tables');
        Route::get('users/record/{user}', 'UserController@record');
        Route::post('users', 'UserController@store');
        Route::get('users/{type}/records', 'UserController@records');
        Route::delete('users/{user}', 'UserController@destroy');

        Route::get('info', [CompanyController::class, 'info']);
        Route::get('categories/productsByCategory', [App\Http\Controllers\Tenant\ItemController::class, 'filterByCategory']);
        Route::get('services/ruc/{number}', 'Api\ServiceController@ruc');
        Route::get('services/dni/{number}', 'Api\ServiceController@dni');
        Route::get('services/numberletter/{number}', 'Api\ServiceController@numberletter');
        Route::get('sale-notes/downloadExternal/{external_id}', '\App\Http\Controllers\Tenant\SaleNoteController@downloadExternal');
        Route::get('sale-notes/recordsMobile', '\App\Http\Controllers\Tenant\SaleNoteController@recordsMobile');
        Route::get('sale-notes/records2', '\App\Http\Controllers\Tenant\SaleNoteController@records2');
        Route::get('sale-notes/record/{id}', '\App\Http\Controllers\Tenant\SaleNoteController@record');

        Route::get('sale-note/print/{external_id}/{format?}', '\App\Http\Controllers\Tenant\SaleNoteController@toPrint');
        Route::middleware(['auth:api', 'locked.tenant'])->group(function () {

            Route::post('store_zip', [DocumentController::class, 'storeZip']);
            Route::get('client-default', [PersonController::class, 'client_default']);

            Route::get('persons/customers/records', [PersonController::class, 'recordsApp']);

            //Route::get('service/ruc/{number}', 'System\ServiceController@ruc');
            Route::get('service/{type}/{number}',  [Modules\Services\Http\Controllers\ServiceController::class, 'service']);

            Route::get('item-sets/check/{id}/{qty}', [App\Http\Controllers\Tenant\ItemSetController::class, 'set_item_check_stock']);
            Route::get('receta/check/{id}/{qty}', [App\Http\Controllers\Tenant\RecetaController::class, 'set_item_check_stock']);

            //Company
            Route::get('companies/record', '\App\Http\Controllers\Tenant\CompanyController@record');
            //Customer
            //Persons
            Route::get('persons/columns', '\App\Http\Controllers\Tenant\PersonController@columns');
            Route::get('persons/tables', '\App\Http\Controllers\Tenant\PersonController@tables');
            Route::get('persons/tablesMobile', '\App\Http\Controllers\Tenant\PersonController@tablesMobile');
            Route::get('persons/{type}', '\App\Http\Controllers\Tenant\PersonController@index');
            //Route::get('persons/{type}/records', '\App\Http\Controllers\Tenant\PersonController@records');
            Route::get('persons/{type}/recordsMobile', [App\Http\Controllers\Tenant\PersonController::class, 'recordsMobile']);
            Route::get('persons/record/{person}', '\App\Http\Controllers\Tenant\PersonController@record');
            // Route::get('persons/{type}/records', '\App\Http\Controllers\Tenant\PersonController@records');
            Route::get('persons/{type}/listcustomer', '\App\Http\Controllers\Tenant\PersonController@listcustomer');

            Route::post('persons', '\App\Http\Controllers\Tenant\PersonController@store');
            Route::delete('persons/{person}', '\App\Http\Controllers\Tenant\PersonController@destroy');
            Route::post('persons/import', '\App\Http\Controllers\Tenant\PersonController@import');
            Route::get('persons/enabled/{type}/{person}', '\App\Http\Controllers\Tenant\PersonController@enabled');

            //unidad de medida
            Route::get('unit_types/records', [App\Http\Controllers\Tenant\UnitTypeController::class, 'records']);
            Route::get('unit_types/columns', [App\Http\Controllers\Tenant\UnitTypeController::class, 'columns']);
            Route::get('unit_types/record/{id}', [App\Http\Controllers\Tenant\UnitTypeController::class, 'record']);
            Route::post('unit_types', [App\Http\Controllers\Tenant\UnitTypeController::class, 'store']);
            Route::delete('unit_types/{id}', [App\Http\Controllers\Tenant\UnitTypeController::class, 'destroy']);

            //Orders
            Route::get('orders', 'OrderController@index');
            Route::get('orders/columns', 'OrderController@columns');
            Route::get('orders/records', 'OrderController@records');
            Route::post('orders/update', 'OrderController@update');
            Route::post('orders/status/update', 'OrderController@StatusOrders');
            Route::get('orders/record/{id}', 'OrderController@record');
            Route::get('items/columns', '\App\Http\Controllers\Tenant\ItemController@columns');
            
            //Items
            Route::get('items', '\App\Http\Controllers\Tenant\ItemController@index')->middleware('redirect.level');
            Route::get('items/columns', '\App\Http\Controllers\Tenant\ItemController@columns');
            Route::get('items/category/{idcategoria}', '\App\Http\Controllers\Tenant\ItemController@filtercategory');
            Route::get('items/records', '\App\Http\Controllers\Tenant\ItemController@records');
            Route::get('items/tables', '\App\Http\Controllers\Tenant\ItemController@tables');
            Route::get('items/record/{item}', '\App\Http\Controllers\Tenant\ItemController@record');
            Route::post('items', '\App\Http\Controllers\Tenant\ItemController@store');
            Route::delete('items/{item}', '\App\Http\Controllers\Tenant\ItemController@destroy');
            Route::delete('items/item-unit-type/{item}', '\App\Http\Controllers\Tenant\ItemController@destroyItemUnitType');
            Route::post('items/import', '\App\Http\Controllers\Tenant\ItemController@import');
            Route::post('items/upload', '\App\Http\Controllers\Tenant\ItemController@upload');
            Route::post('items/visible_store', '\App\Http\Controllers\Tenant\ItemController@visibleStore');
            Route::post('items/duplicate', '\App\Http\Controllers\Tenant\ItemController@duplicate');
            Route::get('items/disable/{item}', '\App\Http\Controllers\Tenant\ItemController@disable');
            Route::get('items/enable/{item}', '\App\Http\Controllers\Tenant\ItemController@enable');
            Route::get('items/images/{item}', '\App\Http\Controllers\Tenant\ItemController@images');
            Route::get('items/images/delete/{id}', '\App\Http\Controllers\Tenant\ItemController@delete_images');
            Route::get('items/recordsMobile', '\App\Http\Controllers\Tenant\ItemController@recordsMobile');

            //MOBILE
            Route::get('downloads/{model}/{type}/{external_id}/{format?}', '\App\Http\Controllers\Tenant\DownloadController@downloadExternal');
            Route::get('document/series', 'Api\MobileController@getSeries');
            Route::get('document/tables', 'Api\MobileController@tables');
            Route::get('document/customers', 'Api\MobileController@customers');
            Route::post('document/email', 'Api\MobileController@document_email');
            Route::get('sale-note/record/{salenote}', '\App\Http\Controllers\Tenant\SaleNoteController@record');
            Route::post('sale-note', '\App\Http\Controllers\Tenant\SaleNoteController@store');
            // para la busqueda de items para la venta

            //--------------------------------------------------------------------------------------------------
            Route::get('quotations', 'QuotationController@index')->middleware('redirect.level');
            Route::get('quotations/columns', 'QuotationController@columns');
            Route::get('quotations/recordsMobile', '\App\Http\Controllers\Tenant\QuotationController@recordsMobile');
            Route::get('quotations/create/{saleOpportunityId?}', 'QuotationController@create')->middleware('redirect.level');
            Route::get('quotations/edit/{id}', 'QuotationController@edit')->middleware('redirect.level');

            Route::get('quotations/state-type/{state_type_id}/{id}', 'QuotationController@updateStateType');
            Route::get('quotations/filter', 'QuotationController@filter');
            Route::get('quotations/tables', 'QuotationController@tables');
            Route::get('quotations/table/{table}', 'QuotationController@table');
            Route::post('quotations', '\App\Http\Controllers\Tenant\QuotationController@store');
            Route::post('quotations/update', 'QuotationController@update');
            Route::get('quotations/record/{quotation}', 'QuotationController@record');
            Route::get('quotations/anular/{id}', 'QuotationController@anular');
            Route::get('quotations/item/tables', 'QuotationController@item_tables');
            Route::get('quotations/option/tables', 'QuotationController@option_tables');
            Route::get('quotations/search/customers', 'QuotationController@searchCustomers');
            Route::get('quotations/search/customer/{id}', 'QuotationController@searchCustomerById');
            Route::get('quotations/download/{external_id}/{format?}', '\App\Http\Controllers\Tenant\QuotationController@download');
            Route::get('quotations/print/{external_id}/{format?}', 'QuotationController@toPrint');
            Route::post('quotations/email', 'QuotationController@email');
            Route::post('quotations/duplicate', 'QuotationController@duplicate');
            Route::get('quotations/record2/{quotation}', 'QuotationController@record2');
            Route::get('quotations/changed/{quotation}', 'QuotationController@changed');
            //--------------------------------------------------------------------------------------------------

            //purchases
            Route::get('purchases/columns', [App\Http\Controllers\Tenant\PurchaseController::class, 'columns']);
            Route::get('purchases/ne76/correlative', [App\Http\Controllers\Tenant\PurchaseController::class, 'ne76_correlative']);
            Route::get('purchases/recordsMobile', [App\Http\Controllers\Tenant\PurchaseController::class, 'recordsMobile']);
            Route::get('purchases/export/{type}', [App\Http\Controllers\Tenant\PurchaseController::class, 'exports']);
            Route::get('purchases/create/{purchase_order_id?}', [App\Http\Controllers\Tenant\PurchaseController::class, 'create'])->name('tenant.purchases.create')->middleware('just.admin');;
            Route::get('purchases/tables', [App\Http\Controllers\Tenant\PurchaseController::class, 'tables']);
            Route::get('purchases/table/{table}', [App\Http\Controllers\Tenant\PurchaseController::class, 'table']);
            Route::post('purchases', [App\Http\Controllers\Tenant\PurchaseController::class, 'store']);
            Route::post('purchases/update', [App\Http\Controllers\Tenant\PurchaseController::class, 'update']);
            Route::get('purchases/record/{document}', [App\Http\Controllers\Tenant\PurchaseController::class, 'record']);
            Route::get('purchases/edit/{id}', [App\Http\Controllers\Tenant\PurchaseController::class, 'edit']);
            Route::get('purchases/anular/{id}', [App\Http\Controllers\Tenant\PurchaseController::class, 'anular']);
            Route::get('purchases/delete/{id}', [App\Http\Controllers\Tenant\PurchaseController::class, 'delete']);
            Route::post('purchases/import', [App\Http\Controllers\Tenant\PurchaseController::class, 'import']);
            Route::post('purchases/facturar', [App\Http\Controllers\Tenant\PurchaseController::class, 'updatefacturar']);
            Route::post('purchases/importColorZise', [App\Http\Controllers\Tenant\PurchaseController::class, 'importColorZise']);

            //grupos//
            Route::get('groups', 'GroupController@index');
            Route::get('groups/create', 'GroupController@create');
            Route::get('groups/columns', 'GroupController@columns');

            Route::get('groups/tables', 'GroupController@tables');
            Route::get('groups/record/{groups}', 'GroupController@record');
            Route::post('groups', 'GroupController@store');
            Route::get('groups/records', 'GroupController@records');
            Route::delete('groups/{groups}', 'GroupController@destroy');
            //categorias//
            Route::get('category', 'CategoryController@index');
            Route::get('category/create', 'CategoryController@create');
            Route::get('category/tables', 'CategoryController@tables');
            Route::get('category/record/{categories}', 'CategoryController@record');
            Route::post('category', 'CategoryController@store');
            Route::get('category/records', 'CategoryController@records');
            Route::delete('category/{categories}', 'CategoryController@destroy');
            //subcategorias//
            Route::get('subcategories/columns', 'SubcategoryController@columns');
            Route::get('subcategories', 'SubcategoryController@index');
            Route::get('subcategories/create', 'SubcategoryController@create');
            Route::get('subcategories/tables', 'SubcategoryController@tables');
            Route::get('subcategories/record/{categories}', 'SubcategoryController@record');
            Route::post('subcategories', 'SubcategoryController@store');
            Route::get('subcategories/records', 'SubcategoryController@records');
            Route::delete('subcategories/{subcategories}', 'SubcategoryController@destroy');

            Route::get('configurations-client', '\App\Http\Controllers\Tenant\ConfigurationController@recordConfigurationClient');

            //cajas Egresos//
            Route::get('reports/boxes', 'BoxController@reports');
            Route::get('reports/boxes/reports_type', 'BoxController@reports_type');
            Route::get('expensesbox', 'BoxController@index');
            Route::get('expensesbox/reports', 'BoxController@reports_results');
            Route::get('expensesbox/create', 'BoxController@create');
            Route::get('expensesbox/columns', 'BoxController@columns');
            Route::get('expensesbox/tables', 'BoxController@tables');
            Route::get('expensesbox/record/{boxes}', 'BoxController@record');
            Route::post('expensesbox', 'BoxController@store');
            Route::get('expensesbox/records', 'BoxController@records');
            Route::delete('expensesbox/{boxes}', 'BoxController@destroy');
            //cajas Ingresos//
            Route::get('incomebox', 'BoxController@incomebox');
            Route::get('incomebox/create', 'BoxController@create');
            Route::get('incomebox/columns', 'BoxController@columns');
            Route::get('incomebox/tables', 'BoxController@tables');
            Route::get('incomebox/record/{boxes}', 'BoxController@record');
            Route::post('incomebox', 'BoxController@store');
            Route::get('incomebox/records', 'BoxController@records2');
            Route::delete('incomebox/{boxes}', 'BoxController@destroy');
            //--------------------------------------------------------------------------------------------------

            Route::get('sale-note/series', 'Api\SaleNoteController@series');
            Route::get('sale-note/lists', 'Api\SaleNoteController@lists');
            Route::post('item', 'Api\MobileController@item');
            Route::post('person', 'Api\MobileController@person');
            Route::get('document/search-items', 'Api\MobileController@searchItems');
            Route::get('document/search-customers', 'Api\MobileController@searchCustomers');
            Route::post('documents/generar_documents', '\App\Http\Controllers\Tenant\DocumentController@store');
            //Route::post('documents/{id}', 'Api\DocumentController@store');
            Route::get('documents/validate/{id}', '\App\Http\Controllers\Tenant\DocumentController@validar_cpe');
            // Route::post('documents', 'Api\DocumentController@store');
            Route::post('documents', '\App\Http\Controllers\Tenant\DocumentController@store');
            Route::post('documents-client', '\App\Http\Controllers\Tenant\DocumentController@storeClient');
            Route::get('documents/tables', '\App\Http\Controllers\Tenant\DocumentController@tables');
            Route::get('app/documents/tables', '\App\Http\Controllers\Tenant\DocumentController@tables');
            Route::get('documents/lists', 'Api\DocumentController@lists');
            Route::get('documents/record/{document}', '\App\Http\Controllers\Tenant\DocumentController@record');
            // Route::get('documents/records', '\App\Http\Controllers\Tenant\DocumentController@records');
            Route::get('documents/records', 'Api\DocumentController@records');
            Route::post('summaries', 'Api\SummaryController@store');
            Route::post('voided', 'Api\VoidedController@store');
            Route::post('retentions', 'Api\RetentionController@store');
            Route::post('dispatches', 'Api\DispatchController@store');
            Route::post('documents/send', 'Api\DocumentController@send');
            Route::get('documents/send/{document}', '\App\Http\Controllers\Tenant\DocumentController@send');
            Route::post('summaries/status', 'Api\SummaryController@status');
            Route::post('voided/status', 'Api\VoidedController@status');
            Route::get('services/ruc/{number}', 'Api\ServiceController@ruc');
            Route::get('services/dni/{number}', 'Api\ServiceController@dni');
            Route::post('services/consult_cdr_status', 'Api\ServiceController@consultCdrStatus');
            Route::post('perceptions', 'Api\PerceptionController@store');

            Route::post('documents_server', 'Api\DocumentController@storeServer');
            Route::get('document_check_server/{external_id}', 'Api\DocumentController@documentCheckServer');

            Route::post('dispatches', 'Api\DispatchController@store');
            Route::get('dispatches/records', 'Api\DispatchController@records');

            //bancos y cuentas bancarias
            Route::get('bank_accounts/records', [App\Http\Controllers\Tenant\BankAccountController::class, 'records']);
            Route::get('bank_accounts/create', [App\Http\Controllers\Tenant\BankAccountController::class, 'create']);
            Route::get('bank_accounts/tables', [App\Http\Controllers\Tenant\BankAccountController::class, 'tables']);
            Route::get('bank_accounts/record/{bank_account}', [App\Http\Controllers\Tenant\BankAccountController::class, 'record']);
            Route::post('bank_accounts', [App\Http\Controllers\Tenant\BankAccountController::class, 'store']);
            Route::get('bank_accounts/update_accounts/{bank_accounts_id}', [App\Http\Controllers\Tenant\BankAccountController::class, 'update_accounts']);
            Route::delete('bank_accounts/{bank_account}', [App\Http\Controllers\Tenant\BankAccountController::class, 'destroy']);

            //bancos
            Route::get('banks/records', [App\Http\Controllers\Tenant\BankController::class, 'records']);
            Route::post('banks/{bank_id}/upload-image', [App\Http\Controllers\Tenant\BankController::class, 'UploadImage']);
            Route::get('banks/record/{bank}', [App\Http\Controllers\Tenant\BankController::class, 'record']);
            Route::post('banks', [App\Http\Controllers\Tenant\BankController::class, 'store']);
            Route::delete('banks/{bank_id}/delete-image', [App\Http\Controllers\Tenant\BankController::class, 'deleteImage']);
            Route::delete('banks/{bank}', [App\Http\Controllers\Tenant\BankController::class, 'destroy']);
        });
        Route::get('documents/search/customers', '\App\Http\Controllers\Tenant\DocumentController@searchCustomers');

        Route::post('services/validate_cpe', 'Api\ServiceController@validateCpe');
        Route::post('services/consult_status', 'Api\ServiceController@consultStatus');
        Route::post('documents/status', 'Api\ServiceController@documentStatus');
        Route::get('sendserver/{document_id}/{query?}', '\App\Http\Controllers\Tenant\DocumentController@sendServer');
    });
} else {
    Route::domain(env('APP_URL_BASE'))->group(function () {
        Route::get('listclients/', 'System\ClientController@records');
        Route::get('getVerificateDominan', 'System\ClientController@getVerificateDominan');
        //reseller
        // Route::post('reseller/detail', 'System\Api\ResellerController@resellerDetail');
        // Route::post('reseller/lockedAdmin', 'System\Api\ResellerController@lockedAdmin');
    });
}
