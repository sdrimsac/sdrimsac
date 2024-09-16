<?php

namespace App\Models\Tenant;


class CommercialTreatmentUserExcluded extends ModelTenant
{
    protected $table = "commercial_treatment_users";         //nombre tabla
    public $timestamps = false;
    protected $fillable = [
        'commercial_treatment_id',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function commercial_treatment(){
        return $this->belongsTo(CommercialTreatment::class);
    }
    
}
