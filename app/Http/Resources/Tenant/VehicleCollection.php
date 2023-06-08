<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VehicleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {

          

            return [
                'business_name'=> $row->business_name,
                'filming_plate'=> $row->filming_plate,
                'vehicle_class'=> $row->vehicle_class,
                'axle_number'=> $row->axle_number,
                'manufacturing_Year'=> $row->manufacturing_Year,
                'mark'=> $row->mark,
                'chassis_number'=> $row->chassis_number,
                'model'=> $row->model,
                'number_seats'=> $row->number_seats,
                'bodywork'=> $row->bodywork,
                'load_capacity'=> $row->load_capacity,
                'gallons'=> $row->gallons,
                'driver'=> $row->driver,
                'chassis'=> $row->chassis,
                'color'=> $row->color,
                'cylinders'=> $row->cylinders,
                'axles'=> $row->axles,
                'dry_weight'=> $row->dry_weight,
                'gross_weight'=> $row->gross_weight,
                'useful_load'=> $row->useful_load,
                'length'=> $row->length,
                'height'=> $row->height,
                'broad'=> $row->broad,
                'pineapples'=> $row->pineapples,
                'fuel'=> $row->fuel,
                'bodywork'=> $row->bodywork,
                'vehicle_insurance'=> $row->vehicle_insurance,
                'insurance_company'=> $row->insurance_company,
                'soat_number'=> $row->soat_number,
                'expiration_date'=> $row->soat_number,
                'soat_cost'=> $row->soat_cost,
                'driver_id' => $row->driver_id,
                'driver' => $row->driver,
            ];
        });
    }
}
