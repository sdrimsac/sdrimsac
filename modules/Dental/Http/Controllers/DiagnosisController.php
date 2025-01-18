<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\DiagnosisCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\Dental\Http\Resources\DiagnosisResource;
use Modules\Dental\Http\Requests\DiagnosisRequest;
use Modules\Dental\Models\Diagnosis;

class DiagnosisController extends Controller
{
    public function index()
    {
        // $type ='vehicle';
        return view('diagnoses.index');
    }

    public function columns()
    {
        return [
            'description'     => 'Descripcion',
            'state'           => 'Estado',

        ];
    }
    public function record($id)
    {
        $record = new DiagnosisResource(Diagnosis::findOrFail($id));
        return $record;
    }
    public function patient($id) //Selecccionar un Registro
    {
        $records = new DiagnosisCollection(Diagnosis::where('patient_id', $id)->get());
        return [
            'data' => $records,
            'success' => true
        ];
    }
    /* public function tables()
    {
      
     $user= User::all();
     return compact('user');
       
    }*/

    public function store(DiagnosisRequest $request)
    {
        $id = $request->input('id');
        $diagnosis = Diagnosis::firstOrNew(['id' => $id]);

        $diagnosis->fill($request->all());
        $diagnosis->date = Carbon::parse($request->date);
        $diagnosis->save();
        return [
            'success' => true,
            'message' => ($id) ? ' actualizado' : 'registrado'
        ];
    }

    public function records(Request $request)
    {
        $records = Diagnosis::where($request->column, 'like', "%{$request->value}%")->orderBy($request->column); //para ordenar

        return new DiagnosisCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function destroy($id)
    {
        $diagnosis = Diagnosis::findOrFail($id);
        $diagnosis->save();

        return [
            'success' => true,
            'message' => 'eliminado con éxito'
        ];
    }
}
