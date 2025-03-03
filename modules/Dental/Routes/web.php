<?php

use Illuminate\Support\Facades\Route;
use Modules\Dental\Http\Controllers\Allergies_TypesController;
use Modules\Dental\Http\Controllers\AllergiesController;
use Modules\Dental\Http\Controllers\CashController;
use Modules\Dental\Http\Controllers\ConsultationController;
use Modules\Dental\Http\Controllers\DentalController;
use Modules\Dental\Http\Controllers\Diagnosi_TypeController;
use Modules\Dental\Http\Controllers\DiagnosisController;
use Modules\Dental\Http\Controllers\Disease_TypesController;
use Modules\Dental\Http\Controllers\DiseaseController;
use Modules\Dental\Http\Controllers\EvolutionController;
use Modules\Dental\Http\Controllers\Medic_DetailsController;
use Modules\Dental\Http\Controllers\MedicController;
use Modules\Dental\Http\Controllers\ObservationController;
use Modules\Dental\Http\Controllers\OdontogramController;
use Modules\Dental\Http\Controllers\OrdenController;
use Modules\Dental\Http\Controllers\Physical_ExplorationController;
use Modules\Dental\Http\Controllers\QuotyController;
use Modules\Dental\Http\Controllers\SpecialtyController;
use Modules\Dental\Http\Controllers\TariffController;
use Modules\Dental\Models\Odontogram;
use Modules\Restaurant\Http\Controllers\RestaurantController;

/* Route::prefix('dental')->group(function() {
    Route::get('/', 'DentalController@index');
}); */

