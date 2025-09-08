<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\Establishment;
use App\Models\Tenant\ModelTenant;


class Tower extends ModelTenant
{

    public $timestamps = false;
    protected $table = "towers";
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $fillable = [
        'name',
        'establishment_id',
        'active',
      
    ];
    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }
}
