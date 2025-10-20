<?php

namespace Modules\Restobar\Models;

use App\Models\Tenant\Item;


  use App\Models\Tenant\ModelTenant;

class Observation extends ModelTenant
{

    public $timestamps = true;
    protected $table = "observations";
    protected $fillable = [
        'description',
        'item_id',
        'active',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
