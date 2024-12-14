<?php

namespace Modules\Item\Models;

use App\Models\Tenant\Item;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\User;

class Brand extends ModelTenant
{

    protected $fillable = [ 
        'name',
    ];
 
    public function items()
    {
        return $this->hasMany(Item::class);
    }
public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
 

}