<?php

namespace App\Traits;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Models\Tenant\Document;
use \App\Models\Tenant\SaleNote;
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

        // Check if it's a sale note (NV prefix) or regular document (B or F prefix)
        $seriePrefix = substr($serie, 0, 2);
        
        if ($seriePrefix === 'NV') {
            // Search in sale_notes table
            $duplicate = SaleNote::where('series', $serie)
                ->where('number', $number)
                ->where('total', $total)
                ->where('id', '!=', $document->id)
                ->first();
        } else {
            // Search in documents table for B or F series
            $duplicate = Document::where('series', $serie)
                ->where('number', $number)
                ->where('total', $total)
                ->where('id', '!=', $document->id)
                ->first();
        }

        if ($duplicate) {
            $message = "El documento {$documentTypeDescription} {$serie}-{$number} de fecha {$date_of_issue} con el mismo total de {$total} se ha duplicado.";
            (new WhatsappController)->sendMessageAllSupprotDuplicate($message);
        }
    }
}
