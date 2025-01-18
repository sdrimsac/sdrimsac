<?php

namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Person;


class Diagnosis extends ModelTenant
{
    protected $with = ['diagnosis_types','paciente']; 
    protected $table="diagnosis"; 
    protected $primarykey="id";
    protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [ 
                           
        'diagnosis_types_id',
        'date',  
        'patient_id'  
      ];

      public function diagnosis_types()
    {
        return $this->belongsTo(Diagnosis_Types::class,'diagnosis_types_id','id');
    } 

    public function paciente()
    {
        return $this->belongsTo(Person::class,'patient_id','id');
    } 
    
}