<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

class Group extends ModelTenant
{ 
    protected $hidden = ["created_at", "updated_at"];
    protected $table="group";         //nombre tabla
    protected $primarykey="id";
    protected $fillable = [
        'group',                      // grupo
        'type'  
        
    ];
}
