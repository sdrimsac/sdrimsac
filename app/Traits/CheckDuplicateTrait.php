<?php

namespace App\Traits;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Models\Tenant\Document;
use App\Models\Tenant\Establishment;
use Carbon\Carbon;

/**
 * 
 */
trait CheckDuplicateTrait
{
    /**
     * Get type doc
     * @param  \App\Models\Tenant\Document $document  
     * @return int
     */
    /* public function checkDuplicateAndSendMessage($document) {
        $documentTypeDescription = $document->document_type->description;
        $serie = $document->series;
        $number = $document->number;
        $date_of_issue = Carbon::parse($document->date_of_issue)->format('d/m/Y');

        $message = "El documento {$documentTypeDescription} {$serie}-{$number} de fecha {$date_of_issue} se ha duplicado.";
        (new WhatsappController)->sendMessageAllSupprotDuplicate($message);
    } */
    public function checkDuplicateAndSendMessage($document)
    {
        $documentTypeDescription = $document->document_type->description;
        $serie = $document->series;
        $number = $document->number;
        $total = $document->total;
        $date_of_issue = Carbon::parse($document->date_of_issue)->format('d/m/Y');

        // Buscar si ya existe otro documento con los mismos valores
        $exists = Document::where('series', $serie)
            ->where('number', $number)
            ->where('total', $total)
            ->where('id', '!=', $document->id) // Excluir el mismo documento si es una actualización
            ->exists();

        if ($exists) {
            $message = "⚠️ El documento {$documentTypeDescription} {$serie}-{$number} de fecha {$date_of_issue} se ha duplicado con el mismo total ({$total}).  mensaje de pruebas";
            (new WhatsappController)->sendMessageAllSupprotDuplicate($message);
        }
    }
}
