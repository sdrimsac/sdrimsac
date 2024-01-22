<?php

namespace App\Models\Tenant;


class ItemColorSize extends ModelTenant
{

    protected $table = 'item_colors_sizes';
    protected $fillable = [
        'item_id',
        'color', 
        'size',
        'stock'   
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

 

}