<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\ScheduleCollection;
use App\Http\Resources\Tenant\ScheduleResource;
use App\Models\Tenant\Schedule;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    public function records(Request $request)
    {
        $records = $this->getRecords($request);

        return new ScheduleCollection($records);
    }
    public function getRecords(Request $request)
    {
        
        $records = Schedule::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $records->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('entrada', 'like', "%{$search}%")
                      ->orWhere('salida', 'like', "%{$search}%");
            });
        }

        return $records->get();
    }

    public function record($id)
    {
        $record = new ScheduleResource(Schedule::findOrFail($id));

        return $record;
    }
    public function store(Request $request)
    {
        $id = $request->input('id');
        $schedule = Schedule::firstOrNew(['id' => $id]);
        $schedule->fill($request->all());
        $schedule->save();
        return [
            'success' => true,
            'message' => ($id) ? 'Horario editado con éxito' : 'Horario registrado con éxito',
            'id' => $schedule->id
        ];
    }
}
