<?php

namespace App\Imports;

use App\Models\Tenant\Inventory;
use Exception;
use App\Models\Tenant\Item;
use App\Models\Tenant\Warehouse;
use App\Models\Tenant\ItemWarehouse;
use Modules\Item\Models\Brand;
use Illuminate\Support\Collection;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\Food;
use Modules\Item\Models\CategoryItem;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\Kardex;
use App\Models\Tenant\InventoryKardex;
use App\Models\Tenant\ItemUnitType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Modules\Item\Models\ItemLotsGroup;

class ItemsImport implements ToCollection
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

            $description = $row[0];
            $second_name = $row[1];
            $item_type_id = '01';
            $internal_id = $row[2];
            $barcode = $row[3];
            $item_code = ($row[4]) ?: null;
            $unit_type_id = $row[5];
            $currency_type_id = $row[6];
            $sale_unit_price = $row[7];
            $sale_affectation_igv_type_id = $row[8];
            $affectation_igv_types_exonerated_unaffected = ['20', '21', '30', '31', '32', '33', '34', '35', '36', '37'];
            $category_name = strtoupper($row[14]);
            $brand_name = strtoupper($row[15]);
            $area_description = strtoupper($row[16]);
            $max_quantity = $row[30];
            $max_quantity_description = $row[31];
            $lote_code = ($row[32]) ?: null;
            $lote_date = ($row[33]) ?: null;

            $establishment_id = 1;

            $warehouse = Warehouse::where('establishment_id',  request('warehouse_id'))->first();
            $category = CategoryItem::updateOrCreate(['name' => $category_name]);
            $area = Area::updateOrCreate(['description' => $area_description]);

            // if(in_array($sale_affectation_igv_type_id, $affectation_igv_types_exonerated_unaffected)) {
            //     $has_igv = true;
            // }else{
            $has_igv = (strtoupper($row[9]) === 'SI') ? true : false;
            // }
            //dd($row,$row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14],$row[15]);
            $purchase_unit_price = ($row[10]) ?: 0;
            $purchase_affectation_igv_type_id = ($row[11]) ?: null;
            $stock = $row[12];
            $stock_min = $row[13];
            $has_series = (strtoupper($row[17]) === 'SI') ? 1 : 0;
            $prices = [];
            //30 31

            for ($i = 1; $i <= 4; $i++) {
                $descIndex = 18 + (($i - 1) * 3);
                $qtyIndex = $descIndex + 1;
                $priceIndex = $descIndex + 2;

                if (empty($row[$descIndex])) {
                }

                $prices["price_$i"] = [
                    'desc' => $row[$descIndex],
                    'qty' => $row[$qtyIndex],
                    'price' => $row[$priceIndex],
                ];
            }


            $warehouse_id = request('warehouse_id');

            if ($internal_id != null) {

                $item = Item::where('internal_id', $internal_id)->first();


                if ($item != null) {
                    $food = Food::where('item_id', $item->id)->first();
                    //dd($food);
                }

                //-------------------------------------------------------------
                if ($item === null) {
                    //dd($item,"aqui...");
                    $brand = Brand::updateOrCreate(['name' => $brand_name]);
                    $item = Item::create([
                        'max_quantity' => $max_quantity,
                        'max_quantity_description' => $max_quantity_description,
                        'description' => $description,
                        'second_name' => $second_name,
                        'item_type_id' => $item_type_id,
                        'internal_id' => $internal_id,
                        'barcode' => $barcode,
                        'item_code' => $item_code,
                        'unit_type_id' => $unit_type_id,
                        'currency_type_id' => $currency_type_id,
                        'sale_unit_price' => $sale_unit_price,
                        'sale_affectation_igv_type_id' => $sale_affectation_igv_type_id,
                        'has_igv' => $has_igv,
                        'purchase_unit_price' => $purchase_unit_price,
                        'purchase_affectation_igv_type_id' => $purchase_affectation_igv_type_id,
                        'stock' => $stock,
                        'attributes' => [],
                        'stock_min' => $stock_min,
                        'category_id' => $category->id,
                        'brand_id' => $brand->id,
                        'warehouse_id' => request('warehouse_id'),
                        'series_enabled' => $has_series
                    ]);

                    $food_new = Food::create([
                        'description' => $description,
                        'code'        => $internal_id,
                        'price'       => $sale_unit_price,
                        'active'      => 1,
                        'category_food_id' => $category->id,
                        'image'       => 'imagen-no-disponible.jpg',
                        'area_id'     => $area->id,
                        'item_id'     => $item->id
                    ]);

                    if($lote_code && $lote_date){
                        try{
                            $format_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($lote_date)->format('Y-m-d');
                            if($format_date){
                                ItemLotsGroup::create([
                                    'code' => $lote_code,
                                    'item_id' => $item->id,
                                    'warehouse_id' => $warehouse->id,
                                    'quantity' => $stock,
                                    'date_of_due' => $format_date,
                                ]);
                                $item->update([
                                    'lot_code' => $lote_code,
                                    'date_of_due' => $format_date,
                                    'lots_enabled' => true,
                                ]);
                            }
                         
                        }catch(Exception $e){
                            Log::error($e->getMessage());
                        }
                    }

                    foreach ($prices as $price) {
                        $this->insertPriceifExist($item->id, $price, $warehouse_id);
                    }

                    $registered += 1;
                } else {

                    $item->update([
                        'max_quantity' => $max_quantity,
                        'max_quantity_description' => $max_quantity_description,
                        'description' => $description,
                        'second_name' => $second_name,
                        'item_type_id' => $item_type_id,
                        'internal_id' => $internal_id,
                        'barcode' => $barcode,
                        'item_code' => $item_code,
                        'unit_type_id' => $unit_type_id,
                        'currency_type_id' => $currency_type_id,
                        'sale_unit_price' => $sale_unit_price,
                        'sale_affectation_igv_type_id' => $sale_affectation_igv_type_id,
                        'has_igv' => $has_igv,
                        'purchase_unit_price' => $purchase_unit_price,
                        'purchase_affectation_igv_type_id' => $purchase_affectation_igv_type_id,
                        'stock_min' => $stock_min,
                        'series_enabled' => $has_series,
                    ]);

                    $food->update([
                        'description' => $description,
                        'code'        => $internal_id,
                        'price'       => $sale_unit_price,
                        'active'      => 1,
                        'category_food_id' => $category->id,
                        'image'       => 'imagen-no-disponible.jpg',
                        'area_id'     => $area->id,
                        'item_id'     => $item->id
                    ]);

                    $item_whareouse = ItemWarehouse::where('item_id', $item->id)->where('warehouse_id', $warehouse_id)->first();
                    if ($item_whareouse) {
                        $item_whareouse->stock =  $stock;
                        $item_whareouse->save();
                    } else {
                        $item_whareouse = new ItemWarehouse;
                        $item_whareouse->item_id = $item->id;
                        $item_whareouse->warehouse_id = $warehouse_id;
                        $item_whareouse->stock = $stock;
                        $item_whareouse->save();
                    }

                    $inventory = Inventory::create([
                        'type' => 1,
                        'description' => 'Stock Inicial',
                        'item_id' => $item->id,
                        'warehouse_id' => $warehouse_id,
                        'quantity' => $stock,
                        'date_of_issue' => date('Y-m-d')
                    ]);

                    Kardex::create([
                        'type' => null,
                        'date_of_issue' => date('Y-m-d'),
                        'item_id' => $item->id,
                        'quantity' => $stock,
                    ]);


                    $inventoryId =  InventoryKardex::create([
                        'date_of_issue' => date('Y-m-d '),
                        'item_id' => $item->id,
                        'warehouse_id' => $warehouse_id,
                        'inventory_kardexable_type' => 'Modules\Inventory\Models\Inventory',
                        'inventory_kardexable_id' => $inventory->id,
                        'quantity' => $stock,
                        'created_at' => date('Y-m-d H:i:s '),
                        'updated_at' => date('Y-m-d H:i:s '),

                    ]);
                    ItemUnitType::where('item_id', $item->id)->delete();
                    foreach ($prices as $price) {
                        $this->insertPriceifExist($item->id, $price, $warehouse_id);
                    }
                    $registered += 1;
                }
                //-------------------------------------------------------------

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

    function insertPriceifExist($item_id, $price, $warehouse_id)
    {
        if ($this->checkPrice($price)) {
            $price_2 = $price['price'];
            $qty = $price['qty'];
            $price2 = floatval($price_2) / floatval($qty);
            ItemUnitType::create([
                'item_id' => $item_id,
                'unit_type_id' => 'NIU',
                'quantity_unit' => $price['qty'],
                // 'price2' =>  $price['price'],
                'price2' =>  $price2,
                'description' => $price['desc'],
                'price1' => 0.0,
                'price3' => 0.0,
                'price_default' => 2,
                // 'warehouse_id' => $warehouse_id,
                // 'total' => floatval($price['qty']) * floatval($price['price']),
                'total' =>  floatval($price['price']),
            ]);
        }
    }
}
