<?php

namespace Modules\Restobar\Models;

use App\Models\Tenant\Item;
use App\Traits\HelperTrait;
use App\Traits\RegisterMovementTrait;
use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\User;

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
        'area_id',
        'user_id'
    ];
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function food()
    {
        return  $this->belongsTo(Food::class, 'food_id');
    }

    public function orden_item()
    {
        return $this->belongsTo(OrdenItem::class, 'orden_item_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
