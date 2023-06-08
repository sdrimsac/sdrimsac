<?php

namespace Modules\Internet\Models;

use App\Models\Tenant\ModelTenant;

class InternetPlanOperation extends ModelTenant
{
    public $timestamps = true;
    protected $table = "internet_plan_operation";
    protected $fillable = [
        'plan_id',
        'operation_id',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
    public function plan()
    {
        return $this->belongsTo(InternetPlanVariation::class, 'plan_id');
    }
    public function operation()
    {
        return $this->belongsTo(InternetOperation::class, 'operation_id');
    }
}
