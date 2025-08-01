<?php

namespace Modules\Restaurant\Models;
use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Person;

class Delivery extends ModelTenant
{

    public $timestamps = false;
    protected $fillable = [
        'customer_id',
        'table_id',
        'orden_id',
        'address',
        'reference',
        'telephone',
        'status',
        'created_at',
        'updated_at',
    ];
    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }
    public function persons()
    {
        return $this->belongsTo(Person::class);
    }
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}