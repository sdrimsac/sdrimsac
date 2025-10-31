<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\Models\Tenant\Item;
use App\Models\Tenant\ItemPromotion;
use App\Models\Tenant\ItemSet;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Modules\Restaurant\Models\CashStockMovement;

class ProcesarCashDocumentStockMovement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $row;
    protected $document_item;
    protected $cash;

    public function __construct($row, $document_item, $cash)
    {
        $this->row = $row;
        $this->document_item = $document_item;
        $this->cash = $cash;
    }

    public function handle()
    {
        try {
            $row = $this->row;
            $document_item = $this->document_item;

            $cash = $this->cash;

            // Nota: el init_report debe evaluarse por el ítem afectado. Para recetas
            // se debe verificar cada componente, y para promociones se debe verificar
            // el/los ítems de la promoción o sus componentes si son sets.

            $cash_id = $cash->id ?? null;

            if (!$cash_id) {
                // Log::warning('No se encontró caja abierta para registrar CashStockMovement (sale_note)', ['item_id' => $row['item_id'] ?? null]);
                return;
            }

            // identificar item vendido
            $item_id = $document_item->item_id ?? ($row['item_id'] ?? null);
            $quantity = $row['quantity'] ?? ($document_item->quantity ?? 0);
            $item = Item::find($item_id);

            if (!$item) return;

            // Si es receta: verificar init_report de cada componente
            if ($item->is_set) {
                $componentes = ItemSet::where('item_id', $item->id)->get();
                foreach ($componentes as $componente) {
                    $compItem = Item::find($componente->individual_item_id);
                    $compInit = (int)($compItem->init_report ?? 0);
                    if ($compInit === 1) {
                        $this->registrarMovimiento($cash_id, $componente->individual_item_id, $componente->quantity * $quantity, $row, 'receta');
                    } else {
                        //Log::info('Saltando componente sin init_report', ['component_item_id' => $componente->individual_item_id, 'init_report' => $compInit]);
                    }
                }
            }
            // Si es promoción: recorrer los items de la promoción y actuar según sean sets o normales
            elseif ($item->promotions_items) {
                $promociones = ItemPromotion::where('item_id', $item->id)->get();
                foreach ($promociones as $promo) {
                    // el item promocionado
                    $promoItem = Item::find($promo->promotion_item_id);
                    if (!$promoItem) continue;

                    if ($promoItem->is_set) {
                        // si el item promocionado es un set, obtener sus componentes
                        $promoComponents = ItemSet::where('item_id', $promoItem->id)->get();
                        foreach ($promoComponents as $pc) {
                            $pcItem = Item::find($pc->individual_item_id);
                            $pcInit = (int)($pcItem->init_report ?? 0);
                            if ($pcInit === 1) {
                                // multiplicar por la cantidad de la promo y la cantidad vendida
                                $this->registrarMovimiento($cash_id, $pc->individual_item_id, $pc->quantity * ($promo->quantity * $quantity), $row, 'promocion_receta');
                            } else {
                                //Log::info('Saltando componente de promocion sin init_report', ['component_item_id' => $pc->individual_item_id, 'init_report' => $pcInit]);
                            }
                        }
                    } else {
                        // item promocionado normal: verificar init_report en el propio item promocionado
                        $promoInit = (int)($promoItem->init_report ?? 0);
                        if ($promoInit === 1) {
                            $this->registrarMovimiento($cash_id, $promo->promotion_item_id, $promo->quantity * $quantity, $row, 'promocion');
                        } else {
                           // Log::info('Saltando item promocionado sin init_report', ['promotion_item_id' => $promo->promotion_item_id, 'init_report' => $promoInit]);
                        }
                    }
                }
            }
            // Item normal: verificar su propio init_report
            else {
                $itemInit = (int)($item->init_report ?? 0);
                if ($itemInit === 1) {
                    $this->registrarMovimiento($cash_id, $item_id, $quantity, $row, 'venta');
                } else {
                   // Log::info('Saltando item normal sin init_report', ['item_id' => $item_id, 'init_report' => $itemInit]);
                }
            }
            
        } catch (\Exception $e) {
           // Log::warning('Error en Job ProcesarCashStockMovement: ' . $e->getMessage(), ['row' => $this->row]);
        }
    }

    private function registrarMovimiento($cash_id, $item_id, $quantity, $row, $tipo)
    {
        // Usar firstOrNew para crear o recuperar la fila y garantizar consistencia
        $movement = CashStockMovement::firstOrNew([
            'cash_id' => $cash_id,
            'item_id' => $item_id,
        ]);

        // asegurar valores por defecto
        $movement->warehouse_id = $movement->warehouse_id ?? ($row['item']['warehouse_id'] ?? $row['warehouse_id'] ?? null);
        $movement->initial_stock = $movement->initial_stock ?? 0;
        $movement->purchases = $movement->purchases ?? 0;

        // acumular cantidades
        $movement->sold_quantity = ($movement->sold_quantity ?? 0) + $quantity;
        $movement->current_stock = ($movement->current_stock ?? 0) - $quantity;
        $movement->movement_type = $tipo;

        $movement->save();
    }
}
