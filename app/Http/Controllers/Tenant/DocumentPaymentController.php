<?php

namespace App\Http\Controllers\Tenant;

use Carbon\Carbon;
use App\Models\Tenant\Box;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\PaymentMethodType;
use Modules\Finance\Traits\FinanceTrait;
use App\Http\Requests\Tenant\DocumentRequest;
use Exception, Illuminate\Support\Facades\DB;
use Modules\Finance\Traits\FilePaymentTrait;
use App\Http\Requests\Tenant\DocumentPaymentRequest;
use App\Http\Resources\Tenant\DocumentPaymentCollection;
use App\Models\System\Configuration;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Receipt;
use Illuminate\Support\Str;
class DocumentPaymentController extends Controller
{

    use FinanceTrait, FilePaymentTrait;

    public function records($document_id)
    {
        $records = DocumentPayment::where('document_id', $document_id)->get();

        return new DocumentPaymentCollection($records);
    }

    public function tables()
    {
        return [
            'payment_method_types' => PaymentMethodType::all(),
            'payment_destinations' => $this->getPaymentDestinations()
        ];
    }

    public function document($document_id)
    {
        $document = Document::find($document_id);

        $total_paid = collect($document->payments)->sum('payment');

        // $total = $document->total_payment;
        if ($document->total_payment == 0) {
            $total = $document->total;
        } else {
            $total = $document->total_payment;
        }
        $total_difference = round($total - $total_paid, 2);

        return [
            'number_full' => $document->number_full,
            'document_type_id' => $document->document_type_id,
            'total_paid' => $total_paid,
            'total' => $total,
            'total_difference' => $total_difference
        ];
    }
    function create_receipt($request,$cash_id,$document_save,$record){
        
        $receipt = new Receipt;
        $receipt->fill($request->all());
        $receipt->user_id = auth()->user()->id;
        $receipt->cash_id = $cash_id;
        $receipt->establishment_id = auth()->user()->establishment_id;
        $receipt->customer_id = $document_save->customer_id;
        $receipt->document_id = $document_save->id;
        $receipt->document_payment_id = $record->id;
        $type = $document_save->document_type_id == "01" ? "FACTURA ELECTRONICA" : "BOLETA DE VENTA ELECTRONICA";
        $receipt->detail = "PAGO DE ".$type. " N° " . $document_save->series . " - " . $document_save->number;
        $receipt->hour = date('H:i:s');
        $receipt->date_of_issue = Carbon::parse($request->date)->format('Y-m-d');
        // $number_receipt = Receipt::select(DB::raw('MAX(number) AS number'))->first();
        //get last record by id
        $last_receipt = Receipt::orderBy('id', 'desc')->first();
        $number_receipt = null;
        if($last_receipt){
            $number_receipt = intval($last_receipt->number);
        }
        
        if ($number_receipt !== null) {
            $number = str_pad(($number_receipt + 1), 7, "0", STR_PAD_LEFT);
        } else {
            $number = str_pad(1, 7, "0", STR_PAD_LEFT);
        }
        $receipt->amount = $request->input('payment');
        $receipt->number = $number;
        $receipt->external_id = Str::uuid()->toString();

        $receipt->save();


    }
    public function store(DocumentPaymentRequest $request)
    {
        // dd($request->all());

        $id = $request->input('id');
        DB::connection('tenant')->transaction(function () use ($id, $request) {

            if ($request->payment_method_type_id == "01" || $request->payment_method_type_id == "04" || $request->payment_method_type_id == "11") {
                $record = DocumentPayment::firstOrNew(['id' => $id]);
                $record->fill($request->all());
                $record->save();
                $this->createGlobalPayment($record, $request->all());
                $this->saveFiles($record, $request, 'documents');
                $cash =  $this->getCash();
                $cash_id   = null;
                if ($cash) {
                    $cash_id = $cash["cash_id"];
                }
                $method_payment = PaymentMethodType::where('id', $request->payment_method_type_id)->first();
                $boxes = new Box;
                $company = Company::first();
                $boxes->group_id = 1;
                $boxes->category_id = 1;
                $boxes->subcategory_id = 1;
                $boxes->amount = $request->input('payment');
                $boxes->date = Carbon::parse($request->input('date_of_payment'))->format('Y-m-d');
                $boxes->type = '1';
                $boxes->state = '1';
                $boxes->cash_id = $cash_id;
                $boxes->method = $method_payment->description;
                $boxes->document_id = $request->document_id;
                $boxes->document_payment_id = $record->id;
                $boxes->user_id = auth()->user()->id;
                $document_save = Document::where('id', $request->document_id)->first();
                switch ($document_save->document_type_id) {
                    case "01":
                        $type_document = "FACTURA ELECTRONICA";
                        $this->create_receipt($request,$cash_id,$document_save,$record);
                        break;
                    case "03":
                        $type_document = "BOLETA DE VENTA ELECTRONICA";
                        $this->create_receipt($request,$cash_id,$document_save,$record);
                        break;
                    case "07":
                        $type_document = "NOTA DE CREDITO";
                        break;
                    case "08":
                        $type_document = "NOTA DE DEBITO";
                        break;
                }
                $documents_rows = $type_document . " N° " . $document_save->series . " - " . $document_save->number;
                $boxes->description = "PAGO DE " . $documents_rows;
                $boxes->soap_type_id = $company->soap_type_id;

                $boxes->save();
                $document_save->canceled();
            }
        });
        return [
            'success' => true,
            'message' => ($id) ? 'Pago editado con éxito' : 'Pago registrado con éxito'
        ];
    }

