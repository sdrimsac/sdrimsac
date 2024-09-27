<?php

namespace App\Models\Tenant;


class UnitTypePerson extends ModelTenant
{
    protected $table = "unti_type_persons";
     public $timestamps = false;
    protected $fillable = [
        'customer_id',
        'description',                   
    ];
    
    public function customer()
    {
        return $this->belongsTo(Person::class, 'customer_id');
    }
}
