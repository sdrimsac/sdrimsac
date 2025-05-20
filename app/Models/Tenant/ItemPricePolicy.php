<?php

namespace App\Models\Tenant;


class ItemPricePolicy extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'item_price_policy';
    protected $fillable = [
        'item_id',
        'item_unit_type_id',
        'price', 
        'barcode_policy',
    ];

    public function itemUnitType()
    {
        return $this->belongsTo(itemUnitType::class);
    }
    

 

}