    public function destroy($id)
    {
        $item = DocumentPayment::findOrFail($id);
        Box::where('document_payment_id', $id)->delete();
        //$boxes = Box::findOrFail($item->document_id);
        // $rows = Box::where('document_id', '=', $item->document_id)->first();
        // if ($rows != null) {
        //     $boxes = Box::findOrFail($rows->id);
        //     $boxes->delete();
        // }
        $item->delete();

        return [
            'success' => true,
            'message' => 'Pago eliminado con éxito'
        ];
    }

    public function initialize_balance()
    {

        DB::connection('tenant')->transaction(function () {

            $documents = Document::get();

            foreach ($documents as $document) {

                $total_payments = $document->payments->sum('payment');

                $balance = $document->total - $total_payments;

                if ($balance <= 0) {

                    $document->total_canceled = true;
                    $document->update();
                } else {

                    $document->total_canceled = false;
                    $document->update();
                }
            }
        });

        return [
            'success' => true,
            'message' => 'Acción realizada con éxito'
        ];
    }

    public function  report($start, $end)
    {
        //$document = Document::select('id')->orderBy('date_of_issue', 'DESC')->take(50)->pluck('id');
        $documents = DocumentPayment::whereBetween('date_of_payment', [$start, $end])->get();

        //$customer = $document->customer;
        //$number = $document->number_full;
        $records = collect($documents)->transform(function ($row) {
            return [
                'id' => $row->id,
                'date_of_payment' => $row->date_of_payment->format('d/m/Y'),
                'payment_method_type_description' => $row->payment_method_type->description,
                'destination_description' => ($row->global_payment) ? $row->global_payment->destination_description : null,
                'change' => $row->change,
                'payment' => $row->payment,
                'reference' => $row->reference,
                'customer' => $row->document->customer->name,
                'number' =>  $row->document->number_full,
                'total' => $row->document->total,
            ];
        });


        /*$methods = PaymentMethodType::all();

        $methdos_sum = array();

        foreach ($methods as $item) {

            $row = [
                'name' => $item->description,
                'sum' => $documents->where('payment_method_type_id', $item->id)->sum('payment')
            ];

            array_push($methdos_sum, (object)$row);
        }*/


        $pdf = PDF::loadView('tenant.document_payments.report', compact("records"));

        $filename = "Reporte_Pagos";

        return $pdf->stream($filename . '.pdf');
    }
}
