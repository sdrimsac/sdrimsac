<?php

namespace App\Models\Tenant;

use Modules\Restaurant\Models\Orden;

class CreditList extends ModelTenant
{
    protected $table="credit_lists";         //nombre tabla
    protected $fillable = [
        'customer_id',                      // categoria 
        'orden_id',
        'establishment_id',
        'paid',
        'observation',
        'user_id',  
        'paid',
    ];


    public function customer()
    {
        return $this->belongsTo(Person::class, 'customer_id');
    }

    public function orden()
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }
}
