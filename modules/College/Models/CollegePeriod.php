<?php

namespace Modules\College\Models;


use App\Models\Tenant\ModelTenant;

class CollegePeriod extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_periods";
    protected $fillable = [
        'description',
        'default_count',
        'active',

    ];
}
