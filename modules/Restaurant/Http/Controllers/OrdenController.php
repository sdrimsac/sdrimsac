<?php

namespace Modules\Restaurant\Http\Controllers;

use App\CoreFacturalo\Requests\Api\Transform\Functions;
use App\Http\Controllers\Tenant\WhatsappController;
use Exception;
use Carbon\Carbon;
use App\Models\Tenant\Box;
use App\Models\Tenant\User;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\SaleNoteItem;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemUnitType;
use Barryvdh\DomPDF\Facade as PDF;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Restaurant\Models\Area;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\Table;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Events\OrdenEvent;
use Modules\Restaurant\Events\PrintEvent;
use Modules\Restaurant\Events\OrdenCancelEvent;
use Modules\Restaurant\Events\OrdenPendingEvent;
use Modules\Restaurant\Http\Resources\ObservationCollection;
use Modules\Restaurant\Http\Resources\OrdenCollection;
use Modules\Restaurant\Http\Resources\OrdenItemCollection;
use Modules\Restaurant\Models\Observation;

class OrdenController extends Controller
{
    public function changeOrder(Request $request)
    {
        $orden = Orden::find($request->orden_id);
        $table = Table::find($request->table_id);
        $table_old = Table::find($orden->table_id);
        $orden->table_id = $table->id;
        $orden->save();
        $table->status_table_id = 2;
        $table->save();

        $ordens = Orden::where('table_id', $table_old->id)->where('status_orden_id', '<>', 4)->where('status_orden_id', '<>', 5)->get();
        if (count($ordens) == 0) {
            $table_old->status_table_id = 1;
            $table_old->save();
        }


        return [
            'success' => true,
            'message' => 'Orden cambiada',

        ];
    }
    public function observation_index()
    {
        return view('restaurant::configuration.observations');
    }
    public function observation_columns()
    {
        return [
            'description' => 'Descripción',
            'active'      => 'Estado'
        ];
    }
    public function observation_records(Request $request)
    {
        $observations = Observation::orderBy('created_at', 'desc')->paginate("20");

        return new ObservationCollection($observations);
    }
    public function print_last_document()
    {
        $establishment_id = auth()->user()->establishment_id;

        $result = null;
        $document = Document::where('establishment_id', $establishment_id)->latest('id')->first();
        $sale_note = SaleNote::where('establishment_id', $establishment_id)->latest('id')->first();
        if (!$document && !$sale_note) {

            return [
                "success" => false,
            ];
        }
        if ($document && $sale_note) {
            if ($document->created_at) {
                $document_date = Carbon::parse($document->created_at);
                $sale_note_date = Carbon::parse($sale_note->created_at);
                if ($document_date->gt($sale_note_date)) {
                    $result = $document;
                } else {
                    $result = $sale_note;
                }
            } else {
                $result = $sale_note;
            }
        } else {
            if (!$document) {
                $result = $sale_note;
            } else {
                $result = $document;
            }
        }


        // event(new PrintEvent($result->id, $result->document_type_id, true, 0));
        return compact('document');
    }
    public function printTicket(Request $request)
    {

        $configuration = Configuration::first();
        $is_restaurant = $configuration->restaurant;
        $show_unit_ticket = $configuration->show_unit_types_ticket;
        $company = Company::first();
        $orden = $request->id;
        $ordens_items_extern = explode("_", $request->ids);
        $area_id = $request->area_id;
        $area_desc = null;
        //   $to_kitchen = true; en true no es pa cocina
        $to_kitchen = true;
        if ($area_id) {
            $area = Area::find($area_id);
            if ($area) {
                $area_desc = $area->description;
                $desc = strtoupper($area_desc);
                if (!str_contains($desc, "CAJA")) {
                    $to_kitchen = false;
                }
            }
        }

        $ordenes = Orden::where('id', $request->id)->first();
        if ($ordenes == null) {
            return [
                "success" => false,
                "message" => "Nº Pedido no existe..."
            ];
        }
        $ordenItem = OrdenItem::where('orden_id', $ordenes->id)->first();
        $user = User::findOrFail($ordenItem->user_id);
        $establishment = Establishment::where('id', $user->establishment_id)->first();
        //

        $ordens = OrdenItem::where('orden_id', $orden);
        // if ($to_kitchen) {
        // }
        // $orden_items = OrdenItem::whereIn('id', $ordens_items_extern)->get();
        $orden_items = OrdenItem::whereIn('id', $ordens_items_extern)->get()->groupBy(function ($elemento) {
            return $elemento->food_id . '-' . $elemento->price;
        })->map(function ($grupo) {
            $cantidadTotal = $grupo->sum('quantity');
            return $grupo->first()->forceFill(['quantity' => $cantidadTotal]);
        });

        $to_carry = [];
        $users = [];
        $date = null;
        $orden_item_length = 0;
        foreach ($orden_items as $ord_itm) {
            if ($date == null) {

                $ord_time = $ord_itm->time;
                $date = join("/", array_reverse(explode("-", $ord_itm->date)),) . " " . $ord_time;
            }
            $ord_itm->desc_unit = $ord_itm->food->description;
            if ($ord_itm->unit_type_id != null) {
                $desc = ItemUnitType::find($ord_itm->unit_type_id);
                if ($desc) {
                    $ord_itm->desc_unit = $ord_itm->desc_unit . " - " . $desc->description;
                    if ($show_unit_ticket) {
                        $unds = floatval($desc->quantity_unit);
                        $ord_itm->desc_unit = $ord_itm->desc_unit . " X " . $unds;
                        $ord_itm->qty_unit = $ord_itm->quantity / $unds;
                        $ord_itm->price_unit = $ord_itm->price * $unds;
                    }
                }
            }
            $orden_item_length += strlen($ord_itm->desc_unit);
            if ($ord_itm->to_carry) {
                $to_carry[] = $ord_itm;
            }
            $user_name = $ord_itm->user->name;
            if (!in_array($user_name, $users)) {
                $users[] = $user_name;
            }
        }

        if ($date == null) {

            $date = Carbon::now()->format('d/m/y H:i:s');
        }


        $height = 8  * 30;

        if ($ordens->count() == 1) {
            $height = $height + $ordens->count() * 28;
        } else if ($ordens->count() > 12) {
            $height = $height + ($ordens->count() * 30);
        } else {
            $height = $height + $orden_item_length;
        }
        if($configuration->text_comanda){
            $height += 100;
        }

        // 

        try {
            $pdf = PDF::loadView('restaurant::ordens.ticket', compact(
                'is_restaurant',
                'configuration',
                'area_desc',
                'to_carry',
                'users',
                'to_kitchen',
                'establishment',
                'date',
                'company',
                'orden',
                'show_unit_ticket',
                'ordenes',
                'orden_items'
            ))
                ->setPaper(array(0, 0, 249.45, $height));
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }

        return $pdf->stream('pdf_file.pdf');
    }
    public function printTicket2(Request $request)
    {

        $configuration = Configuration::first();
        $is_restaurant = $configuration->restaurant;
        $show_unit_ticket = $configuration->show_unit_types_ticket;
        $company = Company::first();
        $orden = $request->id;
        $ordens_items_extern = explode("_", $request->ids);
        $area_id = $request->area_id;
        $area_desc = null;
        //   $to_kitchen = true; en true no es pa cocina
        $to_kitchen = true;
        if ($area_id) {
            $area = Area::find($area_id);
            if ($area) {
                $area_desc = $area->description;
                $desc = strtoupper($area_desc);
                if (str_contains($desc, "COCIN")) {
                    $to_kitchen = false;
                }
            }
        }

        $ordenes = Orden::where('id', $request->id)->first();
        if ($ordenes == null) {
            return [
                "success" => false,
                "message" => "Nº Pedido no existe..."
            ];
        }
        $ordenItem = OrdenItem::where('orden_id', $ordenes->id)->first();
        $user = User::findOrFail($ordenItem->user_id);
        $establishment = Establishment::where('id', $user->establishment_id)->first();
        //

        $ordens = OrdenItem::where('orden_id', $orden);
        // if ($to_kitchen) {
        // }
        $orden_items = OrdenItem::whereIn('id', $ordens_items_extern)->get();
        $reducedCollection = OrdenItem::whereIn('id', $ordens_items_extern)->get()->groupBy(['food_id', 'price']);


        $to_carry = [];
        $users = [];
        $date = null;
        $orden_item_length = 0;
        foreach ($orden_items as $ord_itm) {
            if ($date == null) {

                $ord_time = $ord_itm->time;
                $date = join("/", array_reverse(explode("-", $ord_itm->date)),) . " " . $ord_time;
            }
            $ord_itm->desc_unit = $ord_itm->food->description;
            if ($ord_itm->unit_type_id != null) {
                $desc = ItemUnitType::find($ord_itm->unit_type_id);
                if ($desc) {
                    $ord_itm->desc_unit = $ord_itm->desc_unit . " - " . $desc->description;
                    if ($show_unit_ticket) {
                        $unds = floatval($desc->quantity_unit);
                        $ord_itm->desc_unit = $ord_itm->desc_unit . " X " . $unds;
                        $ord_itm->qty_unit = $ord_itm->quantity / $unds;
                        $ord_itm->price_unit = $ord_itm->price * $unds;
                    }
                }
            }
            $orden_item_length += strlen($ord_itm->desc_unit);
            if ($ord_itm->to_carry) {
                $to_carry[] = $ord_itm;
            }
            $user_name = $ord_itm->user->name;
            if (!in_array($user_name, $users)) {
                $users[] = $user_name;
            }
        }

        if ($date == null) {

            $date = Carbon::now()->format('d/m/y H:i:s');
        }


        $height = 8  * 30;

        if ($ordens->count() == 1) {
            $height = $height + $ordens->count() * 28;
        } else if ($ordens->count() > 12) {
            $height = $height + ($ordens->count() * 30);
        } else {
            $height = $height + $orden_item_length;
        }

        // 

        try {
            $pdf = PDF::loadView('restaurant::ordens.ticket', compact(
                'is_restaurant',
                'configuration',
                'area_desc',
                'to_carry',
                'users',
                'to_kitchen',
                'establishment',
                'date',
                'company',
                'orden',
                'show_unit_ticket',
                'ordenes',
                'orden_items'
            ))
                ->setPaper(array(0, 0, 249.45, $height));
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }

        return $pdf->stream('pdf_file.pdf');
    }
    public function index()
    {
        $configuration = Configuration::first();

        return view('restaurant::ordens.index', compact('configuration'));
    }
    public function columns()
    {
        return [
            'date' => 'Fecha',
            'number' => 'Nº Orden',
            'customer_id' => 'Clientes'
        ];
    }
    public function ordenspending(Request $request)
    {

        $ordens = Orden::query();
        if ($request->value) {
            $ordens = $ordens->where('id', 'like', '%' . $request->value . '%');
        }
        return new OrdenCollection($ordens->where('status_orden_id', '<>', 4)->orderBy('created_at', 'desc')->paginate(10));
    }
    public function ordenslist()
    {
        $date = Carbon::now()->format('Y-m-d');
        $ordens = new OrdenCollection(Orden::whereDate('date', '=', $date)->get());
        return [
            'success' => true,
            'data' => $ordens
        ];
    }
    public function records(Request $request)
    {
        $configuration = Configuration::first();
        if ($request->column == 'date') {
            $date_value = Carbon::parse($request->value)->format('Y-m-d');
            $request->merge(['value' => $date_value]);
        }
        if ($request->column == 'client') {
            $records = Orden::whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->value}%")
                    ->orWhere('number', 'like', "%{$request->value}%");
            });
        } else {
            if ($request->id == "id") {
                if ($configuration->commands_fisico == 1) {
                    $records = Orden::where('commands_fisico', 'like', "%{$request->value}%");
                } else {
                    $records = Orden::where($request->column, 'like', "%{$request->value}%");
                }
            }
            $records = Orden::where($request->column, 'like', "%{$request->value}%");
        }
        return new OrdenCollection($records->paginate(100));
    }

    public function state(Request $request)
    {
        $id = $request->id;
        $orden = Orden::find($id);
        $orden->active = !$orden->active;
        $orden->save();
        return [
            'success' => true,
            'data' => $orden,
            'message' => 'Área ' . ($orden->active ? 'activada' : 'desactivada')
        ];
    }
    public function record($id, Request $request)
    {
        $orden = Orden::find($id);
        $to_kitchen = $request->to_kitchen;
        $establishment = Establishment::findOrFail(auth()->user()->establishment_id);
        $user = auth()->user();
        $printer = null;
        if (!$to_kitchen) {
            $area_id = $user->area_id;
            $area = Area::find($area_id);
        } else {
            $area = Area::where('description', 'like', '%COCIN%')->first();
            $area_id = $area->id;
        }

        if ($area != null) {
            $printer = $area->printer;
        }
        if ($printer == null) {
            $printer = $establishment->printer;
        }
        if ($orden == null) {
            return [
                'success' => false,
                'print'  => "Nº Orden no existe"
            ];
        } else {
            $orden_items = OrdenItem::where('orden_id', $id)->pluck('id')->toArray();
            $ids_string = "";
            if (count($orden_items) != 0) {
                $ids_string = join("_", $orden_items);
            }
            return [
                'success' => true,
                'data' => $orden,
                'printer' => $printer,
                'direct_printing' => (bool) $establishment->direct_printing,
                'printer_serve' => $establishment->printer_serve,
                'print'   => url('') . "/caja/worker/print-ticket?id={$id}&ids={$ids_string}&area_id={$area_id}"
            ];
        }
    }
    public function store(Request $request)
    {
        try {
            $customer_id_credit_list = $request->customer_id_credit_list;
            $user = User::query();
            $ref = $request->ref;
            $sale_direct = $request->saleDirect ?? true;
            $configuration = Configuration::first();
            // if ($configuration->commands_fisico == true) {
            //     $orden = Orden::where('commands_fisico', $request->commands_fisico)->where('status_orden_id', '4')->first();
            //     if ($orden !== null) {
            //         return [
            //             'success' => false,
            //             'message' => 'Nº de Comanda ya fue cobrada'
            //         ];
            //     }
            // }
            if ($request->caja == false && $configuration->pin_switch) {

                $pin = $request->pin;
                $user = User::where('pin', $pin)->first();
                if (!$user || !$pin) {
                    return [
                        'success' => false,
                        'message' => 'Pin incorrecto'
                    ];
                }
            } else {
                $user = User::where('id', auth()->user()->id)->first();
            }
            if ($configuration->commands_fisico == true) {
                $orden = Orden::where('commands_fisico', $request->commands_fisico)->first();
                if ($orden != null) {
                    $id = $orden->id;
                } else {
                    $id = null;
                }
            } else {
                if ($request->id != null) {
                    $orden = Orden::find($request->id);
                    if($orden){
                        $id = $orden->id;
                    }
                } else {
                    $id = null;
                }
            }
          

            $new_orden = collect($request->orden);

            //si new_orden no tiene status_orden_id por defecto es 1
            if (!$new_orden->has('status_orden_id')) {
                $new_orden->put('status_orden_id', 1);
            }

            $items = $request->items;
            $user_id = $user->id;
            $message = 'Pedido realizado.';
            $establishment_id = auth()->user()->establishment_id;
            if ($request->caja == true && $sale_direct == true) {
                $table = Table::where('number', "caja")
                    ->where('establishment_id', $establishment_id)
                    ->first();
                if ($table == null) {
                    $table = Table::firstOrNew(['id' => $request->table_id]);
                    $table->area_id = auth()->user()->area_id;
                    $table->number = 'caja';
                    $table->status_table_id = 2;
                    $table->establishment_id = $establishment_id;
                    $table->save();
                }
            } else {

                //   dd($request->all());
                $table = Table::find($request->orden['table_id']);
               
                $table->status_table_id = 2;
                $table->save();
            }

            //si la orden existe solo quiero agregar
            //los items
            $orden = null;
            if ($id != null) {
                $orden = Orden::find($id);
                $orden->ref = $ref;
                $table = Table::find($orden->table_id);
                if($table->is_room){
                    $hotel_rent_item = DB::connection('tenant')->table('hotel_rent_items')->where('table_id', $table->id)->latest('id')->first();
                    if($hotel_rent_item){
                        $orden->hotel_rent_item_id = $hotel_rent_item->id;
                    }
                }
                $message = 'Pedido agregado.'; //me refiero en punto de caja
                $orden->save();
                //creo la orden y guardo los items
            } else {
                $orden = new Orden;

                $orden = $orden->fill($new_orden->all());

                $orden->date = Carbon::today();
                $orden->ref = $ref;
                $orden->to_carry = $request->to_carry;
                $orden->commands_fisico = $request->commands_fisico;

                if ($request->caja == true) {
                    $orden->table_id = $table->id;
                }
                $table = Table::find($orden->table_id);
                $table->status_table_id = 2;
                if($table->is_room){
                    $hotel_rent_item = DB::connection('tenant')->table('hotel_rent_items')->where('table_id', $table->id)->latest('id')->first();
                    if($hotel_rent_item){
                        $orden->hotel_rent_item_id = $hotel_rent_item->id;
                    }
                }
                $table->save();
                $orden->save();
            }
            event(new OrdenPendingEvent(1));
            /* ----------------------------- */
            $orden_items_ids = [];
            $orden_items_ids_for_kitchen = [];
            foreach ($items as $item) {
                $orden_item = new OrdenItem;
                $orden_item->food_id = $item['food']['id'];
                $orden_item->observations = $item['observation'] ?? '-';
                $orden_item->quantity = $item['quantity'];
                $orden_item->unit_type_id = Functions::valueKeyInArray($item, 'type_id', null);
                $orden_item->price = $item['price'];
                $orden_item->user_id = $user_id;
                $orden_item->orden_id = $orden->id;
                $orden_item->to_carry = Functions::valueKeyInArray($item, 'to_carry', 0);
                $orden_item->status_orden_id = 1;
                $orden_item->date = Carbon::today();
                $orden_item->time = date('H:i:s');
                $orden_item->area_id = $item['food']['area_id'];
                $orden_item->save();
                $orden_items_ids[] = $orden_item->id;
                $orden_items_ids_for_kitchen[] = [
                    "orden_id" => $orden_item->id,
                    "area_id" => $orden_item->area_id
                ];
                event(new OrdenEvent($orden_item->id));
            }

            $print_box = $configuration->print_commands ;
            $print_kitchen = $configuration->print_kitchen;

            if ($print_kitchen) {
                $ids_areas = array_unique(array_column($orden_items_ids_for_kitchen, "area_id"));
                foreach ($ids_areas as $area_id) {
                    $filtered = array_column(array_filter($orden_items_ids_for_kitchen, function ($a) use ($area_id) {
                        return $area_id == $a['area_id'];
                    }), "orden_id");
                    event(new PrintEvent($orden->id, "0", true, $area_id, $filtered));
                }
            }
            $isFromBox = $this->isArea("CAJ", $user->area_id);

            if ($print_box) {
                event(new PrintEvent($orden->id, "0", true, $this->getBoxArea(), $orden_items_ids));
            }
            // if ($isFromBox == false && $print_box) {
            //     event(new PrintEvent($orden->id, "0", true, $user->area_id, $orden_items_ids));
            // }

            $id = strval($orden->id);
            $establishment = Establishment::findOrFail(auth()->user()->establishment_id);
            //$orden_items_ids
            return [
                'id' => $orden->id,
                'success' => true,
                'message' => $message,
                'ordenId' => $orden->id,
                'printer' => $establishment->printer,
                'copies' => $establishment->copies,
                'printer_serve' => $establishment->printer_serve,
                'direct_printing' => (bool) $establishment->direct_printing,
                //'print'   => url('') . "/restaurant/worker/print-ticket/{$id}"
            ];
            /* ----------------------------- */
        } catch (Exception $e) {
            if($e->getMessage()!=null){

                Log::info($e->getMessage());
            }
            if($e->getLine()!=null){

                Log::info($e->getLine());
            }
            if($orden){
                $ordens_items = OrdenItem::where('orden_id', $orden->id)->count();
                if ($ordens_items == 0) {
                    $orden->delete();
                    $table = Table::find($orden->table_id);
                    $table->status_table_id = 1;
                    $table->save();
                }
            }
            return [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ];
        }
    }
    function getBoxArea()
    {
        $area_box = Area::where('description', 'like', '%CAJ%')->first();

        if ($area_box != null) {
            return $area_box->id;
        }
        return null;
    }
    function isArea($name, $area_id)
    {
        $area = Area::find($area_id);
        if ($area) {
            $desc = strtoupper($area->description);
            $name = strtoupper($name);
            return str_contains($desc, $name);
        }
        return false;
    }
    public function cancelOrden(Request $request)
    {
        $configuration = Configuration::first();
        $id = $request->id;
        $reason = $request->reason;
        $user = auth()->user();
        $pin = $request->pin;
        if ($configuration->pin_orden_delete) {

            if ($user->pin != $pin) {
                return [
                    'success' => false,
                    'message' => 'Pin incorrecto'
                ];
            }
        }
        $items = OrdenItem::where('orden_id', $id)->get();
        $items_message = [];
        foreach ($items as $item) {
            //cancelar orden
            $items_message[] = $item->info_item();
            $item->delete();
            event(new OrdenCancelEvent($item->id));
        }
        $orden = Orden::find($id);
        if ($configuration->send_whatsapp_activity && $configuration->pin_orden_delete) {
            try {
                (new WhatsappController)->sendMessage($orden->info_to_message($items_message, $reason));
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' => 'Error al enviar mensaje de whatsapp'
                ];
            }
        }
        $orden->delete();
        $table_id = $orden->table_id;
        $ordens = Orden::where('status_orden_id', 1)->where('table_id', $table_id)->count();
        if ($ordens == 0) {
            $table = Table::find($table_id);
            $table->status_table_id = 1;
            $table->save();
        }
        event(new OrdenPendingEvent(-1));
        return ['success' => true, 'message' => 'Orden cancelada con éxito.'];
    }
    public function destroyorden($id)
    {
        $configuration = Configuration::first();
        if ($configuration->commands_fisico == 1) {
            $search = Orden::where('commands_fisico', $id)->first();
            if ($search !== null) {
                $orden = Orden::find($search->id);
            }
        } else {
            $orden = Orden::find($id);
        }
        if ($orden->document_id != null) {
            Document::where('orden_id', $orden->id)->delete();
        }
        if ($orden->sale_note_id != null) {
            SaleNote::where('orden_id', $orden->id)->delete();
        }
        Box::where('orden_id', $orden->id)->delete();
        $table_id = $orden->table_id;
        $ordens = Orden::where('status_orden_id', 1)->where('table_id', $table_id)->count();
        if ($ordens == 0) {
            $table = Table::find($table_id);
            $table->status_table_id = 1;
            $table->save();
        }

        if ($orden->sale_note_id == null || $orden->document_id == null) {
            OrdenItem::where('orden_id', $orden->id)->delete();
            $orden->delete();
        }
        event(new OrdenPendingEvent(-1));
        return ['success' => true, 'message' => 'Orden anulada con éxito.'];
    }

    public function finishOrden(Request $request)
    {


        $id = $request->id;
        $orden = Orden::find($id);
        $orden->status_orden_id = 4;

        $orden->save();

        //enviar evento pa eliminar las ordenes listas

        return [
            'success' => true,
            'message' => 'Orden finalizada'
        ];
    }
}
