<?php

namespace App\Models\Tenant;


class CommercialTreatment extends ModelTenant
{
    protected $table = "commercial_treatments";         //nombre tabla
    protected $with =   ["commercial_treatment_categories"];         //nombre tabla
    public $timestamps = false;
    protected $fillable = [
        'description',
        'is_amount',
        'active'
    ];

    public function commercial_treatment_categories(){
        return $this->hasMany(CommercialTreatmentCategory::class);
    }
}