Route::middleware(['auth'])->group(function () {
    Route::prefix('dental')->group(function () {
        Route::get('/', 'DentalController@index');
        Route::get('observations', [ObservationController::class, 'index'])->name('workshop.observations');
        Route::get('observations/columns', [ObservationController::class, 'columns']);
        Route::get('observations/records', [ObservationController::class, 'records']);
        Route::post('observations', [ObservationController::class, 'store']);
        Route::get('observations/record/{id}', [ObservationController::class, 'record']);
        Route::get('observations/{id}', [ObservationController::class, 'active']);

        Route::get('specialties', [SpecialtyController::class, 'index'])->name('tenant.dental.specialties');
        Route::get('specialties/record/{id}', [SpecialtyController::class, 'record']);
        /* Route::get('specialties/columns', [SpecialtyController::class, 'columns']); */
        Route::get('specialties/records', [SpecialtyController::class, 'records']);
        Route::post('specialties', [SpecialtyController::class, 'store']);
        Route::delete('specialties/{id}', [SpecialtyController::class, 'destroy']);

        Route::get('medic', [MedicController::class, 'index'])->name('tenant.dental.medic');
        Route::get('medic/record/{id}', [MedicController::class, 'record']);
        /* Route::get('specialties/columns', [SpecialtyController::class, 'columns']); */
        Route::get('medic/records', [MedicController::class, 'records']);
        Route::get('medic/tables', [MedicController::class, 'tables']);
        Route::post('medic', [MedicController::class, 'store']);
        Route::delete('medic/{id}', [MedicController::class, 'destroy']);

        Route::get('tariffs', [TariffController::class, 'index'])->name('tenant.dental.tariffs');
        Route::get('tariffs/record/{id}', [TariffController::class, 'record']);
        /* Route::get('tariffs/columns', [TariffController::class, 'columns']); */
        Route::get('tariffs/tables', [TariffController::class, 'tables']);
        Route::post('tariffs', [TariffController::class, 'store']);
        Route::get('tariffs/records', [TariffController::class, 'records']);
        Route::delete('tariffs/{id}', [TariffController::class, 'destroy']);

        Route::get('searchCustomers', [OdontogramController::class, 'searchCustomers']);

        /* Route::get('medic_details', [Medic_DetailsController::class, 'index'])->name('tenant.dental.medic'); */
        Route::get('medic_details/record/{id}', [Medic_DetailsController::class, 'record']);
        Route::get('medic_details/records', [Medic_DetailsController::class, 'records']);
        Route::get('medic_details/tables', [Medic_DetailsController::class, 'tables']);
        Route::post('medic_details', [Medic_DetailsController::class, 'store']);
        Route::delete('medic_details/{id}', [Medic_DetailsController::class, 'destroy']);


        Route::prefix('worker')->group(function () {
            Route::get('/dashboard-pos', [DentalController::class, 'pos']);
            Route::get('print_last_document', [OrdenController::class, 'print_last_document']);
            Route::post('pos/last_number_documents', [App\Http\Controllers\Tenant\PosController::class, 'last_number_documents']);
            Route::get('expenses', [DentalController::class, 'expenses'])->name('workshop.expenses.index')->middleware('just.worker');
            Route::get('expenses/records', [DentalController::class, 'records']);
            Route::get('expenses/record/{id}', [DentalController::class, 'record']);
            Route::post('expenses', [DentalController::class, 'store']);
            Route::delete('expenses/{id}', [DentalController::class, 'destroy']);
            Route::get('expenses/columns', [DentalController::class, 'columns']);
            Route::get('expenses/tables', [DentalController::class, 'tables']);
            Route::post('pos/orden_payment', [DentalController::class, 'payment']);
            Route::get('pos/search_orden', [DentalController::class, 'search']);
            Route::get('pos/listtables', [DentalController::class, 'listtables']);
            Route::get('pos/selecttabled/{idOrden}', [DentalController::class, 'electtabled']);
            Route::get('pos/foods', [DentalController::class, 'foods']);

            Route::get('cash', [CashController::class, 'index'])->name('restaurant.cash.index')->middleware('just.worker');;
            Route::get('cash/get-final-balance/{cash_id}', [CashController::class, 'getFinalBalance']);
            Route::get('cash/columns', [CashController::class, 'columns']);
            Route::get('cash/generate_reports/{cash_id}', [CashController::class, 'generate_reports']);
            Route::get('cash/records', [CashController::class, 'records']);
            Route::get('cash/records_closed', [CashController::class, 'recordsClosed']);
            Route::get('cash/create', [CashController::class, 'create'])->name('tenant.cash_pos.create')->middleware('just.worker');;
            Route::get('cash/tables', [CashController::class, 'tables']);
            Route::get('cash/final_balance_last_principal', [CashController::class, 'final_balance_last_principal']);
            Route::get('cash/opening_cash', [CashController::class, 'opening_cash']);
            Route::get('cash/opening_cash_check/{user_id}', [CashController::class, 'opening_cash_check']);
            Route::post('cash', [CashController::class, 'store']);
            Route::post('cash/close', [CashController::class, 'close']);
            Route::get('cash/report/{cash}', [CashController::class, 'report']);
            Route::get('cash/get_printer/{area_id}', [CashController::class, 'get_printer']);
            Route::get('cash/get_last_documents', [CashController::class, 'get_last_documents']);
            Route::get('cash/incomes_expenses', [CashController::class, 'incomes_expenses']);
            Route::delete('cash/incomes_expenses/{id}/{type}', [CashController::class, 'incomes_expenses_delete']);
            Route::get('cash/report', [CashController::class, 'report_general']);
            Route::get('cash/record/{cash}', [CashController::class, 'record']);
            Route::delete('cash/{cash}', [CashController::class, 'destroy']);
            Route::get('cash/item/tables', [CashController::class, 'item_tables']);
            Route::get('cash/search/customers', [CashController::class, 'searchCustomers']);
            Route::get('cash/search/customer/{id}', [CashController::class, 'searchCustomerById']);
            Route::get('cash/report/products/{cash}', [CashController::class, 'report_products']);

            Route::get('search_customers', [RestaurantController::class, 'search_customer']);

            // promociones nuevo
            Route::post('pos/processPromo', 'PromocionPorItemController@processPromo');
            Route::get('pos/showCliePromos', 'PromocionPorItemController@showCliePromos');
            Route::post('pos/getPrductosPromo', 'PromocionPorItemController@getPrductosPromo');
            Route::post('pos/canjearPromo', 'PromocionPorItemController@canjearPromo');
            Route::post('pos/HistCanje', 'PromocionPorItemController@HistCanje');

            Route::post('odontogram', [OdontogramController::class, 'store']);
            Route::get('odontogram', [OdontogramController::class, 'index']);
            Route::get('odontogram/record/{id}', [OdontogramController::class, 'record']); //Admin
            Route::get('odontogram/patient/{patient_id}', [OdontogramController::class, 'patient']);
            Route::get('odontogram/columns', [OdontogramController::class, 'columns']);
            Route::get('odontogram/records', [OdontogramController::class, 'records']);
            Route::delete('odontogram/{id}', [OdontogramController::class, 'destroy']);


            Route::post('evolution', [EvolutionController::class, 'store']);
            Route::get('evolution', [EvolutionController::class, 'index']); //Admin
            Route::get('evolution/record/{id}', [EvolutionController::class, 'record']); //Admin
            Route::get('evolution/patient/{patient_id}', [EvolutionController::class, 'patient']);
            Route::get('evolution/columns', [EvolutionController::class, 'columns']);
            Route::get('evolution/records', [EvolutionController::class, 'records']);
            Route::delete('evolution/{id}', [EvolutionController::class, 'destroy']);

            Route::post('allergies', [AllergiesController::class, 'store']);
            Route::get('allergies', [AllergiesController::class, 'index'])->name('allergies.index'); //Admin
            Route::get('allergies/record/{id}', [AllergiesController::class, 'record']); //Admin
            Route::get('allergies/patient/{patient_id}', [AllergiesController::class, 'patient']);
            Route::get('allergies/columns', [AllergiesController::class, 'columns']);
            Route::get('allergies/records', [AllergiesController::class, 'records']);
            Route::delete('allergies/{id}', [AllergiesController::class, 'destroy']);



            Route::post('allery_type', [Allergies_TypesController::class, 'store']);
            Route::get('allery_type', [Allergies_TypesController::class, 'index'])->name('allery_type.index'); //Admin
            Route::get('allery_type/record/{id}', [Allergies_TypesController::class, 'record']); //Admin
            Route::get('allery_type/patient/{patient_id}', [Allergies_TypesController::class, 'patient']);
            Route::get('allery_type/columns', [Allergies_TypesController::class, 'columns']);
            Route::get('allery_type/records', [Allergies_TypesController::class, 'records']);
            Route::delete('allery_type/{id}', [Allergies_TypesController::class, 'destroy']);

            Route::post('diseases', [Disease_TypesController::class, 'store']);
            Route::get('diseases', [Disease_TypesController::class, 'index'])->name('diseases.index'); //Admin
            Route::get('diseases/record/{id}', [Disease_TypesController::class, 'record']); //Admin
            Route::get('diseases/patient/{patient_id}', [Disease_TypesController::class, 'patient']);
            Route::get('diseases/columns', [Disease_TypesController::class, 'columns']);
            Route::get('diseases/records', [Disease_TypesController::class, 'records']);
            Route::delete('diseases/{id}', [Disease_TypesController::class, 'destroy']);

            Route::post('consultations', [ConsultationController::class, 'store']);
            Route::get('consultations', [ConsultationController::class, 'index'])->name('consultations.index'); //Admin
            Route::get('consultations/record/{id}', [ConsultationController::class, 'record']); //Admin
            Route::get('consultations/patient/{patient_id}', [ConsultationController::class, 'patient']);
            Route::get('consultations/columns', [ConsultationController::class, 'columns']);
            Route::get('consultations/records', [ConsultationController::class, 'records']);
            Route::delete('consultations/{id}', [ConsultationController::class, 'destroy']);

            Route::post('disease', [DiseaseController::class, 'store']);
            Route::get('disease', [DiseaseController::class, 'index'])->name('disease.index'); //Admin
            Route::get('disease/record/{id}', [DiseaseController::class, 'record']); //Admin
            Route::get('disease/patient/{patient_id}', [DiseaseController::class, 'patient']);
            Route::get('disease/columns', [DiseaseController::class, 'columns']);
            Route::get('disease/records', [DiseaseController::class, 'records']);
            Route::delete('disease/{id}', [DiseaseController::class, 'destroy']);

            Route::post('physical_exploration', [Physical_ExplorationController::class, 'store']);
            Route::get('physical_exploration', [Physical_ExplorationController::class, 'index'])->name('physical_exploration.index'); //Admin
            Route::get('physical_exploration/record/{id}', [Physical_ExplorationController::class, 'record']); //Admin
            Route::get('physical_exploration/patient/{patient_id}', [Physical_ExplorationController::class, 'patient']);
            Route::get('physical_exploration/columns', [Physical_ExplorationController::class, 'columns']);
            Route::get('physical_exploration/records', [Physical_ExplorationController::class, 'records']);
            Route::delete('physical_exploration/{id}', [Physical_ExplorationController::class, 'destroy']);

            Route::post('diagnoses', [DiagnosisController::class, 'store']);
            Route::get('diagnoses', [DiagnosisController::class, 'index'])->name('diagnoses.index'); //Admin
            Route::get('diagnoses/record/{id}', [DiagnosisController::class, 'record']); //Admin
            Route::get('diagnoses/columns', [DiagnosisController::class, 'columns']);
            Route::get('diagnoses/records', [DiagnosisController::class, 'records']);
            Route::delete('diagnoses/{id}', [DiagnosisController::class, 'destroy']);

            Route::post('quotes', [QuotyController::class, 'store']);
            Route::get('quotes', [QuotyController::class, 'index'])->name('quotes.index'); //Admin
            Route::get('quotes/record/{id}', [QuotyController::class, 'record']); //Admin
            Route::get('quotes/patient/{patient_id}', [QuotyController::class, 'patient']); //A
            Route::get('quotes/columns', [QuotyController::class, 'columns']);
            Route::post('quotes/records', [QuotyController::class, 'records']);
            Route::get('quotes/patients', [QuotyController::class, 'patients']);
            Route::get('quotes/tables', [QuotyController::class, 'tables']);
            Route::delete('quotes/{id}', [QuotyController::class, 'destroy']);



            Route::post('diagnosis_types', [Diagnosi_TypeController::class, 'store']);
            Route::get('diagnosis_types', [Diagnosi_TypeController::class, 'index'])->name('diagnosis_types.index');
            Route::get('diagnosis_types/record/{id}', [Diagnosi_TypeController::class, 'record']);
            Route::get('diagnosis_types/patient/{patient_id}', [Diagnosi_TypeController::class, 'patient']);
            Route::get('diagnosis_types/columns', [Diagnosi_TypeController::class, 'columns']);
            Route::get('diagnosis_types/records', [Diagnosi_TypeController::class, 'records']);
            Route::delete('diagnosis_types/{id}', [Diagnosi_TypeController::class, 'destroy']);
        });
        /* Route::get('pos/foods', [WorkshopController::class, 'foods']); */
    });
});
