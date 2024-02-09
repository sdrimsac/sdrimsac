<?php

namespace Modules\Restaurant\Http\Resources;

use App\Models\Tenant\HotelRent;
use App\Models\Tenant\HotelRentDocument;
use Carbon\Carbon;
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
        $hotel_rent_id = $this->hotel_rent_id;
        $has_services = $this->services->count() > 0;
        $advances_document = 0;
        $documents = HotelRentDocument::where('hotel_rent_id', $hotel_rent_id)->get()
            ->transform(function ($row) {
                $document = $row->document ? $row->document : $row->sale_note;
                $is_sale_note = $row->document ? false : true;
                $external_id = $document->external_id;
                $url = "print/document/$external_id/ticket";
                if ($is_sale_note) {
                    $url = "sale-notes/print/$external_id/ticket";
                }
                $date_of_issue = $document->date_of_issue;
                //si date_of_issue es string lo convierto a date
                if (is_string($date_of_issue)) {
                    $date_of_issue = Carbon::parse($date_of_issue);
                }
                return [
                    'id' => $row->id,
                    'number' => $document->number_full,
                    'pdf' => url($url),
                    'total' => $document->total,
                    'date_of_issue' => $date_of_issue->format('Y-m-d'),

                ];
            });
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
        $price_table = $this->table->price;
        $extra_time = 0;
        $checkout_date_estimated = Carbon::parse($this->checkout_date_estimated . " " . $this->checkout_time_estimated);
        $now = Carbon::now();
     
        if ($now->greaterThan($checkout_date_estimated)) {
            $difference_days = $checkout_date_estimated->diffInDays($now);
            if ($difference_days == 0) {
                $checkout_time_estimated = Carbon::parse($this->checkout_time_estimated);
                $now_time = Carbon::parse($now->format('H:i:s'));
                if ($now_time->greaterThan($checkout_time_estimated)) {
                    $extra_time = $price_table / 2;
                }
            }
            if ($difference_days > 0) {
                $extra_time = $price_table * $difference_days;
            }
        }
        // if ($checkout_date_estimated->greaterThan($now) && $checkout_date_estimated->diffInDays($now) <= 1

        // ) {
        //     $extra_time = $price_table / 2;
        // }else{
        //     $extra_time = $price_table * $checkout_date_estimated->diffInDays($now);
        // }
        $toPay = ($this->total +  $total_all_orden) > 0 ;
        $credit_line =0;
        if($this->credit_line > 0){
            $credit_line = $this->credit_line - $total_all_orden;
        }
        $tes = $this->total + $this->advances;
        return [
            'credit_line' => $credit_line,
            'has_services' => $has_services,
            'toPay' => $toPay,
            'extra_time' => $extra_time,
            'id' => $this->id,
            'documents' => $documents,
            'has_many_rooms' => $has_many_rooms,
            'hotel_rent_id' => $this->hotel_rent_id,
            'hotel_rent' => $this->hotel_rent,
            'checkout_date_estimated' => $this->checkout_date_estimated,
            'checkout_time_estimated' => $this->checkout_time_estimated,
            'guesses' => $guesses,
            'duration' => $this->duration,
            'quantity_persons' => $this->quantity_persons,
            'checkin_date' => $this->checkin_date,
            'checkin_time' => $this->checkin_time,
            'advance' => $this->advances,
            'ordens' => $ordens,
            'customer' => $customer,
            'total_room' => $this->total + $this->advances,
            'total_orden' => $total_all_orden,
            'total' => $this->total + $total_all_orden,
            'is_month_rent' => $this->is_month_rent,
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
