<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\Cash;
use App\Models\Tenant\Item;
use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Warehouse;

class CashStockMovement extends ModelTenant
{
    protected $fillable = [
        'cash_id',
        'warehouse_id',
        'item_id',
        'initial_stock',
        'purchases',
        'sold_quantity',
        'current_stock',
        'movement_type',
        'created_at',
        'updated_at',
    ];
    public function warehouses()
    {
        //return $this->belongsTo(Orden::class);
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
    public function cash()
    {
        return $this->belongsTo(Cash::class, 'cash_id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}