<?php

namespace Modules\Restaurant\Models;
use App\Models\Tenant\ModelTenant;


class Floor extends ModelTenant
{

    public $timestamps = false;
    protected $table = "floors";
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $fillable = [
        'name',
        'active',
      
    ];
}
