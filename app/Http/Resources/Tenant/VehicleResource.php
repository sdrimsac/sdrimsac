<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Module;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
                'business_name'=> $this->business_name,
                'filming_plate'=> $this->filming_plate,
                'vehicle_class'=> $this->vehicle_class,
                'axle_number'=> $this->axle_number,
                'manufacturing_Year'=> $this->manufacturing_Year,
                'mark'=> $this->mark,
                'chassis_number'=> $this->chassis_number,
                'model'=> $this->model,
                'number_seats'=> $this->number_seats,
                'bodywork'=> $this->bodywork,
                'load_capacity'=> $this->load_capacity,
                'gallons'=> $this->gallons,
                'driver'=> $this->driver,
                'chassis'=> $this->chassis,
                'color'=> $this->color,
                'cylinders'=> $this->cylinders,
                'axles'=> $this->axles,
                'dry_weight'=> $this->dry_weight,
                'gross_weight'=> $this->gross_weight,
                'useful_load'=> $this->useful_load,
                'length'=> $this->length,
                'height'=> $this->height,
                'broad'=> $this->broad,
                'pineapples'=> $this->pineapples,
                'fuel'=> $this->fuel,
                'bodywork'=> $this->bodywork,
                'vehicle_insurance'=> $this->vehicle_insurance,
                'insurance_company'=> $this->insurance_company,
                'soat_number'=> $this->soat_number,
                'expiration_date'=> $this->soat_number,
                'soat_cost'=> $this->soat_cost,
                'driver_id' => $this->driver_id,
              
        ];
    }
}