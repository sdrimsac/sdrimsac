<?php

namespace Modules\Inventory\Models;


use App\Models\Tenant\Item;
use App\Models\Tenant\Person as ModelsPerson;
use App\Models\Tenant\ModelTenant;

class ListOrdenCompra extends ModelTenant
{
    protected $hidden = ["created_at", "updated_at"];

    protected $fillable = [ 
        'item_id',
        'id_persons',
        'unit_price',
        'id_orden_compra',
    ];

    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function persons()
    {
        return $this->belongsTo(ModelsPerson::class, 'id_persons');
    }
}