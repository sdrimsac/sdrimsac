<?php

namespace Modules\Dental\Models;

use App\Models\Tenant\Category;
use App\Models\Tenant\ModelTenant;
use Modules\Item\Models\CategoryItem;

class Tariff extends ModelTenant
{
    protected $table = "tariffs";
    protected $with = ["category"];
    protected $fillable = [
        'code',
        'process',                    //procedimiento
        'category',   
        'category_id',                //categoria_id
        'price',
        'discount',
        'measure',                    //medida
        'type_concept',               //tipo_concepto
        'state'                       //estado
    ];


    public function category()
    {
        return $this->belongsTo(CategoryItem::class);
    }
}