<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\Cash;
use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\User;

class CashOpeningBalance extends ModelTenant
{

    public $timestamps = false;
    protected $table = 'cash_opening_balances';
    protected $fillable = [
        'cash_id',
        'user_id',
        'method',
        'amount',
    ];
    public function cash()
    {
        return $this->belongsTo(Cash::class, 'cash_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}