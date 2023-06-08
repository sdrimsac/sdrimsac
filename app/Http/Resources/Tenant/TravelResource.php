<?php
namespace App\Http\Resources\Tenant;
use App\Models\Tenant\Module;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelResource extends JsonResource
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
                'destination' => $this->destination,
                'mileage'     => $this->mileage,
                'price'       => $this->price,
                'carga'       => $this->carga,
                'travel_date' => $this->travel_date,
                'vehicle_id'  => $this->vehicle_id,
                
            
            ];
    }
}