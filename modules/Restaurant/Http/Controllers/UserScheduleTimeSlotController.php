<?php

namespace Modules\Restaurant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\UserScheduleDay;
use Modules\Restaurant\Models\UserScheduleTimeSlot;
use Modules\Restaurant\Models\UserSchedule;
use Modules\Restaurant\Models\UserScheduleException;
use Carbon\Carbon;

class UserScheduleTimeSlotController extends Controller
{
    public function index($dayId)
    {
        $day = UserScheduleDay::findOrFail($dayId);
        return view('restaurant::estilista.time_slots.index', compact('day'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_schedule_day_id' => 'required|exists:tenant.user_schedule_days,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'required|integer|min:5',
            'break_between_slots' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        $timeSlot = UserScheduleTimeSlot::create($request->all());

        return [
            'success' => true,
            'message' => 'Franja horaria creada con éxito',
            'data' => $timeSlot
        ];
    }

    public function edit($id)
    {
        $timeSlot = UserScheduleTimeSlot::findOrFail($id);
        return view('restaurant::estilista.time_slots.form', compact('timeSlot'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'required|integer|min:5',
            'break_between_slots' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        $timeSlot = UserScheduleTimeSlot::findOrFail($id);
        $timeSlot->update($request->all());

        return [
            'success' => true,
            'message' => 'Franja horaria actualizada con éxito',
            'data' => $timeSlot
        ];
    }

    public function destroy($id)
    {
        $timeSlot = UserScheduleTimeSlot::findOrFail($id);
        $timeSlot->delete();

        return [
            'success' => true,
            'message' => 'Franja horaria eliminada con éxito'
        ];
    }

    public function records($dayId)
    {
        $records = UserScheduleTimeSlot::where('user_schedule_day_id', $dayId)
            ->orderBy('start_time')
            ->get();

        return [
            'data' => $records
        ];
    }

    public function getAvailableSlots(Request $request, $userId, $date)
    {
        $date = Carbon::parse($date);
        $dayOfWeek = $date->dayOfWeek;
        
        // Verificar si hay una excepción para esta fecha
        $exception = UserScheduleException::getForDate($userId, $date->format('Y-m-d'));
        
        if ($exception) {
            if (!$exception->is_working_day) {
                return [
                    'success' => true,
                    'data' => [],
                    'message' => 'No hay horarios disponibles para esta fecha (día no laborable)'
                ];
            }
            
            // Si hay una excepción con horario específico, devolver esos slots
            if ($exception->start_time && $exception->end_time) {
                $customSlot = new UserScheduleTimeSlot([
                    'start_time' => $exception->start_time,
                    'end_time' => $exception->end_time,
                    'slot_duration' => 60, // Duración predeterminada
                    'break_between_slots' => 0
                ]);
                
                return [
                    'success' => true,
                    'data' => $customSlot->getAvailableSlots($date->format('Y-m-d')),
                    'message' => 'Horarios disponibles (excepción)'
                ];
            }
        }
        
        // Obtener el horario activo del usuario
        $schedule = UserSchedule::where('user_id', $userId)
            ->where('is_active', true)
            ->first();
            
        if (!$schedule) {
            return [
                'success' => false,
                'message' => 'El usuario no tiene un horario activo'
            ];
        }
        
        // Obtener el día de la semana correspondiente
        $day = $schedule->days()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_working_day', true)
            ->first();
            
        if (!$day) {
            return [
                'success' => true,
                'data' => [],
                'message' => 'No hay horarios disponibles para este día de la semana'
            ];
        }
        
        // Obtener todos los slots de tiempo activos para ese día
        $timeSlots = $day->getActiveTimeSlots();
        
        if ($timeSlots->isEmpty()) {
            return [
                'success' => true,
                'data' => [],
                'message' => 'No hay franjas horarias configuradas para este día'
            ];
        }
        
        // Obtener todos los slots disponibles
        $availableSlots = [];
        foreach ($timeSlots as $timeSlot) {
            $slots = $timeSlot->getAvailableSlots($date->format('Y-m-d'));
            $availableSlots = array_merge($availableSlots, $slots);
        }
        
        return [
            'success' => true,
            'data' => $availableSlots,
            'message' => 'Horarios disponibles'
        ];
    }
} 