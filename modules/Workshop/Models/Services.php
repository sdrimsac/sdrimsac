<?php

namespace Modules\Workshop\Models;

use App\Models\Tenant\ModelTenant;

class Services extends ModelTenant
{
    protected $table = 'services';
    
    protected $fillable = [
        'description',
        'active',
    ];
}