<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\Item;


  use App\Models\Tenant\ModelTenant;

class Observation extends ModelTenant
{

    public $timestamps = true;
    protected $table = "observations";
    protected $fillable = [
        'description',
        'active',
    ];
}
