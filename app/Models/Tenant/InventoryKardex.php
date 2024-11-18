<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

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
        'is_import_excel',
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