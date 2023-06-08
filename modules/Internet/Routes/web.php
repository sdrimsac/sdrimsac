<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Internet\Http\Controllers\InternetConceptVariationController;
use Modules\Internet\Http\Controllers\InternetController;
use Modules\Internet\Http\Controllers\InternetPlanVariationController;
use Modules\Internet\Http\Controllers\InternetRegisterController;
use Modules\Internet\Http\Controllers\InternetSuspensionController;
use Modules\Internet\Http\Controllers\PlanesController;
use Modules\Internet\Http\Controllers\InternetWorkersController;

Route::get('/internet/register/export', [InternetRegisterController::class, 'export']);
Route::get('/payments_print/{register_id}', [InternetRegisterController::class, "print_payments"]);
Route::middleware(['auth'])->group(function () {
    Route::prefix('internet')->group(function () {
        Route::get('/', 'InternetController@index');
        Route::post('/', [InternetController::class, 'store']);
        Route::post('/image', [InternetController::class, 'image']);

        Route::get('/register/update_date', [InternetRegisterController::class, "update__date"]);
        Route::post('/register/update_service', [InternetSuspensionController::class, "store"]);
        Route::get('/register/{id}', [InternetRegisterController::class, "register_data"]);
        Route::get('/register/data/{id}', [InternetRegisterController::class, "register"]);
        Route::post('/register/data', [InternetRegisterController::class, "update_register"]);
        Route::post('/payments', [InternetRegisterController::class, "register_payments"]);
        Route::post('/update', [InternetRegisterController::class, "update_plan"]);
        Route::get('/payments/{register_id}', [InternetRegisterController::class, "get_payments"]);
        Route::get('/contract/{register_id}', [InternetController::class, 'contract']);
        Route::get('/persons/{number}', [InternetController::class, 'person']);
        Route::get('/records', [InternetController::class, 'records']);
        Route::get('/tables', [InternetController::class, 'tables']);
        Route::get('/techs', [InternetController::class, 'techs']);
        Route::get('/create_tech/{person_id}', [InternetController::class, 'create_tech']);
        Route::post('/plan/variation', [InternetPlanVariationController::class, 'store']);
        Route::post('/concept/variation', [InternetConceptVariationController::class, 'store']);

        Route::prefix('worker')->group(function () {
            Route::get('/dashboard-pos', [InternetController::class, 'pos']);
        });

        //modulo de PLANES CONCEPTOS Y VARIACIONES 
        Route::get('/planes', [PlanesController::class, 'index'])->name('tenant.internet.planes');
        Route::get('/planes/getAllRecords', [PlanesController::class, 'getAllRecords']);
        Route::post('/planes/createPlan', [PlanesController::class, 'createPlan']);
        Route::post('/planes/createConcepto', [PlanesController::class, 'createConcepto']);
        Route::post('/planes/desactivePlanConcepts', [PlanesController::class, 'desactivePlanConcepts']);
        Route::post('/planes/editarPlanesConcepts', [PlanesController::class, 'editarPlanesConcepts']);
        Route::post('/planes/saveEditarPlanesConcepts', [PlanesController::class, 'saveEditarPlanesConcepts']);
        Route::post('/planes/newPlanVar', [PlanesController::class, 'newPlanVar']);
        Route::post('/planes/newconceptVar', [PlanesController::class, 'newconceptVar']);
        Route::post('/planes/changestatusVar', [PlanesController::class, 'changestatusVar']);
        Route::post('/planes/searchEditVar', [PlanesController::class, 'searchEditVar']);
        Route::post('/planes/guardarEdicionVariacion', [PlanesController::class, 'guardarEdicionVariacion']);
        Route::post('/planes/saveEdicionVariacion', [PlanesController::class, 'saveEdicionVariacion']);

        //MODULO DE TRABAJADORES Y TECNICOS 
        Route::get('/workersadm', [InternetWorkersController::class, 'index'])->name('tenant.internet.workersadmin');
        Route::get('/workersadm/getAllRecords', [InternetWorkersController::class, 'getAllRecords']);
        Route::post('/workersadm/saveRecord', [InternetWorkersController::class, 'saveRecord']);
        Route::post('/workersadm/changeStatus', [InternetWorkersController::class, 'changeStatus']);
    });
});
