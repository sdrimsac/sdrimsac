<?php

namespace App\Models\Tenant;


class CommercialTreatmentCategory extends ModelTenant
{
    public $timestamps = false;
    protected $table = "commercial_treatment_categories";         //nombre tabla
    protected $fillable = [
        'category_item_id',
        'commercial_treatment_id',
        'amount',
        'active'
    ];
}
