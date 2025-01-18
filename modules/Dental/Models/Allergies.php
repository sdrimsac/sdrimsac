<?php

namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Person;

class Allergies extends ModelTenant
{
    protected $with = ['allergies_types','persons']; 
    protected $table="allergies"; 
    protected $primarykey="id";
    protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [
        'observation',                       
        'allergies_types_id',
        'patient_id'  
      ];

      public function allergies_types()
    {
        return $this->belongsTo(Allergies_Types::class,'allergies_types_id','id');
    } 

    public function persons()
    {
        return $this->belongsTo(Person::class,'patient_id','id');
    } 
}