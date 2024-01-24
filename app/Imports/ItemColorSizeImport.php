<?php

namespace App\Imports;

use App\Models\Tenant\Item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Tenant\ItemColorSize;
use App\Models\Tenant\ItemWarehouse;

class ItemColorSizeImport implements ToCollection
{
    use Importable;

    protected $data;

    public function collection(Collection $rows)
    {
        //try {
        $total = count($rows);

        $registered = 0;
        unset($rows[0]);
        $warehouse_id = request('warehouse_id');
        foreach ($rows as $row) {


            $internal_id = $row[0];
            $color = strtoupper($row[1]);
            $size = strtoupper($row[2]);
            $stock = $row[3];




            if ($internal_id != null) {

                $item = Item::where('internal_id', $internal_id)->first();


                if ($item !== null) {
                    $item_id = $item->id;
                    $item_warehouse = ItemWarehouse::where('item_id', $item_id)
                        ->where('warehouse_id', $warehouse_id)
                        ->first();
                    if ($item_warehouse == null) {
                        $item_warehouse = ItemWarehouse::create([
                            'item_id' => $item_id,
                            'warehouse_id' => $warehouse_id,
                            'stock' => $stock,
                        ]);
                        $item_warehouse->save();
                    } else {
                        $item_warehouse->stock = $item_warehouse->stock + $stock;
                        $item_warehouse->save();
                    }

                    $color_size_exits = ItemColorSize::where('item_id', $item_id)
                        ->where('color', $color)
                        ->where('size', $size)
                        ->where('warehouse_id', $warehouse_id)
                        ->first();
                    if ($color_size_exits == null) {
                        $item_color_size = ItemColorSize::create([
                            'item_id' => $item_id,
                            'color' => $color,
                            'size' => $size,
                            'stock' => $stock,
                            'warehouse_id' => $warehouse_id,
                        ]);
                        $item_color_size->save();
                    } else {
                        $color_size_exits->stock = $color_size_exits->stock + $stock;
                        $color_size_exits->save();
                    }

                    $registered += 1;
                }
            }
        }
        $this->data = compact('total', 'registered');
    }

    public function getData()
    {
        return $this->data;
    }

    function checkPrice($price)
    {
        if ($price['desc'] == null && $price['qty'] == null && $price['price'] == null) {
            return false;
        }
        return true;
    }
}
