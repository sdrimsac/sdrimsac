<?php

namespace Modules\Restaurant\Models;

use Hyn\Tenancy\Abstracts\TenantModel;
use Carbon\Carbon;

class UserScheduleTimeSlot extends TenantModel
{
    protected $fillable = [
        'user_schedule_day_id',
        'start_time',
        'end_time',
        'slot_duration',
        'break_between_slots',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i'
    ];

    /**
     * Relación con el día del horario
     */
    public function day()
    {
        return $this->belongsTo(UserScheduleDay::class, 'user_schedule_day_id');
    }

    /**
     * Obtener la duración en formato legible
     */
    public function getDurationTextAttribute()
    {
        if ($this->slot_duration < 60) {
            return $this->slot_duration . ' minutos';
        }
        
        $hours = floor($this->slot_duration / 60);
        $minutes = $this->slot_duration % 60;
        
        if ($minutes === 0) {
            return $hours . ' hora' . ($hours > 1 ? 's' : '');
        }
        
        return $hours . ' hora' . ($hours > 1 ? 's' : '') . ' y ' . $minutes . ' minutos';
    }

    /**
     * Obtener el horario en formato legible
     */
    public function getTimeRangeAttribute()
    {
        return Carbon::parse($this->start_time)->format('H:i') . ' - ' . 
               Carbon::parse($this->end_time)->format('H:i');
    }

    /**
     * Calcular los slots disponibles basados en la duración
     */
    public function getAvailableSlots($date)
    {
        $startTime = Carbon::parse($this->start_time)->format('H:i:s');
        $endTime = Carbon::parse($this->end_time)->format('H:i:s');
        
        $startDateTime = Carbon::parse("$date $startTime");
        $endDateTime = Carbon::parse("$date $endTime");
        
        $slots = [];
        $currentTime = clone $startDateTime;
        
        while ($currentTime->addMinutes($this->slot_duration)->lte($endDateTime)) {
            $slotStart = clone $currentTime;
            $slotStart->subMinutes($this->slot_duration);
            
            $slotEnd = clone $currentTime;
            
            // Verificar si el slot ya está ocupado por una cita
            $isAvailable = !UserScheduleAppointment::where('appointment_date', $date)
                ->where(function ($query) use ($slotStart, $slotEnd) {
                    $query->where(function ($q) use ($slotStart, $slotEnd) {
                        $q->where('start_time', '>=', $slotStart->format('H:i:s'))
                          ->where('start_time', '<', $slotEnd->format('H:i:s'));
                    })->orWhere(function ($q) use ($slotStart, $slotEnd) {
                        $q->where('end_time', '>', $slotStart->format('H:i:s'))
                          ->where('end_time', '<=', $slotEnd->format('H:i:s'));
                    })->orWhere(function ($q) use ($slotStart, $slotEnd) {
                        $q->where('start_time', '<=', $slotStart->format('H:i:s'))
                          ->where('end_time', '>=', $slotEnd->format('H:i:s'));
                    });
                })
                ->exists();
            
            $slots[] = [
                'start' => $slotStart->format('H:i'),
                'end' => $slotEnd->format('H:i'),
                'available' => $isAvailable
            ];
            
            // Agregar el tiempo de descanso entre slots
            $currentTime->addMinutes($this->break_between_slots);
        }
        
        return $slots;
    }
} 