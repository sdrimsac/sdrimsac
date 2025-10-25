<?php

namespace Modules\Restobar\Models;

use App\Models\Tenant\Item;
use App\Traits\HelperTrait;
use App\Traits\RegisterMovementTrait;
use App\Models\Tenant\ModelTenant;

class OrderItemDetail extends ModelTenant
{
    use HelperTrait, RegisterMovementTrait;

    public $timestamps = false;
    protected $table = "order_item_details";
    protected $with = ['food'];

    protected $fillable = [
        'orden_item_id',
        'item_id',
        'description',
        'quantity',
    ];
    public function item(){
        return $this->belongsTo(Item::class);
    }
    public function food()
    {
        return  $this->belongsTo(Food::class);
    }

    public function orden_item()
    {
        return $this->belongsTo(OrdenItem::class, 'orden_item_id');
    }
}
