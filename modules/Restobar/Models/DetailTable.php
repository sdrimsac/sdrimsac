<?php

namespace Modules\Restobar\Models;
use App\Models\Tenant\ModelTenant;


class DetailTable extends ModelTenant
{

    public $timestamps = false;
    protected $table = "detail_tables";
 
    protected $fillable = [
        'description',
        'active',
    ];
}
