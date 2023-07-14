<?php

namespace Modules\Restaurant\Events;

use App\Models\Tenant\User;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use Illuminate\Support\Str;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use Modules\Restaurant\Models\Area;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Modules\Restaurant\Models\OrdenItem;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrintEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $data;
    public function __construct($id, $document_type = 0, $printing = true, $area_id = null, $ids = [])
    {

        $establishment = Establishment::findOrFail(auth()->user()->establishment_id);


        $format = 'ticket';
        if ($establishment->format_printer == 2) {
            $format = 'a5';
        }
        if ($establishment->format_printer == 4) {
            $format = 'ticket_50';
        }
        if ($establishment->format_printer == 1) {
            $format = 'a4';
        }
        $configuration = Configuration::first();
        $multiple_boxes = (bool) $configuration->multiple_boxes;

        if ($document_type == "0") {
            $orderItem = OrdenItem::where('orden_id', $id)->first();
            $user = User::where('id', $orderItem->user_id)->first();
            if ($multiple_boxes == true) {
                $area = Area::where('id', $user->area_id)->first();
            }
        } else {
            //   dd(auth()->user()->id);
            $user = User::where('id', auth()->user()->id)->first();
            $area = Area::where('id', $user->area_id)->first();
        }
        if ($area_id != null) {
            $area_printer = Area::findOrFail($area_id);
        } else {
            if (auth()->user()->type == 'admin' || auth()->user()->type == 'superadmin') {
                $area = Area::where('description', 'like', '%caja%')->first();
                $area_printer = Area::findOrFail($area->id);
            } else {
                $area_printer = Area::findOrFail(auth()->user()->area_id);
            }
        }
        if ($area_id == null) {
            $area_id = auth()->user()->area_id;
        }
        $ids_string = "";
        if (count($ids) != 0) {
            $ids_string = join("_", $ids);
        }
        $documentLink = null;
        switch ($document_type) {
            case "0":
                $documentLink = url('') . "/caja/worker/print-ticket?id={$id}&area_id={$area_id}&ids={$ids_string}";
                break;
            case "box":
                $documentLink = url('') . "/caja/worker/expenses/print-box?box_id={$id}&area_id={$area_id}";
                break;
            case "01":
                $doc = Document::where('id', $id)->first();
                $documentLink = url('') . "/print/document/{$doc->external_id}/{$format}";
                break;
            case "03":
                $doc = Document::where('id', $id)->first();
                $documentLink = url('') . "/print/document/{$doc->external_id}/{$format}";
                break;
            case "80":
                $doc = SaleNote::where('id', $id)->first();
                $documentLink = url('') . "/sale-notes/print/{$doc->external_id}/{$format}";
                break;
            case "CO":
                $doc = $id;
                $documentLink = url('') . $format == "a4" ? "/consignment/format/{$doc}" : "/consignment/format_ticket/{$doc}";
                break;
        }
        $printer = $area_printer->printer;
        if ($printer == null) {
            if ($area_printer->search_print) {
                $printer = $establishment->printer;
            } else {
                $printing = false;
            }
        }


        $this->data = array(
            'printer' => $printer,
            'printing' => $printing,
            'copies' => ($multiple_boxes == true && auth()->user()->type != 'admin') ? $area->copies : $establishment->copies,
            'direct_printing' => (bool) $establishment->direct_printing,
            'print'   => $documentLink,
            'multiple_boxes' => (bool) $configuration->multiple_boxes,
            'typeuser' => auth()->user()->type,
            'user_id' => $user->id,
            'area_id' => $area_id
        );
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return
            new Channel('print_orden');
    }


    public function broadcastAs()
    {
        $configuration = Configuration::first();
        $event_name = $configuration->socket_channel;
        if (!$event_name) {
            $configuration->socket_channel = Str::random(10);
            $configuration->save();
            $event_name = $configuration->socket_channel;
        }
        return 'print-order-' . $event_name;
    }
}
