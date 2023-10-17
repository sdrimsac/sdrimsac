<?php

namespace Modules\Restaurant\Models;
use App\Models\Tenant\ModelTenant;


class Floor extends ModelTenant
{

    public $timestamps = false;
    protected $table = "floors";
    protected $with = ['tower'];
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $fillable = [
        'name',
        'tower_id',
        'active',
      
    ];

    public function tower()
    {
        return $this->belongsTo(Tower::class);
    }
}
