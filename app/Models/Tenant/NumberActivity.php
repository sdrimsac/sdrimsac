<?php

namespace App\Models\Tenant;

class NumberActivity extends ModelTenant
{   
    public $timestamps = false;
    protected $table = "numbers_activity";
    protected $fillable = [
    
        'number',
    ];

    
}