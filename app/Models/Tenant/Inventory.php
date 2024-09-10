<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\Models\InventoryTransaction;
use React\Http\Io\Transaction;

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
        'internal_id',
        "real_stock",
        "system_stock",
        'inventory_transaction_id',
        'created_at',
        
    ];
    protected $table = 'inventories';

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
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function inventory_kardex()
    {
        return $this->morphMany(InventoryKardex::class, 'inventory_kardexable');
    }
    public function inventoryTransaction()
    {
        return $this->belongsTo(InventoryTransaction::class, 'inventory_transaction_id');
    }
}
