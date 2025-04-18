<?php

namespace App\Models\Tenant;

class Transport extends ModelTenant
{

    protected $table = "transports";

    protected $fillable = [
        'id',
        'plate_number',
        'model',
        'brand',
        'is_default',
        'is_active',
    ];  
}