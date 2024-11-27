<?php

namespace Modules\Workshop\Models;

use App\Models\Tenant\ModelTenant;

use Modules\Workshop\Models\servicesDetails;

class HistorialServicesDetails extends ModelTenant
{
    protected $table = 'historial_services_details';
    
    protected $fillable = [
        'services_detail_id',
        'historial_id',
    ];
    public function serviceDetail(){
        return $this->belongsTo(servicesDetails::class,'services_detail_id');
    }
    
}