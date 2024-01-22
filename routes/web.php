<?php

use App\Http\Controllers\Tenant\ClientZoneController;
use App\Http\Controllers\Tenant\CommercialTreatmentController;
use App\Http\Controllers\Tenant\CreditListController;
use App\Http\Controllers\Tenant\DispatchController;
use App\Http\Controllers\Tenant\InventoryController;
use App\Http\Controllers\Tenant\ItemController;
use App\Http\Controllers\Tenant\PersonController;
use App\Http\Controllers\Tenant\TollController;
use App\Http\Controllers\Tenant\WhatsappController;
use App\Http\Controllers\Tenant\PurchaseController;
use App\Http\Controllers\Tenant\SellerController;
use App\Models\Tenant\CommercialTreatment;
use App\Models\Tenant\Dispatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Restaurant\Events\OrdenEvent;
use Modules\Restaurant\Http\Controllers\CashController;
use Modules\Inventory\Http\Controllers\TransferPlaceController;
use Modules\Restaurant\Http\Controllers\IncomesController;

$hostname = app(Hyn\Tenancy\Contracts\CurrentHostname::class);
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home']);
if ($hostname) {
    Route::domain($hostname->fqdn)->group(
        function () {
            Auth::routes([
                'register' => false,
                'verify'   => false
            ]);
            Route::get('report_product_client/report/excel', [ItemController::class, 'items_by_clients_excel']);

            Route::get('credit-list/receipt/{id}/ticket', [CreditListController::class, 'receipt']);
            Route::get('buscar', [App\Http\Controllers\Tenant\SearchController::class, 'index'])->name('search.index');
            Route::get('search/tables', [App\Http\Controllers\Tenant\SearchController::class, 'tables']);
            Route::post('search', [App\Http\Controllers\Tenant\SearchController::class, 'store']);
            Route::post('efectivo', [App\Http\Controllers\Tenant\SearchController::class, 'efectivo']);
            Route::get('transfers/print_places/{code?}', [TransferPlaceController::class, 'print_transfer']);
            Route::get('report_cash/report/{type}', [CashController::class, 'report_cash_export']);
            Route::get('downloads/{model}/{type}/{external_id}/{format?}', [App\Http\Controllers\Tenant\DownloadController::class, 'downloadExternal'])->name('tenant.download.external_id');
            Route::get('print/{model}/{external_id}/{format?}', [App\Http\Controllers\Tenant\DownloadController::class, 'toPrint']);
            Route::get('quotations/print/{external_id}/{format?}', [App\Http\Controllers\Tenant\QuotationController::class, 'toPrint']);
            Route::get('sale-notes/print/{external_id}/{format?}', [App\Http\Controllers\Tenant\SaleNoteController::class, 'toPrint']);
            Route::get('sale-notes/schedule/{sale_note_id}', [App\Http\Controllers\Tenant\SaleNoteController::class, 'schedule']);
            Route::get('receipt/print/{external_id}', [App\Http\Controllers\Tenant\ReceiptController::class, 'toPrint']);
            Route::get('getDesarrollador', [App\Http\Controllers\Tenant\UserController::class, 'getDesarrollador']);
            Route::get('getAreaPrinter', [App\Http\Controllers\Tenant\UserController::class, 'getAreaPrinter']);

            //Route::post('logout', [App\Http\Controllers\Tenant\LoginController::class, 'logout'])->name('logout');
            Route::post('auth', [App\Http\Controllers\Tenant\LoginController::class, 'authenticate'])->name('authenticate');

            Route::middleware(['auth', 'redirect.module', 'locked.tenant'])->group(function () {
                Route::prefix('/commercial_treatment')
                    ->group(function () {
                        Route::get('/', [CommercialTreatmentController::class, 'index'])->name('tenant.commercial_treatment.index');
                        Route::get('/columns', [CommercialTreatmentController::class, 'columns']);
                        Route::get('/records', [CommercialTreatmentController::class, 'records']);
                        Route::get('/record/{id}', [CommercialTreatmentController::class, 'record']);
                        Route::delete('/{id}', [CommercialTreatmentController::class, 'delete']);
                        Route::post('/', [CommercialTreatmentController::class, 'store']);
                        Route::prefix('categories')
                            ->group(function () {

                                Route::get('/records/{commercial_treatment_id}', [CommercialTreatmentController::class, 'records_categories']);
                                Route::post('/{commercial_treatment_id}', [CommercialTreatmentController::class, 'store_categories']);
                            });
                        Route::prefix('items')
                            ->group(function () {

                                Route::get('/records/{commercial_treatment_id}', [CommercialTreatmentController::class, 'records_items']);
                                Route::get('/record/{item_id}/{commercial_treatment_id}', [CommercialTreatmentController::class, 'record_items']);
                                Route::post('/{commercial_treatment_id}', [CommercialTreatmentController::class, 'store_items']);
                                Route::post('/record/{item_id}/{commercial_treatment_id}', [CommercialTreatmentController::class, 'set_item']);
                                Route::post('/get-items/{commercial_treatment_id}', [CommercialTreatmentController::class, 'get_items']);
                                Route::delete('/record/{commercial_treatment_items_id}', [CommercialTreatmentController::class, 'deleteItem']);
                            });
                    });
                Route::prefix('credit-list')->group(function () {
                    Route::get('/', [CreditListController::class, 'credit_list_report_index'])->name('tenant.credit_list.index');
                    Route::get('/tables', [CreditListController::class, 'tables']);
                    Route::post('/send-credit', [CreditListController::class, 'send_credit']);

                    Route::get('/balance/{customer_id}', [CreditListController::class, 'get_balance']);
                    Route::get('/records', [CreditListController::class, 'records']);
                    Route::get('/records_by_person/download', [CreditListController::class, 'download']);
                    Route::post('/records_by_person', [CreditListController::class, 'recordByPerson']);
                    Route::post('/records_by_person_to_pay', [CreditListController::class, 'recordByPersonToPay']);
                    Route::get('/get-ordens/{customer_id}', [CreditListController::class, 'get_ordens']);
                });
                Route::prefix('/sellers')->group(function () {
                    //
                    Route::get('/', [SellerController::class, 'index'])->name('tenant.sellers.index');
                    Route::get('/records', [SellerController::class, 'records']);
                    Route::get('/record/{id}', [SellerController::class, 'record']);
                    Route::get('/tables', [SellerController::class, 'tables']);
                    Route::post('/', [SellerController::class, 'store']);
                });
                Route::prefix('/registers')->group(function () {
                    Route::get('/', [App\Http\Controllers\Tenant\RegisterController::class, 'index'])->name('tenant.registers.index');
                    Route::get('/records', [App\Http\Controllers\Tenant\RegisterController::class, 'records']);
                    Route::get('/columns', [App\Http\Controllers\Tenant\RegisterController::class, 'columns']);
                    Route::get('/tables', [App\Http\Controllers\Tenant\RegisterController::class, 'tables']);
                    Route::get('/record/{id}', [App\Http\Controllers\Tenant\RegisterController::class, 'record']);
                    Route::post('/', [App\Http\Controllers\Tenant\RegisterController::class, 'store']);
                    Route::delete('/delete/{id}', [App\Http\Controllers\Tenant\RegisterController::class, 'destroy']);
                });

                Route::get('fix_models', [InventoryController::class, 'fix_models']);
                Route::get('toll', [TollController::class, 'index'])->name('toll.index');
                Route::get('toll/records', [TollController::class, 'records']);
                Route::get('toll/items/{warehouse_id}', [TollController::class, 'items']);
                Route::get('toll/tables', [TollController::class, 'tables']);
                Route::get('toll/delete/{toll_id}', [TollController::class, 'delete_item']);
                Route::post('toll', [TollController::class, 'store']);
                Route::get('toll/{number}', [TollController::class, 'person']);

                Route::get('report_product_client', [ItemController::class, 'index_product_client'])->name('reports.products-clients.index');
                Route::get('report_product_client/records', [ItemController::class, 'items_by_clients']);



                Route::get('report_cash', [CashController::class, 'index_report_cash'])->name('reports.cash.index');
                Route::get('report_closed_cash', [CashController::class, 'index_report_closed_cash'])->name('reports.cash_closes.index');
                Route::get('report_cash/records', [CashController::class, 'report_cash']);
                Route::get('get_stock_file/{id}', [CashController::class, 'get_stock_file']);

                Route::post('whatsapp', [App\Http\Controllers\Tenant\WhatsappController::class, 'sendwhatsapp']);
                Route::post('whatsapp/reprint/{type}/{external_id}', [App\Http\Controllers\Tenant\WhatsappController::class, 'reprintDocument']);
                Route::post('whatsapp/save', [App\Http\Controllers\Tenant\WhatsappController::class, 'saveWhatsapp']);
                Route::post('whatsapp/remove', [App\Http\Controllers\Tenant\WhatsappController::class, 'removeWhatsapp']);
                Route::get('whatsapp/numbers', [App\Http\Controllers\Tenant\WhatsappController::class, 'getNumbers']);
                Route::post('whatsapp/historial', [App\Http\Controllers\Tenant\WhatsappController::class, 'sendHistorial']);
                Route::get('report_cash/report/pdf', [CashController::class, 'report_cash_pdf']);
                Route::post('whatsapp', [App\Http\Controllers\Tenant\WhatsappController::class, 'sendwhatsapp']);
                Route::get('whatsapp', [WhatsappController::class, 'index'])->name('whatsapp');
                Route::get('whatsapp/get-sesion', [WhatsappController::class, 'getStatus']);
                Route::post('whatsapp/init', [WhatsappController::class, 'initWhatsapp']);
                Route::post('whatsapp/get-file', [WhatsappController::class, 'getFile']);


                Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
                Route::get('validar', [App\Http\Controllers\Tenant\ValidateController::class, 'validar_cpe']);
                Route::get('pos/tables', [App\Http\Controllers\Tenant\PosController::class, 'tables']);
                Route::get('pos/table/customerId/{id}', [App\Http\Controllers\Tenant\PosController::class, 'table_customer']);
                Route::get('persons/tables', [App\Http\Controllers\Tenant\PersonController::class, 'tables']);
                Route::get('items/tables', [App\Http\Controllers\Tenant\ItemController::class, 'tables']);
                Route::get('documents/record/{document}', [App\Http\Controllers\Tenant\DocumentController::class, 'record']);
                Route::get('documents/get_record/{document}', [App\Http\Controllers\Tenant\DocumentController::class, 'getRecord']);
                Route::get('sale-notes/record/{salenote}', [App\Http\Controllers\Tenant\SaleNoteController::class, 'record']);
                Route::get('pos/print_default', [App\Http\Controllers\Tenant\PosController::class, 'print_default']);
                Route::post('pos/date_of_issue', [App\Http\Controllers\Tenant\PosController::class, 'date_of_issue']);
                Route::post('pos/last_number_documents', [App\Http\Controllers\Tenant\PosController::class, 'last_number_documents']);
                Route::get('pos/payment_tables', [App\Http\Controllers\Tenant\PosController::class, 'payment_tables']);
                Route::post('sale-notes', [App\Http\Controllers\Tenant\SaleNoteController::class, 'store']);
                Route::get('sale-notes/credit-cash/records', [App\Http\Controllers\Tenant\SaleNoteController::class, 'credit_cash_records']);
                Route::post('cash/cash_document', [Modules\Restaurant\Http\Controllers\CashController::class, 'cash_document']);
                Route::prefix('cash/main_cash')->group(function () {
                    Route::get('/', [CashController::class, 'index_main']);
                    Route::get('/records', [CashController::class, 'records_principal']);
                    Route::get('/accept/{id}', [CashController::class, 'accept_register']);
                    Route::post('/observ/{id}', [CashController::class, 'observ_register']);
                });
                Route::post('documents', [App\Http\Controllers\Tenant\DocumentController::class, 'store']);
                Route::post('sale_note_payments', [App\Http\Controllers\Tenant\SaleNotePaymentController::class, 'store']);
                Route::post('document_payments', [App\Http\Controllers\Tenant\DocumentPaymentController::class, 'store']);
                Route::post('persons', [App\Http\Controllers\Tenant\PersonController::class, 'store']);
                Route::get('pos/table/{table}', [App\Http\Controllers\Tenant\PosController::class, 'table']);
                Route::get('companies/record', [App\Http\Controllers\Tenant\CompanyController::class, 'record']);
                Route::get('documents/records', [App\Http\Controllers\Tenant\DocumentController::class, 'records']);
                Route::get('documents/excel', [App\Http\Controllers\Tenant\DocumentController::class, 'excel']);


                Route::get('catalogs', [App\Http\Controllers\Tenant\CatalogController::class, 'index'])->name('tenant.catalogs.index')->middleware('just.admin');
                Route::get('expenses', [Modules\Restaurant\Http\Controllers\PosController::class, 'expenses_admin'])->name('expenses.index')->middleware('just.admin');
                Route::get('incomes', [IncomesController::class, 'incomes_admin']);
                Route::get('advanced', [App\Http\Controllers\Tenant\AdvancedController::class, 'index'])->name('tenant.advanced.index')->middleware('just.admin');
                Route::get('tasks', [App\Http\Controllers\Tenant\TaskController::class, 'index'])->name('tenant.tasks.index')->middleware('just.admin');
                Route::post('tasks/commands', [App\Http\Controllers\Tenant\TaskController::class, 'listsCommand']);
                Route::post('tasks/tables', [App\Http\Controllers\Tenant\TaskController::class, 'tables']);
                Route::post('tasks', [App\Http\Controllers\Tenant\TaskController::class, 'store']);
                Route::delete('tasks/{task}', [App\Http\Controllers\Tenant\TaskController::class, 'destroy']);
                //Order
                Route::get('orders', [App\Http\Controllers\Tenant\OrderController::class, 'index'])->name('tenant_orders_index')->middleware('just.admin');
                Route::get('orders/columns', [App\Http\Controllers\Tenant\OrderController::class, 'columns']);
                Route::get('orders/record/{id}', [App\Http\Controllers\Tenant\OrderController::class, 'record']);
                Route::get('orders/records', [App\Http\Controllers\Tenant\OrderController::class, 'records']);
                Route::post('statusOrder/update/', [App\Http\Controllers\Tenant\OrderController::class, 'updateStatusOrders']);
                //warehouse
                Route::post('orders/warehouse', [App\Http\Controllers\Tenant\OrderController::class, 'searchWarehouse']);
                //Status Orders
                Route::get('statusOrder/records', [App\Http\Controllers\Tenant\StatusOrdersController::class, 'records']);

                //Company
                Route::get('companies/create', [App\Http\Controllers\Tenant\CompanyController::class, 'create'])->name('tenant.companies.create')->middleware('just.admin');;
                Route::get('companies/tables', [App\Http\Controllers\Tenant\CompanyController::class, 'tables']);

                Route::post('companies', [App\Http\Controllers\Tenant\CompanyController::class, 'store']);
                Route::post('companies/uploads', [App\Http\Controllers\Tenant\CompanyController::class, 'uploadFile']);
                Route::post('companies/img_bg', [App\Http\Controllers\Tenant\CompanyController::class, 'img_bg']);
                Route::post('companies/favicon', [App\Http\Controllers\Tenant\CompanyController::class, 'favicon']);

                //Card Brands
                Route::get('card_brands/records', [App\Http\Controllers\Tenant\CardBrandController::class, 'records']);
                Route::get('card_brands/record/{card_brand}', [App\Http\Controllers\Tenant\CardBrandController::class, 'record']);
                Route::post('card_brands', [App\Http\Controllers\Tenant\CardBrandController::class, 'store']);
                Route::delete('card_brands/{card_brand}', [App\Http\Controllers\Tenant\CardBrandController::class, 'destroy']);

                //Configurations
                Route::get('configurations/addSeeder', [App\Http\Controllers\Tenant\ConfigurationController::class, 'addSeeder']);
                Route::get('configurations/getFormats', [App\Http\Controllers\Tenant\ConfigurationController::class, 'getFormats']);
                Route::get('configurations/create', [App\Http\Controllers\Tenant\ConfigurationController::class, 'create'])->name('tenant.configurations.create')->middleware('just.admin');
                Route::get('configurations/record', [App\Http\Controllers\Tenant\ConfigurationController::class, 'record']);
                Route::post('configurations', [App\Http\Controllers\Tenant\ConfigurationController::class, 'store']);
                Route::post('configurations/icbper', [App\Http\Controllers\Tenant\ConfigurationController::class, 'icbper']);
                Route::post('configurations/changeFormat', [App\Http\Controllers\Tenant\ConfigurationController::class, 'changeFormat']);
                Route::get('configurations/tables', [App\Http\Controllers\Tenant\ConfigurationController::class, 'tables']);
                Route::get('configurations/visual_defaults', [App\Http\Controllers\Tenant\ConfigurationController::class, 'visualDefaults'])->name('visual_defaults')->middleware('just.admin');
                Route::post('configurations/visual_settings', [App\Http\Controllers\Tenant\ConfigurationController::class, 'visualSettings'])->name('visual-settings')->middleware('just.admin');
                Route::get('configurations/pdf_templates', [App\Http\Controllers\Tenant\ConfigurationController::class, 'pdfTemplates'])->name('tenant.advanced.pdf_templates')->middleware('just.admin');

                //Certificates
                Route::get('certificates/record', [App\Http\Controllers\Tenant\CertificateController::class, 'record']);
                Route::post('certificates/uploads', [App\Http\Controllers\Tenant\CertificateController::class, 'uploadFile']);
                Route::delete('certificates', [App\Http\Controllers\Tenant\CertificateController::class, 'destroy']);

                //Establishments
                Route::get('establishments', [App\Http\Controllers\Tenant\EstablishmentController::class, 'index'])->name('tenant.establishments.index')->middleware('just.admin');
                Route::get('establishments/create', [App\Http\Controllers\Tenant\EstablishmentController::class, 'create']);
                Route::post('establishments/update_conf', [App\Http\Controllers\Tenant\EstablishmentController::class, 'update_conf']);
                Route::get('establishments/tables', [App\Http\Controllers\Tenant\EstablishmentController::class, 'tables']);
                Route::get('establishments/record/{establishment}', [App\Http\Controllers\Tenant\EstablishmentController::class, 'record']);
                Route::post('establishments', [App\Http\Controllers\Tenant\EstablishmentController::class, 'store']);
                Route::get('establishments/records', [App\Http\Controllers\Tenant\EstablishmentController::class, 'records']);
                Route::delete('establishments/{establishment}', [App\Http\Controllers\Tenant\EstablishmentController::class, 'destroy']);
                Route::post('establishments/uploads', [App\Http\Controllers\Tenant\EstablishmentController::class, 'uploadFile']);
                //Arqueo
                Route::get('arqueos', [App\Http\Controllers\Tenant\ArqueoController::class, 'index'])->name('tenant.arqueos.index')->middleware('just.admin');
                Route::get('arqueos/create', [App\Http\Controllers\Tenant\ArqueoController::class, 'create']);
                Route::get('arqueos/columns', [App\Http\Controllers\Tenant\ArqueoController::class, 'columns']);
                Route::get('arqueos/tables', [App\Http\Controllers\Tenant\ArqueoController::class, 'tables']);
                Route::get('arqueos/record/{arqueo}', [App\Http\Controllers\Tenant\ArqueoController::class, 'record']);
                Route::get('arqueos/statusarqueo', [App\Http\Controllers\Tenant\ArqueoController::class, 'statusarqueo']);
                Route::get('arqueos/apertura', [App\Http\Controllers\Tenant\ArqueoController::class, 'apertura']);
                //Vaults Bovedad

                Route::get('vault', [App\Http\Controllers\Tenant\VaultController::class, 'index'])->name('tenant.vault.index')->middleware('just.admin');
                Route::get('vault/columns', [App\Http\Controllers\Tenant\VaultController::class, 'columns']);
                Route::get('vault/tables', [App\Http\Controllers\Tenant\VaultController::class, 'tables']);
                Route::get('vault/records', [App\Http\Controllers\Tenant\VaultController::class, 'records']);
                Route::get('vault/reports', [App\Http\Controllers\Tenant\VaultController::class, 'reports'])->name('tenant.vault.report')->middleware('just.admin');
                Route::get('vault/reportsresults', [App\Http\Controllers\Tenant\VaultController::class, 'reportsresults']);
                Route::get('vault/exportreport', [App\Http\Controllers\Tenant\VaultController::class, 'exportreport']);

                Route::post('arqueos', [App\Http\Controllers\Tenant\ArqueoController::class, 'store']);
                Route::get('arqueos/records', [App\Http\Controllers\Tenant\ArqueoController::class, 'records']);
                Route::put('arqueos/habilitar/{arqueo}', [App\Http\Controllers\Tenant\ArqueoController::class, 'abrircaja']);
                Route::put('arqueos/deshabilitar/{arqueo}', [App\Http\Controllers\Tenant\ArqueoController::class, 'cerrar_caja']);
                Route::delete('arqueos/{arqueo}', [App\Http\Controllers\Tenant\ArqueoController::class, 'destroy']);

                //vehicles------------------------------------------------------vehiculos


                //Reviews-----------------------------------------------------revisiones
                Route::get('Reviews/columns', [App\Http\Controllers\Tenant\ReviewsController::class, 'columns']);
                Route::get('Reviews', [App\Http\Controllers\Tenant\ReviewsController::class, 'driver_index'])->name('tenant.reviews.index')->middleware('just.admin');
                Route::get('Reviews/tables', [App\Http\Controllers\Tenant\ReviewsController::class, 'tables']);
                Route::get('Reviews/record/{id}', [App\Http\Controllers\Tenant\ReviewsController::class, 'record']);
                Route::post('Reviews', [App\Http\Controllers\Tenant\ReviewsController::class, 'store']);
                Route::get('Reviews/records', [App\Http\Controllers\Tenant\ReviewsController::class, 'records']);
                Route::delete('Reviews/{id}', [App\Http\Controllers\Tenant\ReviewsController::class, 'destroy']);

                //travels------------------------------------------------------viajes
                //Bank Accounts
                Route::get('bank_accounts', [App\Http\Controllers\Tenant\BankAccountController::class, 'index'])->name('tenant.bank_accounts.index');
                Route::get('bank_accounts/records', [App\Http\Controllers\Tenant\BankAccountController::class, 'records']);
                Route::get('bank_accounts/create', [App\Http\Controllers\Tenant\BankAccountController::class, 'create']);
                Route::get('bank_accounts/tables', [App\Http\Controllers\Tenant\BankAccountController::class, 'tables']);
                Route::get('bank_accounts/record/{bank_account}', [App\Http\Controllers\Tenant\BankAccountController::class, 'record']);
                Route::post('bank_accounts', [App\Http\Controllers\Tenant\BankAccountController::class, 'store']);
                Route::delete('bank_accounts/{bank_account}', [App\Http\Controllers\Tenant\BankAccountController::class, 'destroy']);

                //Series
                Route::get('series/check', [App\Http\Controllers\Tenant\SeriesController::class, 'check']);
                Route::get('series/records/{establishment}', [App\Http\Controllers\Tenant\SeriesController::class, 'records']);
                Route::get('series/create', [App\Http\Controllers\Tenant\SeriesController::class, 'create']);
                Route::get('series/tables', [App\Http\Controllers\Tenant\SeriesController::class, 'tables']);
                Route::post('series', [App\Http\Controllers\Tenant\SeriesController::class, 'store']);
                Route::delete('series/{series}', [App\Http\Controllers\Tenant\SeriesController::class, 'destroy']);

                //Users
                Route::get('users', [App\Http\Controllers\Tenant\UserController::class, 'index'])->name('tenant.users.index')->middleware('just.super');
                Route::get('users/tables', [App\Http\Controllers\Tenant\UserController::class, 'tables']);
                Route::get('users/record/{user}', [App\Http\Controllers\Tenant\UserController::class, 'record']);
                Route::post('users', [App\Http\Controllers\Tenant\UserController::class, 'store']);
                Route::post('users/update_pin', [App\Http\Controllers\Tenant\UserController::class, 'update_pin']);
                Route::get('users/{type}/records', [App\Http\Controllers\Tenant\UserController::class, 'records']);
                Route::delete('users/{user}', [App\Http\Controllers\Tenant\UserController::class, 'destroy']);

                //Driver Chofer
                // Route::get('drivers/columns', [App\Http\Controllers\Tenant\UserController::class, 'columns']);
                // Route::get('drivers', [App\Http\Controllers\Tenant\UserController::class, 'driver_index'])->name('tenant.driver.index')->middleware('just.admin');
                // Route::get('drivers/tables', [App\Http\Controllers\Tenant\UserController::class, 'tables']);
                // Route::get('drivers/record/{user}', [App\Http\Controllers\Tenant\UserController::class, 'record']);
                // Route::post('drivers', [App\Http\Controllers\Tenant\UserController::class, 'store']);
                // Route::get('drivers/{type}/records', [App\Http\Controllers\Tenant\UserController::class, 'records']);
                // Route::delete('drivers/{user}', [App\Http\Controllers\Tenant\UserController::class, 'destroy']);




                //ChargeDiscounts
                Route::get('charge_discounts', [App\Http\Controllers\Tenant\ChargeDiscountController::class, 'index'])->name('tenant.charge_discounts.index')->middleware('just.admin');
                Route::get('charge_discounts/records/{type}', [App\Http\Controllers\Tenant\ChargeDiscountController::class, 'records']);
                Route::get('charge_discounts/create', [App\Http\Controllers\Tenant\ChargeDiscountController::class, 'create']);
                Route::get('charge_discounts/tables/{type}', [App\Http\Controllers\Tenant\ChargeDiscountController::class, 'tables']);
                Route::get('charge_discounts/record/{charge}', [App\Http\Controllers\Tenant\ChargeDiscountController::class, 'record']);
                Route::post('charge_discounts', [App\Http\Controllers\Tenant\ChargeDiscountController::class, 'store']);
                Route::delete('charge_discounts/{charge}', [App\Http\Controllers\Tenant\ChargeDiscountController::class, 'destroy']);


                //Items Ecommerce
                Route::get('items_ecommerce', [App\Http\Controllers\Tenant\ItemController::class, 'index_ecommerce'])->name('tenant.items_ecommerce.index')->middleware('just.admin');

                //Items
                Route::get('items', [App\Http\Controllers\Tenant\ItemController::class, 'index'])->name('tenant.items.index')->middleware(['redirect.level', 'just.admin']);
                Route::get('items/columns', [App\Http\Controllers\Tenant\ItemController::class, 'columns']);
                Route::get('items/check_series', [App\Http\Controllers\Tenant\ItemController::class, 'check_series']);
                Route::get('items/records', [App\Http\Controllers\Tenant\ItemController::class, 'records']);
                Route::get('items/excel', [App\Http\Controllers\Tenant\ItemController::class, 'excel']);
                Route::get('items/excel-for-import', [App\Http\Controllers\Tenant\ItemController::class, 'excelForImport']);
                Route::post('items/updateprice', [App\Http\Controllers\Tenant\ItemController::class, 'updateprice']);
                Route::get('items/check_stock', [ItemController::class, 'check_stock']);
                Route::get('items/generate_code', [ItemController::class, 'generateCode']);

                Route::get('items/record/{item}', [App\Http\Controllers\Tenant\ItemController::class, 'record']);
                Route::post('items', [App\Http\Controllers\Tenant\ItemController::class, 'store']);
                Route::delete('items/{item}', [App\Http\Controllers\Tenant\ItemController::class, 'destroy']);
                Route::delete('items/item-unit-type/{item}', [App\Http\Controllers\Tenant\ItemController::class, 'destroyItemUnitType']);
                Route::post('items/import', [App\Http\Controllers\Tenant\ItemController::class, 'import']);
                Route::post('items/import_prices', [App\Http\Controllers\Tenant\ItemController::class, 'import_prices']);
                Route::post('items/uploads', [App\Http\Controllers\Tenant\ItemController::class, 'upload']);
                Route::post('items/visible_store', [App\Http\Controllers\Tenant\ItemController::class, 'visibleStore']);
                Route::post('items/duplicate', [App\Http\Controllers\Tenant\ItemController::class, 'duplicate']);
                Route::get('items/disable/{item}', [App\Http\Controllers\Tenant\ItemController::class, 'disable']);
                Route::get('items/enable/{item}', [App\Http\Controllers\Tenant\ItemController::class, 'enable']);
                Route::get('items/images/{item}', [App\Http\Controllers\Tenant\ItemController::class, 'images']);
                Route::get('items/images/delete/{id}', [App\Http\Controllers\Tenant\ItemController::class, 'delete_images']);
                Route::get('items/import/tables', [App\Http\Controllers\Tenant\ItemController::class, 'tablesImport']);
                Route::get('items/export/barcode', [App\Http\Controllers\Tenant\ItemController::class, 'exportBarCode'])->name('tenant.items.export.barcode')->middleware('just.admin');
                Route::get('items/export/barcode/print', [App\Http\Controllers\Tenant\ItemController::class, 'printBarCode'])->name('tenant.items.export.barcode.print')->middleware('just.admin');
                Route::get('items/export/barcode/last', [App\Http\Controllers\Tenant\ItemController::class, 'itemLast'])->name('tenant.items.last')->middleware('just.admin');
                Route::get('items/check_all_stock', [App\Http\Controllers\Tenant\ItemController::class, 'check_all_stock'])->name('tenant.items.check_stock')->middleware('just.admin');
                //ClientZone
                Route::get('client_zones/records', [ClientZoneController::class, 'records']);
                Route::post('client_zones', [ClientZoneController::class, 'store']);
                Route::get('client_zones/active/{id}', [ClientZoneController::class, 'active_desactive']);
                Route::delete('client_zones/delete/{id}', [ClientZoneController::class, 'destroy']);
                Route::get('purchases/search-items', [PurchaseController::class, 'searchItems']);

                //Persons
                Route::get('filtrar_distritos/records', [App\Http\Controllers\Tenant\PersonController::class, 'distritos']);
                Route::get('persons/columns', [App\Http\Controllers\Tenant\PersonController::class, 'columns']);
                Route::get('customers/list', [PersonController::class, 'clientsForGenerateCPE']);
                Route::get('persons/{type}', [App\Http\Controllers\Tenant\PersonController::class, 'index'])->name('tenant.persons.index')->middleware('just.admin');
                Route::get('persons/{type}/printer', [App\Http\Controllers\Tenant\PersonController::class, 'printer']);
                Route::get('persons/{type}/records', [App\Http\Controllers\Tenant\PersonController::class, 'records']);
                Route::get('persons/record/{person}', [App\Http\Controllers\Tenant\PersonController::class, 'record']);
                //  Route::post('persons', [App\Http\Controllers\Tenant\PersonController::class, 'store']);
                Route::delete('persons/{person}', [App\Http\Controllers\Tenant\PersonController::class, 'destroy']);
                Route::post('persons/import', [App\Http\Controllers\Tenant\PersonController::class, 'import']);
                Route::get('persons/enabled/{type}/{person}', [App\Http\Controllers\Tenant\PersonController::class, 'enabled']);

                //Consolidado
                Route::get('consolidated-items', [App\Http\Controllers\Tenant\ConsolidatedController::class, 'index'])->name('tenant.consolidated-sales.index')->middleware('just.admin');
                Route::get('consolidated/records', [App\Http\Controllers\Tenant\ConsolidatedController::class, 'records']);
                Route::get('consolidated/filter', [App\Http\Controllers\Tenant\ConsolidatedController::class, 'filter']);
                //Documents
                Route::get('documents/create_summarie', [App\Http\Controllers\Tenant\DocumentController::class, 'createSummarie']);
                Route::get('documents/check_summarie', [App\Http\Controllers\Tenant\DocumentController::class, 'checkSummarie']);
                Route::post('documents/categories', [App\Http\Controllers\Tenant\DocumentController::class, 'storeCategories']);
                Route::post('documents/brands', [App\Http\Controllers\Tenant\DocumentController::class, 'storeBrands']);
                Route::get('documents/data_table', [App\Http\Controllers\Tenant\DocumentController::class, 'data_table']);


                Route::get('documents/notpayment', [App\Http\Controllers\Tenant\DocumentController::class, 'notpayment']);

                Route::get('documents/search/customers', [App\Http\Controllers\Tenant\DocumentController::class, 'searchCustomers']);
                Route::get('documents/search/customer/{id}', [App\Http\Controllers\Tenant\DocumentController::class, 'searchCustomerById']);

                Route::get('documents', [App\Http\Controllers\Tenant\DocumentController::class, 'index'])->name('tenant.documents.index')->middleware(['redirect.level', 'tenant.internal.mode', 'just.admin']);
                Route::get('documents/columns', [App\Http\Controllers\Tenant\DocumentController::class, 'columns']);

                Route::get('documents/create/{documents?}', [App\Http\Controllers\Tenant\DocumentController::class, 'create'])->name('tenant.documents.create')->middleware(['redirect.level', 'tenant.internal.mode'])->middleware('just.admin');
                Route::get('documents/record2/{salenote}', [App\Http\Controllers\Tenant\DocumentController::class, 'record2']);
                Route::get('documents/create_tensu', [App\Http\Controllers\Tenant\DocumentController::class, 'create_tensu'])->name('tenant.documents.create_tensu')->middleware('just.admin');

                Route::get('documents/tables', [App\Http\Controllers\Tenant\DocumentController::class, 'tables']);

                Route::get('documents/send/{document}', [App\Http\Controllers\Tenant\DocumentController::class, 'send']);
                Route::get('documents/get-series/{id_item}', [App\Http\Controllers\Tenant\DocumentController::class, 'getSeriesByItem']);
                Route::get('documents/consultarcdr/{document}', [App\Http\Controllers\Tenant\DocumentController::class, 'consultarcdr']);
                Route::get('items/category/{idcategoria}', [App\Http\Controllers\Tenant\ItemController::class, 'filtercategory']);
                Route::post('documents/email', [App\Http\Controllers\Tenant\DocumentController::class, 'email']);
                Route::get('documents/note/{document}', [App\Http\Controllers\Tenant\NoteController::class, 'create']);
                Route::get('documents/note/record/{document}', [App\Http\Controllers\Tenant\NoteController::class, 'record']);
                Route::get('documents/item/tables', [App\Http\Controllers\Tenant\DocumentController::class, 'item_tables']);
                Route::get('documents/table/{table}', [App\Http\Controllers\Tenant\DocumentController::class, 'table']);
                Route::get('documents/re_store/{document}', [App\Http\Controllers\Tenant\DocumentController::class, 'reStore']);
                Route::post('documents/re_store_range', [App\Http\Controllers\Tenant\DocumentController::class, 'reStoreRange']);
                Route::get('documents/locked_emission', [App\Http\Controllers\Tenant\DocumentController::class, 'messageLockedEmission']);
                Route::get('documents/validate/{id}', [App\Http\Controllers\Tenant\DocumentController::class, 'validar_cpe']);
                Route::get('documents/totals', [App\Http\Controllers\Tenant\DocumentController::class, 'totals']);
                Route::get('document_payments/records/{document_id}', [App\Http\Controllers\Tenant\DocumentPaymentController::class, 'records']);
                Route::get('document_payments/document/{document_id}', [App\Http\Controllers\Tenant\DocumentPaymentController::class, 'document']);
                Route::get('document_payments/tables', [App\Http\Controllers\Tenant\DocumentPaymentController::class, 'tables']);
                Route::get('documents/data_table', [App\Http\Controllers\Tenant\DocumentController::class, 'data_table']);

                Route::delete('document_payments/{document_payment}', [App\Http\Controllers\Tenant\DocumentPaymentController::class, 'destroy']);
                Route::get('document_payments/initialize_balance', [App\Http\Controllers\Tenant\DocumentPaymentController::class, 'initialize_balance']);
                Route::get('document_payments/report/{start}/{end}', [App\Http\Controllers\Tenant\DocumentPaymentController::class, 'report']);


                Route::get('documents/send_server/{document}/{query?}', [App\Http\Controllers\Tenant\DocumentController::class, 'sendServer']);
                Route::get('documents/check_server/{document}', [App\Http\Controllers\Tenant\DocumentController::class, 'checkServer']);
                Route::get('documents/change_to_registered_status/{document}', [App\Http\Controllers\Tenant\DocumentController::class, 'changeToRegisteredStatus']);

                Route::post('documents/import', [App\Http\Controllers\Tenant\DocumentController::class, 'import']);
                Route::post('documents/import_second_format', [App\Http\Controllers\Tenant\DocumentController::class, 'importTwoFormat']);
                Route::get('documents/payments/excel', [App\Http\Controllers\Tenant\DocumentController::class, 'report_payments'])->name('tenant.document.payments.excel')->middleware('just.admin');

                Route::delete('documents/delete_document/{document_id}', [App\Http\Controllers\Tenant\DocumentController::class, 'destroyDocument']);
                Route::get('documents/data-table/items', [App\Http\Controllers\Tenant\DocumentController::class, 'getDataTableItem']);

                //Contingencies
                Route::get('contingencies', [App\Http\Controllers\Tenant\ContingencyController::class, 'index'])->name('tenant.contingencies.index')->middleware('redirect.level', 'tenant.internal.mode')->middleware('just.admin');
                Route::get('contingencies/columns', [App\Http\Controllers\Tenant\ContingencyController::class, 'columns']);
                Route::get('contingencies/records', [App\Http\Controllers\Tenant\ContingencyController::class, 'records']);
                Route::get('contingencies/create', [App\Http\Controllers\Tenant\ContingencyController::class, 'create'])->name('tenant.contingencies.create')->middleware('just.admin');


                //Summaries
                Route::get('summaries', [App\Http\Controllers\Tenant\SummaryController::class, 'index'])->name('tenant.summaries.index')->middleware('redirect.level', 'tenant.internal.mode')->middleware('just.admin');
                Route::get('summaries/records', [App\Http\Controllers\Tenant\SummaryController::class, 'records']);
                Route::post('summaries/documents', [App\Http\Controllers\Tenant\SummaryController::class, 'documents']);
                Route::post('summaries', [App\Http\Controllers\Tenant\SummaryController::class, 'store']);
                Route::get('summaries/status/{summary}', [App\Http\Controllers\Tenant\SummaryController::class, 'status']);
                Route::get('summaries/columns', [App\Http\Controllers\Tenant\SummaryController::class, 'columns']);
                Route::delete('summaries/{summary}', [App\Http\Controllers\Tenant\SummaryController::class, 'destroy']);

                //Voided
                Route::get('voided', [App\Http\Controllers\Tenant\VoidedController::class, 'index'])->name('tenant.voided.index')->middleware('redirect.level', 'tenant.internal.mode')->middleware('just.admin');
                Route::get('voided/columns', [App\Http\Controllers\Tenant\VoidedController::class, 'columns']);
                Route::get('voided/records', [App\Http\Controllers\Tenant\VoidedController::class, 'records']);
                Route::post('voided', [App\Http\Controllers\Tenant\VoidedController::class, 'store']);
                //            Route::get('voided/download/{type}/{voided}', [App\Http\Controllers\Tenant\VoidedController::class, 'download'])->name('tenant.voided.download']);
                Route::get('voided/status/{voided}', [App\Http\Controllers\Tenant\VoidedController::class, 'status']);
                Route::get('voided/status_masive', [App\Http\Controllers\Tenant\VoidedController::class, 'status_masive']);

                Route::delete('voided/{voided}', [App\Http\Controllers\Tenant\VoidedController::class, 'destroy']);
                //            Route::get('voided/ticket/{voided_id}/{group_id}', [App\Http\Controllers\Tenant\VoidedController::class, 'ticket']);

                //Retentions
                Route::get('retentions', [App\Http\Controllers\Tenant\RetentionController::class, 'index'])->name('tenant.retentions.index');
                Route::get('retentions/columns', [App\Http\Controllers\Tenant\RetentionController::class, 'columns']);
                Route::get('retentions/records', [App\Http\Controllers\Tenant\RetentionController::class, 'records']);
                Route::get('retentions/create', [App\Http\Controllers\Tenant\RetentionController::class, 'create'])->name('tenant.retentions.create')->middleware('just.admin');
                Route::get('retentions/tables', [App\Http\Controllers\Tenant\RetentionController::class, 'tables']);
                Route::get('retentions/record/{retention}', [App\Http\Controllers\Tenant\RetentionController::class, 'record']);
                Route::post('retentions', [App\Http\Controllers\Tenant\RetentionController::class, 'store']);
                Route::delete('retentions/{retention}', [App\Http\Controllers\Tenant\RetentionController::class, 'destroy']);
                Route::get('retentions/document/tables', [App\Http\Controllers\Tenant\RetentionController::class, 'document_tables']);
                Route::get('retentions/table/{table}', [App\Http\Controllers\Tenant\RetentionController::class, 'table']);
                Route::post('get_igv', [App\Http\Controllers\Tenant\StoreController::class, 'getIgv']);
                //Dispatches

                Route::prefix("dispatches")->group(function () {
                    Route::get('/', [App\Http\Controllers\Tenant\DispatchController::class, 'index'])->name('tenant.dispatches.index')->middleware('just.admin');
                    Route::get('/columns', [App\Http\Controllers\Tenant\DispatchController::class, 'columns']);
                    Route::get('/records', [App\Http\Controllers\Tenant\DispatchController::class, 'records']);
                    Route::get(
                        '/data_table',
                        [App\Http\Controllers\Tenant\DispatchController::class, 'data_table']
                    );
                    Route::get('/create/{document?}/{type?}/{dispatch?}', [App\Http\Controllers\Tenant\DispatchController::class, 'create']);
                    Route::post('/tables', [App\Http\Controllers\Tenant\DispatchController::class, 'tables']);
                    Route::post('/', [App\Http\Controllers\Tenant\DispatchController::class, 'store']);
                    Route::get('/record/{id}', [DispatchController::class, 'record']);
                    Route::get('/correlative/{serie}', [DispatchController::class, 'getCorrelative']);
                    Route::post('/sendSunat/{document}', [DispatchController::class, 'sendDispatchToSunat']);
                    Route::post('/email', [DispatchController::class, 'email']);
                    Route::get('/generate/{sale_note}', [DispatchController::class, 'generate']);
                    Route::get('/record/{id}/tables', [DispatchController::class, 'generateDocumentTables']);
                    Route::post('/record/{id}/set-document-id', [DispatchController::class, 'setDocumentId']);
                    Route::get('/client/{id}', [DispatchController::class, 'dispatchesByClient']);
                    Route::post('/items', [DispatchController::class, 'getItemsFromDispatches']);
                    Route::post('/getDocumentType', [DispatchController::class, 'getDocumentTypeToDispatches']);
                    Route::get('/data_table', [DispatchController::class, 'data_table']);
                    Route::get('create_new/{table}/{id}', [DispatchController::class, 'createNew']);
                    Route::get('create_new_info/{table}/{id}', [DispatchController::class, 'createNewInfo']);
                    Route::get('/get_origin_addresses/{establishment_id}', [DispatchController::class, 'getOriginAddresses']);
                    // Route::get('/get_delivery_addresses/{person_id}', [DispatchController::class, 'getDeliveryAddresses']);
                    // Route::get('/search/customers', [DispatchController::class, 'searchCustomers']);
                    Route::get('/search/customer/{id}', [DispatchController::class, 'searchClientById']);
                    Route::post('/status_ticket', [DispatchController::class, 'statusTicket']);
                });


                Route::get('reports/consistency-documents', [App\Http\Controllers\Tenant\ReportConsistencyDocumentController::class, 'index'])->name('tenant.consistency-documents.index')->middleware('tenant.internal.mode')->middleware('just.admin');
                Route::post('reports/consistency-documents/lists', [App\Http\Controllers\Tenant\ReportConsistencyDocumentController::class, 'lists']);

                Route::post('options/delete_documents', [App\Http\Controllers\Tenant\OptionController::class, 'deleteDocuments']);
                Route::post('options/delete_items', [App\Http\Controllers\Tenant\OptionController::class, 'deleteItems']);
                Route::get('boxes', [Modules\Restaurant\Http\Controllers\BoxesController::class, 'index'])->name('boxes')->middleware('just.admin');

                Route::get('unit_types/records', [App\Http\Controllers\Tenant\UnitTypeController::class, 'records']);
                Route::get('unit_types/record/{code}', [App\Http\Controllers\Tenant\UnitTypeController::class, 'record']);
                Route::post('unit_types', [App\Http\Controllers\Tenant\UnitTypeController::class, 'store']);
                Route::delete('unit_types/{code}', [App\Http\Controllers\Tenant\UnitTypeController::class, 'destroy']);

                //Detractions
                Route::get('detraction_types/records', [App\Http\Controllers\Tenant\DetractionTypeController::class, 'records']);
                Route::get('detraction_types/tables', [App\Http\Controllers\Tenant\DetractionTypeController::class, 'tables']);
                Route::get('detraction_types/record/{code}', [App\Http\Controllers\Tenant\DetractionTypeController::class, 'record']);
                Route::post('detraction_types', [App\Http\Controllers\Tenant\DetractionTypeController::class, 'store']);
                Route::delete('detraction_types/{code}', [App\Http\Controllers\Tenant\DetractionTypeController::class, 'destroy']);

                //Banks
                Route::get('banks', [App\Http\Controllers\Tenant\BankController::class, 'index'])->name('tenant.banks.index')->middleware('just.admin');
                Route::get('banks/records', [App\Http\Controllers\Tenant\BankController::class, 'records']);
                Route::get('banks/record/{bank}', [App\Http\Controllers\Tenant\BankController::class, 'record']);
                Route::post('banks', [App\Http\Controllers\Tenant\BankController::class, 'store']);
                Route::delete('banks/{bank}', [App\Http\Controllers\Tenant\BankController::class, 'destroy']);

                //Exchange Rates
                Route::get('exchange_rates/records', [App\Http\Controllers\Tenant\ExchangeRateController::class, 'records']);
                Route::post('exchange_rates', [App\Http\Controllers\Tenant\ExchangeRateController::class, 'store']);

                //Currency Types
                Route::get('currency_types/records', [App\Http\Controllers\Tenant\CurrencyTypeController::class, 'records']);
                Route::get('currency_types/record/{currency_type}', [App\Http\Controllers\Tenant\CurrencyTypeController::class, 'record']);
                Route::post('currency_types', [App\Http\Controllers\Tenant\CurrencyTypeController::class, 'store']);
                Route::delete('currency_types/{currency_type}', [App\Http\Controllers\Tenant\CurrencyTypeController::class, 'destroy']);

                //Perceptions
                Route::get('perceptions', [App\Http\Controllers\Tenant\PerceptionController::class, 'index'])->name('tenant.perceptions.index')->middleware('just.admin');
                Route::get('perceptions/columns', [App\Http\Controllers\Tenant\PerceptionController::class, 'columns']);
                Route::get('perceptions/records', [App\Http\Controllers\Tenant\PerceptionController::class, 'records']);
                Route::get('perceptions/create', [App\Http\Controllers\Tenant\PerceptionController::class, 'create'])->name('tenant.perceptions.create')->middleware('just.admin');
                Route::get('perceptions/tables', [App\Http\Controllers\Tenant\PerceptionController::class, 'tables']);
                Route::get('perceptions/record/{perception}', [App\Http\Controllers\Tenant\PerceptionController::class, 'record']);
                Route::post('perceptions', [App\Http\Controllers\Tenant\PerceptionController::class, 'store']);
                Route::delete('perceptions/{perception}', [App\Http\Controllers\Tenant\PerceptionController::class, 'destroy']);
                Route::get('perceptions/document/tables', [App\Http\Controllers\Tenant\PerceptionController::class, 'document_tables']);
                Route::get('perceptions/table/{table}', [App\Http\Controllers\Tenant\PerceptionController::class, 'table']);


                //Tribute Concept Type
                Route::get('tribute_concept_types/records', [App\Http\Controllers\Tenant\TributeConceptTypeController::class, 'records']);
                Route::get('tribute_concept_types/record/{id}', [App\Http\Controllers\Tenant\TributeConceptTypeController::class, 'record']);
                Route::post('tribute_concept_types', [App\Http\Controllers\Tenant\TributeConceptTypeController::class, 'store']);
                Route::delete('tribute_concept_types/{id}', [App\Http\Controllers\Tenant\TributeConceptTypeController::class, 'destroy']);

                //purchases
                Route::get('purchases', [App\Http\Controllers\Tenant\PurchaseController::class, 'index'])->name('tenant.purchases.index')->middleware('just.admin');
                Route::get('purchases/columns', [App\Http\Controllers\Tenant\PurchaseController::class, 'columns']);
                Route::get('purchases/ne76/correlative', [App\Http\Controllers\Tenant\PurchaseController::class, 'ne76_correlative']);
                Route::get('purchases/records', [App\Http\Controllers\Tenant\PurchaseController::class, 'records']);
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


                // Route::get('documents/send/{document}', [App\Http\Controllers\Tenant\DocumentController::class, 'send']);
                // Route::get('documents/consult_cdr/{document}', [App\Http\Controllers\Tenant\DocumentController::class, 'consultCdr']);
                // Route::post('documents/email', [App\Http\Controllers\Tenant\DocumentController::class, 'email']);
                // Route::get('documents/note/{document}', [App\Http\Controllers\Tenant\NoteController::class, 'create']);
                Route::get('purchases/item/tables', [App\Http\Controllers\Tenant\PurchaseController::class, 'item_tables']);
                Route::get('purchases/item', [App\Http\Controllers\Tenant\PurchaseController::class, 'item_id']);
                // Route::get('documents/table/{table}', [App\Http\Controllers\Tenant\DocumentController::class, 'table']);

                //quotations
                Route::get('quotations', [App\Http\Controllers\Tenant\QuotationController::class, 'index'])->name('tenant.quotations.index')->middleware('redirect.level')->middleware('just.admin');
                Route::get('quotations/columns', [App\Http\Controllers\Tenant\QuotationController::class, 'columns']);
                Route::get('quotations/records', [App\Http\Controllers\Tenant\QuotationController::class, 'records']);
                Route::get('quotations/create/{saleOpportunityId?}', [App\Http\Controllers\Tenant\QuotationController::class, 'create'])->name('tenant.quotations.create')->middleware('redirect.level')->middleware('just.admin');
                Route::get('quotations/edit/{id}', [App\Http\Controllers\Tenant\QuotationController::class, 'edit'])->middleware('redirect.level')->middleware('just.admin');

                Route::get('quotations/state-type/{state_type_id}/{id}', [App\Http\Controllers\Tenant\QuotationController::class, 'updateStateType']);
                Route::get('quotations/filter', [App\Http\Controllers\Tenant\QuotationController::class, 'filter']);
                Route::get('quotations/tables', [App\Http\Controllers\Tenant\QuotationController::class, 'tables']);
                Route::get('quotations/table/{table}', [App\Http\Controllers\Tenant\QuotationController::class, 'table']);
                Route::post('quotations', [App\Http\Controllers\Tenant\QuotationController::class, 'store']);
                Route::post('quotations/update', [App\Http\Controllers\Tenant\QuotationController::class, 'update']);
                Route::get('quotations/record/{quotation}', [App\Http\Controllers\Tenant\QuotationController::class, 'record']);
                Route::get('quotations/anular/{id}', [App\Http\Controllers\Tenant\QuotationController::class, 'anular']);
                Route::get('quotations/item/tables', [App\Http\Controllers\Tenant\QuotationController::class, 'item_tables']);
                Route::get('quotations/option/tables', [App\Http\Controllers\Tenant\QuotationController::class, 'option_tables']);
                Route::get('quotations/search/customers', [App\Http\Controllers\Tenant\QuotationController::class, 'searchCustomers']);
                Route::get('quotations/search/customer/{id}', [App\Http\Controllers\Tenant\QuotationController::class, 'searchCustomerById']);
                Route::get('quotations/download/{external_id}/{format?}', [App\Http\Controllers\Tenant\QuotationController::class, 'download']);

                Route::post('quotations/email', [App\Http\Controllers\Tenant\QuotationController::class, 'email']);
                Route::post('quotations/duplicate', [App\Http\Controllers\Tenant\QuotationController::class, 'duplicate']);
                Route::get('quotations/record2/{quotation}', [App\Http\Controllers\Tenant\QuotationController::class, 'record2']);
                Route::get('quotations/changed/{quotation}', [App\Http\Controllers\Tenant\QuotationController::class, 'changed']);

                //sale-notes
                Route::get('sale-notes', [App\Http\Controllers\Tenant\SaleNoteController::class, 'index'])->name('tenant.sale_notes.index')->middleware('redirect.level')->middleware('just.admin');
                Route::get('sale-notes/columns', [App\Http\Controllers\Tenant\SaleNoteController::class, 'columns']);
                Route::post('sale-notes/items',  [App\Http\Controllers\Tenant\SaleNoteController::class, 'getItemsFromNotes']);
                Route::post('sale-notes/items_caja',  [App\Http\Controllers\Tenant\SaleNoteController::class, 'getItemsFromNotesCaja']);
                Route::get('sale-notes/columns2', [App\Http\Controllers\Tenant\SaleNoteController::class, 'columns2']);
                Route::get('sale-notes/list-by-client', [App\Http\Controllers\Tenant\SaleNoteController::class, 'saleNotesByClient']);
                Route::get('sale-notes/records', [App\Http\Controllers\Tenant\SaleNoteController::class, 'records']);
                Route::get('sale-notes/excel', [App\Http\Controllers\Tenant\SaleNoteController::class, 'excel']);
                Route::get('sale-notes/credit_pending', [App\Http\Controllers\Tenant\SaleNoteController::class, 'getCreditPending']);
                Route::get('sale-notes/totals', [App\Http\Controllers\Tenant\SaleNoteController::class, 'totals']);
                // Route::get('sale-notes/create', [App\Http\Controllers\Tenant\SaleNoteController::class, 'create'])->name('tenant.sale_notes.create']);
                Route::get('sale-notes/create/{salenote?}', [App\Http\Controllers\Tenant\SaleNoteController::class, 'create'])->name('tenant.sale_notes.create')->middleware('just.admin')->middleware('redirect.level');

                Route::get('sale-notes/tables', [App\Http\Controllers\Tenant\SaleNoteController::class, 'tables']);
                Route::get('sale-notes/table/{table}', [App\Http\Controllers\Tenant\SaleNoteController::class, 'table']);


                Route::get('sale-notes/item/tables', [App\Http\Controllers\Tenant\SaleNoteController::class, 'item_tables']);
                Route::get('sale-notes/search/customers', [App\Http\Controllers\Tenant\SaleNoteController::class, 'searchCustomers']);
                Route::get('sale-notes/search/customer/{id}', [App\Http\Controllers\Tenant\SaleNoteController::class, 'searchCustomerById']);
                Route::get('sale-notes/record2/{salenote}', [App\Http\Controllers\Tenant\SaleNoteController::class, 'record2']);
                Route::get('sale-notes/option/tables', [App\Http\Controllers\Tenant\SaleNoteController::class, 'option_tables']);
                Route::get('sale-notes/changed/{salenote}', [App\Http\Controllers\Tenant\SaleNoteController::class, 'changed']);
                Route::post('sale-notes/email', [App\Http\Controllers\Tenant\SaleNoteController::class, 'email']);
                Route::get('sale-notes/items/{salenote}', [App\Http\Controllers\Tenant\SaleNoteController::class, 'items']);
                Route::get('sale-notes/print-a5/{sale_note_id}/{format}', [App\Http\Controllers\Tenant\SaleNotePaymentController::class, 'toPrint']);
                // Route::get('sale-notes/dispatches', [App\Http\Controllers\Tenant\SaleNoteController::class, 'dispatches']);
                Route::get('sale-notes/contract/{id}', [App\Http\Controllers\Tenant\SaleNoteController::class, 'contract']);
                Route::delete('sale-notes/destroy_sale_note_item/{sale_note_item}', [App\Http\Controllers\Tenant\SaleNoteController::class, 'destroy_sale_note_item']);

                Route::get('sale_note_payments/records/{sale_note}', [App\Http\Controllers\Tenant\SaleNotePaymentController::class, 'records']);
                Route::get('sale_note_payments/document/{sale_note}', [App\Http\Controllers\Tenant\SaleNotePaymentController::class, 'document']);
                Route::get('sale_note_payments/tables', [App\Http\Controllers\Tenant\SaleNotePaymentController::class, 'tables']);

                Route::delete('sale_note_payments/{sale_note_payment}', [App\Http\Controllers\Tenant\SaleNotePaymentController::class, 'destroy']);

                Route::post('sale-notes/enabled-concurrency', [App\Http\Controllers\Tenant\SaleNoteController::class, 'enabledConcurrency']);

                Route::get('sale-notes/anulate/{id}', [App\Http\Controllers\Tenant\SaleNoteController::class, 'anulate']);

                Route::get('sale-notes/downloadExternal/{external_id}', [App\Http\Controllers\Tenant\SaleNoteController::class, 'downloadExternal']);

                //POS
                Route::get('points', [Modules\Restaurant\Http\Controllers\PosController::class, 'pos'])->name('tenant.point.index')->middleware('just.admin');
                Route::get('pos/foods', [Modules\Restaurant\Http\Controllers\PosController::class, 'foods']);
                Route::get('pos/orden_update/{id}', [Modules\Restaurant\Http\Controllers\PosController::class, 'orden_update']);

                Route::get('pos/orden_items/{id}', [Modules\Restaurant\Http\Controllers\PosController::class, 'destroy_items']);
                Route::post('pos/orden_payment', [Modules\Restaurant\Http\Controllers\PosController::class, 'payment']);
                Route::get('pos/search_orden', [Modules\Restaurant\Http\Controllers\PosController::class, 'search']);
                //Route::get('pos/listtables', [Modules\Restaurant\Http\Controllers\PosController::class, 'listtables']);
                Route::get('pos/selecttabled/{idOrden}', [Modules\Restaurant\Http\Controllers\PosController::class, 'selecttabled']);
                Route::get('search_orden_document', [Modules\Restaurant\Http\Controllers\PosController::class, 'search_orden_document']);

                Route::get('pos_full', [App\Http\Controllers\Tenant\PosController::class, 'index_full'])->name('tenant.pos_full.index')->middleware('just.admin');

                Route::get('pos/search_items', [App\Http\Controllers\Tenant\PosController::class, 'search_items']);



                Route::get('pos/payment', [App\Http\Controllers\Tenant\PosController::class, 'payment'])->name('tenant.pos.payment')->middleware('just.admin');
                Route::get('pos/status_configuration', [App\Http\Controllers\Tenant\PosController::class, 'status_configuration']);

                Route::get('pos/validate_stock/{item}/{quantity}', [App\Http\Controllers\Tenant\PosController::class, 'validate_stock']);



                //Tags
                Route::get('tags', [App\Http\Controllers\Tenant\TagController::class, 'index'])->name('tenant.tags.index')->middleware('just.admin');
                Route::get('tags/columns', [App\Http\Controllers\Tenant\TagController::class, 'columns']);
                Route::get('tags/records', [App\Http\Controllers\Tenant\TagController::class, 'records']);
                Route::get('tags/record/{tag}', [App\Http\Controllers\Tenant\TagController::class, 'record']);
                Route::post('tags', [App\Http\Controllers\Tenant\TagController::class, 'store']);
                Route::delete('tags/{tag}', [App\Http\Controllers\Tenant\TagController::class, 'destroy']);

                //Promotion
                Route::get('promotions', [App\Http\Controllers\Tenant\PromotionController::class, 'index'])->name('tenant.promotion.index')->middleware('just.admin');
                Route::get('promotions/columns', [App\Http\Controllers\Tenant\PromotionController::class, 'columns']);
                Route::get('promotions/tables', [App\Http\Controllers\Tenant\PromotionController::class, 'tables']);
                Route::get('promotions/records', [App\Http\Controllers\Tenant\PromotionController::class, 'records']);
                Route::get('promotions/record/{tag}', [App\Http\Controllers\Tenant\PromotionController::class, 'record']);
                Route::post('promotions', [App\Http\Controllers\Tenant\PromotionController::class, 'store']);
                Route::delete('promotions/{promotion}', [App\Http\Controllers\Tenant\PromotionController::class, 'destroy']);
                Route::post('promotions/upload', [App\Http\Controllers\Tenant\PromotionController::class, 'upload']);


                Route::get('item-sets', [App\Http\Controllers\Tenant\ItemSetController::class, 'index'])->name('tenant.item_sets.index')->middleware('just.admin');
                Route::get('item-sets/columns', [App\Http\Controllers\Tenant\ItemSetController::class, 'columns']);
                Route::get('item-sets/records', [App\Http\Controllers\Tenant\ItemSetController::class, 'records']);
                Route::get('item-sets/check/{id}/{qty}', [App\Http\Controllers\Tenant\ItemSetController::class, 'set_item_check_stock']);
                Route::get('item-sets/tables', [App\Http\Controllers\Tenant\ItemSetController::class, 'tables']);
                Route::get('item-sets/record/{item}', [App\Http\Controllers\Tenant\ItemSetController::class, 'record']);
                Route::post('item-sets', [App\Http\Controllers\Tenant\ItemSetController::class, 'store']);
                Route::delete('item-sets/{item}', [App\Http\Controllers\Tenant\ItemSetController::class, 'destroy']);
                Route::delete('item-sets/item-unit-type/{item}', [App\Http\Controllers\Tenant\ItemSetController::class, 'destroyItemUnitType']);
                Route::post('item-sets/import', [App\Http\Controllers\Tenant\ItemSetController::class, 'import']);
                Route::post('item-sets/upload', [App\Http\Controllers\Tenant\ItemSetController::class, 'upload']);
                Route::post('item-sets/visible_store', [App\Http\Controllers\Tenant\ItemSetController::class, 'visibleStore']);
                Route::get('item-sets/item/tables', [App\Http\Controllers\Tenant\ItemSetController::class, 'item_tables']);
                Route::get('person-types/columns', [App\Http\Controllers\Tenant\PersonTypeController::class, 'columns']);
                Route::get('person-types', [App\Http\Controllers\Tenant\PersonTypeController::class, 'index'])->name('tenant.person_types.index')->middleware('just.admin');
                Route::get('person-types/records', [App\Http\Controllers\Tenant\PersonTypeController::class, 'records']);
                Route::get('person-types/record/{person}', [App\Http\Controllers\Tenant\PersonTypeController::class, 'record']);
                Route::post('person-types', [App\Http\Controllers\Tenant\PersonTypeController::class, 'store']);
                Route::delete('person-types/{person}', [App\Http\Controllers\Tenant\PersonTypeController::class, 'destroy']);

                //Cuenta
                Route::get('cuenta/payment_index', [App\Http\Controllers\Tenant\AccountController::class, 'paymentIndex'])->name('tenant.payment.index')->middleware('just.admin');
                Route::get('cuenta/configuration', [App\Http\Controllers\Tenant\AccountController::class, 'index'])->name('tenant.configuration.index')->middleware('just.admin');
                Route::get('cuenta/payment_records', [App\Http\Controllers\Tenant\AccountController::class, 'paymentRecords']);
                Route::get('cuenta/tables', [App\Http\Controllers\Tenant\AccountController::class, 'tables']);
                Route::post('cuenta/update_plan', [App\Http\Controllers\Tenant\AccountController::class, 'updatePlan']);
                Route::post('cuenta/payment_culqui', [App\Http\Controllers\Tenant\AccountController::class, 'paymentCulqui'])->name('tenant.account.payment_culqui')->middleware('just.admin');
                Route::get('payment_method/records', [App\Http\Controllers\Tenant\PaymentMethodTypeController::class, 'records']);
                Route::get('payment_method/record/{code}', [App\Http\Controllers\Tenant\PaymentMethodTypeController::class, 'record']);
                Route::post('payment_method', [App\Http\Controllers\Tenant\PaymentMethodTypeController::class, 'store']);
                Route::delete('payment_method/{code}', [App\Http\Controllers\Tenant\PaymentMethodTypeController::class, 'destroy']);
                //formats PDF
                Route::get('templates', [App\Http\Controllers\Tenant\FormatTemplateController::class, 'records']);
                /////////////////////////////////////////////////////////////////////////////////////////////////
                //grupos//
                Route::get('groups', [App\Http\Controllers\Tenant\GroupController::class, 'index'])->name('tenant.groups.index')->middleware('just.admin');;
                Route::get('groups/create', [App\Http\Controllers\Tenant\GroupController::class, 'create']);
                Route::get('groups/columns', [App\Http\Controllers\Tenant\GroupController::class, 'columns']);

                Route::get('groups/tables', [App\Http\Controllers\Tenant\GroupController::class, 'tables']);
                Route::get('groups/record/{groups}', [App\Http\Controllers\Tenant\GroupController::class, 'record']);
                Route::post('groups', [App\Http\Controllers\Tenant\GroupController::class, 'store']);
                Route::get('groups/records', [App\Http\Controllers\Tenant\GroupController::class, 'records']);
                Route::delete('groups/{groups}', [App\Http\Controllers\Tenant\GroupController::class, 'destroy']);

                //categorias//
                Route::get('category', [App\Http\Controllers\Tenant\CategoryController::class, 'index'])->name('tenant.categories.index')->middleware('just.admin');
                Route::get('category/create', [App\Http\Controllers\Tenant\CategoryController::class, 'create']);
                Route::get('category/tables', [App\Http\Controllers\Tenant\CategoryController::class, 'tables']);
                Route::get('category/record/{categories}', [App\Http\Controllers\Tenant\CategoryController::class, 'record']);
                Route::post('category', [App\Http\Controllers\Tenant\CategoryController::class, 'store']);
                Route::get('category/records', [App\Http\Controllers\Tenant\CategoryController::class, 'records']);
                Route::delete('category/{categories}', [App\Http\Controllers\Tenant\CategoryController::class, 'destroy']);

                //subcategorias//
                Route::get('subcategories/columns', [App\Http\Controllers\Tenant\SubcategoryController::class, 'columns']);
                Route::get('subcategories', [App\Http\Controllers\Tenant\SubcategoryController::class, 'index'])->name('tenant.subcategories.index')->middleware('just.admin');
                Route::get('subcategories/create', [App\Http\Controllers\Tenant\SubcategoryController::class, 'create']);
                Route::get('subcategories/tables', [App\Http\Controllers\Tenant\SubcategoryController::class, 'tables']);
                Route::get('subcategories/record/{categories}', [App\Http\Controllers\Tenant\SubcategoryController::class, 'record']);
                Route::post('subcategories', [App\Http\Controllers\Tenant\SubcategoryController::class, 'store']);
                Route::get('subcategories/records', [App\Http\Controllers\Tenant\SubcategoryController::class, 'records']);
                Route::delete('subcategories/{subcategories}', [App\Http\Controllers\Tenant\SubcategoryController::class, 'destroy']);

                //cajas Egresos//
                Route::get('reports/boxes', [App\Http\Controllers\Tenant\BoxController::class, 'reports'])->name('tenant.reportincomebox.index')->middleware('just.admin');
                Route::get('reports/boxes/reports_type', [App\Http\Controllers\Tenant\BoxController::class, 'reports_type']);
                Route::get('reports/boxes/reports_resumen_type', [App\Http\Controllers\Tenant\BoxController::class, 'reports_resumen_type']);
                Route::get('reports/boxes/reports_categoria_type', [App\Http\Controllers\Tenant\BoxController::class, 'reports_categoria_type']);
                Route::get('reports/boxes/reports_bancario_type', [App\Http\Controllers\Tenant\BoxController::class, 'reports_bancario_type']);

                Route::get('expensesbox', [App\Http\Controllers\Tenant\BoxController::class, 'index'])->name('tenant.expensesbox.index')->middleware('just.admin');
                Route::get('expensesbox/reports', [App\Http\Controllers\Tenant\BoxController::class, 'reports_results']);
                Route::get('expensesbox/reports_pdf', [App\Http\Controllers\Tenant\BoxController::class, 'reports_results_pdf']);
                Route::get('expensesbox/reports_excel', [App\Http\Controllers\Tenant\BoxController::class, 'reports_results_excel']);
                Route::get('expensesbox/create', [App\Http\Controllers\Tenant\BoxController::class, 'create']);
                Route::get('expensesbox/columns', [App\Http\Controllers\Tenant\BoxController::class, 'columns']);
                Route::get('expensesbox/tables', [App\Http\Controllers\Tenant\BoxController::class, 'tables']);
                Route::get('expensesbox/record/{boxes}', [App\Http\Controllers\Tenant\BoxController::class, 'record']);
                Route::post('expensesbox', [App\Http\Controllers\Tenant\BoxController::class, 'store']);
                Route::get('expensesbox/records', [App\Http\Controllers\Tenant\BoxController::class, 'records']);
                Route::get('expensesbox/user/{userid}', [App\Http\Controllers\Tenant\BoxController::class, 'date_start']);
                Route::delete('expensesbox/{boxes}', [App\Http\Controllers\Tenant\BoxController::class, 'destroy']);
                //cajas Ingresos//
                Route::get('incomebox', [App\Http\Controllers\Tenant\BoxController::class, 'incomebox'])->name('tenant.incomebox.index')->middleware('just.admin');
                Route::get('incomebox/create', [App\Http\Controllers\Tenant\BoxController::class, 'create']);
                Route::get('incomebox/columns', [App\Http\Controllers\Tenant\BoxController::class, 'columns']);
                Route::get('incomebox/tables', [App\Http\Controllers\Tenant\BoxController::class, 'tables']);
                Route::get('incomebox/record/{boxes}', [App\Http\Controllers\Tenant\BoxController::class, 'record']);
                Route::post('incomebox', [App\Http\Controllers\Tenant\BoxController::class, 'store']);
                Route::get('incomebox/records', [App\Http\Controllers\Tenant\BoxController::class, 'records2']);
                Route::delete('incomebox/{boxes}', [App\Http\Controllers\Tenant\BoxController::class, 'destroy']);
                Route::middleware(['just.admin'])->group(function () {
                });
            });
        }
    );
} else {
    $prefix = env('PREFIX_URL', null);
    $prefix = !empty($prefix) ? $prefix . "." : '';
    $app_url = $prefix . env('APP_URL_BASE');

    Route::domain($app_url)->group(function () {
        Route::get('login', 'System\LoginController@showLoginForm')->name('login');
        Route::post('login', 'System\LoginController@login');
        Route::post('logout', 'System\LoginController@logout')->name('logout');
        Route::get('phone', 'System\UserController@getPhone');


        Route::middleware('auth:admin')->group(function () {
            Route::get('phpinfo', function () {
                return phpinfo();
            });
            Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
            Route::get('/', function () {
                return redirect()->route('system.dashboard');
            });
            Route::get('dashboard', 'System\HomeController@index')->name('system.dashboard');
            Route::post('logos', 'System\UserController@setLogo');
            //Clients
            Route::get('clients', 'System\ClientController@index')->name('system.clients.index');
            Route::get('clients/records', 'System\ClientController@records');
            Route::get('clients/record/{client}', 'System\ClientController@record');

            Route::get('clients/create', 'System\ClientController@create');
            Route::get('clients/tables', 'System\ClientController@tables');
            Route::get('clients/charts', 'System\ClientController@charts');
            Route::post('clients', 'System\ClientController@store');
            Route::post('clients/update', 'System\ClientController@update');

            Route::delete('clients/{client}/{input_validate}', 'System\ClientController@destroy');
            // Route::delete('clients/{client}', 'System\ClientController@destroy');

            Route::post('clients/password/{client}', 'System\ClientController@password');
            Route::post('clients/locked_emission', 'System\ClientController@lockedEmission');
            Route::post('clients/locked_tenant', 'System\ClientController@lockedTenant');
            // Route::post('clients/locked_tenant', 'System\ClientController@lockedTenant'); //Linea repetida

            Route::post('clients/locked_user', 'System\ClientController@lockedUser');
            Route::post('clients/renew_plan', 'System\ClientController@renewPlan');

            Route::post('clients/set_billing_cycle', 'System\ClientController@startBillingCycle');

            Route::post('clients/locked-by-column', 'System\ClientController@lockedByColumn');

            Route::post('clients/upload', 'System\ClientController@upload');

            Route::get('client_payments/records/{client_id}', 'System\ClientPaymentController@records');
            Route::get('client_payments/client/{client_id}', 'System\ClientPaymentController@client');
            Route::get('client_payments/tables', 'System\ClientPaymentController@tables');
            Route::post('client_payments', 'System\ClientPaymentController@store');
            Route::delete('client_payments/{client_payment}', 'System\ClientPaymentController@destroy');
            Route::get('client_payments/cancel_payment/{client_payment_id}', 'System\ClientPaymentController@cancel_payment');

            Route::get('client_account_status/records/{client_id}', 'System\AccountStatusController@records');
            Route::get('client_account_status/client/{client_id}', 'System\AccountStatusController@client');
            Route::get('client_account_status/tables', 'System\AccountStatusController@tables');

            //Planes
            Route::get('plans', 'System\PlanController@index')->name('system.plans.index');
            Route::get('plans/records', 'System\PlanController@records');
            Route::get('plans/tables', 'System\PlanController@tables');
            Route::get('plans/record/{plan}', 'System\PlanController@record');
            Route::post('plans', 'System\PlanController@store');
            Route::delete('plans/{plan}', 'System\PlanController@destroy');

            //Users
            Route::get('users/create', 'System\UserController@create')->name('system.users.create');
            Route::get('users/record', 'System\UserController@record');
            Route::post('users', 'System\UserController@store');

            Route::get('services/ruc/{number}', 'System\ServiceController@ruc');

            Route::get('certificates/record', 'System\CertificateController@record');
            Route::post('certificates/uploads', 'System\CertificateController@uploadFile');
            Route::post('certificates/saveSoapUser', 'System\CertificateController@saveSoapUser');
            Route::delete('certificates', 'System\CertificateController@destroy');
            Route::get('configurations', 'System\ConfigurationController@index')->name('system.configuration.index');
            Route::post('configurations/login', 'System\ConfigurationController@storeLoginSettings');
            Route::post('configurations/bg', 'System\ConfigurationController@storeBgLogin');
            Route::post('configurations/other-configuration', 'System\ConfigurationController@storeOtherConfiguration');

            Route::get('companies/record', 'System\CompanyController@record');
            Route::post('companies', 'System\CompanyController@store');

            // auto-update
            Route::get('auto-update', 'System\UpdateController@index')->name('system.update');
            Route::get('auto-update/branch', 'System\UpdateController@branch')->name('system.update.branch');
            Route::get('auto-update/pull/{branch}', 'System\UpdateController@pull')->name('system.update.pull');
            Route::get('auto-update/artisan/migrate', 'System\UpdateController@artisanMigrate')->name('system.update.artisan.migrate');
            Route::get('auto-update/artisan/migrate/tenant', 'System\UpdateController@artisanTenancyMigrate')->name('system.update.artisan.tenancy.migrate');
            Route::get('auto-update/artisan/clear', 'System\UpdateController@artisanClear')->name('system.update.artisan.clear');
            Route::get('auto-update/composer/install', 'System\UpdateController@composerInstall')->name('system.update.composer.install');
            Route::get('auto-update/keygen', 'System\UpdateController@keygen')->name('system.update.keygen');
            Route::get('auto-update/version', 'System\UpdateController@version')->name('system.update.version');
            Route::get('auto-update/changelog', 'System\UpdateController@changelog')->name('system.changelog');

            //Configuration

            Route::post('configurations', 'System\ConfigurationController@store');
            Route::get('configurations/record', 'System\ConfigurationController@record');
            Route::get('information', 'System\ConfigurationController@InfoIndex')->name('system.information');
            Route::get('status/history', 'System\StatusController@history')->name('system.status');
            Route::get('status/memory', 'System\StatusController@memory')->name('system.status.memory');
            Route::get('status/cpu', 'System\StatusController@cpu')->name('system.status.cpu');
            Route::get('configurations/apiruc', 'System\ConfigurationController@apiruc');
            Route::get('configurations/apkurl', 'System\ConfigurationController@apkurl');

            Route::get('configurations/update-tenant-discount-type-base', 'System\ConfigurationController@updateTenantDiscountTypeBase');

            // backup
            Route::get('backup', 'System\BackupController@index')->name('system.backup');
            Route::post('backup/db', 'System\BackupController@db')->name('system.backup.db');
            Route::post('backup/files', 'System\BackupController@files')->name('system.backup.files');
            Route::post('backup/upload', 'System\BackupController@upload')->name('system.backup.upload');

            Route::get('backup/last-backup', 'System\BackupController@mostRecent');
            Route::get('backup/download/{filename}', 'System\BackupController@download');

            /*
            Route::get('ajuste_claves_mysql', function(){

                $sites = \Hyn\Tenancy\Models\Website::all();
                $passwords = [];
                foreach($sites as $site){
                    $contra =md5(sprintf(
                                     '%s.%d',
                                     \Config::get('app.key'),
                                     $site->id
                                 ));
                    $temp = [
                        'username'=>$site->uuid,
                        'password'=>$contra,
                        'query'=>"SET PASSWORD FOR '{$site->uuid}'@'%' = PASSWORD('$contra');"
                    ];
                    $passwords[] = $temp;
                    \DB::update( $temp['query'] );
                }
            });
            */
        });
    });
}

//Route::prefix('service')->group(function () {

//});

// Route::get('/', function () {
//     return redirect()->route('tenant.dashboard');
// });

// Route::get('search', [App\Http\Controllers\Tenant\SearchController::class, 'index'])->name('search.index');
