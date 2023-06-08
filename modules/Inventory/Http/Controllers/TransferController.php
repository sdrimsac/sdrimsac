<?php

namespace Modules\Inventory\Http\Controllers;

use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
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
use Modules\Item\Models\ItemLotsGroup;

class TransferController extends Controller
{
    use InventoryTrait;

    public function index()
    {

        return view('inventory::transfers.index');
    }
    public function index_place()
    {
        return view('inventory::transfers_place.index');
    }

    public function create()
    {
        $establishment_id = auth()->user()->establishment_id;
        $establishments = Establishment::all();
        // $establishment_id = auth()->user()->establishment_id;
        //$current_warehouse = Warehouse::where('establishment_id', $establishment_id)->first();
        return view('inventory::transfers.form', compact('establishment_id', 'establishments'));
    }

    public function columns()
    {
        return [
            'description' => 'Nombre/Código de producto',
            'serie' => 'Serie',
            'lote' => 'Lote',
            'created_at' => 'Fecha de emisión',
        ];
    }

    public function records(Request $request)
    {
        $column = $request->column;
        $value = $request->value;
        $records =  InventoryTransfer::with(['warehouse', 'warehouse_destination', 'inventory']);
        if ($column == 'created_at') {
            $records = $records->where('created_at', 'like', "%{$value}%")->latest();
        } else if ($column == 'description') {
            $records = $records->whereHas('inventory', function ($query) use ($value) {
                $query->whereHas('item', function ($query) use ($value) {
                    $query->where('description', 'like', '%' . $value . '%')->orWhere('internal_id', 'like', '%' . $value . '%');
                });
            });
        } else if ($column == 'serie') {
            $records = $records->whereHas('inventory', function ($query) use ($value) {
                $query->whereHas('lots', function ($query) use ($value) {
                    $query->where('series', 'like', '%' . $value . '%');
                });
            });
        } else if ($column == 'lote') {
            $records = $records->whereHas('inventory', function ($query) use ($value) {
                $query->whereHas('item', function ($query) use ($value) {
                    $query->whereHas('lots_group', function ($query) use ($value) {
                        $query->where('code', 'like', '%' . $value . '%');
                    });
                });
            });
        } else {
            $records = $records->latest();
        }
        //return json_encode( $records );
        /*$records = Inventory::with(['item', 'warehouse', 'warehouse_destination'])
                            ->where('type', 2)
                            ->whereHas('warehouse_destination')
                            ->whereHas('item', function($query) use($request) {
                                $query->where('description', 'like', '%' . $request->value . '%');

                            })
                            ->latest();*/


        return new TransferCollection($records->paginate(config('tenant.items_per_page')));
    }


    public function tables()
    {
        return [
            //'items' => $this->optionsItemWareHouse(),
            'warehouses' => $this->optionsWarehouse()
        ];
    }

    public function record($id)
    {
        $record = new TransferResource(Inventory::findOrFail($id));

        return $record;
    }


    /* public function store(Request $request)
    {

        $result = DB::transaction(function () use ($request) {

            $id = $request->input('id');
            $item_id = $request->input('item_id');
            $warehouse_id = $request->input('warehouse_id');
            $warehouse_destination_id = $request->input('warehouse_destination_id');
            $stock = $request->input('stock');
            $quantity = $request->input('quantity');
            $detail = $request->input('detail');

            if($warehouse_id === $warehouse_destination_id) {
                return  [
                    'success' => false,
                    'message' => 'El almacén destino no puede ser igual al de origen'
                ];
            }
            if($stock < $quantity) {
                return  [
                    'success' => false,
                    'message' => 'La cantidad a trasladar no puede ser mayor al que se tiene en el almacén.'
                ];
            }

            $re_it_warehouse = ItemWarehouse::where([['item_id',$item_id],['warehouse_id', $warehouse_destination_id]])->first();

            if(!$re_it_warehouse) {
                return  [
                    'success' => false,
                    'message' => 'El producto no se encuentra registrado en el almacén destino.'
                ];
            }


            $inventory = Inventory::findOrFail($id);

            //proccess stock
            $origin_inv_kardex = $inventory->inventory_kardex->first();
            $origin_item_warehouse = ItemWarehouse::where([['item_id',$origin_inv_kardex->item_id],['warehouse_id', $origin_inv_kardex->warehouse_id]])->first();
            $origin_item_warehouse->stock += $inventory->quantity;
            $origin_item_warehouse->stock -= $quantity;
            $origin_item_warehouse->update();


            $destination_inv_kardex = $inventory->inventory_kardex->last();
            $destination_item_warehouse = ItemWarehouse::where([['item_id',$destination_inv_kardex->item_id],['warehouse_id', $destination_inv_kardex->warehouse_id]])->first();
            $destination_item_warehouse->stock -= $inventory->quantity;
            $destination_item_warehouse->update();


            $new_item_warehouse = ItemWarehouse::where([['item_id',$item_id],['warehouse_id', $warehouse_destination_id]])->first();
            $new_item_warehouse->stock += $quantity;
            $new_item_warehouse->update();

            //proccess stock

            //proccess kardex
            $origin_inv_kardex->quantity = -$quantity;
            $origin_inv_kardex->update();

            $destination_inv_kardex->quantity = $quantity;
            $destination_inv_kardex->warehouse_id = $warehouse_destination_id;
            $destination_inv_kardex->update();
            //proccess kardex

            $inventory->warehouse_destination_id = $warehouse_destination_id;
            $inventory->quantity = $quantity;
            $inventory->detail = $detail;


            $inventory->update();

            return  [
                'success' => true,
                'message' => 'Traslado actualizado con éxito'
            ];
        });

        return $result;
    }*/


