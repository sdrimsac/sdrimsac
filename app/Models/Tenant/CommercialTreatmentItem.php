<?php

namespace App\Models\Tenant;


class CommercialTreatmentItem extends ModelTenant
{
    public $timestamps = false;
    protected $table = "commercial_treatment_items";         //nombre tabla
    protected $fillable = [
        'item_id',
        'commercial_treatment_id',
        'amount',
        'active'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function commercial_treatment()
    {
        return $this->belongsTo(CommercialTreatment::class, 'commercial_treatment_id');
    }
}
