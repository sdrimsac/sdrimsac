<?php

namespace Modules\Restaurant\Http\Resources;

use App\Models\Tenant\HotelRent;
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
        $customer = $this->setCustomer($this->hotel_rent->customer);
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
        $total_all_orden = 0;
        $ordens = Orden::where('hotel_rent_item_id', $this->id)
            ->whereNull('document_id')
            ->whereNull('sale_note_id')
            ->orderBy('created_at', 'desc')
            ->get()
            ->transform(function ($row) use (&$total_all_orden) {
                $total_orden = 0;

                return [
                    'id' => $row->id,
                    'paid' => $row->hasDocument(),

                    'document' => $row->getDocument(),
                    'number' => $row->id,
                    'date' => $row->created_at->format('d/m/Y H:i:s'),
                    'items' => $row->orden_items->transform(function ($item) use (&$total_orden, &$total_all_orden) {

                        $total = $item->price * $item->quantity;
                        $total_orden += $total;
                        $total_all_orden += $total;
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
            $has_many_rooms = $this->hotel_rent->has_many_rooms();
        return [
            'id' => $this->id,
            'has_many_rooms' => $has_many_rooms,
            'hotel_rent_id' => $this->hotel_rent_id,
            'hotel_rent' => $this->hotel_rent,
            'guesses' => $guesses,
            'duration' => $this->duration,
            'quantity_persons' => $this->quantity_persons,
            'checkin_date' => $this->checkin_date,
            'checkin_time' => $this->checkin_time,
            'advance' => $this->advances,
            'ordens' => $ordens,
            'customer' => $customer,
            'total_room' => $this->total + $this->advances,
            'total_orden' => number_format($total_all_orden, 2),
            'total' => number_format($this->total + $total_all_orden, 2),
        ];
    }


    function setCustomer($customer)
    {
        $name = $customer->name;
        $number = $customer->number;

        $complete_name = "";
        if ($number) {
            $complete_name = $number;
        }
        if ($name) {
            $complete_name = $complete_name . " - " . $name;
        }
        return $complete_name;
    }
}
