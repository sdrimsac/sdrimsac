<?php

namespace Modules\Etiquetas\Models;



use App\Models\Tenant\ModelTenant;

class MurcielagoPalabras extends ModelTenant
{

    protected $table = "murcielago_palabras";
    protected $fillable = [
        'palabra'
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
