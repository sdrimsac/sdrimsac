<?php

namespace Modules\Internet\Models;

use App\Models\Tenant\ModelTenant;

class InternetPlanVariation extends ModelTenant
{
    public $timestamps = true;
    protected $table = "internet_plan_variation";
    protected $fillable = [
        'plan_id',
        'description',
        'price',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
    public function plan()
    {
        return $this->belongsTo(InternetPlan::class, 'plan_id');
    }
}
