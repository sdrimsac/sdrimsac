<?php

namespace Modules\Restaurant\Http\Controllers;

use App\CoreFacturalo\Requests\Api\Transform\Functions;
use App\Http\Controllers\Tenant\WhatsappController;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemUnitType;
use Barryvdh\DomPDF\Facade as PDF;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Restaurant\Models\Area;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Item\Models\CategoryItem;
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
use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\Observation;
use App\Events\MessageEvent;
use App\Jobs\PrintOrderJob;
use App\Models\Tenant\Cash;
use App\Models\Tenant\ItemSet;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Warehouse;
use Illuminate\Support\Str;
use Modules\Restaurant\Events\StockRealEvent;
use Modules\Restaurant\Models\UserScheduleAppointment;

class OrdenController extends Controller
{
    public function changeOrder(Request $request)
    {
        $user = auth()->user();
        $user_name = $user->name;
        $orden = Orden::find($request->orden_id);
        $table = Table::find($request->table_id);
        $table_old = Table::find($orden->table_id);
        $orden->table_id = $table->id;
        $orden->save();
        $table->status_table_id = 2;
        $table->save();

        $message = "El usuario " . $user_name . " cambió la orden: " . $orden->id . " de la mesa " . $table_old->number . " a la mesa " . $table->number;
        $ordens = Orden::where('table_id', $table_old->id)->where('status_orden_id', '<>', 4)->where('status_orden_id', '<>', 5)->get();
        if (count($ordens) == 0) {
            $table_old->status_table_id = 1;
            $table_old->save();
        }
        $caja_area_id = Area::getAreaCajaId();


        event(new MessageEvent($message, $caja_area_id));
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
        /* return compact('document'); */
        return [
            'success' => true,
            'document' => $document,
            'result' => $result,
        ];
    }
    public function printTicket(Request $request)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');
        $configuration = Configuration::first();
        $precuenta = $request->precuenta ?? false;
        $is_restaurant = $configuration->restaurant;
        $show_unit_ticket = $configuration->show_unit_types_ticket;
        $company = Company::first();
        $orden = $request->id;
        $ordens_items_extern = explode("_", $request->ids);
        $area_id = $request->area_id;
        $mozo_id = $request->mozo_id;
        $area_desc = null;
        $mozo_name = $request->mozo_name ?? null;
        $zone_name = $request->zone_name ?? null;
        $es_anulacion = $request->cancelled ?? false;
        $es_anulacion_item = $request->cancel_orden_item;
        /* dump($es_anulacion_item); */
        $to_kitchen = false;
        if ($precuenta) {
            $to_kitchen = true;
        }

        if ($area_id) {
            $area = Area::find($area_id);
            if ($area) {
                $area_desc = $area->description;
                $desc = strtoupper($area_desc);
            }
        }

        if ($mozo_id) {
            $mozo = DB::connection('tenant')->table('seller_mozo')->where('id', $mozo_id)->first();
            if ($mozo) {
                $mozo_name = $mozo->name;
            }
        }
        $ordenes = Orden::where('id', $request->id)->first();

        $all_orden_items = [];
        if ($ordenes) {
            $all_orden_items = OrdenItem::where('orden_id', $ordenes->id)
            ->pluck('id')
            ->toArray();
        }

        $requested_items = explode("_", $request->ids);

        $is_partial_cancellation = !empty($all_orden_items) && 
            count(array_diff($all_orden_items, $requested_items)) > 0;

        if ($ordenes == null) {
            if ($es_anulacion) {
            $ordenes = new Orden();
            $ordenes->id = $request->id;
            $ordenes->status_orden_id = 5;
            } else {
            return [
                "success" => false,
                "message" => "Nº Pedido no existe..."
            ];
            }
        } else {
            // Set cancellation flags
            $es_anulacion = $es_anulacion || $ordenes->status_orden_id == 5;
            $es_anulacion_item = $is_partial_cancellation;
        }

        if (!$zone_name && $ordenes && $ordenes->table_id) {
            $table = Table::find($ordenes->table_id);
            if ($table && $table->zone) {
                $zone_name = $table->zone->name;
            }
        }

        $ordenItem = OrdenItem::where('orden_id', $request->id)->first();

