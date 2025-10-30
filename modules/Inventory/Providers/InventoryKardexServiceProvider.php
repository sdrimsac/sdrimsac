<?php

namespace Modules\Inventory\Providers;

use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\Document;
use App\Models\Tenant\InventoryKardexDetail;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemColorSize;
use App\Models\Tenant\ItemPromotion;
use App\Models\Tenant\ItemSet;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\PurchaseItem;
use App\Models\Tenant\SaleNoteItem;
use App\Models\Tenant\SaleNoteItemPromotion;
use App\Models\Tenant\Warehouse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Modules\Inventory\Traits\InventoryTrait;
use Modules\Order\Models\OrderNote;
//use Modules\Order\Models\OrderNoteItem;
use Modules\Item\Models\ItemLotsGroup;
use Modules\Item\Models\ItemLot;
use Modules\Order\Models\OrderNoteItem;

class InventoryKardexServiceProvider extends ServiceProvider
{
    use InventoryTrait;

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->purchase();
        $this->sale();
        $this->sale_note();
        $this->sale_note_item_delete();
        $this->sale_document_type_03_delete();
        // $this->order_note();
        // $this->order_note_item_delete();
    }

    private function purchase()
    {
        PurchaseItem::created(function ($purchase_item) {

            $presentationQuantity = (!empty($purchase_item->item->presentation)) ? $purchase_item->item->presentation->quantity_unit : 1;

            $warehouse = ($purchase_item->warehouse_id) ? $this->findWarehouse($this->findWarehouseById($purchase_item->warehouse_id)->establishment_id) : $this->findWarehouse();
            // $warehouse = $this->findWarehouse($this->findWarehouseById($purchase_item->warehouse_id)->establishment_id);
            // $warehouse = $this->findWarehouse();
            //$this->createInventory($purchase_item->item_id, $purchase_item->quantity, $warehouse->id);
            $this->createInventoryKardex($purchase_item->purchase, $purchase_item->item_id, /*$purchase_item->quantity*/ ($purchase_item->quantity * $presentationQuantity), $warehouse->id);
            $this->updateStock($purchase_item->item_id, ($purchase_item->quantity * $presentationQuantity), $warehouse->id);
        });
    }

    private function sale()
    {
        DocumentItem::created(function ($document_item) {
            $inventory_kardex = null;
            $document = Document::whereIn('document_type_id', ['01', '03'])->find($document_item->document_id);
            if (isset($document->has_related_sale_note) && $document->has_related_sale_note == 1) return;
            $warehouse = ($document_item->warehouse_id) ? $this->findWarehouse($this->findWarehouseById($document_item->warehouse_id)->establishment_id) : $this->findWarehouse();
            $presentationQuantity = (!empty($document_item->item->presentation)) ? $document_item->item->presentation->quantity_unit : 1;
            if (!$document_item->item->is_set) {

                /* if ($document_item->item->promotions_items) {

                    // Obtener los items de la promoción
                    $promotion_item = ItemPromotion::where('item_id', $document_item->item_id)->get();

                    foreach ($promotion_item as $promo) {

                        $child_item = Item::find($promo->promotion_item_id);

                        if (!$child_item) {
                            Log::warning("Item promocional no encontrado. Promotion ID: {$promo->id}, promotion_item_id: {$promo->promotion_item_id}");
                            continue;
                        }

                        $promo_quantity = $document_item->quantity * $promo->quantity;

                        // Si el item es receta (is_set = 1)
                        if ($child_item->is_set) {
                            $recipe_items = ItemSet::where('item_id', $child_item->id)->get();

                            foreach ($recipe_items as $ingredient) {
                                $ingredient_item = Item::find($ingredient->individual_item_id);

                                if (!$ingredient_item) {
                                    Log::warning("Ingrediente no encontrado. ItemSet ID: {$ingredient->id}, individual_item_id: {$ingredient->individual_item_id}");
                                    continue;
                                }

                                $ingredient_quantity = $promo_quantity * $ingredient->quantity;

                                $this->createInventoryKardexSaleNote(
                                    $document_item->document,
                                    $ingredient_item->id,
                                    -$ingredient_quantity,
                                    $warehouse->id,
                                    $document_item->id
                                );

                                $this->updateStock($ingredient_item->id, -$ingredient_quantity, $warehouse->id);
                            }
                        } else {
                            // Item normal
                            $this->createInventoryKardexSaleNote(
                                $document_item->document,
                                $child_item->id,
                                -$promo_quantity,
                                $warehouse->id,
                                $document_item->id
                            );

                            $this->updateStock($child_item->id, -$promo_quantity, $warehouse->id);
                        }
                    }

                    // Terminó de procesar la promoción
                    return;
                } */

                if (isset($document_item->item) && $document_item->item->promotions_items == 1) {
                    /* Log::info('Item promocional detectado, se omite el descuento de stock: ' . $document_item->item->description); */
                    return;
                }

                $quantity = $document_item->quantity;

                if (isset($document_item->item->has_unit_type)) {
                    $unit_type = ItemUnitType::where('item_id', $document_item->item_id)
                        ->where('description', $document_item->item->has_unit_type)->first();
                    if ($unit_type) {

                        $quantity = $quantity * $unit_type->quantity_unit;
                    }
                } else if (isset($document_item->item->from_unit_type_id)) {
                    $unit_type = ItemUnitType::where('item_id', $document_item->item_id)
                        ->where('id', $document_item->item->from_unit_type_id)->first();
                    if ($unit_type) {
                        $quantity = $quantity * $unit_type->quantity_unit;
                    }
                }
                $document = $document_item->document;
                //Log::info("ver asddd $document");
                //$factor = ($document->document_type_id === '07') ? 1 : -1;
                if ($document) {
                    $factor = ($document->document_type_id === '07') ? 1 : -1;
                } else {
                    return;
                }

                $inventory_kardex = $this->createInventoryKardex($document_item->document, $document_item->item_id, ($factor * ($quantity * $presentationQuantity)), $warehouse->id);
                if (!$document_item->document->sale_note_id && !$document_item->document->order_note_id)
                    $this->updateStock($document_item->item_id, ($factor * ($quantity * $presentationQuantity)), $warehouse->id);
            } else {
                if ($document) {
                    $factor = ($document->document_type_id === '07') ? 1 : -1;
                } else {
                    return;
                }
                //$factor = ($document->document_type_id === '07') ? 1 : -1;
                //Log::info("verdasdasdasdadas $document");
                $item = Item::findOrFail($document_item->item_id);
                $document = $document_item->document;
                $inventory_kardex =  $this->createInventoryKardex($document_item->document, $document_item->item_id, ($factor * ($document_item->quantity * $presentationQuantity)), $warehouse->id);

                // $this->updateStock($document_item->item_id, ($factor * ($document_item->quantity * $presentationQuantity)), $warehouse->id);
                foreach ($item->sets as $it) {
                    $ind_item  = $it->individual_item;
                    $presentationQuantity = $it->quantity;

                    $document = $document_item->document;
                    $factor = ($document->document_type_id === '07') ? 1 : -1;
                    $warehouse = $this->findWarehouse();
                    $this->createInventoryKardex($document_item->document, $ind_item->id, ($factor * ($document_item->quantity * $presentationQuantity)), $warehouse->id);
                    if (!$document_item->document->sale_note_id && !$document_item->document->order_note_id) {
                        $this->updateStock($ind_item->id, ($factor * ($document_item->quantity * $presentationQuantity)), $warehouse->id);
                    }
                }
            }

            /* if (isset($document_item->item->IdLoteSelected)) {
                if ($document_item->item->IdLoteSelected != null) {
                    $lot = ItemLotsGroup::find($document_item->item->IdLoteSelected);
                    // $lot->quantity = ($lot->quantity - $document_item->quantity);
                    $lot->quantity = ($document->document_type_id === '07') ? ($lot->quantity + $document_item->quantity) : ($lot->quantity - $document_item->quantity);
                    Log::info('Cantidad Nueva dasfdfd: '. $lot->quantity);
                    $lot->save();
                }
            } */
            if (isset($document_item->item->color_size)) {
                foreach ($document_item->item->color_size as $it) {
                    $color_size_found = ItemColorSize::find($it->id);
                    if ($color_size_found) {
                        $quantity_color_size = $it->quantity ?? $it->selectedQuantity;
                        $color_size_found->stock = ($document->document_type_id === '07') ? ($color_size_found->stock + $quantity_color_size) : ($color_size_found->stock - $quantity_color_size);
                        $color_size_found->save();
                        InventoryKardexDetail::create([
                            'inventory_kardex_id' => $inventory_kardex->id,
                            'detail' => ($document->document_type_id === '07') ? 'Entrada del color ' . $it->color . ' y talla ' . $it->size : 'Salida del color ' . $it->color . ' y talla ' . $it->size,
                        ]);
                    }
                }
            }
            if (isset($document_item->item->lots)) {
                foreach ($document_item->item->lots as $it) {

                    // if($it->has_sale){
                    $r = ItemLot::find($it->id);
                    $r->has_sale = ($document->document_type_id === '07') ? false : true;
                    $r->save();
                    $detail = $r->has_sale ? 'Salida de la serie ' . $it->series : 'Entrada de la serie ' . $it->series;
                    InventoryKardexDetail::create([
                        'inventory_kardex_id' => $inventory_kardex->id,
                        'detail' => $detail,
                    ]);
                    // }
                    // $r->has_sale = true;
                }
                /*if($document_item->item->IdLoteSelected != null)
                {
                    $lot = ItemLotsGroup::find($document_item->item->IdLoteSelected);
                    $lot->quantity = ($lot->quantity - $document_item->quantity);
                    $lot->save();
                }*/
            }
            /* if (isset($document_item->item->lotes)) {
                foreach ($document_item->item->lotes as $it) {
                    Log::info('Lote ID: ' . $it->id);
                    $lot_found = ItemLotsGroup::find($it->id);
                    if ($lot_found) {
                        Log::info(''. $it->id);
                        $lot_found->quantity = $lot_found->quantity - $it->quantitySelected;
                        Log::info('Cantidad Nueva: '. $lot_found->quantity);
                        $lot_found->save();
                    }
                }
            } */
            if (isset($document_item->item->lotes)) {
                foreach ($document_item->item->lotes as $it) {
                    $lot_found = ItemLotsGroup::find($it->id);
                    Log::info('Lote ID: ' . $it->id . '' . $lot_found);
                    if ($lot_found) {
                        $quantityLot  = $it->quantitySelected;
                        Log::info('Cantidad del Lote asdfasdf: ' . $quantityLot);
                        if (isset($document_item->item->from_unit_type_id)) {
                            $unit_type = ItemUnitType::where('id', $document_item->item->from_unit_type_id)
                                ->first();
                            if ($unit_type) {
                                Log::info('Unidad de Medida asdasdfsdfsdf: ' . $unit_type->id . '' . $unit_type->quantity_unit);

                                $quantityLot = $it->quantitySelected * $unit_type->quantity_unit;
                            }
                        }
                        $lot_found->quantity = $lot_found->quantity - $quantityLot;
                        Log::info('Cantidad Nueva: ' . $lot_found->quantity);
                        $lot_found->save();
                    }
                }
            }
        });
    }


    private function sale_note()
    {
        SaleNoteItem::created(function ($sale_note_item) {

            if (isset($sale_note_item->item->lotes)) {
                foreach ($sale_note_item->item->lotes as $it) {
                    $lot_found = ItemLotsGroup::find($it->id);
                    if ($lot_found) {
                        $quantityLot  = $it->quantitySelected;
                        Log::info('Cantidad del Lote asdfasdf: ' . $quantityLot);
                        if (isset($sale_note_item->item->from_unit_type_id)) {
                            $unit_type = ItemUnitType::where('id', $sale_note_item->item->from_unit_type_id)
                                ->first();
                            if ($unit_type) {

                                $quantityLot = $it->quantitySelected * $unit_type->quantity_unit;
                            }
                        }
                        $lot_found->quantity = $lot_found->quantity - $quantityLot;
                        $lot_found->save();
                    }
                }
            }
            if (isset($sale_note_item->item->color_size)) {
                foreach ($sale_note_item->item->color_size as $it) {
                    $color_size_found = ItemColorSize::find($it->id);
                    if ($color_size_found) {
                        $color_size_found->stock = $color_size_found->stock - $it->quantity;
                        $color_size_found->save();
                    }
                }
            }
            if (isset($sale_note_item->item->lots)) {
                foreach ($sale_note_item->item->lots as $it) {
                    $serie_found = ItemLot::find($it->id);
                    if ($serie_found) {
                        $serie_found->has_sale = true;
                        $serie_found->save();
                    }
                }
            }
            if ($sale_note_item->item->is_stock == 'Si' && !$sale_note_item->sale_note->from_consignment) {
                if ($sale_note_item->warehouse_id) {
                    $warehouse = Warehouse::find($sale_note_item->warehouse_id);
                } else {
                    $warehouse = $this->findWarehouse($sale_note_item->sale_note->establishment_id);
                }
                /* if (!$sale_note_item->item->is_set) {
                    $quantity = $sale_note_item->quantity;

                    if (isset($sale_note_item->item->from_unit_type_id)) {
                        $unit_type = ItemUnitType::where('id', $sale_note_item->item->from_unit_type_id)
                            ->first();
                        if ($unit_type) {

                            $quantity = $quantity * $unit_type->quantity_unit;
                        }
                    }
                    $presentationQuantity = (!empty($sale_note_item->item->presentation)) ? $sale_note_item->item->presentation->quantity_unit : 1;

                    $this->createInventoryKardexSaleNote($sale_note_item->sale_note, $sale_note_item->item_id, (-1 * ($quantity * $presentationQuantity)), $warehouse->id, $sale_note_item->id);
                    if (!$sale_note_item->sale_note->order_note_id) {
                        $this->updateStock($sale_note_item->item_id, (-1 * ($quantity * $presentationQuantity)), $warehouse->id);
                    }
                } */

                if (!$sale_note_item->item->is_set) {

                    if (isset($sale_note_item->item) && $sale_note_item->item->promotions_items == 1) {
                        Log::info('Item promocional detectado, se omite el descuento de stock: ' . $sale_note_item->item->description);
                        return;
                    }

                    $quantity = $sale_note_item->quantity;

                    if (isset($sale_note_item->item->from_unit_type_id)) {
                        $unit_type = ItemUnitType::where('id', $sale_note_item->item->from_unit_type_id)->first();
                        if ($unit_type) {
                            $quantity = $quantity * $unit_type->quantity_unit;
                        }
                    }

                    $presentationQuantity = (!empty($sale_note_item->item->presentation))
                        ? $sale_note_item->item->presentation->quantity_unit
                        : 1;

                    $this->createInventoryKardexSaleNote(
                        $sale_note_item->sale_note,
                        $sale_note_item->item_id,
                        (-1 * ($quantity * $presentationQuantity)),
                        $warehouse->id,
                        $sale_note_item->id
                    );

                    if (!$sale_note_item->sale_note->order_note_id) {
                        $this->updateStock($sale_note_item->item_id, (-1 * ($quantity * $presentationQuantity)), $warehouse->id);
                    }
                } else {
                    $quantity = $sale_note_item->quantity;
                    $presentationQuantity = (!empty($sale_note_item->item->presentation)) ? $sale_note_item->item->presentation->quantity_unit : 1;
                    $this->createInventoryKardexSaleNote($sale_note_item->sale_note, $sale_note_item->item_id, (-1 * ($quantity * $presentationQuantity)), $warehouse->id, $sale_note_item->id);
                    $item = Item::findOrFail($sale_note_item->item_id);
                    foreach ($item->sets as $it) {
                        $ind_item  = $it->individual_item;
                        $presentationQuantity = $it->quantity;
                        // $this->createInventoryKardex($sale_note_item->sale_note, $ind_item->id , (-1 * ($sale_note_item->quantity * $presentationQuantity)), $warehouse->id);
                        $this->createInventoryKardexSaleNote($sale_note_item->sale_note, $ind_item->id, (-1 * ($sale_note_item->quantity * $presentationQuantity)), $warehouse->id, $sale_note_item->id);
                        if (!$sale_note_item->sale_note->order_note_id) $this->updateStock($ind_item->id, (-1 * ($sale_note_item->quantity * $presentationQuantity)), $warehouse->id);
                    }
                }
            }
        });
    }



    private function createInventory($item_id, $quantity, $warehouse_id)
    {
        if (!$this->checkInventory($item_id, $warehouse_id)) {
            $item = $this->findItem($item_id);
            $this->createInitialInventory($item_id, $item->stock + (-1 * $quantity), $warehouse_id);
        }
    }



    private function sale_note_item_delete()
    {
        SaleNoteItem::deleted(function ($sale_note_item) {

            // dd($sale_note_item);

            if (!$sale_note_item->item->is_set) {

                $presentationQuantity = (!empty($sale_note_item->item->presentation)) ? $sale_note_item->item->presentation->quantity_unit : 1;

                $warehouse = $this->findWarehouse();
                $this->deleteInventoryKardex($sale_note_item->sale_note, $sale_note_item->inventory_kardex_id);
                $this->updateStock($sale_note_item->item_id, (1 * ($sale_note_item->quantity * $presentationQuantity)), $warehouse->id);
            } else {

                $item = Item::findOrFail($sale_note_item->item_id);

                foreach ($item->sets as $it) {

                    $ind_item  = $it->individual_item;
                    $presentationQuantity = 1;
                    $warehouse = $this->findWarehouse();
                    $this->deleteInventoryKardex($sale_note_item->sale_note, $sale_note_item->inventory_kardex_id);
                    $this->updateStock($ind_item->id, (1 * ($sale_note_item->quantity * $presentationQuantity)), $warehouse->id);
                }
            }

            $this->deleteItemLots($sale_note_item);
        });
    }



    private function sale_document_type_03_delete()
    {

        Document::deleted(function ($document) {

            if ($document->document_type_id === '03' && $document->state_type_id === '01') {

                foreach ($document->items as $document_item) {


                    if (!$document_item->item->is_set) {

                        $presentationQuantity = (!empty($document_item->item->presentation)) ? $document_item->item->presentation->quantity_unit : 1;

                        $factor = 1;
                        $warehouse = $this->findWarehouse();

                        $this->deleteAllInventoryKardexByModel($document);

                        if (!$document->sale_note_id) $this->updateStock($document_item->item_id, ($factor * ($document_item->quantity * $presentationQuantity)), $warehouse->id);
                    } else {

                        $item = Item::findOrFail($document_item->item_id);

                        foreach ($item->sets as $it) {

                            $ind_item  = $it->individual_item;
                            $presentationQuantity = 1;
                            $factor = 1;
                            $warehouse = $this->findWarehouse();

                            $this->deleteAllInventoryKardexByModel($document);
                            if (!$document->sale_note_id) $this->updateStock($ind_item->id, ($factor * ($document_item->quantity * $presentationQuantity)), $warehouse->id);
                        }
                    }
                }
            }
        });
    }



    private function order_note()
    {

        OrderNoteItem::created(function ($order_note_item) {

            $presentationQuantity = (!empty($order_note_item->item->presentation)) ? $order_note_item->item->presentation->quantity_unit : 1;

            $warehouse = $this->findWarehouse($order_note_item->order_note->establishment_id);
            $this->createInventoryKardex($order_note_item->order_note, $order_note_item->item_id, (-1 * ($order_note_item->quantity * $presentationQuantity)), $warehouse->id);
            $this->updateStock($order_note_item->item_id, (-1 * ($order_note_item->quantity * $presentationQuantity)), $warehouse->id);
        });
    }


    private function order_note_item_delete()
    {

        OrderNoteItem::deleted(function ($order_note_item) {

            // dd($order_note_item);
            $presentationQuantity = (!empty($order_note_item->item->presentation)) ? $order_note_item->item->presentation->quantity_unit : 1;

            $warehouse = $this->findWarehouse($order_note_item->order_note->establishment_id);

            $this->createInventoryKardex($order_note_item->order_note, $order_note_item->item_id, (1 * ($order_note_item->quantity * $presentationQuantity)), $warehouse->id);

            $this->updateStock($order_note_item->item_id, (1 * ($order_note_item->quantity * $presentationQuantity)), $warehouse->id);
        });
    }
}
