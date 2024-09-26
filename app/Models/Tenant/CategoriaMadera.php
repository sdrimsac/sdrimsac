<?php

namespace App\Models\Tenant;


class CategoriaMadera extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'categoria_madera';
    protected $fillable = [
        'id',
        'description',
        'sum_totals',
        'ancho_default',
        'grosor_default',
        'largo_default',
    ];
    protected $casts = [
        'sum_totals' => 'boolean'
    ];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
