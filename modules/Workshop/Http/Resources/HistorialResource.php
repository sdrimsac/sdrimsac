<?php

namespace Modules\Workshop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistorialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'vehiculo_id' => $this->vehiculo_id,
            'salenote_id' => $this->salenote_id,
            'document_id' => $this->document_id,
            'personal_id' => $this->personal_id,
            'personal_name' => $this->personal ? $this->personal->name : null,
            'observacion' => $this->observacion,
            'motive' => $this->motive,
            'reparacion' => $this->reparacion,
            'garantia' => $this->garantia,
            'mantenimiento' => $this->mantenimiento,
            'diagnostico' => $this->diagnostico,
            'estado' => $this->estado,
            'vehicle_features' => $this->getVehicleFeaturesAttribute(),
            'services_details' => $this->getServicesDetailsAttribute()
        ];
    }
    
    public function getVehicleFeaturesAttribute()
    {
        return $this->vehicleFeatures()->where('historial_id', $this->id)->get();
    }

    public function getServicesDetailsAttribute()
    {
        return $this->servicesDetails()->get();
    }
}