<?php

namespace Modules\Restaurant\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Restaurant\Models\Orden;

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
        $table_id = $this->table_id;
        $ordens = Orden::where('table_id', $table_id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->transform(function ($row) {
                $total_orden = 0;
                return [
                    'id' => $row->id,
                    'number' => $row->id,
                    'date' => $row->created_at->format('d/m/Y H:i:s'),
                    'items' => $row->orden_items->transform(function ($item) use (&$total_orden) {
                        $total = $item->price * $item->quantity;
                        $total_orden += $total;
                        return [
                            'id' => $item->id,
                            'name' => $item->food->description,
                            'quantity' => $item->quantity,
                            'price' => number_format($item->price, 2),
                            'total' => number_format($total, 2),
                        ];
                    }),
                    'total' => number_format($total_orden, 2),
                ];
            });
        return [
            'id' => $this->id,
            'hotel_rent_id' => $this->hotel_rent_id,
            'hotel_rent' => $this->hotel_rent,
            'guesses' => $guesses,
            'duration' => $this->duration,
            'quantity_persons' => $this->quantity_persons,
            'checkin_date' => $this->checkin_date,
            'checkin_time' => $this->checkin_time,
            'ordens' => $ordens,
        ];
    }
}
