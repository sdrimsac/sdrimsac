<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\PersonCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Modules\Dental\Http\Resources\EvolutionResource;
use Modules\Dental\Http\Requests\EvolutionRequest;
use Modules\Dental\Models\Person;

class MedicController extends Controller
{
    /* public function index() {
        $products = Person::all()->toArray();
        return array_reverse($products);
    }
    public function columns()
    {
        return [
            'name' => 'Nombres',
            'detail' => 'Detalle',
          
        ];
    }
  
    public function tables()
    {
        $users = User::orderBy('name')->get();

        $countries = Country::get();
        $departments = Department::get();
        $provinces = Province::get();
        $districts = District::get();
        $specialty=Specialty::all();
        $identity_document_types = IdentityDocumentType::get();
         $api_service_token = config('configuration.api_service_token');
        return compact('countries', 'departments', 'provinces', 'districts', 'identity_document_types','api_service_token','users','specialty');
    }

    public function record($id)//Selecccionar un Registro
    {
        $record = new PersonResource(Person::findOrFail($id));
        return $record;
    }
    public function records(Request $request)
    {
        $records = Person::where('type','medico')->where($request->column, 'like', "%{$request->value}%")->orderBy('name','asc');
        return new PersonCollection($records->paginate(20));
         
    }

    public function store(PersonRequest $request) {
        $id = $request->input('id');
        $person = Person::firstOrNew(['id' => $id]);
        $person->fill($request->all());
         $person->fech_nac=Carbon::parse($request->input('fech_nac'))->format('Y-m-d');
        $person->save();
        return response()->json([
            "success" =>true,
            "message" =>"Se Registro con exito"
        ]);
    }
    public function show($id) {
        $product = Person::find($id);
        return response()->json($product);
    }
    public function update($id, Request $request) {
        $product = Person::find($id);
        $product->update($request->all());
        return response()->json([
            "success" =>true,
            "message" =>"Se actualizo con exito"
        ]);
    }
    public function destroy($id) {
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
