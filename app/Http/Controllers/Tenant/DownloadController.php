<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\Http\Controllers\Controller;
use App\CoreFacturalo\Facturalo;
use App\CoreFacturalo\Template;
use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use Mpdf\Mpdf;
use Exception;

class DownloadController extends Controller
{
    use StorageDocument;

    public function downloadExternal($model, $type, $external_id, $format = null)
    {
        $model = "App\\Models\\Tenant\\" . ucfirst($model);
        $document = $model::where('external_id', $external_id)->first();
        if ($type == 'pdf') {
            $user = auth()->user() ?? auth('api')->user();
            if ($user) {
                $format_type = Establishment::find($user->establishment_id)->format_printer;
                switch ($format_type) {
                    case 1:
                        $format = 'a4';
                        break;
                    case 2:
                        $format = 'a5';
                        break;
                    case 3:
                        $format = 'ticket';
                        break;
                    default:
                        $format =  'ticket_50';
                        break;
                }
            }
        }
        if (!$document) throw new Exception("El código {$external_id} es inválido, no se encontro documento relacionado");

        if ($format != null) $this->reloadPDF($document, 'invoice', $format);

        return $this->download($type, $document);
    }

    public function download($type, $document)
    {

        switch ($type) {
            case 'pdf':
                $folder = 'pdf';
                break;
            case 'xml':
                $folder = 'signed';
                break;
            case 'cdr':
                $folder = 'cdr';
                break;
            case 'quotation':
                $folder = 'quotation';
                break;
            case 'sale_note':
                $folder = 'sale_note';
                break;

            default:
                throw new Exception('Tipo de archivo a descargar es inválido');
        }

        return $this->downloadStorage($document->filename, $folder);
    }
    public function toPrint($model, $external_id, $format = 'a4')
    {
        $document_type = $model;

        $model = "App\\Models\\Tenant\\" . ucfirst($model);

        $document = $model::where('external_id', $external_id)->first();

        if (!$document) {
            throw new Exception("El código {$external_id} es inválido, no se encontro documento relacionado");
        }

        if ($document_type == 'quotation') {
            // Las cotizaciones tienen su propio controlador, si se generan por este medio, dará error
            $quotation = new QuotationController();
            return $quotation->toPrint($external_id, $format);
        } elseif ($document_type == 'salenote') {
            $saleNote = new SaleNoteController();
            return $saleNote->toPrint($external_id, $format);
        }
        $type = 'invoice';
        if ($document_type == 'dispatch') {
            $type = 'dispatch';
        }
        if ($document->document_type_id === '07') {
            $type = 'credit';
        }
        if ($document->document_type_id === '08') {
            $type = 'debit';
        }

        $this->reloadPDF($document, $type, $format);

        $temp = tempnam(sys_get_temp_dir(), 'pdf');

        file_put_contents($temp, $this->getStorage($document->filename, 'pdf'));

        /*
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$document->filename.'.pdf'.'"'
        ];
        */

        return response()->file($temp, $this->generalPdfResponseFileHeaders($document->filename));
    }
    // public function toPrint($model, $external_id, $format = null)
    // {


    //     $model = "App\\Models\\" . ucfirst($model);

    //     $document = $model::where('external_id', $external_id)->first();

    //     if (!$document) throw new Exception("El código {$external_id} es inválido, no se encontro documento relacionado");

    //     if ($format != null) $this->reloadPDF($document, 'invoice', $format);

    //     $temp = tempnam(sys_get_temp_dir(), 'pdf');
    //     file_put_contents($temp, $this->getStorage($document->filename, 'pdf'));

    //     return response()->file($temp);
    // }

    /**
     * Reload PDF
     * @param  ModelTenant $document
     * @param  string $format
     * @return void
     */
    private function reloadPDF($document, $type, $format)
    {

        (new Facturalo)->createPdf($document, $type, $format);
    }
}
