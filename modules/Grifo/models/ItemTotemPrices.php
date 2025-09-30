<?php

namespace Modules\Grifo\Models;

use App\Models\Tenant\Item;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\User;

class ItemTotemPrices extends ModelTenant
{

    protected $fillable = [
        'item_id',
        'price',
        'user_id',
        'date_of_price',
        'created_at',
        'updated_at',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
