<?php

namespace Modules\Inventory\Models;

use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use App\Models\Tenant\ModelTenant;

class TransferPlaceDetail extends ModelTenant
{

    protected $table = "transfers_place_detail";
    protected $with = ["item"];
    protected $casts = [
        'series_lots' => 'array'
    ];
    public $timestamps = false;
    protected $fillable = [
        'item_id',
        'transfers_place_id',
        'warehouse_id',
        'warehouse_id_destination',
        'quantity',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
