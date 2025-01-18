
<?php

namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;


class Specialty extends ModelTenant
{
    protected $table = "specialties";
    protected $fillable = [
        'name',
        'description',                       //Descripcion
        'state',

    ];
}
