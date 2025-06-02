<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

class Category extends ModelTenant
{
    protected $table="categogies_purchases"; 
    protected $primarykey="id";
    protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [
        'item_id',          
        'description',
        'active'  
    ];
}
