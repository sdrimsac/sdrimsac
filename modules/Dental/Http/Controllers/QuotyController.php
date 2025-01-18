<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\QuotyCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Person;
use Exception;
use Modules\Dental\Http\Resources\QuotyResource;
use Modules\Dental\Http\Requests\QuotyRequest;
use Modules\Dental\Models\Quoty;
use Modules\Dental\Models\Specialty;

class QuotyController extends Controller
{
    public function index()
    {
        // $type ='vehicle';
        return view('quotes.index');
    }

    public function columns()
    {
        return [
            'date'          => 'Fecha',
            'patient_id'    => 'Paciente',

        ];
    }
    public function record($id)
    {
        $record = new QuotyResource(Quoty::findOrFail($id));
        return $record;
    }
    public function patient($id)
    {
        $records = new QuotyCollection(Quoty::where('patient_id', $id)->get());
        return [
            'data' => $records,
            'success' => true
        ];
    }
    public function tables()
    {

        $person = Person::where('type', 'medico')->get();
        $specialities = Specialty::all();
        return [
            'persons' => $person,
            'specialities' => $specialities
        ];
    }

    public function store(QuotyRequest $request)
    {

        $id = $request->input('id');
        $request['date'] = Carbon::parse($request['date']);
        $quoty = Quoty::firstOrNew(['id' => $id]);
        $quoty->fill($request->all());
        try {
            $quoty->save();
            return [
                'success' => true,
                'message' => ($id) ? ' actualizado' : 'registrado'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function records(Request $request)
    {
        //fecha
        //doctor_id
        //paciente_id
        //rango
        //estado de cita
        //especialidad

        $avance = $request['avance'];
        $date = $request['dateField'];
        if ($avance) {
            $start = $request['dateRange'][0];
            $end = $request['dateRange'][1];
        }


        $medic_id = $request['current_doctor'];
        $patient_id = $request['patient_id'];
        $state = $request['state'];
        $speciality = $request["current_speciality"];

        //  dump($request->all());
        try {
            if (!$avance) {
                $date = Carbon::parse($date, 'America/Lima');
                $records = Quoty::whereDate('date', $date);
            } else {
                $start = Carbon::parse($start, 'America/Lima');
                $end = Carbon::parse($end, 'America/Lima');
                $records = Quoty::whereBetween('date', [
                    $start,
                    $end
                ]);
            }
            if ($patient_id) {
                $records = $records->where('patient_id', $patient_id);
            }
            if ($medic_id) {
                $records = $records->where('medic_id', $medic_id);
            }
            if ($state) {
                $records = $records->where('state', $state);
            }
            // $records = Quoty::where($request->column, 'like', "%{$request->value}%")->orderBy($request->column); //para ordenar
            //para ordenar

            return new QuotyCollection($records->paginate(config('tenant.items_per_page')));
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function patients(Request $request)
    {


        $records = Person::where('type', 'patient')->where('name', 'like', "%{$request->patient}%")->orderBy('name')->get();

        return [
            'success' => true,
            'patients' => $records
        ];
    }

    public function destroy($id)
    {
        $quoty = Quoty::findOrFail($id);
        $quoty->save();

        return [
            'success' => true,
            'message' => 'eliminado con éxito'
        ];
    }
}
