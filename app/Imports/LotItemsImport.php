<?php

namespace App\Imports;

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
                            ItemWarehouse::where('item_id', $item_id)->where('warehouse_id', $warehouse_id)->increment('stock', 1);
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
