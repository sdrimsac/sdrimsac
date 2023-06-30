<?php

namespace Modules\Consignment\Models;
 

use App\Models\Tenant\ModelTenant;

class ConsignmentPenalty extends ModelTenant
{
    protected $table = 'consignment_penalties'; 
    protected $fillable = [
        'description',
        'type',
        'amount',
    ];

}