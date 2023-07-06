<?php

namespace Modules\Consignment\Models;

use App\Models\Tenant\Item;
use App\Models\Tenant\ModelTenant;

class ConsignmentItem extends ModelTenant
{
    protected $table = 'consignment_items'; 
    protected $fillable = [
        'consignment_id',
        'item_id',
        'original_quantity',
        'selled_quantity',
        'return_quantity',
        'lost_quantity',
        'active'
    ];

    
    public function item(){
        return $this->belongsTo(Item::class);
    }
    public function lots(){
        return $this->hasMany(ConsignmentItemLot::class);
    }

}