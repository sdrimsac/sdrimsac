<?php
namespace App\Http\Resources\Tenant;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TravelCollection extends ResourceCollection
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
                   'id'                    => $row->id,
                   'destination'           => $row->destination,
                   'mileage'               => $row->mileage,
                   'price'                 => $row->price,
                   'carga'                 => $row->carga,
                   'travel_date'           => $row->travel_date,
                   'vehicle_id'            => $row->vehicle_id,
               ];
           });
    }
}