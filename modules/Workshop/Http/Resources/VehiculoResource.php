<?php

namespace Modules\Workshop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Workshop\Models\Historial;
use Modules\Workshop\Models\ServicesDetails;
use Modules\Workshop\Models\VehicleFeature;
use Modules\Workshop\Models\HistorialServicesDetails;

class VehiculoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $historial = Historial::where('estado', 0)
            ->where('vehiculo_id', $this->id)
            ->first();

        $vehicleFeatures = VehicleFeature::where('vehiculo_id', $this->id)->get();

        $servicesDetails = [];
        if ($historial) {
            $historialServiceDetails = HistorialServicesDetails::where('historial_id', $historial->id)->get();
            $servicesDetailsIds = $historialServiceDetails->pluck('services_detail_id');
            $servicesDetails = ServicesDetails::whereIn('id', $servicesDetailsIds)->get();
        }

        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer->name,
            'tipo_vehiculo_id' => $this->tipo_vehiculo_id,
            'tipo_vehiculo_description' => $this->tipo_vehiculo->name,
            'placa' => $this->placa,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'serie' => $this->serie,
            'color' => $this->color,
            'motor' => $this->motor,
            'anio_fabricacion' => $this->anio_fabricacion,
            'kilometraje' => $this->kilometraje,
            'historiales' => HistorialResource::collection($this->historiales),
            'vehicle_features' => $vehicleFeatures,
            'services_details' => $servicesDetails,
        ];
    }
}