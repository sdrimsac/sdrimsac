<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CoreFacturalo\Facturalo;
use App\Http\Requests\Tenant\{
    SummaryDocumentsRequest,
    SummaryRequest
};
use App\Http\Resources\Tenant\{
    DocumentCollection,
    SummaryCollection
};
use App\Traits\SummaryTrait;
use App\Models\Tenant\{
    Box,
    Document,
    Summary,
    Company,
    Configuration
};
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Modules\College\Models\CollegePayment;
use Modules\College\Models\CollegeStudent;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;

class SummaryController extends Controller
{
    use StorageDocument, SummaryTrait;

    public function __construct()
    {
        $this->middleware('input.request:summary,web', ['only' => ['store']]);
    }

    public function index()
    {
        return view('tenant.summaries.index');
    }

    public function records(Request $request)
    {

        $records = Summary::where([['summary_status_type_id', '1'], [$request->column, 'like', "%{$request->value}%"]])
            ->latest();

        return new SummaryCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function columns()
    {
        return [
            'date_of_issue' => 'Fecha de emisión'
        ];
    }

    public function documents(SummaryDocumentsRequest $request)
    {
        try {
            ini_set('max_execution_time', 6000);
            ini_set('memory_limit', '-1');
            $company = Company::active();
            $date_of_reference = $request->input('date_of_reference');

            $documents = Document::query()
                ->where('date_of_issue', $request->input('date_of_reference'))
                ->where('soap_type_id', $company->soap_type_id)
                ->where('group_id', '02')
                ->where('state_type_id', '01')
                ->take(50)
                ->get();

            if (count($documents) === 0) throw new Exception("No se encontraron documentos con la fecha {$date_of_reference}");

            return new DocumentCollection($documents);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function store(SummaryRequest $request)
    {
        $affectCash = $request->input('affect_cash');
        $documents = $request->input('documents');
        $document_id = null;
        if (is_array($documents) && isset($documents[0]['document_id'])) {
            $document_id = $documents[0]['document_id'];
        }

        if ($affectCash && $document_id) {
            try {
                $record = Document::find($document_id);
                $boxDeleted = Box::where('document_id', $document_id)->delete();
                if ($record) {
                    $record->internal_voided = true;
                    $record->save();
                }
                Log::info('Se eliminó el documento de la caja y se marcó como internal_voided', [
                    'document_id' => $document_id,
                    'box_deleted' => $boxDeleted
                ]);
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }

        ini_set('max_execution_time', 6000);
        ini_set('memory_limit', '-1');
        return $this->save($request);
    }

    public function status($summary_id)
    {
        return $this->query($summary_id);
    }

    public function destroy($voided_id)
    {
        $summary = Summary::find($voided_id);
        foreach ($summary->documents as $doc) {
            $doc->document->update([
                'state_type_id' => ($summary->summary_status_type_id === '1') ? '01' : '05'
            ]);
        }
        $summary->delete();

        return [
            'success' => true,
            'message' => 'Resumen eliminada con éxito'
        ];
    }
}
