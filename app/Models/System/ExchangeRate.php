<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
 
    protected $fillable = [
        'date',
        'purchase',
        'sale',
    ];
}