<?php

namespace Modules\Internet\Models;

use App\Models\Tenant\Item;
use App\Models\Tenant\ModelTenant;

class InternetItem extends ModelTenant
{
    public $timestamps = true;
    protected $table = "internet_item";
    protected $fillable = [
        'item_id',
        'register_id',
        'series',
        'quantity',
    ];

    protected $casts = [
        'series' => 'array'
    ];
    protected $with = ["item"];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
