<?php

namespace Modules\College\Models;


use App\Models\Tenant\ModelTenant;

class CollegePlanType extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_plan_types";
    protected $fillable = [
        'description',
        'active',

    ];
}
