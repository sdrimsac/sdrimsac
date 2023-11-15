<?php

namespace Modules\Restaurant\Models;
use App\Models\Tenant\ModelTenant;


class TableMaintenance extends ModelTenant
{
    public $timestamps = false;
    protected $table = "table_maintenance";
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $fillable = [
        'table_id',
        'table_status_id',
        'start_time',
        'end_time',
        'active'
    ];
}
