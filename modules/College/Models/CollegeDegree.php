<?php

namespace Modules\College\Models;


use App\Models\Tenant\ModelTenant;

class CollegeDegree extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_degrees";
    protected $fillable = [
        'description',
        'active',

    ];
}
