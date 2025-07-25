<?php

namespace App\Services;

use App\Models\Tenant\Item;
use App\Models\Tenant\ItemCodes;
use App\Models\Tenant\ItemWarehouse;

class ItemCodeService
{
    /*public static function generateCodesForItemWarehouse($item_id, $warehouse_id)
    {
        $item = Item::findOrFail($item_id);
        if (!$item->codes_family) return;

        $stock = ItemWarehouse::where('item_id', $item_id)
            ->where('warehouse_id', $warehouse_id)
            ->value('stock');

        $existing_codes = ItemCodes::where('item_id', $item_id)
            ->where('warehouse_id', $warehouse_id)
            ->where('code_barcode', 'like', $item->internal_id . '-%')
            ->count();

        $start_number = $existing_codes + 1;
        $cantidad = $stock - $existing_codes;

        if ($cantidad <= 0) return;

        for ($i = 0; $i < $cantidad; $i++) {
            $code_number = str_pad($start_number + $i, 3, '0', STR_PAD_LEFT);
            $code_barcode = $item->internal_id . '-' . $code_number;

            if (!ItemCodes::where('code_barcode', $code_barcode)
                ->where('item_id', $item_id)
                ->where('warehouse_id', $warehouse_id)
                ->exists()) {
                ItemCodes::create([
                    'item_id' => $item_id,
                    'warehouse_id' => $warehouse_id,
                    'code_barcode' => $code_barcode,
                ]);
            }
        }
    }*/

    public static function generateCodesForItemWarehouse($item_id, $warehouse_id)
    {
        $item = Item::findOrFail($item_id);

        // ✅ Solo si está activado el sistema de códigos únicos
        if (!$item->codes_family) return;

        $stock = ItemWarehouse::where('item_id', $item_id)
            ->where('warehouse_id', $warehouse_id)
            ->value('stock');

        if (!$stock || $stock <= 0) return;

        // ✅ Obtener último código correlativo generado para este item
        $last_code = ItemCodes::where('item_id', $item_id)
            ->where('code_barcode', 'like', $item->internal_id . '-%')
            ->orderByDesc('code_barcode')
            ->value('code_barcode');

        $start_number = 1;
        if ($last_code) {
            $parts = explode('-', $last_code);
            $start_number = intval(end($parts)) + 1;
        }

        // ✅ Ver cuántos códigos ya existen
        $existing_codes = ItemCodes::where('item_id', $item_id)->count();

        $cantidad = $stock - $existing_codes;
        if ($cantidad <= 0) return;

        for ($i = 0; $i < $cantidad; $i++) {
            $code_number = str_pad($start_number + $i, 3, '0', STR_PAD_LEFT);
            $code_barcode = $item->internal_id . $code_number;

            if (!ItemCodes::where('code_barcode', $code_barcode)
                ->where('item_id', $item_id)
                ->exists()) {
                ItemCodes::create([
                    'item_id' => $item_id,
                    'warehouse_id' => $warehouse_id,
                    'code_barcode' => $code_barcode,
                ]);
            }
        }
    }
}
