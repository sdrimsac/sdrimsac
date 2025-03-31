<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\Item;
use App\Models\Tenant\User;
use App\Models\Tenant\Person;
use Hyn\Tenancy\Abstracts\TenantModel;
use Carbon\Carbon;

class UserScheduleAppointment extends TenantModel
{
    protected $fillable = [
        'orden_id',
        'user_id',
        'client_id',
        'appointment_date',
        'start_time',
        'end_time',
        'duration',
        'status',
        'notes',
        'service_id'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i'
    ];

    /**
     * Relación con el usuario (estilista, médico, etc.)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el cliente
     */
    public function client()
    {
        return $this->belongsTo(Person::class, 'client_id');
    }

    public function service()
    {
        return $this->belongsTo(Item::class, 'service_id');
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
     * Obtener la duración en formato legible
     */
    public function getDurationTextAttribute()
    {
        if ($this->duration < 60) {
            return $this->duration . ' minutos';
        }
        
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        
        if ($minutes === 0) {
            return $hours . ' hora' . ($hours > 1 ? 's' : '');
        }
        
        return $hours . ' hora' . ($hours > 1 ? 's' : '') . ' y ' . $minutes . ' minutos';
    }

    /**
     * Verificar si la cita está programada
     */
    public function isScheduled()
    {
        return $this->status === 'scheduled';
    }

    /**
     * Verificar si la cita está completada
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Verificar si la cita está cancelada
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Verificar si el cliente no se presentó
     */
    public function isNoShow()
    {
        return $this->status === 'no_show';
    }

    /**
     * Verificar si la cita está en atención
     */
    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    /**
     * Verificar disponibilidad para una nueva cita
     */
    public static function checkAvailability($userId, $date, $startTime, $endTime, $excludeAppointmentId = null)
    {
        $query = self::where('user_id', $userId)
            ->where('appointment_date', $date)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '>=', $startTime)
                      ->where('start_time', '<', $endTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    $q->where('end_time', '>', $startTime)
                      ->where('end_time', '<=', $endTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<=', $startTime)
                      ->where('end_time', '>=', $endTime);
                });
            });
        
        // Si estamos editando una cita, excluirla de la verificación
        if ($excludeAppointmentId) {
            $query->where('id', '!=', $excludeAppointmentId);
        }
        
        return !$query->exists();
    }

    /**
     * Obtener citas para un día específico
     */
    public static function getAppointmentsForDay($userId, $date)
    {
        return self::where('user_id', $userId)
            ->where('appointment_date', $date)
            ->orderBy('start_time')
            ->get();
    }

    /**
     * Obtener el texto del estado en español
     */
    public static function getStatusText($status)
    {
        return [
            'scheduled' => 'Programada',
            'completed' => 'Completada',
            'cancelled' => 'Cancelada',
            'no_show' => 'No asistió',
            'in_progress' => 'En atención'
        ][$status] ?? $status;
    }

    public function products()
    {
        return $this->hasMany(AppointmentProduct::class, 'appointment_id');
    }
} 