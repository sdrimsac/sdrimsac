<?php

namespace App\Models\Tenant;


class CategoriaMadera extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'categoria_madera';
    protected $fillable = [
        'id', 
        'description',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}