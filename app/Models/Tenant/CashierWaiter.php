<?php

namespace App\Models\Tenant;


use Illuminate\Foundation\Auth\User as Authenticatable;



class CashierWaiter extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'tenant';
    protected $table = 'cashier_waiter';
    protected $fillable = [
        'cashier_id',
        'waiter_id',
        'establishment_id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }
}
