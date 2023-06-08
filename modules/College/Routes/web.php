<?php


use Illuminate\Support\Facades\Route;
use Modules\College\Http\Controllers\CollegeClassroomController;
use Modules\College\Http\Controllers\CollegeController;
use Modules\College\Http\Controllers\CollegeLevelsController;
use Modules\College\Http\Controllers\CollegePaymentController;
use Modules\College\Http\Controllers\CollegePenaltyController;
use Modules\College\Http\Controllers\CollegePeriodController;
use Modules\College\Http\Controllers\CollegePersonController;
use Modules\College\Http\Controllers\CollegePlanController;
use Modules\College\Http\Controllers\CollegeRegisterController;
use Modules\College\Http\Controllers\CollegeStudentController;
use Modules\College\Http\Controllers\CollegeListSchoolSuppliesController;

Route::prefix('college')->middleware(['auth', 'redirect.module', 'locked.tenant'])->group(function () {
    Route::get('/', [CollegeController::class, 'index'])->name('college.index');
    //persons
    Route::get('/persons', [CollegePersonController::class, 'index'])->name('college.persons.index');
    Route::post('/persons', [CollegePersonController::class, 'store']);
    Route::post('/persons/update', [CollegePersonController::class, 'updateRecord']);
    Route::get('/persons/member/{parent_id}', [CollegePersonController::class, 'members']);
    Route::get('/persons/children/{parent_id}', [CollegePersonController::class, 'get_children']);
    Route::get('/persons/update/{parent_id}', [CollegePersonController::class, 'update_record']);
    Route::get('/persons/columns', [CollegePersonController::class, 'columns']);
    Route::get('/persons/records', [CollegePersonController::class, 'records']);
    Route::get('/persons/tables', [CollegePersonController::class, 'tables']);
    Route::post('/persons/attorney', [CollegePersonController::class, 'create_attorney_type']);
    Route::get('/persons/attorney/records', [CollegePersonController::class, 'records_attorney']);
    Route::get('/persons/{number}', [CollegePersonController::class, 'person']);

    //levels
    Route::get('/levels', [CollegeLevelsController::class, 'index'])->name('college.levels.index');
    Route::post('/levels/{item}', [CollegeLevelsController::class, 'store']);
    Route::post('/levels/active/{item}', [CollegeLevelsController::class, 'desactive']);
    Route::get('/levels/records', [CollegeLevelsController::class, 'records']);

    //periods
    Route::get('/periods', [CollegePeriodController::class, 'index'])->name('college.periods.index');
    Route::get('/periods/records', [CollegePeriodController::class, 'records']);
    Route::post('/periods', [CollegePeriodController::class, 'store']);

    //plans
    Route::get('/plans', [CollegePlanController::class, 'index'])->name('college.plans.index');
    Route::get('/plans/records', [CollegePlanController::class, 'records']);
    Route::get('/plans/tables', [CollegePlanController::class, 'tables']);
    Route::get('/plans/columns', [CollegePlanController::class, 'columns']);
    Route::post('/plans/active', [CollegePlanController::class, 'active']);
    Route::post('/plans', [CollegePlanController::class, 'store']);

    //regisers
    Route::get('/registers', [CollegeRegisterController::class, 'index'])->name('college.registers.index');
    Route::get('/registers/records', [CollegeRegisterController::class, 'records']);
    Route::post('/registers/sale', [CollegeRegisterController::class, 'register_sale']);
    Route::get('/registers/tables', [CollegeRegisterController::class, 'tables']);
    Route::get('/registers/payment_tables', [CollegeRegisterController::class, 'payment_tables']);
    Route::get('/registers/parents', [CollegeRegisterController::class, 'parents']);
    Route::post('/registers', [CollegeRegisterController::class, 'store']);

    //classrooms
    Route::get('/classrooms', [CollegeClassroomController::class, 'index'])->name('college.classrooms.index');
    Route::get('/classrooms/records', [CollegeClassroomController::class, 'records']);
    Route::get('/classrooms/tables', [CollegeClassroomController::class, 'tables']);
    Route::post('/classrooms', [CollegeClassroomController::class, 'store']);
    Route::get('/classrooms/{id}', [CollegeClassroomController::class, 'students']);

    Route::post('/payments', [CollegePaymentController::class, 'store']);

    Route::get('/students', [CollegeStudentController::class, 'index'])->name('college.students.index');
    Route::get('/students/records', [CollegeStudentController::class, 'records']);
    Route::get('/students/columns', [CollegeStudentController::class, 'columns']);

    //penalties
    Route::get('/penalties', [CollegePenaltyController::class, 'index'])->name('college.penalties.index');
    Route::get('/penalties/records', [CollegePenaltyController::class, 'records']);
    Route::get('/penalties/tables', [CollegePenaltyController::class, 'tables']);
    Route::post('/penalties', [CollegePenaltyController::class, 'store']);

    //Utiles // List Suplies 
    Route::get('/listsuplies', [CollegeListSchoolSuppliesController::class, 'index'])->name('college.listsuplies.index');
    Route::post('/listsuplies/saveNewBranch', [CollegeListSchoolSuppliesController::class, 'saveNewBranch']);
    Route::post('/listsuplies/saveSupplie', [CollegeListSchoolSuppliesController::class, 'saveSupplie']);
    Route::post('/listsuplies/searchnameSupplies', [CollegeListSchoolSuppliesController::class, 'searchnameSupplies']);
    Route::post('/listsuplies/searchCodeSupplies', [CollegeListSchoolSuppliesController::class, 'searchCodeSupplies']);
    Route::get('/listsuplies/searchRemoteUtilIng', [CollegeListSchoolSuppliesController::class, 'searchRemoteUtilIng']);
    Route::get('/listsuplies/searchRemotealumno', [CollegeListSchoolSuppliesController::class, 'searchRemotealumno']);
    Route::get('/listsuplies/searchRemoteProf', [CollegeListSchoolSuppliesController::class, 'searchRemoteProf']);
    Route::post('/listsuplies/saveIntoAlmacenUtil', [CollegeListSchoolSuppliesController::class, 'saveIntoAlmacenUtil']);
    Route::post('/listsuplies/datosTablaAlmacen/', [CollegeListSchoolSuppliesController::class, 'datosTablaAlmacen']);
    Route::post('/listsuplies/getDetailSupplies', [CollegeListSchoolSuppliesController::class, 'getDetailSupplies']);
    Route::get('/listsuplies/listadoSalones', [CollegeListSchoolSuppliesController::class, 'listadoSalones']);
    Route::post('/listsuplies/utilesPorSalonDeClases', [CollegeListSchoolSuppliesController::class, 'utilesPorSalonDeClases']);
    Route::post('/listsuplies/SacarUtilsave', [CollegeListSchoolSuppliesController::class, 'SacarUtilsave']);
});
