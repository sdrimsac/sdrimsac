<?php

namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;


class Allergies_Types extends ModelTenant
{
    protected $table = "allergies_types";  
    protected $fillable = [
       'description',
       'active'                      
        ];
}