<?php

namespace Modules\Restaurant\Events;

use App\Models\Tenant\Company;
use App\Models\Tenant\ConfEstablishment;
use App\Models\Tenant\User;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use Illuminate\Support\Str;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Quotation;
use Modules\Restaurant\Models\Area;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Modules\Restaurant\Models\OrdenItem;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class PrintEventJob implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $data;
    public function __construct($id, $document_type = 0, $printing = true, $area_id = null, $ids = [], $isEmit = false, $isPrecuenta = false, $url = null, $user_id = null, $url_base = null)
    {

        if ($url_base == null) {
            $url_base = url('');
        }
        $configuration = Configuration::first();
        $company = Company::active();
        $current_user = User::findOrFail($user_id);
        $user_establishment_id_printer = $current_user->establishment_id;
        $zone_id = $area_id;
        if ($zone_id) {
            $id_by_zone = Area::getZoneEstablishmentJob($zone_id, $user_id);
            if ($id_by_zone) {
                $zone_id = $id_by_zone;
                if ($company->number == '10484420331') {
                    $area_id = $id_by_zone;
                }
            }
        }
        if ($company->number == '10484420331') {
            Log::info('zone_id:' . $zone_id);
            Log::info('area_id:' . $area_id);
        }

        /* $establishment = Establishment::findOrFail($current_user->establishment_id);
        $id_by_area = Area::getAreaEstablishmentJob($area_id,$user_id);
        $menaje_area = Area::where('description', 'MENAJE')->first();
        if (!($menaje_area && $area_id == $menaje_area->id)) {
            if ($id_by_area && $company->number != '10484420331') {
                $area_id = $id_by_area;
            }
        }
        if ($id_by_area && $company->number != '10484420331') {
            $area_id = $id_by_area;
        } */
       
        //para que se imprima en el area de menaje

        $establishment = Establishment::findOrFail($current_user->establishment_id);
        $id_by_area = Area::getAreaEstablishmentJob($area_id, $user_id);

        $menaje_area = Area::where('description', 'MENAJE')->first();

        if ($menaje_area && $area_id == $menaje_area->id) {

        } else {
            if ($id_by_area && $company->number != '10484420331') {
                $area_id = $id_by_area;
            }
        }

        $area_found = Area::find($area_id);
        if ($area_found) {
            if ($area_found->establishment_id != null) {
                $user_establishment_id_printer = $area_found->establishment_id;
            }
        }

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
        $multiple_boxes = (bool) $configuration->multiple_boxes;

        if ($document_type == "0") {
            $orderItem = OrdenItem::where('orden_id', $id)->first();
            $user = User::where('id', $orderItem->user_id)->first();
            if ($multiple_boxes == true) {
                $area = Area::where('id', $user->area_id)->first();
            }
        } else {
            //   dd(auth()->user()->id);
            $user = User::where('id', $user_id)->first();
            $area = Area::where('id', $user->area_id)->first();
        }
        if ($area_id != null && $area_id != 0) {
            $area_printer = Area::findOrFail($area_id);
        } else {
            $user = User::where('id', $user_id)->first();
            $isArca = $user->isWorkerType('arca');
            if ($current_user->type == 'admin' || $current_user->type == 'superadmin' || $isArca) {
                $area = Area::where('description', 'like', '%caja%')->first();

                $area_printer = Area::findOrFail($area->id);
            } else {
                $area_printer = Area::findOrFail($current_user->area_id);
            }
        }
        if ($area_id == null) {
            $area_id = $current_user->area_id;
        }
        $ids_string = "";
        if (count($ids) != 0) {
            $ids_string = join("_", $ids);
        }
        // $copies = 0;
        $documentLink = null;
        switch ($document_type) {
            case "URL1":
                $documentLink = $url;
                break;
            case "URL":
                //si $url inicia con http o https,  no se le agrega la url base
                if (strpos($url, 'http') === 0) {
                    $documentLink = $url;
                } else {
                    $documentLink = url('') . $url;
                }
                // $documentLink = url('') . $url;
            case "D":
                $documentLink = $url_base . "/caja/delivery/ticket?id={$id}&establishment_id={$establishment->id}";
                break;
            case "S":
                // $copies = 1;
                $documentLink = $url_base . "/credit-list/receipt/{$id}/ticket";
                break;
            case "H":
                $documentLink = $url_base . "/caja/rooms/print_service/{$id}";
                break;
            case "L":
                $documentLink = $url_base . "/caja/rooms/print_warranty/{$id}";
                break;
            case "00":
                $documentLink = $url_base . "/caja/worker/print-ticket?id={$id}&area_id={$zone_id}&ids={$ids_string}&precuenta={$isPrecuenta}";
                break;
            case "0":
                $documentLink = $url_base . "/caja/worker/print-ticket?id={$id}&area_id={$zone_id}&ids={$ids_string}";
                break;
            case "box":
                $documentLink = $url_base . "/caja/worker/expenses/print-box?box_id={$id}&area_id={$area_id}";
                break;
            case "01":
                $doc = Document::where('id', $id)->first();
                $documentLink = $url_base . "/print/document/{$doc->external_id}/{$format}";
                if ($configuration->android_configuration) {
                    sleep(15);
                }
                break;
            case "03":
                $doc = Document::where('id', $id)->first();
                $documentLink = $url_base . "/print/document/{$doc->external_id}/{$format}";
                if ($configuration->android_configuration) {
                    // sleep(15);
                }
                break;
            case "80":
                $doc = SaleNote::where('id', $id)->first();
                $documentLink = $url_base . "/sale-notes/print/{$doc->external_id}/{$format}";
                if ($configuration->android_configuration) {
                    // sleep(15);
                }
                break;
            case "CO":
                $doc = $id;
                $documentLink = $url_base . $format == "a4" ? "/consignment/format/{$doc}" : "/consignment/format_ticket/{$doc}";
                break;
            case "COL":
                $doc = $id;
                $documentLink = $url_base .  "/consignment/format_ticket_liquidated/{$doc}";
                break;
            case "COT":
                $doc = Quotation::where('id', $id)->first();
                $documentLink = $url_base .  "/quotations/print/{$doc->external_id}/{$format}";
                break;
        }
        $printer = $area_printer->printer;
        if ($printer == null) {
            if ($area_printer->search_print) {
                $printer = $establishment->printer;

                if ($printer) {
                    $area_with_printer = Area::where('printer', $printer)->first();
                    if ($area_with_printer) {
                        $area_id = $area_with_printer->id;
                    }
                }
            } else {
                $printing = false;
            }
        }
        $conf_establishment = ConfEstablishment::where('establishment_id', $establishment->id)->first();
        if ($conf_establishment && $conf_establishment->print_command == false && $document_type == "0" && $document_type == "00") {
            // Log::info('No se imprime el comando');
            $printing = false;
        }
        $copies = 0;
        if ($isEmit) {
            $copies = $area->copies;
        }
        $user_establishment_id = null;
        $user_area = User::where('area_id', $area_id)->first();
        if ($user_area) {
            $user_establishment_id = $user_area->establishment_id;
        }
        $isFromBox = $current_user->isWorkerType('caja');
        $data = array(
            'orden_id' => $id,
            'is_from_box' => $isFromBox,
            'document_type' => $document_type,
            'printer' => $printer,
            'printing' => $printing,
            'copies' => $copies,
            'direct_printing' => (bool) $establishment->direct_printing,
            'print'   => $documentLink,
            'multiple_boxes' => (bool) $configuration->multiple_boxes,
            'typeuser' => $current_user->type,
            'user_id' => $user->id,
            'area_id' => $area_id,
            'zone_id' => $zone_id,
            'user_establishment_id' => $user_establishment_id,
            'user_establishment_id_printer' => $user_establishment_id_printer,
        );
        $this->data = $data;

        // Log::info(json_encode($this->data));
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
