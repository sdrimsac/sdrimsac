<?php

use App\Http\Controllers\Tenant\ItemController;
use App\Http\Controllers\Tenant\PersonController;
use App\Http\Controllers\Tenant\CompanyController;
use App\Http\Controllers\Tenant\WhatsappController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Restaurant\Http\Controllers\RestaurantController;

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
        Route::get('persons/customers/records', [PersonController::class, 'recordsApp']);
        // Route::get('/documents/series', 'Api\MobileController@getSeries');
        Route::get('categories/init', [ItemController::class, 'init_categories']);
        Route::post('whatsapp/qr', [WhatsappController::class, 'receiveQr']);
        Route::get('whatsapp/notification', [WhatsappController::class, 'notification']);
        Route::post('/login', 'Api\MobileController@login');
        Route::post('get_igv', [App\Http\Controllers\StoreController::class, 'getIgv']);
        //   Route::get('users/create', 'UserController@create')->name('tenant.users.create');
        Route::post('perfil', 'Api\MobileController@perfil');
        Route::get('users/type', 'UserController@usertype');
        Route::get('users/filter', 'UserController@filter');
        //Users
        Route::get('users', 'UserController@index');
        Route::get('users/tables', 'UserController@tables');
        Route::get('users/record/{user}', 'UserController@record');
        Route::post('users', 'UserController@store');
        Route::get('users/{type}/records', 'UserController@records');
        Route::delete('users/{user}', 'UserController@destroy');

        Route::get('info',[CompanyController::class,'info']);
        Route::get('categories/productsByCategory', [App\Http\Controllers\Tenant\ItemController::class, 'filterByCategory']);
        Route::get('services/ruc/{number}', 'Api\ServiceController@ruc');
        Route::get('services/dni/{number}', 'Api\ServiceController@dni');
        Route::get('services/numberletter/{number}', 'Api\ServiceController@numberletter');
        Route::get('sale-notes/downloadExternal/{external_id}', '\App\Http\Controllers\Tenant\SaleNoteController@downloadExternal');
        Route::get('sale-notes/records', '\App\Http\Controllers\Tenant\SaleNoteController@records');
        Route::get('sale-notes/records2', '\App\Http\Controllers\Tenant\SaleNoteController@records2');

        Route::get('sale-note/print/{external_id}/{format?}', '\App\Http\Controllers\Tenant\SaleNoteController@toPrint');
        Route::middleware(['auth:api', 'locked.tenant'])->group(function () {




            //Company
            Route::get('companies/record', 'CompanyController@record');
            //Customer
            //Persons
            Route::get('persons/columns', 'PersonController@columns');
            Route::get('persons/tables', 'PersonController@tables');
            Route::get('persons/{type}', 'PersonController@index');
            Route::get('persons/{type}/records', 'PersonController@records');
            Route::get('persons/record/{person}', 'PersonController@record');
            Route::get('persons/{type}/records', 'PersonController@records');
            Route::get('persons/{type}/listcustomer', 'PersonController@listcustomer');

            Route::post('persons', 'PersonController@store');
            Route::delete('persons/{person}', 'PersonController@destroy');
            Route::post('persons/import', 'PersonController@import');
            Route::get('persons/enabled/{type}/{person}', 'PersonController@enabled');

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
            //MOBILE
            Route::get('downloads/{model}/{type}/{external_id}/{format?}', 'DownloadController@downloadExternal');
            Route::get('document/series', 'Api\MobileController@getSeries');
            Route::get('document/tables', 'Api\MobileController@tables');
            Route::get('document/customers', 'Api\MobileController@customers');
            Route::post('document/email', 'Api\MobileController@document_email');
            Route::get('sale-note/record/{salenote}', '\App\Http\Controllers\Tenant\SaleNoteController@record');
            Route::post('sale-note', '\App\Http\Controllers\Tenant\SaleNoteController@store');
            //--------------------------------------------------------------------------------------------------
            Route::get('quotations', 'QuotationController@index')->middleware('redirect.level');
            Route::get('quotations/columns', 'QuotationController@columns');
            Route::get('quotations/records', 'QuotationController@records');
            Route::get('quotations/create/{saleOpportunityId?}', 'QuotationController@create')->middleware('redirect.level');
            Route::get('quotations/edit/{id}', 'QuotationController@edit')->middleware('redirect.level');

            Route::get('quotations/state-type/{state_type_id}/{id}', 'QuotationController@updateStateType');
            Route::get('quotations/filter', 'QuotationController@filter');
            Route::get('quotations/tables', 'QuotationController@tables');
            Route::get('quotations/table/{table}', 'QuotationController@table');
            Route::post('quotations', 'QuotationController@store');
            Route::post('quotations/update', 'QuotationController@update');
            Route::get('quotations/record/{quotation}', 'QuotationController@record');
            Route::get('quotations/anular/{id}', 'QuotationController@anular');
            Route::get('quotations/item/tables', 'QuotationController@item_tables');
            Route::get('quotations/option/tables', 'QuotationController@option_tables');
            Route::get('quotations/search/customers', 'QuotationController@searchCustomers');
            Route::get('quotations/search/customer/{id}', 'QuotationController@searchCustomerById');
            Route::get('quotations/download/{external_id}/{format?}', 'QuotationController@download');
            Route::get('quotations/print/{external_id}/{format?}', 'QuotationController@toPrint');
            Route::post('quotations/email', 'QuotationController@email');
            Route::post('quotations/duplicate', 'QuotationController@duplicate');
            Route::get('quotations/record2/{quotation}', 'QuotationController@record2');
            Route::get('quotations/changed/{quotation}', 'QuotationController@changed');
            //--------------------------------------------------------------------------------------------------
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
            Route::post('documents/{id}', 'Api\DocumentController@store');
            Route::get('documents/validate/{id}', '\App\Http\Controllers\Tenant\DocumentController@validar_cpe');
            Route::post('documents', 'Api\DocumentController@store');
            Route::get('documents/tables', '\App\Http\Controllers\Tenant\DocumentController@tables');
            Route::get('app/documents/tables', '\App\Http\Controllers\Tenant\DocumentController@tables');
            Route::get('documents/lists', 'Api\DocumentController@lists');
            Route::get('documents/record/{document}', '\App\Http\Controllers\Tenant\DocumentController@record');
            Route::get('documents/records', '\App\Http\Controllers\Tenant\DocumentController@records');
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
        //reseller
        // Route::post('reseller/detail', 'System\Api\ResellerController@resellerDetail');
        // Route::post('reseller/lockedAdmin', 'System\Api\ResellerController@lockedAdmin');
    });
}
