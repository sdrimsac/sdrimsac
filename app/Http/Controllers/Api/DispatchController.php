<?php
namespace App\Http\Controllers\Api;

use App\CoreFacturalo\Facturalo;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\DispatchCollection;
use App\Models\Tenant\Dispatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DispatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('input.request:dispatch,api', ['only' => ['store']]);
    }

    public function store(Request $request)
    {
        $fact = DB::connection('tenant')->transaction(function () use($request) {
            $facturalo = new Facturalo();
            $facturalo->save($request->all());
            $facturalo->createXmlUnsigned();
            $facturalo->signXmlUnsigned();
            $facturalo->createPdf();
            $facturalo->sendEmail();
            $facturalo->senderXmlSignedBill();

            return $facturalo;
        });

        $document = $fact->getDocument();
        $response = $fact->getResponse();

        return [
            'success' => true,
            'data' => [
                'number' => $document->number_full,
                'filename' => $document->filename,
                'external_id' => $document->external_id,
            ],
            'links' => [
                'xml' => $document->download_external_xml,
                'pdf' => $document->download_external_pdf,
                'cdr' => $document->download_external_cdr,
            ],
            'response' => array_except($response, 'sent')
        ];
    }

    public function records(Request $request)
    {
        $records = $this->getRecords($request);

        return new DispatchCollection($records->paginate(config('tenant.items_per_page')));
    }


    public function getRecords($request)
    {

        $d_end = $request->d_end;
        $d_start = $request->d_start;
        $number = $request->number;
        $series = $request->series;
        $customer_id = $request->customer_id;


        if ($d_start && $d_end) {
            $query = Dispatch::query()
                ->where('document_type_id', '09')
                ->where('series', 'like', '%' . $series . '%')
                ->whereBetween('date_of_issue', [$d_start, $d_end]);
        } else {
            $query = Dispatch::query()
                ->where('document_type_id', '09')
                ->where('series', 'like', '%' . $series . '%');
        }

        if ($number) {
            $query->where('number', $number);
        }

        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        }

        return $query->latest();
    }
}