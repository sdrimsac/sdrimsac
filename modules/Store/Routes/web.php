<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'locked.tenant'])->group(function () {
    Route::prefix('store')->group(function () {
        Route::get('record/{table}/{table_id}', 'StoreController@getRecord');
        Route::post('get_item_series', 'StoreController@getItemSeries');
        Route::post('get_igv', 'StoreController@getIgv');
        Route::post('get_customers', 'StoreController@getCustomers');
    });
    Route::prefix('documents')->group(function () {
        Route::get('create/{table?}/{table_id?}', 'StoreController@tableToDocument');
    });
});
