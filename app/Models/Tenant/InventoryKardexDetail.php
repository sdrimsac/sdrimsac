<?php

namespace App\Models\Tenant;


class InventoryKardexDetail extends ModelTenant
{
    protected $table = 'inventory_kardex_detail';

    public $timestamps = false;
    protected $fillable = [ 
        'inventory_kardex_id',
        'detail',
    ];

    public function inventory_kardex()
    {
        return $this->belongsTo(InventoryKardex::class);
    }
 

}