        if (!$ordenItem && $es_anulacion) {

            $user = auth()->user();
            $establishment = Establishment::where('id', $user->establishment_id)->first();
        } else if ($ordenItem) {
            $user = User::findOrFail($ordenItem->user_id);
            $establishment = Establishment::where('id', $user->establishment_id)->first();
        } else {

            $user = auth()->user();
            $establishment = Establishment::where('id', $user->establishment_id)->first();
        }

        $ordens = OrdenItem::where('orden_id', $orden);

        $diff_ordens = [];
        $orden_items = OrdenItem::whereIn('id', $ordens_items_extern)->get()->groupBy(function ($elemento) use (&$diff_ordens) {
            $diff_ordens[] = $elemento->orden_id;
            return $elemento->food_id . '-' . $elemento->price . '-' . $elemento->observations;
        })->map(function ($grupo) {

            $cantidadTotal = $grupo->sum('quantity');
            return $grupo->first()->forceFill(['quantity' => $cantidadTotal]);
        });
        // eliminar los elementos repetidos de $diff_ordens
        $diff_ordens = array_unique($diff_ordens);
        $two_or_more = count($diff_ordens) > 1;
        $to_carry = [];
        $users = [];
        $date = null;
        $orden_item_length = 0;

        // Process order items
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

        // Calculate PDF height
        $height = 8 * 30;

        if ($ordens->count() == 1) {
            $height = $height + $ordens->count() * 50;
        } else {
            $height = $height + ($ordens->count() * 30);
        }
        if ($es_anulacion) {
            $height += 50;
        }

        if ($configuration->text_comanda) {
            $height += 100;
        }
        $mozo_name = $request->mozo_name ?? null;
        if (!$mozo_name && $ordenes && $ordenes->mozo_id) {
            $mozo = DB::connection('tenant')
                ->table('seller_mozo')
                ->where('id', $ordenes->mozo_id)
                ->first();
            if ($mozo) {
                $mozo_name = $mozo->name;
            }
        }

        try {
            $pdf = PDF::loadView('restaurant::ordens.ticket', compact(
                'two_or_more',
                'is_restaurant',
                'precuenta',
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
                'orden_items',
                'mozo_name',
                'zone_name',
                'es_anulacion',
                'es_anulacion_item',
            ))
                ->setPaper(array(0, 0, 249.45, $height));
        } catch (Exception $e) {
            /* \Log::error('Línea 268 - Error en el proceso: ' . $e->getMessage()); */
            return ['m' => $e->getMessage()];
        }
        $timestamp = Carbon::now()->format('YmdHis');

