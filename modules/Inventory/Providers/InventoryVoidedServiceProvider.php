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

    /* private function voided()
    {
        //Revisar los tipos de documentos, ello varia el control de stock en las anulaciones.
        Document::updated(function ($document) {
            if ($document['document_type_id'] == '01' || $document['document_type_id'] == '03') {
                if (in_array($document['state_type_id'], ['09', '11'], true)) {
                    $warehouse = $this->findWarehouse($document['establishment_id']);
                    if ($document['state_type_id'] == '09') {
                        $company = Company::first();
                        $company_name = $company->name;
                        $message = "El documento con serie {$document['series']} y número {$document['number']} de la empresa {$company_name} ha sido rechazado";
                        (new WhatsappController)->sendMessageAllSupprot($message);
                    }
                    foreach ($document['items'] as $detail) {
                        $lots = isset($detail['item']->lots) ? $detail['item']->lots : [];

                        foreach ($lots as $lot) {
                            $has_sale_note = $document->sale_note_id != null;
                            if (!$has_sale_note) {
                                ItemLot::find($lot->id)->update(["has_sale" => 0]);
                            }
                        }
                        $quantity = $detail['quantity'];
                        if (isset($detail['item']->has_unit_type)) {
                            $unit_type = ItemUnitType::where('item_id', $detail['item_id'])
                                ->where('description', $detail['item']->has_unit_type)->first();
                            if ($unit_type) {

                                $quantity = $quantity * $unit_type->quantity_unit;
                            }
                        }
                        $warehouse_id = isset($detail['warehouse_id']) ? $detail['warehouse_id'] : null;
                        // dd($detail['item']->presentation);
                        $presentationQuantity = (!empty($detail['item']->presentation)) ? $detail['item']->presentation->quantity_unit : 1;

                        $this->createInventoryKardex($document, $detail['item_id'], $detail['quantity'] * $presentationQuantity,  $warehouse_id ?? $warehouse->id);
                        $has_sale_note = $document->sale_note_id != null;
                        if (!$has_sale_note) {
                            $this->updateStock($detail['item_id'], $detail['quantity'] * $presentationQuantity, $warehouse_id ?? $warehouse->id);
                            $this->updateDataLots($detail);
                        }
                    }

                    $this->voidedWasDeductedPrepayment($document);
                }
            }
        });
    } */

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

                        /* dump($item_data); */

                        //$item_data = json_decode(json_encode($detail['item']), true);
                        /* dump($item_data); */

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
                                }

                                $this->createInventoryKardex($document, $component_item->id, $component_total, $warehouse->id);
                            }

                            // 🍽 También devolver stock al ítem principal (plato)
                            $item_warehouse = $item->warehouses()->where('warehouse_id', $warehouse_id)->first();
                            if ($item_warehouse) {
                                $item_warehouse->stock += $total_quantity;
                                $item_warehouse->save();
                            }

                            $this->createInventoryKardex($document, $item->id, $total_quantity, $warehouse_id);

                            // ⛔ Saltar el resto de la lógica
                            continue;
                        }

                        /* if (isset($item_data['color_size']) && is_array($item_data['color_size'])) {

                            $color_sizes = $item_data['color_size'];

                            foreach ($color_sizes as $cs) {
                                if (!isset($cs['id']) || !isset($cs['quantity'])) continue;

                                DB::connection('tenant')
                                    ->table('item_colors_sizes')
                                    ->where('id', $cs['id'])
                                    ->increment('stock', $cs['quantity']);
                            }

                            continue;
                        } */

                        if (isset($item_data['color_size']) && is_array($item_data['color_size']) && count($item_data['color_size']) > 0) {

                            $stockRestored = false;

                            foreach ($item_data['color_size'] as $cs) {
                                if (!isset($cs['id']) || !isset($cs['quantity'])) continue;

                                DB::connection('tenant')
                                    ->table('item_colors_sizes')
                                    ->where('id', $cs['id'])
                                    ->increment('stock', $cs['quantity']);

                                $stockRestored = true;
                            }

                            if ($stockRestored) {
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
