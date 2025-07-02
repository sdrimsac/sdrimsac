<?php

namespace App\Imports;

use App\Models\Tenant\Item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Tenant\ItemColorSize;

class ItemColorSizeImport implements ToCollection
{
    use Importable;

    protected $data = [];

    public function collection(Collection $rows)
    {
        $data = [];
        unset($rows[0]); // Remove header row
        $warehouse_id = request('warehouse_id');
        $duplicados = [];

        foreach ($rows as $row) {
            $internal_id = $row[0];
            $code = $row[1];
            $color = strtoupper($row[2]);
            $size = strtoupper($row[3]);
            $stock = $row[4];
            $price = $row[5];

            if ($internal_id != null) {
                $item = Item::where('internal_id', $internal_id)->first();

                if ($item !== null) {
                    $item_id = $item->id;
                    
                    // Check if color/size combination already exists
                    $exists = ItemColorSize::where('item_id', $item_id)
                        ->where('color', $color)
                        ->where('code', $code)
                        ->where('size', $size)
                        ->where('warehouse_id', $warehouse_id)
                        ->exists();
                    
                    if (!$exists) {
                        // Mark item as having color/size
                        $item->has_color_size = true;
                        $item->save();
                        
                        $data[] = [
                            'item_id' => $item_id,
                            'warehouse_id' => $warehouse_id,
                            'color' => $color,
                            'size' => $size,
                            'stock' => $stock,
                            'code' => $code,
                            'price' => $price
                        ];
                    } else {
                        $duplicados[] = $code;
                    }
                    } else {
                        // Si ya existe, guardar el código duplicado
                        $duplicados[] = $code;
                        continue;
                    }

                }
            }
        }
        $this->data = compact('total', 'registered', 'duplicados');
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
