<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\Establishment;
use App\Models\Tenant\ModelTenant;


class Zone extends ModelTenant
{

    public $timestamps = false;
    protected $table = "zones";
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $fillable = [
        'name',
        'active',
        'establishment_id'
      
    ];

    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }
}
