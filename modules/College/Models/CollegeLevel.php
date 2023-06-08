<?php

namespace Modules\College\Models;


use App\Models\Tenant\ModelTenant;

class CollegeLevel extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_levels";
    protected $fillable = [
        'description',
        'active',

    ];
}
