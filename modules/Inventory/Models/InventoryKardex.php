<?php

namespace Modules\Inventory\Models;

use App\Models\Tenant\Item;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\User;

class InventoryKardex extends ModelTenant
{
    protected $table = 'inventory_kardex';

    protected $fillable = [ 
        'date_of_issue',
        'item_id',
        'inventory_kardexable_id',
        'inventory_kardexable_type',
        'warehouse_id',
        'quantity', 
        'user_id',
    ];

    public function inventory_kardexable()
    {
        return $this->morphTo();
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
