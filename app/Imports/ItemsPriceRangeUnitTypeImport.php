<?php

namespace App\Imports;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemPriceRange;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\ItemUnitTypePriceRange;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class ItemsPriceRangeUnitTypeImport implements ToCollection
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

        foreach ($rows as $row) {
            $internal_id = $row[0];
            $unit_type_description = $row[1];
            $unit_type_description = trim($unit_type_description);

            $item = Item::where('internal_id', $internal_id)->first();
            if($item == null){
                continue;
            }
            $unit_type = ItemUnitType::where(DB::raw('LOWER(description)'), strtolower($unit_type_description))
                ->where('item_id', $item->id)
                ->first();
            if ($internal_id != null && $item != null && $unit_type != null) {
                $item_id = $item->id;
                $unit_type_id = $unit_type->id;
                for ($i = 1; $i <= 3; $i++) {
                    $minQty = 2 + (($i - 1) * 2);
                    $price = $minQty + 1;

                    if (!empty($row[$minQty])) {
                        if ($item != null) {
                            $existingRange = ItemUnitTypePriceRange::where('unit_type_id', $unit_type_id)
                                ->where('quantity_min', $row[$minQty])
                                ->first();

                            if ($existingRange) {
                                $existingRange->update([
                                    'price' => $row[$price]
                                ]);
                                continue;
                            }
                            ItemUnitTypePriceRange::create([
                                'unit_type_id' => $unit_type_id,
                                'quantity_min' => $row[$minQty],
                                'price' => $row[$price],
                            ]);
                            $registered += 1;
                        }
                    }
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
