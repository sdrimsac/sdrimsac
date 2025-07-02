<?php

namespace App\Imports;

use App\Models\Tenant\InventoryKardex;
use App\Models\Tenant\InventoryKardexDetail;
use App\Models\Tenant\Item;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
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
        $total = count($rows);
        $registered = 0;
        unset($rows[0]);  // Skip header row
        $warehouse_id = request('warehouse_id');
        $duplicados = [];
        $grouped_items = [];

        /* Log::info('Iniciando importación', [
            'total_rows' => $total,
            'warehouse_id' => $warehouse_id
        ]); */

        foreach ($rows as $row) {
            // Skip empty rows
            if (!$row || $row->filter()->isEmpty()) {
                continue;
            }

            $rowValues = $row->toArray();
           /*  Log::info('Procesando fila', ['row_values' => $rowValues]); */

            // Get values using index access since row is now an array
            $internal_id = $rowValues[0] ?? null;
            $code = $rowValues[1] ?? null;
            $color = isset($rowValues[2]) ? strtoupper($rowValues[2]) : null;
            $size = isset($rowValues[3]) ? strtoupper($rowValues[3]) : null;
            $stock = isset($rowValues[4]) ? (float)$rowValues[4] : 0;
            $price = isset($rowValues[5]) ? (float)$rowValues[5] : 0;

            /* Log::info('Datos extraídos', [
                'internal_id' => $internal_id,
                'code' => $code,
                'color' => $color,
                'size' => $size,
                'stock' => $stock,
                'price' => $price
            ]); */

            if ($internal_id) {
                $item = Item::where('internal_id', $internal_id)->first();
                Log::info('Búsqueda de item', [
                    'internal_id' => $internal_id,
                    'item_encontrado' => $item ? true : false,
                    'item_id' => $item ? $item->id : null
                ]);

                if ($item) {
                    $item->has_color_size = true;
                    $item->save();
                    
                    $item_id = $item->id;
                    $item_key = $item_id . '_' . $warehouse_id;

                    if (!isset($grouped_items[$item_key])) {
                        $grouped_items[$item_key] = [
                            'type' => 'input',
                            'item_id' => $item_id,
                            'warehouse_id' => $warehouse_id,
                            'inventory_transaction_id' => "02",
                            'quantity' => 0,
                            'color_size' => []
                        ];
                        /* Log::info('Creando nuevo grupo para item', [
                            'item_key' => $item_key,
                            'group' => $grouped_items[$item_key]
                        ]); */
                    }

                    // Check for duplicates
                    $exists_in_group = false;
                    foreach ($grouped_items[$item_key]['color_size'] as $cs) {
                        if ($cs['color'] === $color && $cs['size'] === $size && $cs['code'] === $code) {
                            $exists_in_group = true;
                            $duplicados[] = [
                                'internal_id' => $internal_id,
                                'code' => $code,
                                'color' => $color,
                                'size' => $size
                            ];
                            /* Log::info('Combinación duplicada encontrada', [
                                'item_key' => $item_key,
                                'color' => $color,
                                'size' => $size,
                                'code' => $code
                            ]); */
                            break;
                        }
                    }

                    if (!$exists_in_group) {
                        $grouped_items[$item_key]['color_size'][] = [
                            'stock' => $stock,
                            'color' => $color,
                            'size' => $size,
                            'price' => $price,
                            'code' => $code
                        ];
                        
                        $grouped_items[$item_key]['quantity'] += $stock;
                        $registered++;

                        /* Log::info('Nueva combinación agregada', [
                            'item_key' => $item_key,
                            'registered' => $registered,
                            'current_group' => $grouped_items[$item_key]
                        ]); */
                    }
                }
            }
        }

        // Ensure we only keep items that have color_size entries
        $grouped_items = array_filter($grouped_items, function($item) {
            return count($item['color_size']) > 0;
        });

        /* Log::info('Resultado final', [
            'total' => $total,
            'registered' => $registered,
            'duplicados' => $duplicados,
            'items_count' => count($grouped_items),
            'grouped_items' => $grouped_items
        ]); */

        $this->data = [
            'total' => $total,
            'registered' => $registered,
            'duplicados' => $duplicados,
            'items' => array_values($grouped_items)
        ];
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
