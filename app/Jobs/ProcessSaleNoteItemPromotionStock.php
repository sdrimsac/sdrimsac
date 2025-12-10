<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\Events\MessageEvent;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemPromotion;
use App\Models\Tenant\ItemSet;
use App\Models\Tenant\SaleNoteItem;
use App\Models\Tenant\SaleNoteItemPromotion;
use App\Traits\JobReportTrait;
use Exception;
use Hyn\Tenancy\Environment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Inventory\Traits\InventoryTrait;
use Modules\Restaurant\Models\CashStockMovement;

class ProcessSaleNoteItemPromotionStock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use InventoryTrait;

    protected $sale_note_item_id;
    protected $warehouse_id;

    /**
     * Create a new job instance.
     */
    public function __construct($sale_note_item_id, $warehouse_id)
    {
        $this->sale_note_item_id = $sale_note_item_id;
        $this->warehouse_id = $warehouse_id;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $sale_note_item = SaleNoteItem::find($this->sale_note_item_id);
        if (!$sale_note_item) {
            Log::warning("❌ SaleNoteItem no encontrado. ID: {$this->sale_note_item_id}");
            return;
        }
        Log::info("PASO POR AQUI EL JOB");

        // Log básico del item y su estado (convertir con seguridad si viene como stdClass)
        $item_info = null;
        if ($sale_note_item->item) {
            $related_item = $sale_note_item->item;
            if (is_object($related_item)) {
                if (method_exists($related_item, 'toArray')) {
                    $item_info = $related_item->toArray();
                } else {
                    // stdClass u otro objeto: castear a array para evitar error "toArray"
                    $item_info = (array) $related_item;
                }
            } else {
                $item_info = $related_item;
            }
        }

        if (!$sale_note_item->item || !$sale_note_item->item->promotions_items) {
            Log::info("No hay promociones configuradas para el ítem asociado.", ['item_id' => $sale_note_item->item_id]);
            return; // No hay promociones
        }

        // Si no nos pasaron warehouse_id, intentar resolverlo desde la sale_note -> establishment
        if (empty($this->warehouse_id)) {
            try {
                $establishment_id = null;
                if (isset($sale_note_item->sale_note->establishment_id)) {
                    $establishment_id = $sale_note_item->sale_note->establishment_id;
                } elseif (isset($sale_note_item->sale_note->establishment) && isset($sale_note_item->sale_note->establishment->id)) {
                    $establishment_id = $sale_note_item->sale_note->establishment->id;
                }

                $warehouse = $this->findWarehouse($establishment_id);
                if ($warehouse && isset($warehouse->id)) {
                    $this->warehouse_id = $warehouse->id;
                    //Log::info('Warehouse id resuelto automáticamente', ['warehouse_id' => $this->warehouse_id, 'establishment_id' => $establishment_id]);
                } else {
                    //Log::warning('No se pudo resolver warehouse_id automáticamente', ['establishment_id' => $establishment_id]);
                }
            } catch (Exception $e) {
                //Log::error('Error resolviendo warehouse por establecimiento', ['exception' => $e->getMessage()]);
            }
        }


        //$promotion_item = ItemPromotion::where('item_id', $sale_note_item->item_id)->get();

        // Obtener solo los ítems seleccionados
        $selected_promos = SaleNoteItemPromotion::where('sale_note_item_id', $this->sale_note_item_id)->get();
        //Log::info('Promociones seleccionadas encontradas', ['count' => $selected_promos->count(), 'sale_note_item_id' => $this->sale_note_item_id]);

        if ($selected_promos->isEmpty()) {
            return; // Nada que procesar
        }

        foreach ($selected_promos as $selected) {

            $child_item = Item::find($selected->item_id);
            if (!$child_item) {
                Log::warning("Item promocional seleccionado no encontrado. SaleNoteItemPromotion ID: {$selected->id}");
                continue;
            }

            // Cantidad total a descontar considerando la cantidad vendida
            $selected_qty = $selected->quantity ?? 1;
            $promo_quantity = $sale_note_item->quantity * $selected_qty;

            /* Log::info('Procesando promocional', [
                'sale_note_item_promotion_id' => $selected->id,
                'promo_item_id' => $selected->item_id,
                'promo_item_description' => $child_item->description ?? null,
                'selected_qty' => $selected_qty,
                'sale_note_item_qty' => $sale_note_item->quantity,
                'promo_quantity_total' => $promo_quantity,
                'warehouse_id' => $this->warehouse_id,
            ]); */

            if ($child_item->is_set) {
                // Si el ítem es un set (receta)
                $recipe_items = ItemSet::where('item_id', $child_item->id)->get();
                foreach ($recipe_items as $ingredient) {
                    $ingredient_item = Item::find($ingredient->individual_item_id);
                    if (!$ingredient_item) continue;

                    $ingredient_quantity = $promo_quantity * $ingredient->quantity;

                    try {
                        // Registrar en kardex
                        $this->createInventoryKardexSaleNote(
                            $sale_note_item->sale_note,
                            $ingredient_item->id,
                            -$ingredient_quantity,
                            $this->warehouse_id,
                            $sale_note_item->id
                        );
                        //Log::info('Kardex creado para ingrediente', ['ingredient_item_id' => $ingredient_item->id, 'quantity' => -$ingredient_quantity]);
                    } catch (Exception $e) {
                        //Log::error('Error creando kardex para ingrediente', ['exception' => $e->getMessage(), 'ingredient_item_id' => $ingredient_item->id]);
                    }

                    try {
                        // Descontar stock
                        $this->updateStock($ingredient_item->id, -$ingredient_quantity, $this->warehouse_id);
                        //Log::info('Stock actualizado para ingrediente', ['ingredient_item_id' => $ingredient_item->id, 'delta' => -$ingredient_quantity]);
                    } catch (Exception $e) {
                        //Log::error('Error actualizando stock para ingrediente', ['exception' => $e->getMessage(), 'ingredient_item_id' => $ingredient_item->id]);
                    }

                    // Registrar movimiento en caja
                    if ($sale_note_item->sale_note->cash_id) {
                        $this->registrarMovimiento(
                            $sale_note_item->sale_note->cash_id,
                            $ingredient_item->id,
                            $ingredient_quantity,
                            $this->warehouse_id,
                            'sale_note'
                        );
                    }
                }
            } else {
                // Item normal
                try {
                    $this->createInventoryKardexSaleNote(
                        $sale_note_item->sale_note,
                        $child_item->id,
                        -$promo_quantity,
                        $this->warehouse_id,
                        $sale_note_item->id
                    );
                    //Log::info('Kardex creado para item promocional', ['item_id' => $child_item->id, 'quantity' => -$promo_quantity]);
                } catch (Exception $e) {
                    //Log::error('Error creando kardex para item promocional', ['exception' => $e->getMessage(), 'item_id' => $child_item->id]);
                }

                try {
                    $this->updateStock($child_item->id, -$promo_quantity, $this->warehouse_id);
                    //Log::info('Stock actualizado para item promocional', ['item_id' => $child_item->id, 'delta' => -$promo_quantity]);
                } catch (Exception $e) {
                    //Log::error('Error actualizando stock para item promocional', ['exception' => $e->getMessage(), 'item_id' => $child_item->id]);
                }

                // Registrar movimiento en caja
                if ($sale_note_item->sale_note->cash_id) {
                    $this->registrarMovimiento(
                        $sale_note_item->sale_note->cash_id,
                        $child_item->id,
                        $promo_quantity,
                        $this->warehouse_id,
                        'sale_note'
                    );
                }
            }
        }
    }

    private function registrarMovimiento($cash_id, $item_id, $quantity, $warehouse_id, $tipo)
    {
       Log::info("Registrando movimiento en CashStockMovement jkjkjkkjkjkjkjkkjk - Cash ID: {$cash_id}, Item ID: {$item_id}, Cantidad: {$quantity}");
        try {
            // Usar firstOrNew para crear o recuperar el registro
            $movement = CashStockMovement::firstOrNew([
                'cash_id' => $cash_id,
                'item_id' => $item_id,
            ]);

            // Si es nuevo, establecer valores iniciales
            if (!$movement->exists) {
                $movement->warehouse_id = $warehouse_id;
                $movement->initial_stock = 0;
                $movement->purchases = 0;
                $movement->sold_quantity = 0;
                $movement->current_stock = 0;
            }

            // Acumular cantidad vendida y actualizar stock actual
            $movement->sold_quantity = ($movement->sold_quantity ?? 0) + $quantity;
            $movement->current_stock = ($movement->current_stock ?? 0) - $quantity;
            $movement->movement_type = $tipo;

            $movement->save();

            Log::info("Movimiento registrado en CashStockMovement qqqqqqqqqqqqqqqqqqqqqqq - Cash ID: {$cash_id}, Item ID: {$item_id}, Cantidad: {$quantity}");
        } catch (\Exception $e) {
            Log::error("Error al registrar movimiento en CashStockMovement zzzzzzzz: " . $e->getMessage());
        }
    }
}
