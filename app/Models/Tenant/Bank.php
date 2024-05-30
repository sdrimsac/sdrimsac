<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Bank extends ModelTenant
{

    protected $fillable = [
        'description',
        'image',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('active', function (Builder $builder) {
    //         $builder->where('active', 1);
    //     });
    // }
}
