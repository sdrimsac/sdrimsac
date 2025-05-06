<?php

namespace App\Traits;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Models\Tenant\Document;
use \App\Models\Tenant\SaleNote;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
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
            $item = Item::select('sale_unit_price', 'description')->find($doc_item->item_id);

            if (!$item) continue;

            $current_price = number_format($item->sale_unit_price, 2);
            $sold_price = number_format($doc_item->unit_value, 2);

            if ($current_price != $sold_price) {
                $price_changes[] = [
                    'item' => $item->description,
                    'old_price' => $current_price,
                    'new_price' => $sold_price,
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
