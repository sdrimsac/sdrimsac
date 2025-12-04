<?php

namespace App\Models\Tenant;



class Schedule extends ModelTenant
{
    protected $table = 'schedules';

    protected $fillable = [
        'person_id',
        'name',
        'entrada',
        'salida',
        'tolerancia_min',
        'created_at',
        'updated_at'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
