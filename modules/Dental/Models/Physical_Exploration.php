<?php

namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Person;

class Physical_Exploration extends ModelTenant
{
    protected $with = ['paciente']; 
    protected $table="physical_exploration"; 
    protected $primarykey="id";
    protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [
        'blood_pressure',                       
        'pulse',                         
        'temperature',                        
        'heart_rate',                    
        'respiratory_rate',
        'weight',                          
        'height',                      
        'imc',
        'general_clinical_examination',
        'complementary_examination',
        'odontostomatological',
        'patient_id'  
      ];
    public function paciente()
    {
        return $this->belongsTo(Person::class,'patient_id','id');
    } 
}