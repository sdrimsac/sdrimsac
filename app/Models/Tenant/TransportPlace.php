<?php

namespace App\Models\Tenant;

class TransportPlace extends ModelTenant
{

    protected $table = "transport_places";

    protected $fillable = [
        'id',
        'plate',
        'vehicle',
        'active',
        'created_at',
        'updated_at',
    ];
    public function customer()
    {
        return $this->belongsTo(Person::class, 'customer_id');
    }
}
