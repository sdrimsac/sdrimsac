<?php

namespace App\Imports;

use App\Models\Tenant\Configuration;
use Exception;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\Warehouse;
use Modules\Item\Models\Brand;
use Illuminate\Support\Collection;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\Food;
use Modules\Item\Models\CategoryItem;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class ItemsPriceImport implements ToCollection
{
    use Importable;

    protected $data;

    public function collection(Collection $rows)
    {
        //try {
        $total = count($rows);
        $configuration = Configuration::first();
        $registered = 0;
        unset($rows[0]);
        $user = auth()->user();
        $warehouse_id = null;
        if ($user) {
            $establishment_id = $user->establishment_id;
            $warehouse_id = Warehouse::where('establishment_id', $establishment_id)->first()->id;
        }
        foreach ($rows as $row) {
            $internal_id = $row[0];
            $description = $row[1];
            $unit_type_id = $row[2];
            $quantity_unit = $row[3];
            $total = $row[4];
            $price1 = $row[5];
            $price2 = $row[6];
            $price3 = $row[7];
            if ($warehouse_id == null) {
                $warehouse_id = request('warehouse_id');
            }

            if ($internal_id != null) {

                $item = Item::where('internal_id', $internal_id)->first();

                if ($item != null) {
                    if ($configuration->price_item_unit_type == 1) {
                        $item = ItemUnitType::create([
                            'description' => $description,
                            'item_id' => $item->id,
                            'unit_type_id' => $unit_type_id,
                            'quantity_unit' => $quantity_unit,
                            'price1' => $price1,
                            'price2' => $price2,
                            'price3' => $price3,
                            'price_default' => 1,
                            'warehouse_id' => $warehouse_id

                        ]);
                    } else {


                        $price2 = floatval($total) / floatval($quantity_unit);
                        $item = ItemUnitType::create([
                            'description' => $description,
                            'item_id' => $item->id,
                            'unit_type_id' => $unit_type_id,
                            'quantity_unit' => $quantity_unit,
                            'price1' => 0.0,
                            'price2' => $price2,
                            'price3' => 0,
                            'price_default' => 2,
                            'warehouse_id' => $warehouse_id

                        ]);
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
}
