<?php

namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Person;


class Quoty extends ModelTenant
{
    protected $table = "quotes";
    protected $with = ['patient', 'doctor'];
    protected $fillable = [
        'patient_id',                     //paciente
        'medic_id',                      //doctor  
        'date',                          //fecha  
        'time',                          //hora
        'price',                          //precio  
        'state',                          //estado 
        'reason_consultation',            //motivo_consulta 
        'observation'                     //observacion 


    ];

    public function patient()
    {
        return $this->belongsTo(Person::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Person::class, 'medic_id');
    }
}