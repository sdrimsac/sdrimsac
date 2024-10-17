<?php

namespace Modules\Workshop\Models;

use App\Models\Tenant\ModelTenant;

class TipoVehiculo extends ModelTenant
{
    protected $table = 'tipo_vehiculo';
    
    protected $fillable = [
        'description'
    ];

}