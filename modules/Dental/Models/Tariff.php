<?php

namespace Modules\Dental\Models;

use App\Models\Tenant\Category;
use App\Models\Tenant\ModelTenant;




class Tariff extends ModelTenant
{
    protected $table = "tariffs";
    protected $with = ["category"];
    protected $fillable = [
        'code',
        'process',                    //procedimiento
        'category',                   //categoria
        'price',
        'discount',

        'measure',                    //medida
        'type_concept',               //tipo_concepto
        'state'                       //estado
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}