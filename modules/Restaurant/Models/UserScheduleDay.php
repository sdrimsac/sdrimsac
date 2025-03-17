<?php

namespace Modules\Restaurant\Models;

use Hyn\Tenancy\Abstracts\TenantModel;

class UserScheduleDay extends TenantModel
{

    protected $table = 'user_schedule_days';
    
    protected $with = ['timeSlots'];

    protected $fillable = [
        'user_schedule_id',
        'day_of_week',
        'is_working_day'
    ];

    protected $casts = [
        'is_working_day' => 'boolean'
    ];

    /**
     * Relación con el horario principal
     */
    public function schedule()
    {
        return $this->belongsTo(UserSchedule::class, 'user_schedule_id');
    }

    /**
     * Relación con los slots de tiempo
     */
    public function timeSlots()
    {
        return $this->hasMany(UserScheduleTimeSlot::class, 'user_schedule_day_id');
    }

    /**
     * Obtener el nombre del día en español
     */
    public function getDayNameAttribute()
    {
        $days = [
            0 => 'Domingo',
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado'
        ];

        return $days[$this->day_of_week];
    }

    /**
     * Verificar si es un día laborable
     */
    public function isWorkingDay()
    {
        return $this->is_working_day;
    }

    /**
     * Obtener todos los slots activos
     */
    public function getActiveTimeSlots()
    {
        return $this->timeSlots()->where('is_active', true)->orderBy('start_time')->get();
    }
} 