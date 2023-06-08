<?php

namespace Modules\College\Models;


use App\Models\Tenant\ModelTenant;

class CollegeTurn extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_turns";
    protected $fillable = [
        'description',
        'active',

    ];
}
