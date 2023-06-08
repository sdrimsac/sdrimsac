<?php

namespace Modules\Inventory\Models;

use App\Models\Tenant\Item;
use App\Models\Tenant\ModelTenant;

class Category extends ModelTenant
{
    protected $hidden = ["created_at", "updated_at"];

    protected $fillable = [ 
        'name',
        'icono',
    ];
 
    public function items()
    {
        return $this->hasMany(Item::class);
    }
 

}