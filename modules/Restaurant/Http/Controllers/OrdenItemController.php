<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\User;
use Barryvdh\DomPDF\Facade as PDF;
use Modules\Restaurant\Events\OrdenReadyEvent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Restaurant\Events\OrdenCancelEvent;
use Modules\Restaurant\Events\OrdenReadyListEvent;
use Modules\Restaurant\Events\PrintEvent;
use Modules\Restaurant\Http\Resources\OrdenItemCollection;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenDelete;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\Table;

class OrdenItemController extends Controller
{

    public function updateObservation(Request $request)
    {

        $id = $request->id;
        $observation = $request->observation;
        $orden = OrdenItem::find($id);

        $orden->observations  = $observation;
        $orden->save();
        return [
            'success' => true,
            'message' => 'Observación actualizada'
        ];
    }
    /* public function ordenDeletePin(Request $request)
    {
        $pin = $request->pin;
        $id = $request->id;
        $reason = $request->reason;
        $user = auth()->user();
        $configuration = Configuration::first();

        if ($user->pin == $pin) {
            try {
                $orden_item = OrdenItem::find($id);
                $orden = Orden::find($orden_item->orden_id);
                $orden_delete = new OrdenDelete();
                $orden_delete->orden_id = $orden_item->orden_id;
                $orden_delete->orden_item_id = $orden_item->id;
                $orden_delete->reason = $reason;
                $orden_delete->user_id = $user->id;
                $orden_delete->save();
                if ($configuration->send_whatsapp_activity) {
                    try {
                        // $result =  (new WhatsappController)->sendMessage($orden_item->info_to_message($reason));
                        (new WhatsappController)->sendMessageAll($orden_item->info_to_message($reason));
                    } catch (Exception $e) {
                        $orden_delete->delete();
                        return [
                            'success' => false,
                            'message' => 'Error al enviar mensaje de whatsapp'
                        ];
                    }
                }
                $orden_item->delete();
                $orden_count = Orden::where('id', $orden_item->orden_id)->count();
                if ($orden_count == 0) {
                    $orden_delete = Orden::findOrFail($orden_item->orden_id);
                    $orden_delete->delete();
                }
                event(new OrdenCancelEvent($id));
                $hasItems = OrdenItem::where('orden_id', $orden->id)->get();

                if ($hasItems->isEmpty()) {
                    $table_id = $orden->table_id;
                    $orden->delete();
                    $ordens = Orden::where('status_orden_id', 1)->where('table_id', $orden->table_id)->count();
                    if ($ordens == 0) {
                        $table = Table::find($table_id);
                        $table->status_table_id = 1;
                        $table->save();
                    }

                }
                return [
                    'success' => true,
                    'message' => 'Pedido cancelado con éxito'
                ];
            } catch (Exception $e) {

                return ['success' => false, 'message' => $e->getMessage()];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Pin incorrecto'
            ];
        }
    } */

