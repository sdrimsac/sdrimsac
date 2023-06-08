<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

class Category extends ModelTenant
{
    protected $table="category";         //nombre tabla
    protected $primarykey="id";
    protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [
        'category',                      // categoria 
        'type'  
    ];
}
