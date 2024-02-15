<?php

namespace App\Models\Tenant;


class ItemColorSize extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'item_colors_sizes';
    protected $fillable = [
        'warehouse_id',
        'item_id',
        'color', 
        'size',
        'stock',
        'price'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

 

}