<?php

namespace Modules\Billar\Models;

use App\Models\Tenant\ModelTenant;

class TarifaCasino extends ModelTenant
{
    protected $table = 'tarifa_casino';
    
    protected $fillable = [
        'hora',
        'media_hora',
        'cuarto_hora',
        'created_at',
        'updated_at',
    ];
}