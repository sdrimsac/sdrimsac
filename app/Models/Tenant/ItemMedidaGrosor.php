<?php

namespace App\Models\Tenant;


class ItemMedidaGrosor extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'categoria_madera_medida_grosor';
    protected $fillable = [
        'id',
        'grosor',
        'categoria_madera_id', 
    ];

    /* public function item()
    {
        return $this->belongsTo(Item::class);
    } */

    public function categoriamadera()
    {
        return $this->belongsTo(CategoriaMadera::class);
    }
}