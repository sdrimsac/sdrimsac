<?php

namespace Modules\Format\Models;

use App\Models\Tenant\ModelTenant;

class Account extends ModelTenant
{
    protected $fillable = [
        'number',
        'description',
    ];


}
