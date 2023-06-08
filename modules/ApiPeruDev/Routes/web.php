<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'locked.tenant'])->group(function () {
    Route::prefix('apiperudev')->group(function () {
        Route::get('massive_validate_cpe/tables', 'MassiveValidateController@tables');
        Route::post('massive_validate_cpe', 'MassiveValidateController@validate');
        Route::post('massive_validate_cpe_2', 'MassiveValidateV2Controller@validate');
    });
    //ruta distinta a la version actual
    Route::prefix('service')->group(function () {
        Route::get('exchange/{date}', 'ServiceController@exchange');
        Route::get('{type}/{number}', 'ServiceController@service');

        Route::get('dispatch/send/{external_id}', 'ServiceDispatchController@send');
        Route::get('dispatch/status_ticket/{external_id}', 'ServiceDispatchController@statusTicket');
    });
});
// $prefix = env('PREFIX_URL',null);
// $prefix = !empty($prefix)?$prefix.".":'';
// $app_url = $prefix. env('APP_URL_BASE');

Route::middleware('auth:admin')->group(function () {
    Route::prefix('service')->group(function () {
        Route::get('{type}/{number}', 'ServiceController@service');
    });
});
