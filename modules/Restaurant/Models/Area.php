<?php

namespace Modules\Restaurant\Models;
use App\Models\Tenant\ModelTenant;


class Area extends ModelTenant
{

    public $timestamps = false;
    protected $table = "areas";
    protected $casts = [
        "search_print" => "bool"
    ];
    protected $fillable = [
        'description',
        'printer',
        'copies',
        'active',
        'search_print'
    ];
}
