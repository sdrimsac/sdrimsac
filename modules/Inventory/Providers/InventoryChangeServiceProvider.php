<?php

namespace Modules\Inventory\Providers;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\InventoryKardexDetail;
use App\Models\Tenant\Item;
use App\Models\Tenant\Warehouse;
use Illuminate\Support\ServiceProvider;
use Modules\Inventory\Models\Inventory;
use Modules\Inventory\Traits\InventoryTrait;
use Modules\Inventory\Models\ItemWarehouse;

class InventoryChangeServiceProvider extends ServiceProvider
{
    use InventoryTrait;

    public function register()
    {
    }

    public function boot()
    {
        $this->createdItem();
        $this->inventory();
    }

    private function createdItem()
    {

        Item::created(function ($item) {

            $configuration = Configuration::firstOrFail();

            if ($item->unit_type_id == 'ZZ' && $configuration->create_service_all_warehouse) {
                $warehouses = Warehouse::all()->pluck('id');
                $stock = $item->stock;
                $id = $item->id;
                foreach ($warehouses as $wh) {
                    $exist = ItemWarehouse::where('warehouse_id', $wh)->where('item_id', $id)->first();

                    if (!isset($exist)) {
                        ItemWarehouse::create([
                            'warehouse_id' => $wh,
                            'stock' => $stock,
                            'item_id' => $item->id,
                            'created_at' => date('Y-m-d H:i:s '),
                            'updated_at' => date('Y-m-d H:i:s '),
                        ]);
                    }
                }
                return;
            }

            $warehouse = ($item->warehouse_id) ? $this->findWarehouse($this->findWarehouseById($item->warehouse_id)->establishment_id) : $this->findWarehouse();
            if (!$item->is_set) {
                $this->createInitialInventory($item->id, $item->stock, $warehouse->id);
            } else {
                $item_warehouse = ItemWarehouse::firstOrNew(['item_id' => $item->id, 'warehouse_id' => $warehouse->id]);
                $item_warehouse->stock = 0;
                $item_warehouse->save();
            }
        });
    }

    private function inventory()
    {
        Inventory::created(function ($inventory) {

            switch ($inventory->type) {
                case 1:
                    $this->createInventoryKardex($inventory, $inventory->item_id, $inventory->quantity, $inventory->warehouse_id);
                    $this->updateStock($inventory->item_id, $inventory->quantity, $inventory->warehouse_id);
                    break;
                case 2:
                    //Origin
                    $this->createInventoryKardex($inventory, $inventory->item_id, -1 * $inventory->quantity, $inventory->warehouse_id);
                    $this->updateStock($inventory->item_id, -1 * $inventory->quantity, $inventory->warehouse_id);
                    //Arrival
                    $this->createInventoryKardex($inventory, $inventory->item_id, $inventory->quantity, $inventory->warehouse_destination_id);
                    $this->updateStock($inventory->item_id, $inventory->quantity, $inventory->warehouse_destination_id);
                    break;
                case 3:
                    $this->createInventoryKardex($inventory, $inventory->item_id, -1 * $inventory->quantity, $inventory->warehouse_id);
                    $this->updateStock($inventory->item_id, -1 * $inventory->quantity, $inventory->warehouse_id);
                    break;
                default:
                    //aqui en el defualt tendria que acceder a la inventory_transactions y determinar el tipo de transaccion
                    //si es ingreso sumo, caso contrario descuento
                    $inventory_transaction = $this->findInventoryTransaction($inventory->inventory_transaction_id);

                    if ($inventory_transaction->type === 'input') {

                        $inventory_kardex = $this->createInventoryKardex($inventory, $inventory->item_id, $inventory->quantity, $inventory->warehouse_id);
                        if (isset($inventory->lots)) {
                            $lots = (array)$inventory->lots;
                            if (count($lots) > 0) {
                                foreach ($lots as $lot) {
                                    InventoryKardexDetail::create([
                                        'inventory_kardex_id' => $inventory_kardex->id,
                                        'detail' => 'Salida de la serie ' . $lot->series,
                                    ]);
                                }
                            }
                        }

                        $this->updateStock($inventory->item_id, $inventory->quantity, $inventory->warehouse_id);
                    } else {

                        $inventory_kardex = $this->createInventoryKardex($inventory, $inventory->item_id, -1 * $inventory->quantity, $inventory->warehouse_id);

                        if (isset($inventory->lots)) {
                            $lots = (array) $inventory->lots;
                            if (count($lots) > 0) {
                                foreach ($lots as $lot) {
                                    if ($lot->has_sale) {
                                        InventoryKardexDetail::create([
                                            'inventory_kardex_id' => $inventory_kardex->id,
                                            'detail' => 'Salida de la serie ' . $lot->series,
                                        ]);
                                    }
                                }
                            }
                        }
                        $this->updateStock($inventory->item_id, -1 * $inventory->quantity, $inventory->warehouse_id);
                    }
                    break;
            }
        });
    }
}
