<?php

namespace App\Imports;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemPriceRange;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class ItemsPriceRangeImport implements ToCollection
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
            $item = Item::where('internal_id', $internal_id)->first();
            if ($internal_id != null && $item != null) {
                $item_id = $item->id;
                for ($i = 1; $i <= 3; $i++) {
                    $minQty = 1 + (($i - 1) * 2);
                    $price = $minQty + 1;

                    if (!empty($row[$minQty])) {
                        if ($item != null) {
                            $existingRange = ItemPriceRange::where('item_id', $item_id)
                                ->where('quantity_min', $row[$minQty])
                                ->first();

                            if ($existingRange) {
                                $existingRange->update([
                                    'price' => $row[$price]
                                ]);
                                continue;
                            }
                            ItemPriceRange::create([
                                'item_id' => $item_id,
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
