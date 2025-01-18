<?php

namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Person;

class Evolution extends ModelTenant
{
    protected $with = ['paciente','medico']; 
    protected $table="evolution"; 
    protected $primarykey="id";
    protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [
        'patient_id',                    
        'medic_id',
        'date',  
        'observation' 
      ];

      public function paciente()
    {
        return $this->belongsTo(Person::class,'patient_id','id');
    } 

    public function medico()
    {
        return $this->belongsTo(Person::class,'medic_id','id');
    } 
}