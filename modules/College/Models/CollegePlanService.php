<?php

namespace Modules\College\Models;

use App\Models\Tenant\Item;
use App\Models\Tenant\ModelTenant;

class CollegePlanService extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_plan_services";
    protected $with = ['item', 'plan'];
    protected $fillable = [
        'plan_id',
        'item_id',
        'price',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function plan()
    {
        return $this->belongsTo(CollegePlan::class);
    }
}
