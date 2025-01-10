<?php

namespace App\Models\System;
use Hyn\Tenancy\Traits\UsesSystemConnection;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use UsesSystemConnection;


    protected $fillable = [
        'name',
        'number',
        'business_id',
        'telephone',
        'direccion',
        'direccion_secondary', 
        'email', 
        'ruc', 
        'user',
        'password',
        'user_secondary',
        'password_secondary',
        'password_certificate',
        'date_certificate',  
    ];

    /* protected $casts = [
        'establishments_unlimited' => 'boolean',
        'establishments_limit' => 'int',
        'sales_unlimited' => 'boolean',
        'sales_limit' => 'float',
        'include_sale_notes_sales_limit' => 'boolean',
    ]; */

    public function business()
    {
        return $this->hasMany(Business::class);
    }
    
}
