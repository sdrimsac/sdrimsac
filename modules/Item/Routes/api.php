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

    //Route::get('brands', 'BrandController@index')->name('tenant.brands.index')->middleware('redirect.level');
    Route::get('brands/records', 'BrandController@records');
    Route::get('brands/record/{brand}', 'BrandController@record');
    Route::post('brands', 'BrandController@store');
    Route::get('brands/columns', 'BrandController@columns');
    Route::delete('brands/{brand}', 'BrandController@destroy');
    Route::get('brands/export', 'BrandController@export');
});
