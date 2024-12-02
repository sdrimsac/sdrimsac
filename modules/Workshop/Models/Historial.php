<?php

namespace Modules\Workshop\Models;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemWarehouse;
use Modules\Workshop\Models\Vehiculo;
use Modules\Workshop\Models\HistorialServicesDetails;

class Historial extends ModelTenant
{
    protected $table = 'historial';
    
    protected $fillable = [
        'vehiculo_id',
        'sale_note_id',
        'document_id',
        'personal_id',
        'establishment_id',
        'observacion',
        'motive',
        'reparacion',
        'garantia',
        'mantenimiento',
        'diagnostico',
        'estado', 
        'filename'
    ];
    public function vehiculo(){
        return $this->belongsTo(vehiculo::class, 'vehiculo_id');
    }
    public function SaleNote(){
        return $this->belongsTo(SaleNote::class, 'sale_note_id');
    }
    public function document(){
        return $this->belongsTo(Document::class, 'document_id');
    }
    public function peronal(){
        return $this->belongsTo(WorkshopPersonal::class, 'personal_id');
    }
    public function establishment(){
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    public function personal(){
        return $this->belongsTo(WorkshopPersonal::class, 'personal_id');
    }
    public function historialItem(){
        return $this->hasMany(HistorialItem::class, 'historial_id');
    }
    public function vehicleFeatures()
    {
        return $this->hasMany(VehicleFeature::class, 'vehiculo_id', 'vehiculo_id');
    }
    public function servicesDetails(){
        return $this->belongsToMany(ServicesDetails::class, 'historial_service_details', 'historial_id', 'services_detail_id');
    }
    /* public function servicesDetails(){
        return $this->hasMany(HistorialServicesDetails::class);
    } */
    

}