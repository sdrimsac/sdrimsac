<?php

namespace App\Traits;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Models\Tenant\Document;
use \App\Models\Tenant\SaleNote;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemUnitType;
use Carbon\Carbon;

/**
 * 
 */
trait CheckEditTrait
{
    /**
     * Get type doc
     * @param  \App\Models\Tenant\Document $document  
     * @return int
     */

    public function checkEditAndSendMessage($document)
    {
        $documentTypeDescription = $document->document_type->description ?? 'Documento';
        $serie = $document->series;
        $number = $document->number;
        $date_of_issue = Carbon::parse($document->date_of_issue)->format('d/m/Y');
        $establishment_name = auth()->user()->establishment->description ?? '';
        $user_name = $document->user->name ?? '';

        $seriePrefix = substr($serie, 0, 2);

        // Ver si es una nota de venta o documento
        $items = collect();
        if ($seriePrefix === 'NV') {
            $sale_note = SaleNote::with('items.relation_item')->find($document->id);
            $items = $sale_note ? $sale_note->items : collect();
        } else {
            $document = Document::with('items.relation_item')->find($document->id);
            $items = $document ? $document->items : collect();
        }

        // Comparar precios
        $price_changes = [];

        foreach ($items as $doc_item) {
            $item = Item::select('sale_unit_price', 'description', 'sale_affectation_igv_type_id')->find($doc_item->item_id);
            if (!$item) continue;

            // Obtener el precio esperado
            $real_price = null;
            
            // Verificar si se usó una política de precio
            $doc_item_data = $doc_item->item;
            $item_unit_type_id = isset($doc_item_data->item_unit_type_id) ? $doc_item_data->item_unit_type_id : null;

            if ($item_unit_type_id) {
                // Si se usó política de precio, obtener el precio de la política
                $item_unit_type = ItemUnitType::find($item_unit_type_id);
                
                if ($item_unit_type) {
                    // Obtener el precio según el price_default de la política
                    switch ($item_unit_type->price_default) {
                        case 1:
                            $real_price = $item_unit_type->price1;
                            break;
                        case 2:
                            $real_price = $item_unit_type->price2;
                            break;
                        case 3:
                            $real_price = $item_unit_type->price3;
                            break;
                    }
                }
            }

            // Si no hay política de precio, usar el precio base del item
            if ($real_price === null) {
                // Validar afectación IGV
                if ($item->sale_affectation_igv_type_id === '10') {
                    // Precio incluye IGV, obtener precio sin IGV
                    $real_price = $item->sale_unit_price / 1.18;
                } else {
                    // Exonerado u otros, el precio se mantiene igual
                    $real_price = $item->sale_unit_price;
                }
            }

            $sold_price = $doc_item->unit_value;

            // Redondear precios a 2 decimales para comparación
            $real_price = round($real_price, 2);
            $sold_price = round($sold_price, 2);

            // Comparar precios con tolerancia de 2 decimales
            if (abs($real_price - $sold_price) > 0.01) {
                $price_changes[] = [
                    'item' => $item->description,
                    'old_price' => number_format($real_price, 2),
                    'new_price' => number_format($sold_price, 2),
                ];
            }
    }

        // Enviar mensaje si hay diferencias
        if (!empty($price_changes)) {
            $message = "– 📢 NOTIFICACIÓN EDICIÓN DE PRECIO DE PRODUCTO\n\n";
            $message .= "ESTABLECIMIENTO {$establishment_name} usuario {$user_name}. ";
            $message .= "Ha editado el precio unitario de los siguientes ítems:\n\n";

            foreach ($price_changes as $change) {
                $message .= "🔸 {$change['item']} → Precio Real. S/{$change['old_price']} → precio Editado S/{$change['new_price']}\n";
            }

            $message .= "\nEn el Documento {$documentTypeDescription} {$serie}-{$number} de fecha {$date_of_issue}.";

            (new WhatsappController)->sendMessageAllSupprotEdit($message);
        }
    }
}
