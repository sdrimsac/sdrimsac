<?php

namespace Modules\Restaurant\Models;
use App\Models\Tenant\ModelTenant;


class TableType extends ModelTenant
{

    public $timestamps = false;
    protected $table = "table_types";
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $fillable = [
        'name',
        'active',
      
    ];
}
