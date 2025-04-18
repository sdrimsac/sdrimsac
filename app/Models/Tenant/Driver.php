<?php

namespace App\Models\Tenant;


class Driver extends ModelTenant
{
       
    protected $table = "drivers";

    protected $fillable = [
        'id',
        'identity_document_type_id',
        'number',
        'name',
        'license',
        'telephone',
        'is_default',
        'is_active',
    ];
}