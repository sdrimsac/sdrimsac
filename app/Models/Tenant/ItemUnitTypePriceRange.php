<?php

namespace App\Models\Tenant;



class ItemUnitTypePriceRange extends ModelTenant
{
    public $timestamps = false;

    protected $fillable = [
        'unit_type_id',
        'quantity_min',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        
    ];

    public function item_unit_type()
    {
        return $this->belongsTo(ItemUnitType::class, 'unit_type_id');
    }

}
