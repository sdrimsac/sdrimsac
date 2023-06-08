<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Inventory extends ModelTenant
{
    protected $fillable = [
        'type',
        'description',
        'item_id',
        'date_of_issue',
        'warehouse_id',
        'warehouse_destination_id',
        'quantity',
        "real_stock",
        "system_stock"
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function warehouse_destination()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_destination_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function inventory_kardex()
    {
        return $this->morphMany(InventoryKardex::class, 'inventory_kardexable');
    }
}
