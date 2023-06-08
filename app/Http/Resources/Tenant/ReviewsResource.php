<?php
namespace App\Http\Resources\Tenant;
use App\Models\Tenant\Module;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResource extends JsonResource
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
                'date_latest_reviews' => $this->date_latest_reviews,
                'date_next_reviews'   => $this->date_next_reviews,
                'description'         => $this->description,
                'vehicle_id'          => $this->vehicle_id,
            
            ];
    }
}