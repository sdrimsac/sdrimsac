<?php

namespace Modules\Etiquetas\Models;



use App\Models\Tenant\ModelTenant;

class Codigos extends ModelTenant
{

    protected $table = "codigos";
    protected $fillable = [
        'description'
    ];


    // public function category()
    // {
    //     return $this->belongsTo(CategoryItem::class, 'category_food_id');
    // }
    // public function item()
    // {
    //     return $this->belongsTo(Item::class);
    // }
    // public function area()
    // {
    //     return $this->belongsTo(Area::class);
    // }
}
