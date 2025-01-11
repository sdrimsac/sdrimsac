<?php

namespace App\Models\System;
use Hyn\Tenancy\Traits\UsesSystemConnection;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use UsesSystemConnection;

    protected $table = 'business';
    protected $fillable = [
        'id',
        'description',
        
         
    ];
    
}
