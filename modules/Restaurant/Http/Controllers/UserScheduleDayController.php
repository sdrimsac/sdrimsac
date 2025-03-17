<?php

namespace Modules\Restaurant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\UserSchedule;
use Modules\Restaurant\Models\UserScheduleDay;

class UserScheduleDayController extends Controller
{
    public function index($scheduleId)
    {
        $schedule = UserSchedule::findOrFail($scheduleId);
        return view('restaurant::estilista.schedule_days.index', compact('schedule'));
    }

    public function workingDays($user_id){
        $workingDays = UserScheduleDay::whereHas('schedule', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();
        return [
            'data' => $workingDays
        ];
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_schedule_id' => 'required|exists:tenant.user_schedules,id',
            'day_of_week' => 'required|integer|min:0|max:6',
            'is_working_day' => 'boolean'
        ]);

        $day = UserScheduleDay::create($request->all());

        return [
            'success' => true,
            'message' => 'Día de horario creado con éxito',
            'data' => $day
        ];
    }

    public function edit($id)
    {
        $day = UserScheduleDay::findOrFail($id);
        return view('restaurant::estilista.schedule_days.form', compact('day'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'day_of_week' => 'required|integer|min:0|max:6',
            'is_working_day' => 'boolean'
        ]);

        $day = UserScheduleDay::findOrFail($id);
        $day->update($request->all());

        return [
            'success' => true,
            'message' => 'Día de horario actualizado con éxito',
            'data' => $day
        ];
    }

    public function destroy($id)
    {
        $day = UserScheduleDay::findOrFail($id);
        $day->delete();

        return [
            'success' => true,
            'message' => 'Día de horario eliminado con éxito'
        ];
    }

    public function records($scheduleId)
    {
        $records = UserScheduleDay::where('user_schedule_id', $scheduleId)
            ->orderBy('day_of_week')
            ->get();

        return [
            'data' => $records
        ];
    }
} 