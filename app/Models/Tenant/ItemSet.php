<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class ItemSet extends ModelTenant
{

    protected $fillable = [
        'item_id',
        'individual_item_id', 
        'quantity',
        'sale_unit_price'   
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function individual_item()
    {
        return $this->belongsTo(Item::class, 'individual_item_id');
    }
 

}