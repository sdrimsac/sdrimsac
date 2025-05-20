<?php

namespace App\Models\Tenant;


class ItemCodes extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'item_codes';
    protected $fillable = [
        'item_id',
        'code_barcode',
        'is_primary', 
        'size',
        'active',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    

 

}