        if ($configuration->android_configuration) {
            $filePath = storage_path('app/public/' . $timestamp . '_orden_.pdf');
            $pdf->save($filePath);

            return response()->download(
                $filePath,
                $timestamp . '_orden_.pdf',
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $timestamp . '_orden_.pdf"'
                ]
            );
        } else {
            return $pdf->stream($timestamp . '_orden_.pdf');
        }
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
        $mozo_id = $request->mozo_id;
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
        if ($mozo_id) {
            $mozo = DB::connection('tenant')->table('seller_mozo')->where('id', $mozo_id)->first();
            if ($mozo) {
                $mozo_name = $mozo->name;
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
                'orden_items',
                'mozo_name'
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
        $user = User::where('id', auth()->user()->id)->first();
        $cash_id =  $user->get_cash_id();
        $cash = Cash::find($cash_id);

        //if no exists cash return collection empty
        if (!$cash) {
            $emptyCollection = new Collection();
            $paginated = new LengthAwarePaginator($emptyCollection, 0, 10);

            return new OrdenCollection($paginated);
        }

        $ordens = Orden::query();
        $ordens = $ordens->where('created_at', '>=', $cash->created_at);
        if ($request->value) {
            $ordens = $ordens->where('id', 'like', '%' . $request->value . '%');
        }

        $cash = $request->cash == 'true' ? true : false;
        if ($cash) {
            /** @var User $user */
            $user = auth()->user();
            $user_cash_id = $user->get_cash_id();
            $ordens = $ordens
                ->whereNotNull('customer_id')
                ->whereHas('mesa', function ($q) {
                    $q->where('number', 'like', '%CAJA%');
                })

                ->where(function ($query) use ($user_cash_id) {
                    $query->whereHas(
                        'document',
                        function ($q) use ($user_cash_id) {
                            $q->where('cash_id', $user_cash_id);
                        }
                    )
                        ->orWhereHas(
                            'salenote',
                            function ($q) use ($user_cash_id) {
                                $q->where('cash_id', $user_cash_id);
                            }
                        );
                });
        }
        return new OrdenCollection($ordens->orderBy('created_at', 'desc')->paginate(10));
    }

    /* public function ordenskitchen(Request $request)
    {
        // Get the latest open cash register from users in the 'CAJA' area
        $current_cash = Cash::whereNull('time_closed')
            ->whereHas('user', function ($query) {
                $query->whereHas('area', function ($q) {
                    $q->where('description', 'like', '%CAJ%'); 
                });
            })
            ->latest()
            ->first();

        // If no open cash register exists, return empty collection
        if (!$current_cash) {
            $emptyCollection = new Collection();
            $paginated = new LengthAwarePaginator($emptyCollection, 0, 10);
            return new OrdenCollection($paginated);
        }

        // Get all orders created since cash register opened
        $ordens = Orden::query()
            ->where('created_at', '>=', $current_cash->date_opening);

        // Filter by order ID if search value provided 
        if ($request->value) {
            $ordens->where('id', 'like', '%' . $request->value . '%');
        }

        $user = auth()->user();

        // Only get orders that have items for current user's area
        $ordens->whereHas('orden_items', function ($q) use ($user) {
            $q->where('area_id', $user->area_id);
        });

        // Return paginated results ordered by newest first
        return new OrdenCollection(
            $ordens->orderBy('created_at', 'desc')
                   ->paginate(10)
        );
    } */

    public function ordenskitchen(Request $request)
    {

        $current_cash = Cash::whereNull('time_closed')
            ->where('state', 1)
            ->whereHas('user', function ($query) {
                $query->whereHas('area', function ($q) {
                    $q->where('description', 'like', '%CAJ%');
                });
            })
            ->latest()
            ->first();

        if (!$current_cash) {
            return new OrdenCollection(new LengthAwarePaginator([], 0, 10));
        }

        $ordens = Orden::query()
            ->where('created_at', '>=', $current_cash->date_opening);

        if ($request->value) {
            $ordens->where('id', 'like', '%' . $request->value . '%');
        }

        $user = auth()->user();
        $ordens->whereHas('orden_items', function ($q) use ($user) {
            $q->where('area_id', $user->area_id);
        });

        return new OrdenCollection(
            $ordens->orderBy('created_at', 'desc')
                ->paginate(10)
        );
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
    public function recordWorker($id, Request $request)
    {
        $orden = Orden::find($id);
        $print_pos = $request->printpos ?? false;
        $precuenta = $request->precuenta ?? false;
        $to_kitchen = $request->to_kitchen;
        $establishment = Establishment::findOrFail(auth()->user()->establishment_id);
        $user = auth()->user();
        $printer = null;

        // Optimizamos cómo obtenemos mozo_name y zone_name
        $mozo_name = null;
        $zone_name = null;

        if ($orden) {
            // Obtenemos el nombre del mozo
            if ($orden->mozo_id) {
                $mozo = DB::connection('tenant')
                    ->table('seller_mozo')
                    ->where('id', $orden->mozo_id)
                    ->first();
                $mozo_name = $mozo ? $mozo->name : null;
            }

            // Obtenemos el nombre de la zona directamente de la relación table->zone
            if ($orden->table_id) {
                $zone = DB::connection('tenant')
                    ->table('tables as t')
                    ->join('zones as z', 't.zone_id', '=', 'z.id')
                    ->where('t.id', $orden->table_id)
                    ->select('z.name')
                    ->first();

                $zone_name = $zone ? $zone->name : null;
            }
        }

        if (!$to_kitchen) {
            $area_id = $user->area_id;
            $area = Area::find($area_id);
        } else {
            $area = Area::where('description', 'like', '%COCIN%')->first();
            $area_id = $area->id;
        }
        if ($print_pos) {
            $area_pos_id = Area::getCajaAreaIdByTableId($orden->table_id);
            $area = Area::find($area_pos_id);
            $area_id = $area_pos_id;
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

            // Asignamos los valores al objeto orden
            $orden->mozo_name = $mozo_name;
            $orden->zone_name = $zone_name;

            event(new PrintEvent($orden->id, "00", true, $area_id, $orden_items, false, $precuenta));
            return [
                'success' => true,
                'data' => $orden,
                'printer' => $printer,
                'direct_printing' => (bool) $establishment->direct_printing,
                'printer_serve' => $establishment->printer_serve,
                'print'   => url('') . "/caja/worker/print-ticket?id={$id}&ids={$ids_string}&area_id={$area_id}&precuenta={$precuenta}&mozo_name={$mozo_name}&zone_name={$zone_name}"
            ];
        }
    }
    public function record($id, Request $request)
    {
        $orden = Orden::find($id);
        $precuenta = $request->precuenta ?? false;
        $to_kitchen = $request->to_kitchen;
        $establishment = Establishment::findOrFail(auth()->user()->establishment_id);
        $user = auth()->user();
        $printer = null;
        // Optimizamos la obtención del nombre del mozo y la zona
        $mozo_name = null;
        $zone_name = null;

        if ($orden) {
            // Obtenemos el nombre del mozo
            if ($orden->mozo_id) {
                $mozo = DB::connection('tenant')
                    ->table('seller_mozo')
                    ->where('id', $orden->mozo_id)
                    ->first();
                $mozo_name = $mozo ? $mozo->name : null;
            }

            // Obtenemos el nombre de la zona directamente mediante una consulta JOIN
            if ($orden->table_id) {
                $zone = DB::connection('tenant')
                    ->table('tables as t')
                    ->join('zones as z', 't.zone_id', '=', 'z.id')
                    ->where('t.id', $orden->table_id)
                    ->select('z.name')
                    ->first();

                $zone_name = $zone ? $zone->name : null;
            }
        }

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

            // Asignamos los valores al objeto orden
            $orden->mozo_name = $mozo_name;
            $orden->zone_name = $zone_name;

            return [
                'success' => true,
                'data' => $orden,
                'printer' => $printer,
                'direct_printing' => (bool) $establishment->direct_printing,
                'printer_serve' => $establishment->printer_serve,
                'print'   => url('') . "/caja/worker/print-ticket?id={$id}&ids={$ids_string}&area_id={$area_id}&precuenta={$precuenta}&mozo_name={$mozo_name}&zone_name={$zone_name}"
            ];
        }
    }
    public function order($id)
    {
        $orden = Orden::find($id);
        return compact('orden');
    }

    public function store(Request $request)
    {
        try {
            $user = null;
            $ref = $request->ref;
            $mozo_id = $request->mozo_id;
            $sale_direct = $request->saleDirect ?? true;
            $configuration = Configuration::first();
            if ($request->caja == false && $configuration->pin_switch) {
                $pin = $request->pin;
                if (!$pin) {
                    return [
                        'success' => false,
                        'message' => 'Pin incorrecto'
                    ];
                }
                $user = User::where('pin', $pin)->first();
                if (!$user) {
                    return [
                        'success' => false,
                        'message' => 'Pin incorrecto'
                    ];
                }
            } else {
                $user = User::find(auth()->id());
            }

            if ($configuration->sales_stock) {
                $user = auth()->user();

                // Obtener el almacén del usuario según su establecimiento
                $establishment_warehouse = Warehouse::where('establishment_id', $user->establishment_id)->first();

                if (!$establishment_warehouse) {
                    return [
                        'success' => false,
                        'message' => 'No existe un almacén para su establecimiento. Contacte al administrador.'
                    ];
                }

                foreach ($request->items as $item) {
                    $food = Food::find($item['food']['id']);

                    // Validar que el producto tenga un item asociado
                    if (!$food->item) {
                        return [
                            'success' => false,
                            'message' => "El producto {$food->description} no tiene un item asociado"
                        ];
                    }

                    // Saltar validación de stock para servicios (type ZZ)
                    if ($food->item->unit_type_id === 'ZZ') {
                        continue;
                    }

                    // Validar que el producto esté activo
                    if (!$food->item->active) {
                        return [
                            'success' => false,
                            'message' => "El producto {$food->description} está desactivado y no puede ser vendido"
                        ];
                    }

                    // Verificar si el código interno comienza con "PACK000" o "PLAT000" (es una receta)
                    if (Str::startsWith($food->item->internal_id, ['PACK000', 'PLAT000'])) {
                        // Obtener los productos individuales que componen la receta
                        $item_set = ItemSet::where('item_id', $food->item_id)->get();

                        foreach ($item_set as $row) {
                            $ingredient = Item::find($row->individual_item_id);

                            // Obtener el stock del ingrediente en el almacén del usuario
                            $warehouse_stock = ItemWarehouse::where([
                                'item_id' => $ingredient->id,
                                'warehouse_id' => $establishment_warehouse->id,
                                'active' => 1
                            ])->value('stock') ?? 0;

                            // Calcular la cantidad requerida del ingrediente
                            $required_quantity = floatval($row->quantity) * floatval($item['quantity']);

                            if ($required_quantity > $warehouse_stock) {
                                return [
                                    'success' => false,
                                    'message' => "El ingrediente {$ingredient->description} de la receta {$food->description} solo tiene {$warehouse_stock} unidades disponibles en el almacén {$establishment_warehouse->description}, y se requieren {$required_quantity}"
                                ];
                            }
                        }
                    } else {
                        $warehouse_stock = ItemWarehouse::where([
                            'item_id' => $food->item_id,
                            'warehouse_id' => $establishment_warehouse->id,
                            'active' => 1
                        ])->value('stock') ?? 0;

                        $ordered_quantity = $item['quantity'];

                        if ($ordered_quantity > $warehouse_stock) {
                            return [
                                'success' => false,
                                'message' => "El producto {$food->description} solo tiene {$warehouse_stock} unidades disponibles en el almacén {$establishment_warehouse->description}"
                            ];
                        }
                    }
                }
            }

            // Optimizar la búsqueda de orden
            $id = null;
            if ($configuration->commands_fisico) {
                $orden = Orden::where('commands_fisico', $request->commands_fisico)->first();
                $id = $orden ? $orden->id : null;
            } else if ($request->id) {
                $orden = Orden::find($request->id);
                $id = $orden ? $orden->id : null;
            }

            $new_orden = collect($request->orden);
            $new_orden->put('status_orden_id', $new_orden->get('status_orden_id', 1));

            $items = $request->items;
            if (empty($items)) {
                return [
                    'success' => false,
                    'message' => 'No se puede guardar una orden sin items'
                ];
            }

            $user_id = $user->id;
            $message = 'Pedido realizado.';
            $establishment_id = auth()->user()->establishment_id;

            // Optimizar la búsqueda y creación de mesa
            if ($request->caja && $sale_direct) {
                $table = Table::firstOrCreate(
                    [
                        'number' => 'caja',
                        'establishment_id' => $establishment_id
                    ],
                    [
                        'area_id' => auth()->user()->area_id,
                        'status_table_id' => 2
                    ]
                );
            } else if ($request->orden) {
                $table = Table::where('id', $request->orden['table_id'])
                    ->update(['status_table_id' => 2]);
                $table = Table::find($request->orden['table_id']);
            }

            $orden = null;
            if ($id != null) {
                $orden = Orden::find($id);
                $orden->ref = $ref;
                $orden->mozo_id = $mozo_id; // Solo guardamos el ID

                $table = Table::find($orden->table_id);
                if ($table->is_room) {
                    $hotel_rent_item = DB::connection('tenant')->table('hotel_rent_items')->where('table_id', $table->id)->latest('id')->first();
                    if ($hotel_rent_item) {
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
                $orden->mozo_id = $mozo_id; // Solo guardamos el ID
                $orden->to_carry = $request->to_carry;
                $orden->commands_fisico = $request->commands_fisico;

                if ($request->caja == true) {
                    $orden->table_id = $table->id;
                }
                $table = Table::find($orden->table_id);
                $table->status_table_id = 2;
                if ($table->is_room) {
                    $hotel_rent_item = DB::connection('tenant')->table('hotel_rent_items')->where('table_id', $table->id)->latest('id')->first();
                    if ($hotel_rent_item) {
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

            $orden_items = collect($items)->map(function ($item) use ($orden, $user_id) {
                return [
                    'food_id' => $item['food']['id'],
                    'observations' => $item['observation'] ?? '-',
                    'quantity' => $item['quantity'],
                    'unit_type_id' => Functions::valueKeyInArray($item, 'type_id', null),
                    'price' => $item['price'],
                    'user_id' => $user_id,
                    'orden_id' => $orden->id,
                    'to_carry' => Functions::valueKeyInArray($item, 'to_carry', 0),
                    'status_orden_id' => 1,
                    'date' => Carbon::today(),
                    'time' => date('H:i:s'),
                    'area_id' => $item['food']['area_id']
                ];
            });

            // Inserción masiva y obtención de IDs
            DB::beginTransaction();
            try {
                $food_ids = $orden_items->pluck('food_id')->toArray();

                OrdenItem::insert($orden_items->toArray());

                // Obtener solo los items recién creados usando los food_ids
                $created_items = OrdenItem::where('orden_id', $orden->id)
                    ->whereIn('food_id', $food_ids)
                    ->select('id', 'food_id', 'area_id')
                    ->latest('id')
                    ->take(count($food_ids))
                    ->get();

                $orden_items_ids = $created_items->pluck('id')->toArray();

                $orden_items_ids_for_kitchen = $created_items->map(function ($item) {
                    return ['orden_id' => $item->id, 'area_id' => $item->area_id];
                })->toArray();

                // Actualizar stock en batch si es posible
                foreach ($created_items as $item) {
                    $item->stockRestaurant();
                    event(new OrdenEvent($item->id));
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

            if ($request->add_charge_room) {
                $food = $this->get_item_service();
                $orden_item = new OrdenItem;
                $orden_item->food_id = $food->id;
                $orden_item->observations = '-';
                $orden_item->quantity = 1;
                // $orden_item->unit_type_id = 'ZZ';
                $orden_item->price = 5;
                $orden_item->user_id = $user_id;
                $orden_item->orden_id = $orden->id;
                $orden_item->to_carry = 0;
                $orden_item->status_orden_id = 1;
                $orden_item->date = Carbon::today();
                $orden_item->time = date('H:i:s');
                $orden_item->area_id = $food->area_id;
                $orden_item->save();
                $orden_item->stockRestaurant();
            }

            $print_box = $configuration->print_commands;
            $print_kitchen = $configuration->print_kitchen;
            $conopy_kitchen = $configuration->conopy_kitchen;

            if ($conopy_kitchen) {
                $ids_areas = array_unique(array_column($orden_items_ids_for_kitchen, "area_id"));
                foreach ($ids_areas as $area_id) {
                    $filtered = array_column(array_filter($orden_items_ids_for_kitchen, function ($a) use ($area_id) {
                        return $area_id == $a['area_id'];
                    }), "orden_id");
                    $area_found = Area::find($area_id);
                    if ($area_found->printer || $area_found->search_print == 1) {
                        // Print to kitchen and box area
                        if ($area_found->description == 'COCINA') {
                            dispatch(new PrintOrderJob($orden->id, "0", true, $area_id, $filtered, null, null, null, $user_id, url('')));
                            dispatch(new PrintOrderJob($orden->id, "0", true, $this->getBoxArea(), $filtered, null, null, null, $user_id, url('')));
                        } else {
                            dispatch(new PrintOrderJob($orden->id, "0", true, $area_id, $filtered, null, null, null, $user_id, url('')));
                        }
                    }
                }
            } else {
                if ($print_kitchen) {
                    $ids_areas = array_unique(array_column($orden_items_ids_for_kitchen, "area_id"));
                    foreach ($ids_areas as $area_id) {
                        $filtered = array_column(array_filter($orden_items_ids_for_kitchen, function ($a) use ($area_id) {
                            return $area_id == $a['area_id'];
                        }), "orden_id");
                        $area_found = Area::find($area_id);
                        if ($area_found->printer || $area_found->search_print == 1) {
                            dispatch(new PrintOrderJob($orden->id, "0", true, $area_id, $filtered, null, null, null, $user_id, url('')));
                        }
                    }
                }
                /* if ($print_box) {
                    dispatch(new PrintOrderJob($orden->id, "0", true, $this->getBoxArea(), $orden_items_ids, null, null, null, $user_id, url('')));
                } */
            }

            $isFromBox = $this->isArea("CAJ", $user->area_id);

            if ($print_box) {
                dispatch(new PrintOrderJob($orden->id, "0", true, $this->getBoxArea(), $orden_items_ids, null, null, null, $user_id, url('')));

                // event(new PrintEvent($orden->id, "0", true, $this->getBoxArea(), $orden_items_ids));
            }
            // if ($isFromBox == false && $print_box) {
            //     event(new PrintEvent($orden->id, "0", true, $user->area_id, $orden_items_ids));
            // }
            if ($request->appointment_id) {
                $appointment = UserScheduleAppointment::find($request->appointment_id);
                $appointment->orden_id = $orden->id;
                $appointment->save();
            }

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
        } catch (Exception $e) {
            if ($e->getMessage() != null) {

                Log::info($e->getMessage());
            }
            if ($e->getLine() != null) {

                Log::info($e->getLine());
            }
            if ($orden) {
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

    function get_item_service()
    {
        $item = Item::where('unit_type_id', 'ZZ')
            ->where('description', 'Servicio')
            ->first();
        if ($item) {
            $food = Food::where('item_id', $item->id)->first();
            return $food;
        } else {
            $configuration = Configuration::first();
            $affectation_igv_type_id = $configuration->affectation_igv_type_id;
            $item = Item::create(
                [
                    'stock' => 0,
                    'attributes' => [],
                    'item_type_id' => '01',
                    'unit_type_id' => 'ZZ',
                    'internal_id' => '000ZZ',
                    'description' => 'Servicio',
                    'currency_type_id' => 'PEN',
                    'sale_unit_price' => '1.00',
                    'sale_affectation_igv_type_id'  => $affectation_igv_type_id,
                    'purchase_affectation_igv_type_id' => $affectation_igv_type_id,
                ]
            );
            $category_food_id = CategoryItem::first()->id;
            $food = Food::create([
                'item_id' => $item->id,
                'description' => 'Servicio',
                'price' => '1.00',
                'category_food_id' => $category_food_id,
                'active' => true,
            ]);

            return $food;
        }
    }
    function getBoxArea()
    {
        $establishment_id = auth()->user()->establishment_id;
        $user_box = User::whereHas('area', function ($query) {
            $query->where('description', 'like', '%CAJ%');
        })->where('establishment_id', $establishment_id)->first();
        if ($user_box) {
            $area_box = $user_box->area;
            return $area_box->id;
        }
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
    public function cancelOrdenHotel(Request $request)
    {
        $id = $request->id;

        $items = OrdenItem::where('orden_id', $id)->get();
        foreach ($items as $item) {
            //cancelar orden
            $items_message[] = $item->info_item();
            $item->delete();
            event(new OrdenCancelEvent($item->id));
        }
        $orden = Orden::find($id);
        $orden->delete();

        return ['success' => true, 'message' => 'Orden cancelada con éxito.'];
    }

    public function cancelOrden(Request $request)
    {
        $configuration = Configuration::first();
        if ($configuration->image_comand) {
            $id = $request->id;
            $reason = $request->reason;
            $user = auth()->user();
            $pin = $request->pin;
            $printer = null;
            $precuenta = $request->precuenta ?? false;
            $to_kitchen = $request->to_kitchen;

            // Validate PIN if required
            if ($configuration->pin_orden_delete) {
                if ($user->pin != $pin) {
                    return [
                        'success' => false,
                        'message' => 'Pin incorrecto'
                    ];
                }
            }

            // Get order and items
            $orden = Orden::find($id);
            if (!$orden) {
                return [
                    'success' => false,
                    'message' => 'Orden no encontrada'
                ];
            }

            DB::connection('tenant')->table('ordens')
                ->where('id', $id)
                ->update([
                    'status_orden_id' => 5,
                    'reason' => $reason,
                ]);

            $orden = Orden::find($id);

            // Get items grouped by area_id
            $items_by_area = OrdenItem::where('orden_id', $id)
                ->get()
                ->groupBy('area_id');

            $items_message = [];
            $print_data = [];

            // Process items for each area
            foreach ($items_by_area as $area_id => $items) {
                $orden_items_ids = $items->pluck('id')->toArray();
                $area = Area::find($area_id);

                // Get printer for this area
                $printer = $area ? $area->printer : null;
                if (!$printer) {
                    $establishment = Establishment::findOrFail(auth()->user()->establishment_id);
                    $printer = $establishment->printer;
                }

                // Get mozo and zone info for printing
                $mozo_name = null;
                if ($orden->mozo_id) {
                    $mozo = DB::connection('tenant')
                        ->table('seller_mozo')
                        ->where('id', $orden->mozo_id)
                        ->first();
                    $mozo_name = $mozo ? $mozo->name : null;
                }

                $zone_name = null;
                if ($orden->table_id) {
                    $zone = DB::connection('tenant')
                        ->table('tables as t')
                        ->join('zones as z', 't.zone_id', '=', 'z.id')
                        ->where('t.id', $orden->table_id)
                        ->select('z.name')
                        ->first();
                    $zone_name = $zone ? $zone->name : null;
                }

                $ids_string = implode("_", $orden_items_ids);

                // Trigger print event for this area
                event(new PrintEvent($orden->id, "00", true, $area_id, $orden_items_ids, true));

                $print_data[] = [
                    'area_id' => $area_id,
                    'printer' => $printer,
                    'print_url' => url('') . "/caja/worker/print-ticket?id={$id}&ids={$ids_string}&area_id={$area_id}" .
                        "&precuenta=false&mozo_name={$mozo_name}&zone_name={$zone_name}"
                ];
            }

            // Update status and process items
            OrdenItem::where('orden_id', $id)->update(['status_orden_id' => 5]);

            foreach ($items_by_area as $items) {
                foreach ($items as $item) {
                    $items_message[] = $item->info_item();
                    event(new OrdenCancelEvent($item->id));
                }
            }

            // Send WhatsApp notification if enabled
            if ($configuration->send_whatsapp_activity && $configuration->pin_orden_delete) {
                try {
                    (new WhatsappController)->sendMessageAll($orden->info_to_message($items_message, $reason));
                } catch (Exception $e) {
                    //\Log::error('WhatsApp notification error: ' . $e->getMessage());
                }
            }

            // Update table status if needed
            $table_id = $orden->table_id;
            if ($table_id) {
                $remaining_orders = Orden::where('status_orden_id', '!=', 5)
                    ->where('table_id', $table_id)
                    ->count();

                if ($remaining_orders == 0) {
                    $table = Table::find($table_id);
                    $table->status_table_id = 1;
                    $table->save();
                }
            }

            event(new OrdenPendingEvent(-1));

            $establishment = Establishment::findOrFail(auth()->user()->establishment_id);

            return [
                'success' => true,
                'message' => 'Orden cancelada con éxito.',
                'print_data' => $print_data,
                'data' => $orden,
                'direct_printing' => (bool) $establishment->direct_printing,
                'printer_serve' => $establishment->printer_serve,
            ];
        } else {
            // Original code for when image_comand is false
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
                $items_message[] = $item->info_item();
                $item->delete();
                event(new OrdenCancelEvent($item->id));
            }
            $orden = Orden::find($id);
            if ($configuration->send_whatsapp_activity && $configuration->pin_orden_delete) {
                try {
                    (new WhatsappController)->sendMessageAll($orden->info_to_message($items_message, $reason));
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
            $orden_items = OrdenItem::where('orden_id', $orden->id)->get();
            /** 
        @var OrdenItem $item 
             */
            foreach ($orden_items as $item) {
                $item->restoreRestaurant();
                $item->delete();
            }
            // OrdenItem::where('orden_id', $orden->id)->delete();
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
    public function tables()
    {
        $areas = Area::all();

        return compact('areas');
    }
    // Método auxiliar para obtener el nombre del mozo
    /* private function getMozoName($mozo_id)
    {
        if (!$mozo_id) return null;

        $mozo = DB::connection('tenant')
            ->table('seller_mozo')
            ->select('name')
            ->where('id', $mozo_id)
            ->first();

        return $mozo ? $mozo->name : null;
    }
    private function getZoneNameFromTable($table_id)
    {
        if (!$table_id) {
            return null;
        }

        try {
            $table = Table::find($table_id);

            if (!$table || !$table->zone_id) {
                return null;
            }

            $zone = DB::connection('tenant')
                ->table('zones')
                ->where('id', $table->zone_id)
                ->first();

            return $zone ? $zone->name : null;
        } catch (\Exception $e) {
            \Log::error('Error getting zone name from table: ' . $e->getMessage());
            return null;
        }
    } */
}
