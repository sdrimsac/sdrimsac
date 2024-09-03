<?php

namespace Modules\Inventory\Http\Controllers;

use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemColorSize;
use Exception;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Http\Resources\TransferCollection;
use Modules\Inventory\Http\Resources\TransferResource;
use Modules\Inventory\Models\Inventory;
use Modules\Inventory\Traits\InventoryTrait;
use Modules\Inventory\Models\ItemWarehouse;
use Modules\Inventory\Models\Warehouse;
use Modules\Inventory\Models\InventoryTransfer;
use Modules\Inventory\Http\Requests\InventoryRequest;
use Modules\Inventory\Http\Requests\TransferRequest;
use Modules\Inventory\Models\TransferPlace;
use Modules\Inventory\Models\TransferPlaceDetail;
use Modules\Item\Models\ItemLot;
use Illuminate\Support\Str;
use Modules\Inventory\Http\Resources\TransferPlaceCollection;
use Modules\Item\Models\ItemLotsGroup;
use Modules\Restaurant\Models\Area;

class TransferPlaceController extends Controller
{
    use InventoryTrait;

    public function index()
    {
        return view('inventory::transfers_place.index');
    }


    public function columns()
    {
        return [
            'warehouse_id' => 'Almacén de salida',
            'warehouse_id_destination' => 'Almacén de llegada',
            'created_at' => 'Fecha de traslado',
            'code' => 'Código',
            'status' => 'Estado',
        ];
    }

