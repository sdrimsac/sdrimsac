<?php

namespace App\Models\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;

class PersonParient extends ModelTenant
{

    use UsesTenantConnection;

    protected $table = 'person_parient';
   
    protected $fillable = [
        'description',
    ];
}
