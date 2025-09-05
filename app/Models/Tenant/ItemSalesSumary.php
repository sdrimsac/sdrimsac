<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class ItemSalesSummary extends ModelTenant
{

    protected $fillable = [
        'item_id',
        'total_sales', 
        'total_quantity',
        'created_at',
        'updated_at'
     
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}