    public function records(Request $request)
    {
        if ($request->column) {
            $records = TransferPlace::where($request->column, 'like', "%" . $request->value . "%")->latest();
        } else {
            $records = TransferPlace::latest();
        }



        return new TransferPlaceCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function tables()
    {
        $printers = Area::whereNotNull('printer')->get()
            ->transform(function ($row, $key) {
                return [
                    'id' => $row->id,
                    'description' => $row->description,
                    'printer' => $row->printer,
                ];
            });

        return [
            'printers' => $printers,
            //'items' => $this->optionsItemWareHouse(),
            'warehouses' => $this->optionsWarehouse()
        ];
    }

    public function record($id)
    {
        $record = new TransferResource(Inventory::findOrFail($id));

        return $record;
    }

    public function destroy($id)
    {

        DB::connection('tenant')->transaction(function () use ($id) {

            $record = Inventory::findOrFail($id);

            $origin_inv_kardex = $record->inventory_kardex->first();
            $destination_inv_kardex = $record->inventory_kardex->last();

            $destination_item_warehouse = ItemWarehouse::where([['item_id', $destination_inv_kardex->item_id], ['warehouse_id', $destination_inv_kardex->warehouse_id]])->first();
            $destination_item_warehouse->stock -= $record->quantity;
            $destination_item_warehouse->update();

            $origin_item_warehouse = ItemWarehouse::where([['item_id', $origin_inv_kardex->item_id], ['warehouse_id', $origin_inv_kardex->warehouse_id]])->first();
            $origin_item_warehouse->stock += $record->quantity;
            $origin_item_warehouse->update();

            $record->inventory_kardex()->delete();
            $record->delete();
        });


        return [
            'success' => true,
            'message' => 'Traslado eliminado con éxito'
        ];
    }

    public function get_place_transfer(Request $request)
    {
        $code = $request->code;
        $transfer = TransferPlace::whereRaw('BINARY code=?', $code)->first();
        if ($transfer) {

            if ($transfer->status == 1) {
                return [
                    "message" => "Traslado encontrado",
                    "success" => true,
                    "transfer" => $transfer,
                ];
            } else {

                return [
                    "message" => "Traslado ya aceptado",
                    "success" => false,
                ];
            }
        } else {
            return [
                "message" => "Código incorrecto",
                "success" => false,
            ];
        }
    }
    public function cancel_transfer(Request $request)
    {
        $code = $request->code;

        $transfer = TransferPlace::where('code', $code)->where('status', 1)->first();

        if ($transfer) {
            $transfer->status = 3;
            $transfer->save();
        } else {
            return response()->json(['success' => false, 'message' => 'transferencia con dato nulo.'], 404);
        }

        $result = DB::connection('tenant')->transaction(function () use ($transfer) {
            $details = TransferPlaceDetail::where('transfers_place_id', $transfer->id)->get();

            foreach ($details as $it) {

                $item_orig = ItemWarehouse::where('item_id', $it->item_id)
                    ->where('warehouse_id', $transfer->warehouse_id)
                    ->first();
                if ($item_orig) {
                    $item_orig->stock += $it->quantity;
                    $item_orig->save();
                }

                /* $item_dest = ItemWarehouse::where('item_id', $it->item_id)
                    ->where('warehouse_id', $transfer->warehouse_id_destination)
                    ->first();
                if ($item_dest) {
                    $item_dest->stock -= $it->quantity;
                    $item_dest->save();
                } */

                $series_lots = $it->series_lots;
                foreach ($series_lots['series'] as $lot) {
                    if ($lot['has_sale']) {
                        $item_lot = ItemLot::findOrFail($lot['id']);
                        $item_lot->warehouse_id = $transfer->warehouse_id;
                        $item_lot->update();
                    }
                }

                foreach ($series_lots['lotes'] as $lote) {
                    $item_group = ItemLotsGroup::find($lote["id"]);
                    $quantity = $lote["quantity"];
                    if ($item_group) {
                        $item_group->quantity -= $quantity;
                        $item_group->save();

                        $item_group_orig = ItemLotsGroup::where("item_id", $lote["item_id"])
                            ->where('warehouse_id', $transfer->warehouse_id)
                            ->where('code', $item_group->code)
                            ->first();

                        if ($item_group_orig) {
                            $item_group_orig->quantity += $quantity;
                            $item_group_orig->save();
                        }
                    }
                }

                foreach ($series_lots['color_size'] as $item_color) {
                    $size = $item_color['size'];
                    $color = $item_color['color'];
                    $quantity = $item_color['selectedQuantity'];

                    /* $item_color_size_dest = ItemColorSize::where('warehouse_id', $transfer->warehouse_id_destination)
                        ->where('size', $size)
                        ->where('color', $color)
                        ->where('item_id', $it->item_id)
                        ->first();
    
                    if ($item_color_size_dest) {
                        $item_color_size_dest->stock -= $quantity;
                        $item_color_size_dest->save();
                    } */

                    $item_color_size_orig = ItemColorSize::where('warehouse_id', $transfer->warehouse_id)
                        ->where('size', $size)
                        ->where('color', $color)
                        ->where('item_id', $it->item_id)
                        ->first();

                    if ($item_color_size_orig) {
                        $item_color_size_orig->stock += $quantity;
                        $item_color_size_orig->save();
                    }
                }
            }

            return [
                'success' => true,
                'message' => 'Traslado cancelado y stock revertido con éxito'
            ];
        });

        return $result;
    }

    public function accept_transfer(Request $request)
    {
        $pin = $request->pin;
        $user = auth()->user();
        $configuration = Configuration::first();
        if ($pin != $user->pin && !$configuration->translate_direct) {
            return [
                "success" => false,
                "message" => "El pin no corresponde al usuario actual"
            ];
        }
        //aqui el usuario ingresa el codigo y busca por el codigo pero en el caso de rechazo será por id supongo
        $code = $request->code;
        $transfer = TransferPlace::where('code', $code)->where('status', 1)->first();
        if ($transfer == null) {
            return [
                "success" => false,
                "message" => "No se encontró algun traslado con ese código"
            ];
        }
        //aqui le cambia el estado, como aceptado
        $transfer->status = 2;
        $transfer->save();

        $result = DB::connection('tenant')->transaction(function () use ($transfer) {
            //aqui obtiene los items
            $details = TransferPlaceDetail::where('transfers_place_id', $transfer->id)->get();
            $row = InventoryTransfer::create([
                //aca en description pondrías que es la cancelacion
                'description' => $transfer->observation,
                'warehouse_id' => $transfer->warehouse_id,
                'warehouse_destination_id' => $transfer->warehouse_id_destination,
                'quantity' =>  count($details),
            ]);

            foreach ($details as $it) {
                //aqui actuliza el stock del almacén
                $item = ItemWarehouse::where(
                    'item_id',
                    $it->item_id
                    //aqui cambiaria el almacén al de origen
                )->where('warehouse_id', $transfer->warehouse_id_destination)->first();
                if ($item) {
                    // $item->stock += $it->quantity;
                    $item->save();
                }
                $inventory = new Inventory;
                $inventory->type = 2;
                $inventory->description = 'Traslado';
                $inventory->item_id = $it->item_id;
                //aqui igual
                $inventory->warehouse_id = $transfer->warehouse_id;
                //esto lo dejas vacio
                $inventory->warehouse_destination_id = $transfer->warehouse_id_destination;
                $inventory->quantity = $it->quantity;

                $inventory->inventories_transfer_id = $row->id;
                $inventory->save();

                $series_lots = $it->series_lots;
                foreach ($series_lots['series']  as $lot) {

                    if ($lot['has_sale']) {
                        $item_lot = ItemLot::findOrFail($lot['id']);
                        $item_lot->warehouse_id = $inventory->warehouse_destination_id;
                        $item_lot->update();
                    }
                }

                foreach ($series_lots['lotes']  as $lote) {
                    $item_group = ItemLotsGroup::find($lote["id"]);
                    $quantity = $lote["quantity"];
                    if ($item_group) {
                        $item_group->quantity -= $quantity;
                        $item_group->save();

                        $item_group_destination =  ItemLotsGroup::where("item_id", $lote["item_id"])
                            ->where('warehouse_id', $transfer->warehouse_id_destination)
                            ->where('code', $item_group->code)
                            ->first();

                        if ($item_group_destination) {
                            $item_group_destination->quantity += $quantity;
                            $item_group_destination->save();
                        } else {
                            $item_group_destination = new ItemLotsGroup;
                            $item_group_destination->item_id = $item_group->item_id;
                            $item_group_destination->quantity = $quantity;
                            $item_group_destination->code = $item_group->code;
                            $item_group_destination->warehouse_id = $transfer->warehouse_id_destination;
                            $item_group_destination->date_of_due = $item_group->date_of_due;
                            $item_group_destination->save();
                        }
                    }
                }
                if (isset($series_lots['color_size'])) {
                    foreach ($series_lots['color_size']  as $item_color) {
                        $size = $item_color['size'];
                        $color = $item_color['color'];
                        $price = $item_color['price'];
                        $quantity = $item_color['selectedQuantity'];
                        $item_color_size = ItemColorSize::where('warehouse_id', $transfer->warehouse_id_destination)
                            ->where('size', $size)
                            ->where('color', $color)
                            ->where('item_id', $it->item_id)
                            ->first();
                        if (!$item_color_size) {
                            $item_color_size = ItemColorSize::create([
                                'size' => $size,
                                'item_id' => $it->item_id,
                                'color' => $color,
                                'price' => $price,
                                'warehouse_id' => $transfer->warehouse_id_destination,
                                'stock' => 0,
                            ]);
                            $item_color_size->save();
                        }
                        $item_color_size->stock += $quantity;
                        $item_color_size->save();
                    }
                }
            }
            Item::where('series_enabled', true)->chunk(50, function ($items_chunk) {
                foreach ($items_chunk as $item) {
                    $item->checkSeries();
                }
            });
            return  [
                'success' => true,
                'message' => 'Traslado creado con éxito'
            ];
        });

        return $result;
        return [
            "success" => true,
        ];
    }
    public function print_transfer($code)
    {
        try {
            $company = Company::first();
            $transfer = TransferPlace::where('code', $code)->first();
            $height = 260;
            foreach ($transfer->detail as $detail) {
                $height +=  20;
                foreach ($detail->series_lots["lotes"] as $value) {
                    $height +=  20;
                }
            }

            $pdf = PDF::loadView('inventory::transfers.guie', compact(
                'transfer',
                'company'
            ))
                ->setPaper(array(0, 0, 249.45, $height));
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }

        return $pdf->stream('pdf_transfers.pdf');
    }

    function createCode()
    {
        $code = Str::random(5);
        $created = false;
        while (!$created) {
            $transfer = TransferPlace::where('code', $code)->first();
            if ($transfer == null) {
                $created = true;
            } else {
                $code = Str::random(5);
            }
        }
        return $code;
    }

    /* public function place_transfer(Request $request)
    {
        $user = auth()->user();
        $code = $this->createCode();

        $transfer_place = new TransferPlace;
        $transfer_place->observation = $request->description ?? "-";
        $transfer_place->status = 1;
        $transfer_place->code = $code;
        $transfer_place->warehouse_id = $request->warehouse_id;
        $transfer_place->warehouse_id_destination = $request->warehouse_destination_id;
        $transfer_place->sender_id = $user->id;
        $transfer_place->save();
        foreach ($request->items as $it) {
            $detail = new TransferPlaceDetail;
            $detail->item_id = $it['id'];
            $detail->transfers_place_id = $transfer_place->id;
            $detail->quantity = $it['quantity'];
            $series_lots = [
                "series" => [],
                "lotes" => [],
                "color_size" => []
            ];
            if (count($it['lotes']) > 0) {
                $series_lots["lotes"] = $it['lotes'];
            }
            if (count($it['lots']) > 0) {
                $series_lots["series"] = $it['lots'];
            }
            if (count($it['color_size']) > 0) {
                $series_lots["color_size"] = $it['color_size'];
            }
            $detail->series_lots = $series_lots;
            $item = ItemWarehouse::where(
                'item_id',
                $it['id']
            )->where('warehouse_id', $request->warehouse_id)->first();
            if ($item) {
                $item->stock -= $it['quantity'];
                $item->save();
            }
            $detail->save();
        }
        $establishment = Establishment::find($request->printer);
        /* $establishment = $request->printer ? Establishment::find($request->printer) : null;
        $configuration = Configuration::first();
        if ($configuration->translate_direct) {
            $request->merge(['code' => $code]);
            $response = $this->accept_transfer($request);
            return $response;
        } else {
            return [
                "message" => "Transferencia por aceptar",
                "code" => url('') . "/transfers/print_places/" . $code,
                /* 'printer' => $establishment ? $establishment->printer : null,
                'printer' => $establishment->printer,
                "success" => true,
            ];
        }
    } */

    public function place_transfer(Request $request)
    {


        $user = auth()->user();
        $code = $this->createCode();

        $transfer_place = new TransferPlace;
        $transfer_place->observation = $request->description ?? "-";
        $transfer_place->status = 1;
        $transfer_place->code = $code;
        $transfer_place->warehouse_id = $request->warehouse_id;
        $transfer_place->warehouse_id_destination = $request->warehouse_destination_id;
        $transfer_place->sender_id = $user->id;
        $transfer_place->save();
        foreach ($request->items as $it) {
            $detail = new TransferPlaceDetail;
            $detail->item_id = $it['id'];
            $detail->transfers_place_id = $transfer_place->id;
            $detail->quantity = $it['quantity'];
            $series_lots = [
                "series" => [],
                "lotes" => []
            ];
            if (count($it['lotes']) > 0) {
                $series_lots["lotes"] = $it['lotes'];
            }
            if (count($it['lots']) > 0) {
                $series_lots["series"] = $it['lots'];
            }
            $detail->series_lots = $series_lots;
            $item = ItemWarehouse::where(
                'item_id',
                $it['id']
            )->where('warehouse_id', $request->warehouse_id)->first();
            if ($item && count($it['lots']) == 0) {
                $item->save();
            }
            $detail->save();
        }
        $establishment = $request->printer ?  Establishment::find($request->printer) : null;
        $configuration = Configuration::first();
        if ($configuration->translate_direct) {
            $request->merge(['code' => $code]);
            $response = $this->accept_transfer($request);
            return $response;
        } else {
            return [
                "message" => "Transferencia por aceptar",
                "code" => url('') . "/transfers/print_places/" . $code,
                'printer' => $establishment ? $establishment->printer : null,
                "success" => true,
            ];
        }
    }
}
