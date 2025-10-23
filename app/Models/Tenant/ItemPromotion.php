<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class ItemPromotion extends ModelTenant
{

    protected $table = "items_promotions";
    protected $fillable = [
        'item_id',
        'promotion_item_id',
        'quantity',
        'sale_unit_price',
        'max_quantity',
        'group_number',
        'created_at',
        'updated_at',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function promotion_item()
    {
        return $this->belongsTo(Item::class, 'promotion_item_id');
    }
}
