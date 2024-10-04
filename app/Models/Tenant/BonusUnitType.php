<?php

namespace App\Models\Tenant;


class BonusUnitType extends ModelTenant
{
    // public $incrementing = false;
    // public $timestamps = false;
    protected $table = 'bonus_unit_type';

    protected $fillable = [
        'description',
        'qty_min',
        'qty_max',
        'qty_free',
    ];
}