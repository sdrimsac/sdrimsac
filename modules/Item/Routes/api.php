<?php

use Illuminate\Support\Facades\Route;


        // Route::post('login', 'Tenant\Api\MobileController@login');
        Route::middleware(['auth:api', 'locked.tenant'])->group(function () {
            Route::get('categories', 'CategoryController@index')->middleware('redirect.level');
            Route::get('categories/records', 'CategoryController@records');
            Route::get('categories/init', 'CategoryController@init');
            Route::get('categories/productsByCategory', 'CategoryController@productsByCategory');
            Route::get('categories/columns', 'CategoryController@columns');
            Route::get('categories/record/{category}', 'CategoryController@record');
            Route::post('categories', 'CategoryController@store');
            Route::get('items/search', 'CategoryController@search');
            Route::delete('categories/{category}', 'CategoryController@destroy');
        });
