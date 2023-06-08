<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class PaymentCondition extends ModelTenant
{
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'days',
        'is_locked',
        'is_active',
    ];
}
