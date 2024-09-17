<?php

namespace App\Models\Tenant;


class ItemCategoriaMadera extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'Item_categoria_madera';
    protected $fillable = [
        'id',
        'categoria_madera_id',
        'item_id',
        'precio', 
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function categoriamadera()
    {
        return $this->belongsTo(CategoriaMadera::class);
    }
}