<?php

namespace Modules\Inventory\Providers;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Company;
use Modules\Order\Models\OrderNote;
use App\Models\Tenant\Document;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemUnitType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Modules\Inventory\Traits\InventoryTrait;
use Modules\Item\Models\ItemLot;

class InventoryVoidedServiceProvider extends ServiceProvider
{
    use InventoryTrait;

    public function register() {}

    public function boot()
    {
        $this->voided();
        // $this->voided_order_note();
    }

    private function voided()
    {
        Document::updated(function ($document) {
            if (in_array($document['document_type_id'], ['01', '03'])) {
                if (in_array($document['state_type_id'], ['09', '11'], true)) {

                    $warehouse = $this->findWarehouse($document['establishment_id']);

                    if ($document['state_type_id'] == '09') {
                        $company = Company::first();
                        $company_name = $company->name;
                        $message = "El documento con serie {$document['series']} y número {$document['number']} de la empresa {$company_name} ha sido rechazado";
                        (new WhatsappController)->sendMessageAllSupprot($message);
                    }

                    foreach ($document['items'] as $detail) {
                        $item = Item::find($detail['item_id']);
                        $item_sets = $item->sets;

                        $item_data = is_string($detail['item'])
                            ? json_decode($detail['item'], true)
                            : (array) $detail['item'];

                        $quantity = $detail['quantity'];
                        if (isset($detail['item']->has_unit_type)) {
                            $unit_type = ItemUnitType::where('item_id', $detail['item_id'])
                                ->where('description', $detail['item']->has_unit_type)->first();
                            if ($unit_type) {
                                $quantity *= $unit_type->quantity_unit;
                            }
                        }

                        $presentationQuantity = (!empty($detail['item']->presentation)) ? $detail['item']->presentation->quantity_unit : 1;
                        $total_quantity = $quantity * $presentationQuantity;
                        $warehouse_id = $detail['warehouse_id'] ?? $warehouse->id;

                        if ($item_sets && $item_sets->count() > 0) {
                            // 🧩 Devolver stock a cada componente de la receta
                            foreach ($item_sets as $component) {
                                $component_total = $detail['quantity'] * $component->quantity;
                                $component_item = Item::find($component->individual_item_id);

                                $item_warehouse = $component_item->warehouses()->where('warehouse_id', $warehouse->id)->first();
                                if ($item_warehouse) {
                                    $item_warehouse->stock += $component_total;
                                    $item_warehouse->save();
                                    /* Log::info("Stock actualizado", [
                                        'item_id' => $component_item->id,
                                        'warehouse_id' => $warehouse->id,
                                        'nuevo_stock' => $item_warehouse->stock
                                    ]); */
                                }

                                $this->createInventoryKardex($document, $component_item->id, $component_total, $warehouse->id);
                            }

                            // 🍽 También devolver stock al ítem principal (plato)
                            $item_warehouse = $item->warehouses()->where('warehouse_id', $warehouse->id)->first();
                            if ($item_warehouse) {
                                $item_warehouse->stock += $total_quantity;
                                $item_warehouse->save();
                                /* Log::info("Stock actualizado", [
                                    'item_id' => $item->id,
                                    'warehouse_id' => $warehouse->id,
                                    'nuevo_stock' => $item_warehouse->stock
                                ]); */
                            }

                            $this->createInventoryKardex($document, $item->id, $total_quantity, $warehouse->id);

                            // ⛔ Saltar el resto de la lógica
                            continue;
                        }

                        if (isset($item_data['color_size']) && is_array($item_data['color_size']) && count($item_data['color_size']) > 0) {
                            $stockRestored = false;
                            $totalColorSizeQuantity = 0;

                            foreach ($item_data['color_size'] as $cs) {
                                $cs = (array)$cs;

                                if (!isset($cs['id']) || !isset($cs['quantity'])) {
                                    Log::warning("Color/Size item skipped due to missing id or quantity", ['cs' => $cs]);
                                    continue;
                                }

                                try {
                                    // Actualizar el stock en item_colors_sizes
                                    DB::connection('tenant')
                                        ->table('item_colors_sizes')
                                        ->where('id', $cs['id'])
                                        ->increment('stock', $cs['quantity']);

                                    $totalColorSizeQuantity += $cs['quantity'];

                                    // Crear kardex para este color/talla específico
                                    $this->createInventoryKardex(
                                        $document,
                                        $detail['item_id'],
                                        $cs['quantity'],
                                        $warehouse_id,
                                        "Devolución de stock - Color/Talla ID: {$cs['id']}"
                                    );

                                    $stockRestored = true;
                                } catch (\Exception $e) {
                                    Log::error("Error restoring stock for color/size", [
                                        'error' => $e->getMessage(),
                                        'cs' => $cs,
                                        'item_id' => $detail['item_id']
                                    ]);
                                }
                            }

                            if ($stockRestored) {
                                // Actualizar el stock en item_warehouse
                                $item_warehouse = $item->warehouses()->where('warehouse_id', $warehouse_id)->first();
                                if ($item_warehouse) {
                                    $item_warehouse->stock += $totalColorSizeQuantity;
                                    $item_warehouse->save();
                                    /* Log::info("Stock general actualizado", [
                                        'item_id' => $item->id,
                                        'warehouse_id' => $warehouse_id,
                                        'nuevo_stock' => $item_warehouse->stock
                                    ]); */
                                }
                                
                                // Si se restauró el stock de color/talla, continuamos con el siguiente item
                                continue;
                            }
                        }


                        // Lotes
                        $lots = isset($detail['item']->lots) ? $detail['item']->lots : [];
                        foreach ($lots as $lot) {
                            if (!$document->sale_note_id) {
                                ItemLot::find($lot->id)->update(["has_sale" => 0]);
                            }
                        }

                        // Crear kardex para ítem normal
                        $this->createInventoryKardex($document, $detail['item_id'], $total_quantity, $warehouse_id);

                        if (!$document->sale_note_id) {
                            $this->updateStock($detail['item_id'], $total_quantity, $warehouse_id);
                            $this->updateDataLots($detail);
                        }
                    }

                    $this->voidedWasDeductedPrepayment($document);
                }
            }
        });
    }

    private function voidedWasDeductedPrepayment($document)
    {

        if ($document->prepayments) {

            foreach ($document->prepayments as $row) {
                $fullnumber = explode('-', $row->number);
                $series = $fullnumber[0];
                $number = $fullnumber[1];

                $doc = Document::where([['series', $series], ['number', $number]])->first();
                if ($doc) {
                    $doc->was_deducted_prepayment = false;
                    $doc->save();
                }
            }
        }
    }

    private function voided_order_note()
    {

        OrderNote::updated(function ($order_note) {

            if (in_array($order_note->state_type_id, ['09', '11'], true)) {

                $warehouse = $this->findWarehouse($order_note->establishment_id);

                foreach ($order_note->items as $order_note_item) {

                    $presentationQuantity = (!empty($order_note_item->item->presentation)) ? $order_note_item->item->presentation->quantity_unit : 1;

                    $this->createInventoryKardex($order_note, $order_note_item->item_id, $order_note_item->quantity * $presentationQuantity, $warehouse->id);
                    $this->updateStock($order_note_item->item_id, $order_note_item->quantity * $presentationQuantity, $warehouse->id);
                }
            }
        });
    }
}
