<?php

 
        Route::middleware(['auth', 'redirect.module', 'locked.tenant'])->group(function () {


            Route::prefix('offline-configurations')->group(function () {

                Route::get('', 'OfflineConfigurationController@index')->name('tenant.offline_configurations.index');
                Route::post('', 'OfflineConfigurationController@store');
                Route::get('record', 'OfflineConfigurationController@record');
            });

        });
 