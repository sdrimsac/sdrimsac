<?php

namespace Modules\Workshop\Models;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Customer;
use App\Models\Tenant\Person;

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
        'active',
    ];
    public function customer(){
        return $this->belongsTo(Person::class,'customer_id' , 'id');
    }
    public function tipo_vehiculo(){
        return $this->belongsTo(TipoVehiculo::class,'tipo_vehiculo_id');
    }
    public function person(){
        return $this->hasMany(Person::class,'person_id');
    }
    public function historial() {
        return $this->hasMany(Historial::class,'vehiculo_id');
    }

}