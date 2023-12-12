<?php

$hostname = app(Hyn\Tenancy\Contracts\CurrentHostname::class);
if ($hostname) {
    Route::domain($hostname->fqdn)->group(function() {

        Route::middleware(['auth:api', 'locked.tenant'])->group(function() {

            Route::prefix('order-notes')->group(function () {
                Route::post('', 'OrderNoteController@store');
                Route::get('lists', 'Api\OrderNoteController@lists');
                Route::post('status', 'Api\OrderNoteController@status');
                Route::get('user/{userid}', 'Api\OrderNoteController@lista_user');
                //----------------------------------------------------------------------
                Route::get('columns', 'OrderNoteController@columns');
                Route::get('records', 'OrderNoteController@records');
                Route::get('create', 'OrderNoteController@create')->name('tenant.order_notes.create');
                Route::get('edit/{id}', 'OrderNoteController@edit');
                
                Route::get('tables', 'OrderNoteController@tables');
                Route::get('table/{table}', 'OrderNoteController@table');
                Route::post('update', 'OrderNoteController@update');
                Route::get('record/{quotation}', 'OrderNoteController@record');
                Route::get('voided/{id}', 'OrderNoteController@voided');
                Route::get('item/tables', 'OrderNoteController@item_tables');
                Route::get('option/tables', 'OrderNoteController@option_tables');
                Route::get('search/customers', 'OrderNoteController@searchCustomers');
                Route::get('search/customer/{id}', 'OrderNoteController@searchCustomerById');
                Route::get('download/{external_id}/{format?}', 'OrderNoteController@download');
                Route::get('print/{external_id}/{format?}', 'OrderNoteController@toPrint');
                Route::post('email', 'OrderNoteController@email');
                Route::post('duplicate', 'OrderNoteController@duplicate');
                Route::get('record2/{quotation}', 'OrderNoteController@record2');
                Route::delete('destroy_order_note_item/{order_note_item}', 'OrderNoteController@destroy_order_note_item');
            });

        });

    });
}
