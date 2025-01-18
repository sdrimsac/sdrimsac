<?php

namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Person;


class Consultation extends ModelTenant
{
    protected $with = ['disease_types','persons']; 
    protected $table="consultations"; 
    protected $primarykey="id";
    protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [
        'orthodontics',                       
        'medicine',                         
        'allergy',                        
        'hospital_surgery',                    
        'disorder',
        'brush_teeth',                          
        'high_pressure',                      
        'disease_type_id',
        'patient_id'  
      ];
 
    public function disease_types()
    {
        return $this->belongsTo(Disease_Types::class,'disease_type_id','id');
    } 
    public function persons()
    {
        return $this->belongsTo(Person::class,'patient_id','id');
    } 
}