    public function ordenDeletePin(Request $request)
    {
        $configuration = Configuration::first();
        if ($configuration->image_comand) {
            $pin = $request->pin;
            $id = $request->id;
            $reason = $request->reason;
            $user = auth()->user();
            $configuration = Configuration::first();

            if ($user->pin != $pin) {
                return [
                    'success' => false,
                    'message' => 'Pin incorrecto'
                ];
            }

            try {
                DB::beginTransaction();

                $orden_item = OrdenItem::findOrFail($id);
                $orden = Orden::findOrFail($orden_item->orden_id);

                $orden_delete = new OrdenDelete();
                $orden_delete->orden_id = $orden_item->orden_id;
                $orden_delete->orden_item_id = $orden_item->id;
                $orden_delete->reason = $reason;
                $orden_delete->user_id = $user->id;
                $orden_delete->save();

                $orden_item->status_orden_id = 5;
                $orden_item->save();
                $print_data = [];

                $area_id = $orden_item->area_id;
                $area = Area::find($area_id);
                $printer = $area ? $area->printer : null;

                if (!$printer) {
                    $establishment = Establishment::findOrFail(auth()->user()->establishment_id);
                    $printer = $establishment->printer;
                }
                $cancel_orden_item = 'true';
                event(new PrintEvent($orden->id, "00", true, $area_id, [$orden_item->id]));
                $print_data = [
                    'area_id' => $area_id,
                    'printer' => $printer,
                    'print_url' => url('') . "/caja/worker/print-ticket?id={$orden->id}&ids={$orden_item->id}&area_id={$area_id}&precuenta=false&cancel_orden_item={$cancel_orden_item}",
                ];

                if ($configuration->send_whatsapp_activity) {
                    try {
                        (new WhatsappController)->sendMessageAll($orden_item->info_to_message($reason));
                    } catch (Exception $e) {
                        DB::rollBack();
                        return [
                            'success' => false,
                            'message' => 'Error al enviar mensaje de WhatsApp'
                        ];
                    }
                }

                $hasActiveItems = OrdenItem::where('orden_id', $orden->id)
                    ->where('status_orden_id', '!=', 5)
                    ->exists();

                if (!$hasActiveItems) {

                    $orden->status_orden_id = 5;
                    $orden->save();

                    $table_id = $orden->table_id;
                    $remainingOrders = Orden::where('status_orden_id', '!=', 5)
                        ->where('table_id', $table_id)
                        ->count();
                    if ($remainingOrders == 0) {
                        $table = Table::find($table_id);
                        if ($table) {
                            $table->status_table_id = 1;
                            $table->save();
                        }
                    }
                }

                DB::commit();

                return [
                    'success' => true,
                    'print_data' => $print_data,
                    'printer' => $printer,
                    'message' => 'Pedido cancelado con éxito',


                ];
            } catch (Exception $e) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }
        } else {

            $pin = $request->pin;
            $id = $request->id;
            $reason = $request->reason;
            $user = auth()->user();
            $configuration = Configuration::first();

            if ($user->pin == $pin) {
                try {
                    $orden_item = OrdenItem::find($id);
                    $orden = Orden::find($orden_item->orden_id);
                    $orden_delete = new OrdenDelete();
                    $orden_delete->orden_id = $orden_item->orden_id;
                    $orden_delete->orden_item_id = $orden_item->id;
                    $orden_delete->reason = $reason;
                    $orden_delete->user_id = $user->id;
                    $orden_delete->save();
                    if ($configuration->send_whatsapp_activity) {
                        try {
                            // $result =  (new WhatsappController)->sendMessage($orden_item->info_to_message($reason));
                            (new WhatsappController)->sendMessageAll($orden_item->info_to_message($reason));
                        } catch (Exception $e) {
                            $orden_delete->delete();
                            return [
                                'success' => false,
                                'message' => 'Error al enviar mensaje de whatsapp'
                            ];
                        }
                    }
                    $orden_item->delete();
                    $orden_count = Orden::where('id', $orden_item->orden_id)->count();
                    if ($orden_count == 0) {
                        $orden_delete = Orden::findOrFail($orden_item->orden_id);
                        $orden_delete->delete();
                    }
                    event(new OrdenCancelEvent($id));
                    $hasItems = OrdenItem::where('orden_id', $orden->id)->get();

                    if ($hasItems->isEmpty()) {
                        $table_id = $orden->table_id;
                        $orden->delete();
                        $ordens = Orden::where('status_orden_id', 1)->where('table_id', $orden->table_id)->count();
                        if ($ordens == 0) {
                            $table = Table::find($table_id);
                            $table->status_table_id = 1;
                            $table->save();
                        }
                    }
                    return [
                        'success' => true,
                        'message' => 'Pedido cancelado con éxito'
                    ];
                } catch (Exception $e) {

                    return ['success' => false, 'message' => $e->getMessage()];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'Pin incorrecto'
                ];
            }
        }
    }

    public function ordenDelete($id)
    {
        try {
            $orden_item = OrdenItem::find($id);
            $orden = Orden::find($orden_item->orden_id);
            $orden_item->restoreRestaurant();
            $orden_item->delete();
            $orden_count = Orden::where('id', $orden_item->orden_id)->count();
            if ($orden_count == 0) {
                $orden_delete = Orden::findOrFail($orden_item->orden_id);
                $orden_delete->delete();
            }
            event(new OrdenCancelEvent($id));
            $hasItems = OrdenItem::where('orden_id', $orden->id)->get();
            if ($hasItems->isEmpty()) {
                $table = Table::find($orden->table_id);
                $table->status_table_id = 1;
                $table->save();
                $orden->delete();
            }
            return [
                'success' => true,
                'message' => 'Pedido cancelado con éxito'
            ];
        } catch (Exception $e) {

            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    public function ordensStatus()
    {
        $ordens = Orden::where('status', "1")->get();
        return compact('ordens');
    }
    public function ordenReady($id)
    {
        $configuration = Configuration::first();
        try {
            $orden_item = OrdenItem::find($id);
            $orden_item->status_orden_id = 3;
            $orden_item->save();
            $ordenCount = OrdenItem::where('orden_id', $orden_item->orden_id)->where('status_orden_id', 1)->count();
            if ($ordenCount == 0) {
                $Orden = Orden::find($orden_item->orden_id);
                $Orden->status = 0;
                $Orden->save();
            }
            event(new OrdenReadyEvent($id));
            if ($configuration->seller_mozo) {
                event(new OrdenReadyListEvent($id));
            }

            return [
                'success' => true,
                'message' => 'Orden lista'
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function records()
    {
        // $date = Carbon::now()->format('Y-m-d');

        $ordens = new OrdenItemCollection(OrdenItem::where('status_orden_id', 1)->get());

        return [
            'success' => true,
            'data' => $ordens
        ];
    }
    public function list_ordens_items()
    {
        $date = Carbon::now()->format('Y-m-d');
        //dd(auth()->user()->area_id);
        $ordens = new OrdenItemCollection(OrdenItem::whereDate('date', '=', $date)->where('status_orden_id', 1)->get());

        return [
            'success' => true,
            'data' => $ordens
        ];
    }
    public function state(Request $request)
    {
        $id = $request->id;
        $orden = OrdenItem::find($id);
        $orden->active = !$orden->active;
        $orden->save();
        return [
            'success' => true,
            'data' => $orden,
            'message' => 'Área ' . ($orden->active ? 'activada' : 'desactivada')
        ];
    }
    public function record($id)
    {
        $orden = OrdenItem::find($id);

        return [
            'success' => true,
            'data' => $orden
        ];
    }

    public function destroy($id)
    {
        //
    }
}
