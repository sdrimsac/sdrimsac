<?php
namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends ModelTenant
{
    protected $table="subcategories";         //nombre tabla
    protected $hidden = ["created_at", "updated_at"];   
    protected $primarykey="id";
    protected $fillable = [
        'subcategory',                      // subcategoria  
        'type'
    ];
}
