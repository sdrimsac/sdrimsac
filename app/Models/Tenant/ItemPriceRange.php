<?php

namespace App\Models\Tenant;





class ItemPriceRange extends ModelTenant
{
    protected $table = 'item_price_ranges';

    protected $fillable = [
        'item_id',
        'quantity_min',
        'price',
    ];

    protected $casts = [
        'quantity_min' => 'decimal:2',
    ];
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}