<?php

namespace Modules\Workshop\Models;

use App\Models\Tenant\ModelTenant;

class HistorialServicesDetails extends ModelTenant
{
    protected $table = 'historial_service_details';

    protected $fillable = [
        'historial_id',
        'services_detail_id'
    ];

    public function historial()
    {
        return $this->belongsTo(Historial::class, 'historial_id');
    }

    public function serviceDetail()
    {
        return $this->belongsTo(ServicesDetails::class, 'services_detail_id');
    }
}