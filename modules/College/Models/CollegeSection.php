<?php

namespace Modules\College\Models;


use App\Models\Tenant\ModelTenant;

class CollegeSection extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_sections";
    protected $fillable = [
        'description',
        'active',

    ];
}
