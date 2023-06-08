<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class ClientZone extends ModelTenant
{
    protected $table = "client_zones";         //nombre tabla
    protected $fillable = [
        'description',                      // grupo

    ];
}
