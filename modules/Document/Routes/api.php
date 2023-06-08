<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/document', function (Request $request) {
    return $request->user();
});
*/
Route::prefix('documents')->group(function() {
    Route::post('pay-constancy/upload', 'DocumentController@upload');
    Route::post('pay-constancy/save', 'DocumentController@savePayConstancy');
    Route::get('detraction/tables', 'DocumentController@detractionTables');
    Route::get('data-table/customers', 'DocumentController@dataTableCustomers');
    Route::get('prepayments/{type}', 'DocumentController@prepayments');
    Route::get('search-items', 'DocumentController@searchItems');
    Route::get('search/item/{item}', 'DocumentController@searchItemById');
});

Route::prefix('reports/validate-documents')->group(function() {
    Route::get('', 'ValidateDocumentController@index')->middleware('tenant.internal.mode');
    Route::get('records', 'ValidateDocumentController@records');
    Route::get('validate', 'ValidateDocumentController@validate');
    Route::get('validateDocuments', 'ValidateDocumentController@validateDocuments');
    Route::get('data_table', 'ValidateDocumentController@data_table');

});
