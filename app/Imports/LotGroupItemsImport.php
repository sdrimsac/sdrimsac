<?php

namespace App\Imports;

use App\Models\Tenant\Inventory;
use App\Models\Tenant\InventoryKardex;
use App\Models\Tenant\InventoryKardexDetail;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Item\Models\ItemLotsGroup;

class LotGroupItemsImport implements ToCollection
{
    use Importable;

    protected $data;

    public function collection(Collection $rows)
    {
        //try {
        $total = count($rows);

        $registered = 0;
        $exist = 0;
        unset($rows[0]);
        foreach ($rows as $row) {
            $internal_id = $row[0];
            $lote = $row[1];
            $quantity = $row[2];
            $date = $row[3];
            $format_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
            $warehouse_id = request('warehouse_id');

            if ($internal_id != null) {
                $item = Item::where('internal_id', $internal_id)->first();
                if($item->lots_enabled == 0){
                    continue;
                }
                $item_id = $item->id;
                $exists = ItemLotsGroup::where('item_id', $item_id)->where('code', $lote)
                    ->where('warehouse_id', $warehouse_id)
                    ->first();
                if ($exists != null) {
                    // $exist += 1;
                    $exists->quantity += $quantity;
                    $exists->save();
                } else {
                    if ($item != null) {
                        $item_lot_group = ItemLotsGroup::create([
                            'item_id' => $item_id,
                            'code' => $lote,
                            'quantity' => $quantity,
                            'date_of_due' => $format_date,
                            'warehouse_id' => $warehouse_id,
                        ]);

                        if ($item_lot_group) {
                            $item->stock += $quantity;
                            $item->save();
                            $item_warehouse = ItemWarehouse::where('item_id', $item_id)->where('warehouse_id', $warehouse_id)->first();
                            if ($item_warehouse != null) {
                                $item_warehouse->stock += $quantity;
                                $item_warehouse->save();
                            } else {
                                $item_warehouse = ItemWarehouse::create([
                                    'item_id' => $item_id,
                                    'warehouse_id' => $warehouse_id,
                                    'stock' => $quantity,
                                ]);
                            }
                            $inventory = Inventory::create([
                                'type' => 1,
                                'description' => 'Ingreso importación',
                                'item_id' => $item->id,
                                'warehouse_id' => $warehouse_id,
                                'quantity' => $quantity,
                                'date_of_issue' => date('Y-m-d')
                            ]);
                            $inventory_kardex =  InventoryKardex::create([
                                'date_of_issue' => date('Y-m-d'),
                                'item_id' => $item_id,
                                'warehouse_id' => $warehouse_id,
                                'quantity' => $quantity,
                                'type' => 'input',
                                'inventory_kardexable_type' => 'Modules\Inventory\Models\Inventory',
                                'inventory_kardexable_id' => $inventory->id,
                                'user_id' => isset(auth()->user()->id) ? auth()->user()->id : null,
                            ]);
                            InventoryKardexDetail::create([
                                'inventory_kardex_id' => $inventory_kardex->id,
                                'detail' => 'Ingreso de la lote ' . $lote,
                            ]);
                        }
                        $registered += 1;
                    }
                }
            }
        }
        $this->data = compact('total', 'registered', 'exist');
    }

    public function getData()
    {
        return $this->data;
    }
}
