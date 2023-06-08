<?php

namespace Modules\Internet\Models;

use App\Models\Tenant\Item;
use App\Models\Tenant\ModelTenant;

class InternetPlan extends ModelTenant
{
    public $timestamps = true;
    protected $table = "internet_plan";
    protected $fillable = [
        'item_id',
        'capacity',
        'default_price',
        'active',
        'item_id'
    ];
    protected $casts = [
        'active' => 'boolean',
        'default_price' => 'float'
    ];
    protected $with = ["variations", "item"];

    public function variations()
    {
        return $this->hasMany(InternetPlanVariation::class, 'plan_id', 'id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
