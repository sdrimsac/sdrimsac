<?php

namespace Modules\Restobar\Models;
use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Person;

class CustomerAddresses extends ModelTenant
{

    public $timestamps = false;
    //protected $with = ['customer_addresses'];
    protected $fillable = [
        'customer_id',
        'address',
        'reference',
        'alias',
        'telephone',
        'status',
        'created_at',
        'updated_at',
    ];
    
    public function persons()
    {
        return $this->belongsTo(Person::class);
    }
}