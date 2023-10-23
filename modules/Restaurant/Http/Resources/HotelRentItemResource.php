<?php

namespace Modules\Restaurant\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HotelRentItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $guesses = [];
        if ($this->guesses->isEmpty()) {
            $guess = $this->hotel_rent->customer;
            $guesses[] = [
                'name' => $guess->name,
                'number' => $guess->number,
            ];
        } else {
            foreach ($this->guesses as $guess) {
                $guesses[] = [
                    'name' => $guess->name,
                    'number' => $guess->number,
                ];
            }
        }

        return [
            'id' => $this->id,
            'hotel_rent_id' => $this->hotel_rent_id,
            'hotel_rent' => $this->hotel_rent,
            'guesses' => $guesses,
            'duration' => $this->duration,
            'quantity_persons' => $this->quantity_persons,
            'checkin_date' => $this->checkin_date,
            'checkin_time' => $this->checkin_time,
        ];
    }
}
