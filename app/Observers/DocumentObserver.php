<?php

namespace App\Observers;

use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use Exception;

class DocumentObserver
{
    /**
     * Handle the document "creating" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function creating(Document $document)
    {
        $company = Company::active();
        $number = Functions::newNumber(
            $document->soap_type_id,
            $document->document_type_id,
            $document->series,
            $document->number,
            Document::class
        );
        $document->number = $number;

        $document->filename = Functions::filename($company, $document->document_type_id, $document->series, $number);

        $existingDocument = Document::where('number', $document->number)
            ->where('series', $document->series)
            ->where('soap_type_id', $document->soap_type_id)
            ->where('document_type_id', $document->document_type_id)
            ->first();

        if ($existingDocument) {

            throw new Exception("Verifique si el documento ya fue emitido, Ya existe un documento con el mismo número y serie");
        }
    }

    /**
     * Handle the document "updated" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function updated(Document $document)
    {
        //
    }

    /**
     * Handle the document "deleted" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function deleted(Document $document)
    {
        //
    }

    /**
     * Handle the document "restored" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function restored(Document $document)
    {
        //
    }

    /**
     * Handle the document "force deleted" event.
     *
     * @param  \App\Models\Document  $document
     * @return void
     */
    public function forceDeleted(Document $document)
    {
        //
    }
}
