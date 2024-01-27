<?php

namespace App\Imports;

use App\Models\Tenant\Inventory;
use App\Models\Tenant\InventoryKardex;
use App\Models\Tenant\InventoryKardexDetail;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Item\Models\ItemLot;

class LotItemsImport implements ToCollection
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
            $serie = $row[1];
            $date = Carbon::now()->format('Y-m-d');
            $warehouse_id = request('warehouse_id');

            if ($internal_id != null) {
                $item = Item::where('internal_id', $internal_id)->first();
                $item_id = $item->id;
                $exists = ItemLot::where('series', $serie)->where('item_id', $item_id)->first();
                if ($exists != null) {
                    $exist += 1;
                } else {
                    if ($item != null) {
                        $item_lot = ItemLot::create([
                            'series' => $serie,
                            'date' => $date,
                            'item_id' => $item_id,
                            'warehouse_id' => $warehouse_id,
                            'item_loteable_type' => 'App\Models\Tenant\Item',
                            'item_loteable_id' => $item_id,
                            'has_sale' => 0,
                            'state' => 'Activo',
                        ]);

                        if($item_lot){
                            $item->stock += 1;
                            $item->save();
                            $item_warehouse = ItemWarehouse::where('item_id', $item_id)->where('warehouse_id', $warehouse_id)->first();
                            if ($item_warehouse != null) {
                                $item_warehouse->stock += 1;
                                $item_warehouse->save();
                            } else {
                                $item_warehouse = ItemWarehouse::create([
                                    'item_id' => $item_id,
                                    'warehouse_id' => $warehouse_id,
                                    'stock' => 1,
                                ]);
                            }
                            $inventory = Inventory::create([
                                'type' => 1,
                                'description' => 'Ingreso importación',
                                'item_id' => $item->id,
                                'warehouse_id' => $warehouse_id,
                                'quantity' => 1,
                                'date_of_issue' => date('Y-m-d')
                            ]);
                          $inventory_kardex =  InventoryKardex::create([
                                'date_of_issue' => date('Y-m-d'),
                                'item_id' => $item_id,
                                'warehouse_id' => $warehouse_id,
                                'quantity' => 1,
                                'type' => 'input',
                                'inventory_kardexable_type' => 'Modules\Inventory\Models\Inventory',
                                'inventory_kardexable_id' => $inventory->id,
                            ]);
                            InventoryKardexDetail::create([
                                'inventory_kardex_id' => $inventory_kardex->id,
                                'detail' => 'Ingreso de la serie ' . $serie,
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
