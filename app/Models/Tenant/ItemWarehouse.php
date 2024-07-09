<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\Models\InventoryTransaction;

class ItemWarehouse extends ModelTenant
{
    protected $table = 'item_warehouse';

    protected $fillable = [
        'item_id',
        'warehouse_id',
        'stock',
        'type',
        
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function Inventory()
    {
        return $this->hasMany(Inventory::class);
    }
    public function transaction ()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
}
