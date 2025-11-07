<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model; 

class SummaryCorrelative extends Model
{ 

    protected $table = "summary_correlatives";
    
    protected $fillable = [
        'ruc', 
        'type',
        'correlative',
        'origin_app',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;
}
