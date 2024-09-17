<?php

namespace App\Models\Tenant;

class ItemMedidaAncho extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'categoria_madera_medida_ancho';
    protected $fillable = [
        'id',
        'ancho',
        'categoria_madera_id',
    ];

    public function categoriamadera()
    {
        return $this->belongsTo(CategoriaMadera::class);
    }
}