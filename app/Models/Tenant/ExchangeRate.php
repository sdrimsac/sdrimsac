<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends ModelTenant
{
 
    protected $fillable = [
        'date',
        'date_original',
        'purchase',
        'purchase_original',
        'sale',
        'sale_original',
    ];
}