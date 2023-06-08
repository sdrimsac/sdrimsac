<?php
namespace App\Http\Resources\Tenant;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewsCollection extends ResourceCollection
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
                'date_latest_reviews' => $row->date_latest_reviews,
                'date_next_reviews'   => $row->date_next_reviews,
                'description'         => $row->description,
                'vehicle_id'          => $row->vehicle_id,
                
            ];
        });
    }
}
