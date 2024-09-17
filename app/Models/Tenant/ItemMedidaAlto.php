<?php

namespace App\Models\Tenant;


class ItemMedidaAlto extends ModelTenant
{
    /* public $timestamps = false; */
    protected $table = 'categoria_madera_medida_alto';
    protected $fillable = [
        'id',
        'alto',
        'categoria_madera_id', 
    ];
    public function categoriamadera()
    {
        return $this->belongsTo(CategoriaMadera::class);
    }
}