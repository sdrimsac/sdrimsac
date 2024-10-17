<?php

namespace Modules\Workshop\Models;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Customer;

class Vehiculo extends ModelTenant
{
    protected $table = 'vehiculos';
    
    protected $fillable = [
        'customer_id',
        'tipo_vehiculo_id',
        'marca',
        'modelo',
        'placa',
        'color',
        'motor',
        'serie',
        'anio_fabricacion',
        'kilometraje',
        'active'

    ];
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function tipo_vehiculo(){
        return $this->belongsTo(TipoVehiculo::class,'tipo_vehiculo_id');
    }

}