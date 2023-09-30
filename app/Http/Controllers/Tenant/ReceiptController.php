<?php

namespace App\Http\Controllers\Tenant;

use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tenant\Item;
use App\Models\Tenant\Works;
use App\Models\Tenant\Person;
use Barryvdh\DomPDF\Facade as PDF;
use Mpdf\HTMLParserMode;
use App\Models\Tenant\User;
use Illuminate\Support\Str;
use App\Models\Tenant\Company;
use App\Models\Tenant\Payment;
use App\Models\Tenant\Receipt;
use App\Models\Tenant\SaleNote;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Tenant\WorksRequest;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Establishment;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Tenant\WorksResource;
use App\Models\Tenant\SaleNotePayment;
use App\Http\Resources\Tenant\WorksCollection;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Tenant\ReceiptCollection;
use App\Http\Requests\Tenant\ReceiptRequest;
use App\Models\Tenant\DocumentPayment;

class ReceiptController extends Controller
{


    public function toPrint($external_id)
    {
        $data = Receipt::where("external_id", $external_id)->first();
        // $SaleNote=SaleNote::where('id',$receipt->sale_note_id)->first();
        $interes = 0;
        if ($data->sale_note_id) {
            $data_payments = Payment::where('sale_note_id', $data->sale_note_id)->first();
            if ($data_payments != null) {
                $interes = $data->sale_note->total * ($data_payments->tasa / 100);
            }
            $payments = SaleNotePayment::select(DB::raw('SUM(payment) as total_payment'))->where('sale_note_id', $data->sale_note_id)->first();
            $deuda = $data->sale_note->total - $payments->total_payment;
        } else {
            $payments = DocumentPayment::select(DB::raw('SUM(payment) as total_payment'))->where('document_id', $data->document_id)->first();
            $deuda = $data->document->total - $payments->total_payment;
        }

        if (!$data) throw new Exception("El código {$external_id} es inválido, no se encontro la cotización relacionada");
        $company = Company::first();
        $user = User::findOrFail($data->user_id);

        $establishment = Establishment::find($user->establishment_id);
        $recibo = PDF::loadView('tenant.receipt.index', ['data' => $data, 'company' => $company, 'interes' => $interes, 'establishment' => $establishment, "deuda" => $deuda, "payments" => $payments, "user" => $user]);
        //    return view('tenant.receipt.index', ['data' => $data, 'company' => $company, 'interes' => $interes, 'establishment' => $establishment, "deuda" => $deuda, "payments" => $payments]);
        return $recibo->setPaper(array(0, 0, 249.45, 650), 'portrait')->stream();
    }

    public function store(ReceiptRequest $request)
    {
        $receipt = Receipt::firstOrNew(['id' => $request->id]);
        $receipt->fill($request->all());
        $receipt->user_id = $request->user_id;
        $receipt->date = Carbon::parse($request->date)->format('Y-m-d');
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
        $receipt->number = $number;
        $receipt->external_id = Str::uuid()->toString();
        $receipt->save();
        return response()->json([
            "success" => true,
            'data' => [
                'id' => $receipt->id,
                'number' => $receipt->number,
                'state_type_description' =>  "Registrado",
            ],
            'links' => [
                'pdf' => url('') . "/api/receipt/print/{$receipt->external_id}",
            ],
            "message" => ($request->id == null) ? "Se Registro con exito" : "Se Actualizo con exito"
        ]);
    }

    public function destroy($id)
    {
        $receipt = Receipt::find($id);
        $receipt->delete();
        return response()->json(
            [
                "success" => true,
                "message" => "Se Elimino con exito"
            ]
        );
    }
}