    public function destroy($id)
    {

        DB::transaction(function () use ($id) {

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

    public function stock($item_id, $warehouse_id)
    {

        $row = ItemWarehouse::where([['item_id', $item_id], ['warehouse_id', $warehouse_id]])->first();

        return [
            'stock' => ($row) ? $row->stock : 0
        ];
    }
    public function get_place_transfer(Request $request)
    {
        $code = $request->code;

        $transfer = TransferPlace::where('status', 1)->whereRaw('BINARY code=?', $code)->first();

        if ($transfer) {
            return [
                "message" => "Traslado encontrado",
                "success" => true,
                "transfer" => $transfer,
            ];
        } else {

            return [
                "message" => "Código incorrecto",
                "success" => false,
            ];
        }
    }
    public function accept_transfer(Request $request)
    {
        $pin = $request->pin;
        $user = auth()->user();
        if ($pin != $user->pin) {
            return [
                "success" => false,
                "message" => "El pin no corresponde al usuario actual"
            ];
        }
        $code = $request->code;
        $transfer = TransferPlace::where('code', $code)->where('status', 1)->first();
        if ($transfer == null) {
            return [
                "success" => false,
                "message" => "No se encontró algun traslado con ese código"
            ];
        }
        $transfer->status = 2;
        $transfer->save();

        $result = DB::transaction(function () use ($transfer) {

            $details = TransferPlaceDetail::where('transfers_place_id', $transfer->id)->get();
            $row = InventoryTransfer::create([
                'description' => $transfer->observation,
                'warehouse_id' => $transfer->warehouse_id,
                'warehouse_destination_id' => $transfer->warehouse_id_destination,
                'quantity' =>  count($details),
            ]);

            foreach ($details as $it) {
                $item = ItemWarehouse::where(
                    'item_id',
                    $it->item_id
                )->where('warehouse_id', $transfer->warehouse_id)->first();
                if ($item) {
                    $item->stock += $it->quantity;
                    $item->save();
                }
                $inventory = new Inventory;
                $inventory->type = 2;
                $inventory->description = 'Traslado';
                $inventory->item_id = $it->item_id;
                $inventory->warehouse_id = $transfer->warehouse_id;
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
                            ->where('warehouse_id', $transfer->warehouse_id_destination)->first();

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
            }

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
            if ($item) {
                $item->stock -= $it['quantity'];
                $item->save();
            }
            $detail->save();
        }
        $establishment = Establishment::find($user->establishment_id);
        return [
            "message" => "Transferencia por aceptar",
            "code" => url('') . "/transfers/print_places/" . $code,
            'printer' => $establishment->printer,
            "success" => true,
        ];
    }
    public function store(TransferRequest $request)
    {

        $result = DB::transaction(function () use ($request) {

            $row = InventoryTransfer::create([
                'description' => $request->description,
                'warehouse_id' => $request->warehouse_id,
                'warehouse_destination_id' => $request->warehouse_destination_id,
                'quantity' =>  count($request->items),
            ]);

            foreach ($request->items as $it) {
                $inventory = new Inventory();
                $inventory->type = 2;
                $inventory->description = 'Traslado';
                $inventory->item_id = $it['id'];
                $inventory->warehouse_id = $request->warehouse_id;
                $inventory->warehouse_destination_id = $request->warehouse_destination_id;
                $inventory->quantity = $it['quantity'];
                $inventory->inventories_transfer_id = $row->id;
                $inventory->save();

                foreach ($it['lots'] as $lot) {

                    if ($lot['has_sale']) {
                        $item_lot = ItemLot::findOrFail($lot['id']);
                        $item_lot->warehouse_id = $inventory->warehouse_destination_id;
                        $item_lot->update();
                    }
                }
            }

            return  [
                'success' => true,
                'message' => 'Traslado creado con éxito'
            ];
        });

        return $result;
    }


    public function items($warehouse_id, Request $request)

    {
        $description = $request->description;
        $type = $request->type;
        return [
            'items' => $this->optionsItemWareHousexId($warehouse_id, $description, $type),
        ];
    }
}
