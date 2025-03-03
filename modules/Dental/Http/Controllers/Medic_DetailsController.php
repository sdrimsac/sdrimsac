<?php

namespace Modules\Dental\Http\Controllers;


use Modules\Dental\Http\Resources\Allergies_TypesCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Modules\Dental\Models\Allergies_Types;
use Modules\Dental\Models\Medic_Details;

class Medic_DetailsController extends Controller
{
    /* public function index()
    {
        $allergies_types = Allergies_Types::all()->toArray();
        return array_reverse($allergies_types);
    } */
    public function columns()
    {
        return [
            'description'  => 'Descripción',


        ];
    }
    /* public function record($id) //Selecccionar un Registro
    {
        $record = new Allergies_TypesResource(Allergies_Types::findOrFail($id));
        return $record;
    } */
    public function records(Request $request)
    {
        return new Allergies_TypesCollection(Allergies_Types::paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'medic_id' => 'required|exists:tenant.medic,id',
            'schedules' => 'required|array',
            'schedules.*.day_of_week' => 'required|string',
            'schedules.*.start_time' => 'nullable',
            'schedules.*.end_time' => 'nullable',
            'schedules.*.is_active' => 'required|boolean',
        ]);
        $daysMap = [
            'Lunes' => 'Monday',
            'Martes' => 'Tuesday',
            'Miércoles' => 'Wednesday',
            'Miercoles' => 'Wednesday',
            'Jueves' => 'Thursday',
            'Viernes' => 'Friday',
            'Sábado' => 'Saturday',
            'Sabado' => 'Saturday',
            'Domingo' => 'Sunday',
        ];

        Medic_Details::where('medic_id', $data['medic_id'])->delete();

        foreach ($data['schedules'] as $schedule) {

            $dayInEnglish = $daysMap[$schedule['day_of_week']] ?? null;

            if ($dayInEnglish) {
                Medic_Details::create([
                    'medic_id' => $data['medic_id'],
                    'day_of_week' => $dayInEnglish,
                    'start_time' => date('H:i:s', strtotime($schedule['start_time'])),
                    'end_time' => date('H:i:s', strtotime($schedule['end_time'])),
                    'active' => $schedule['is_active'] ? '1' : '0',
                ]);
            }
        }
        return response()->json(['message' => 'Horarios actualizados correctamente']);
    }
    /* public function show($id)
    {
        $allergies_types = Allergies_Types::find($id);
        return response()->json($allergies_types);
    } */
    /* public function update($id, Request $request)
    {
        $allergies_types = Allergies_Types::find($id);
        $allergies_types->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Se actualizo con exito"
        ]);
    } */
    /* public function destroy($id)
    {
        $allergies_types = Allergies_Types::find($id);
        $allergies_types->delete();
        return response()->json(
            [
                "success" => true,
                "message" => "Se Elimino con exito"
            ]
        );
    } */
}
