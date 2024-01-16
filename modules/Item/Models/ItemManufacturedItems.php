<?php

namespace Modules\Item\Models;

use App\Models\Tenant\Item;

use App\Models\Tenant\ModelTenant;

class ItemManufacturedItems extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'manufactured_record_items';
    protected $fillable = [ 
        'manufactured_record_id',
        'item_id',
        'quantity'
    ];
 
    public function manufactured_item()
    {
        return $this->hasMany(ItemManufactured::class, 'id', 'manufactured_record_id');
    }
    
    public function item()
    {
        return $this->hasMany(Item::class, 'id', 'item_id');
    }

}