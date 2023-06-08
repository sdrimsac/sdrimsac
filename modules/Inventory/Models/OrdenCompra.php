<?php

namespace Modules\Inventory\Models;


use App\Models\Tenant\ModelTenant;

class OrdenCompra extends ModelTenant
{
    protected $hidden = [ "updated_at"];

    protected $fillable = [ 
        'ordc_total_monto',
        'ordc_status',
        
    ];
 
    
 

}