<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\PersonCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Catalogs\Country;
use App\Models\Tenant\Catalogs\Department;
use App\Models\Tenant\Catalogs\District;
use App\Models\Tenant\Catalogs\Province;
use Modules\Dental\Http\Requests\MedicRequest;
use Modules\Dental\Http\Resources\MedicCollection;
use Modules\Dental\Http\Resources\MedicResource;
use Modules\Dental\Models\Medic;
use Modules\Dental\Models\Specialty;

class MedicController extends Controller
{
    public function index()
    {
        return view('dental::medic.index');
    }

    public function record($id)
    {
        $record = new MedicResource(Medic::findOrFail($id));
        return $record;
    }

    /* public function records()
    {
        $records = Medic::all();

        return new MedicCollection($records);
    } */

    public function records()
    {
        $records = Medic::with('specialty')->get();

        return new MedicCollection($records);
    }

    public function store(MedicRequest $request)
    {
        $medic = Medic::firstOrNew(['id' => $request->id]);
        $medic->fill($request->all());
        $medic->save();
        return response()->json([
            "success" => true,
            "message" => ($request->id == null) ? "Se Registro con exito" : "Se Actualizo con exito"
        ]);
    }

    public function tables()
    {
        /* $users = User::orderBy('name')->get(); */

        $countries = Country::get();
        $departments = Department::get();
        $provinces = Province::get();
        $districts = District::get();
        $specialties = Specialty::all();
        /* $identity_document_types = IdentityDocumentType::get(); */
        $api_service_token = config('configuration.api_service_token');
        return compact('countries', 'departments', 'provinces', 'districts', 'api_service_token', 'specialties');
    }
    /* public function update($id, Request $request) {
        $product = Person::find($id);
        $product->update($request->all());
        return response()->json([
            "success" =>true,
            "message" =>"Se actualizo con exito"
        ]);
    } */
    /* public function destroy($id) {
        $patient = Person::find($id);
        //$patient->state="0";
        $patient->delete();
        return response()->json(
            [
                "success" =>true,
                "message" =>"Se Elimino con exito"
            ]
        );
    } */
}
