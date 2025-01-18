<?php
namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Person;

class Disease extends ModelTenant
{
    protected $with = ['disease_types','persons']; 
    protected $table="diseases"; 
    protected $primarykey="id";
    protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [
        'disease_type_id', 
        'consultation_reason',                       
        'signs_symptoms',                         
        'personal_background',                        
        'family_background',                    
        'medicine',
        'medicine_name',                          
        'medicine_reason',                      
        'medicine_dose',
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