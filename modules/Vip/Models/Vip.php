<?php

namespace Modules\Vip\Models;

use App\Models\Tenant\ModelTenant;

class Vip extends ModelTenant
{

    public $timestamps = true;
    protected $table = "vips";
    protected $casts = [
        "active" => "bool"
    ];
    protected $fillable = [
        'description',
        'percentage',
        'inscription_amount',
        'active',
    ];
}
