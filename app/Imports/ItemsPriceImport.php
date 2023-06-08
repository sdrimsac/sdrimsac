<?php

namespace App\Imports;

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

        $registered = 0;
        unset($rows[0]);
        foreach ($rows as $row) {
            $internal_id = $row[0];
            $description = $row[1];
            $unit_type_id = $row[2];
            $quantity_unit = $row[3];
            $total = $row[4];
            $warehouse_id = request('warehouse_id');

            if ($internal_id != null) {

                $item = Item::where('internal_id', $internal_id)->first();

                if ($item != null) {
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

                    ]);


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
