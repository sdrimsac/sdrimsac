<?php

namespace Modules\Restobar\Models;
use App\Models\Tenant\ModelTenant;


class TableType extends ModelTenant
{

    public $timestamps = false;
    protected $table = "table_types";
    protected $casts = [
        'active' => 'boolean',
        'price' => 'float'
    ];
    protected $fillable = [
        'name',
        'active',
        'price'
      
    ];
}
