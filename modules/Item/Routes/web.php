<?php

use Illuminate\Support\Facades\Route;
use Modules\Item\Http\Controllers\ItemLotsGroupController;

Route::middleware(['auth', 'locked.tenant'])->group(function () {


    Route::get('lotes', [ItemLotsGroupController::class, 'index'])->name("lotes");
    Route::get('lotes/records', [ItemLotsGroupController::class, 'records']);
    Route::get('lotes/tables', [ItemLotsGroupController::class, 'tables']);
    Route::get('categories/init', 'CategoryController@init');
    //->name('tenant.categories.index')
    Route::get('items/categories', 'CategoryController@index')->middleware('redirect.level');
    Route::get('items/categories/records', 'CategoryController@records');
    Route::post('items/categories/search/{category_id}', 'CategoryController@searchItemsByCategory');
    Route::get('items/categories/update_drag/{id}', 'CategoryController@changeDrag');
    Route::get('items/categories/drag', 'CategoryController@recordsDrag');
    Route::get('items/categories/columns', 'CategoryController@columns');
    Route::get('items/categories/record/{category}', 'CategoryController@record');
    Route::get('items/categories/update_category/{category_id}/{item_id}', 'CategoryController@update_category');
    Route::post('items/categories/uploads', 'CategoryController@uploads');
    Route::get('items/categories/export', 'CategoryController@export');
    Route::post('items/categories', 'CategoryController@store');
    Route::delete('items/categories/{category}', 'CategoryController@destroy');

    Route::get('brands', 'BrandController@index')->name('tenant.brands.index')->middleware('redirect.level');
    Route::get('brands/records', 'BrandController@records');
    Route::get('brands/record/{brand}', 'BrandController@record');
    Route::post('brands', 'BrandController@store');
    Route::get('brands/columns', 'BrandController@columns');
    Route::delete('brands/{brand}', 'BrandController@destroy');
    Route::get('brands/export', 'BrandController@export');

    Route::get('incentives', 'IncentiveController@index')->name('tenant.incentives.index')->middleware('redirect.level');
    Route::get('incentives/records', 'IncentiveController@records');
    Route::get('incentives/record/{incentive}', 'IncentiveController@record');
    Route::post('incentives', 'IncentiveController@store');
    Route::get('incentives/columns', 'IncentiveController@columns');
    Route::delete('incentives/{incentive}', 'IncentiveController@destroy');

    Route::get('items/barcode/{item}', 'ItemController@generateBarcode');

    Route::post('items/import/item-price-lists', 'ItemController@importItemPriceLists');
});
