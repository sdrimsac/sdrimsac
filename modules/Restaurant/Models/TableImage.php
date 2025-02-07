<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\ModelTenant;

class TableImage extends ModelTenant
{
    protected $fillable = [
        'table_id',
        'image_path',
        'order'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}