<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\Cash;
use App\Models\Tenant\ModelTenant;

class CashOrderSession extends ModelTenant
{
    protected $fillable = [
        'cash_id',
        'order_start_id',
        'order_end_id',
        'state',
        'user_id',
        'establishment_id',
        'created_at',
        'updated_at',
    ];
    public function orden()
    {
        //return $this->belongsTo(Orden::class);
        return $this->belongsTo(Orden::class, 'orden_id');
    }
    public function cash()
    {
        return $this->belongsTo(Cash::class, 'cash_id');
    }
}