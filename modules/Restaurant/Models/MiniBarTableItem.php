<?php

namespace Modules\Restaurant\Models;


use App\Models\Tenant\ModelTenant;

class MiniBarTableItem extends ModelTenant
{

    public $timestamps = false;
    protected $table = "minibar_table_items";
    protected $fillable = [
        'minibar_table_id',
        'food_id',
        'price',
        'quantity',
        'active',
        
    ];

    public function minibar_table()
    {
        return $this->belongsTo(MiniBarTable::class);
    }
    public function food()
    {
        return $this->belongsTo(Food::class);
    }

}   
