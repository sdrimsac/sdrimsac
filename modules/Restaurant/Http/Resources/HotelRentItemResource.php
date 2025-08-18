<?php

namespace Modules\Restaurant\Http\Resources;

use App\Models\Tenant\Document;
use App\Models\Tenant\HotelRent;
use App\Models\Tenant\HotelRentDocument;
use App\Models\Tenant\HotelRentItem;
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
        $cancel_document = 0;
        $documents = HotelRentDocument::where('hotel_rent_id', $hotel_rent_id)->get()
            ->transform(function ($row) use (&$cancel_document){
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
                if($document->is_advance == 0){
                    $cancel_document += $document->total;
                }
                $document_variation_url = null;
                if($is_sale_note && $document->variation_document_id){
                    $document_variation = Document::find($document->variation_document_id);
                    $document_variation_url = url("print/document/{$document_variation->external_id}/ticket");
                }
                return [
                    'id' => $row->id,
                    'number' => $document->number_full,
                    'pdf' => url($url),
                    'total' => $document->total,
                    'date_of_issue' => $date_of_issue->format('Y-m-d'),
                    'document_variation_url' => $document_variation_url,

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
        // Only show orders on the active (is_reserve = 0) item for the same room (table).
        // If this item is a reservation, hide orders here; they will appear under the active item.
        $total_all_orden = 0;
        $ordens = collect([]);
        $orderItemIds = [];
        if (!$this->is_reserve) {
            // Agregar órdenes de todos los registros (reserva y no-reserva) de la misma habitación (table)
            $orderItemIds = HotelRentItem::query()
                ->where('table_id', $this->table_id)
                ->pluck('id')
                ->all();
        }

        if (!empty($orderItemIds)) {
            $ordens = Orden::whereIn('hotel_rent_item_id', $orderItemIds)
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
        }
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
    // Outstanding (Resta): usar total neto + ordenes + extra, sin restar documentos facturados aquí
    $outstanding = ($this->total + $total_all_orden + $extra_time);
    $toPay = $outstanding > 0;
        $credit_line =0;
        if($this->credit_line > 0){
            $credit_line = $this->credit_line - $total_all_orden;
        }
        $table_name = $this->table->getTableFullName();
        if($this->total == 0){
            $cancel_document = 0;
        }
        return [
            'active' => (bool) $this->active,
            'table_name' => $table_name,
            'discount_instead_services' => $this->discount_instead_services,
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
            // Precio real de la habitación = total (neto) + advances
            'total_room' => $this->total + $this->advances,
            'total_orden' => $total_all_orden,
            // Resta = total (neto) + órdenes + extra (sin descontar documentos facturados)
            'total' => $outstanding,
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
