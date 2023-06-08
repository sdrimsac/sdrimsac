<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class BillingCycle extends ModelTenant
{
    
    protected $fillable = [
        'date_time_start',
        'renew',
        'quantity_documents', 
    ];
    
 
}