<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\User;
use Hyn\Tenancy\Abstracts\TenantModel;
use Carbon\Carbon;

class UserScheduleException extends TenantModel
{
    protected $fillable = [
        'user_id',
        'exception_date',
        'is_working_day',
        'start_time',
        'end_time',
        'reason'
    ];

    protected $casts = [
        'exception_date' => 'date',
        'is_working_day' => 'boolean',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i'
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verificar si es un día laborable
     */
    public function isWorkingDay()
    {
        return $this->is_working_day;
    }

    /**
     * Obtener el horario en formato legible
     */
    public function getTimeRangeAttribute()
    {
        if (!$this->start_time || !$this->end_time) {
            return 'No disponible';
        }
        
        return Carbon::parse($this->start_time)->format('H:i') . ' - ' . 
               Carbon::parse($this->end_time)->format('H:i');
    }

    /**
     * Verificar si una fecha específica tiene una excepción
     */
    public static function hasException($userId, $date)
    {
        return self::where('user_id', $userId)
            ->where('exception_date', $date)
            ->exists();
    }

    /**
     * Obtener la excepción para una fecha específica
     */
    public static function getForDate($userId, $date)
    {
        return self::where('user_id', $userId)
            ->where('exception_date', $date)
            ->first();
    }
} 