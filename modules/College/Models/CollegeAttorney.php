<?php

namespace Modules\College\Models;

use App\Models\Tenant\ModelTenant;

class CollegeAttorney extends ModelTenant
{

    public $timestamps = true;
    protected $table = "attorney_types";
    protected $fillable = [
        'description',

    ];
}
