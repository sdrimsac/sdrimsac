<?php

namespace Modules\Item\Models;

use App\Models\Tenant\InventoryKardex;
use App\Models\Tenant\Item;

use App\Models\Tenant\ModelTenant;

class ItemManufactured extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'manufactured_records';
    protected $fillable = [
        'item_id',
        'quantity',
    ];

    /* public function items()
    {
        return $this->hasMany(ItemManufacturedItems::class);
    } */
    public function items()
    {
        return $this->hasMany(ItemManufacturedItems::class, 'manufactured_record_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function inventory_kardex()
    {
        return $this->morphMany(InventoryKardex::class, 'inventory_kardexable');
    }
}
