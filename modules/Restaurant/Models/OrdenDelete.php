<?php

namespace Modules\Restaurant\Models;

  use App\Models\Tenant\ModelTenant;

class OrdenDelete extends ModelTenant
{

    public $timestamps = false;
    protected $table = "ordens_delete";

    protected $fillable = [
        'orden_id',
        'orden_item_id',
        'reason',
        'data',
       
    ];
}
