<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\User;
use Hyn\Tenancy\Abstracts\TenantModel;

class UserSchedule extends TenantModel
{
    protected $fillable = [
        'user_id',
        'name',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con los días del horario
     */
    public function days()
    {
        return $this->hasMany(UserScheduleDay::class);
    }

    /**
     * Obtener todos los slots de tiempo a través de los días
     */
    public function allTimeSlots()
    {
        return UserScheduleTimeSlot::whereHas('day', function ($query) {
            $query->where('user_schedule_id', $this->id);
        });
    }

    /**
     * Verificar si el horario está activo
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Crear un horario predeterminado para un usuario
     */
    public static function createDefaultSchedule($userId, $name = 'Horario predeterminado')
    {
        $schedule = self::create([
            'user_id' => $userId,
            'name' => $name,
            'is_active' => true
        ]);

        // Crear días de lunes a viernes (1-5)
        for ($i = 1; $i <= 5; $i++) {
            $day = UserScheduleDay::create([
                'user_schedule_id' => $schedule->id,
                'day_of_week' => $i,
                'is_working_day' => true
            ]);

            // Crear slots de mañana y tarde
            UserScheduleTimeSlot::create([
                'user_schedule_day_id' => $day->id,
                'start_time' => '09:00:00',
                'end_time' => '13:00:00',
                'slot_duration' => 60,
                'break_between_slots' => 0,
                'is_active' => true
            ]);

            UserScheduleTimeSlot::create([
                'user_schedule_day_id' => $day->id,
                'start_time' => '15:00:00',
                'end_time' => '19:00:00',
                'slot_duration' => 60,
                'break_between_slots' => 0,
                'is_active' => true
            ]);
        }

        // Crear sábado (6) con horario reducido
        $saturday = UserScheduleDay::create([
            'user_schedule_id' => $schedule->id,
            'day_of_week' => 6,
            'is_working_day' => true
        ]);

        UserScheduleTimeSlot::create([
            'user_schedule_day_id' => $saturday->id,
            'start_time' => '09:00:00',
            'end_time' => '14:00:00',
            'slot_duration' => 60,
            'break_between_slots' => 0,
            'is_active' => true
        ]);

        // Domingo (0) como no laborable
        UserScheduleDay::create([
            'user_schedule_id' => $schedule->id,
            'day_of_week' => 0,
            'is_working_day' => false
        ]);

        return $schedule;
    }
} 