<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Vault extends ModelTenant
{
    protected $table="vault";         //nombre tabla
    protected $hidden = ["created_at", "updated_at"];   
    protected $primarykey="id";
    protected $fillable = [
        'date',                      // subcategoria  
        'amount',
        'destination',
        'movement'
        
    ];
}
