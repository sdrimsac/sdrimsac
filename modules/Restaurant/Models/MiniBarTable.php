<?php

namespace Modules\Restaurant\Models;


use App\Models\Tenant\ModelTenant;

class MiniBarTable extends ModelTenant
{

    public $timestamps = false;
    protected $table = "minibar_tables";
    protected $fillable = [
        'table_id',
        'description',
        'active',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

}   
