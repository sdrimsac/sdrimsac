<?php

namespace App\Traits;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\SaleNotePromotion;
use Carbon\Carbon;

/**
 * 
 */
trait CheckTotalTrait
{
    /**
     * Get type doc
     * @param  string $documentType
     * @return int
     */
    public function checkTotalAndSendMessage($document) {
        $documentTypeDescription = $document->document_type->description;
        $serie = $document->series;
        $number = $document->number;
        $date_of_issue = Carbon::parse($document->date_of_issue)->format('d/m/Y');
        $total = $document->total;
        if($total <= 0){

            $isHotelPromotionRedemption = false;

            try {
                // Only Sale Notes will have a SaleNotePromotion associated
                $isHotelPromotionRedemption = SaleNotePromotion::where('sale_note_id', $document->id)->exists();
            } catch (\Throwable $e) {
            }
            
            $message = "El documento {$documentTypeDescription} {$serie}-{$number} de fecha {$date_of_issue} ha sido emitido con un valor igual o menor a 0 (Total: {$total})";

            if ($isHotelPromotionRedemption) {
                $message .= " :CANJE PROMOCIÓN HOTEL. ";
            }

            (new WhatsappController)->sendMessageAllSupprot($message);
        }

    }
}


        
    
