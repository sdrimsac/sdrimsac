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
        // $previous_receipt = Receipt::where("sale_note_id", $data->sale_note_id)->where("id", "<", $data->id)->orderBy("id", "desc")->first();
        //change for a bool, return a boolean instead a register
        $previous_receipt = Receipt::where("sale_note_id", $data->sale_note_id)->where("id", "<", $data->id)->orderBy("id", "desc")->exists();

        $payment = null;
        if ($data->sale_note_id) {
            $payment = $data->sale_note_payment;
        } else {
            $payment = $data->document_payment;
            if ($payment ==  null) {
                // $payment 
            }
        }
        $payment_method_type = $payment->payment_method_type->description;
        // $SaleNote=SaleNote::where('id',$receipt->sale_note_id)->first();
        $quote = null;
        $interes = 0;
        
        if ($data->sale_note_id) {
            $data_payments = Payment::where('sale_note_id', $data->sale_note_id)->first();
            if ($data_payments != null) {
                $quote = $data_payments->amount;
                $interes = ($data->sale_note->total - $data->sale_note->advances) * (($data_payments->tasa / 100));
            }
            $sale_note = SaleNote::find($data->sale_note_id);
            if ($sale_note->sale_note_credit) {
                // Paso 1: Seleccionar los registros limitados
                $limitedPayments = Payment::where('sale_note_id', $data->sale_note_id)
                    ->orderBy('id') // Asegúrate de tener un criterio de ordenación
                    ->limit($data->num_cuota)
                    ->get();

                // Paso 2: Sumar los valores de los registros seleccionados
                $totalPayment = $limitedPayments->sum('amount_paid');
                $totalPenalty = $limitedPayments->sum('penalty_amount');

                // Crear un objeto para mantener la estructura original
                $payments = (object) [
                    'total_payment' => $totalPayment,
                    'total_penalty' => $totalPenalty,
                ];
                $sum_payments = Payment::where('sale_note_id', $data->sale_note_id)->sum('amount');
                $give = Payment::where('sale_note_id', $data->sale_note_id)->sum('amount');
                $deuda = $sum_payments - ($payments->total_payment - $payments->total_penalty);
            } else {
                $payments = SaleNotePayment::select(DB::raw('SUM(payment) as total_payment'))->where('sale_note_id', $data->sale_note_id)->first();
                $give = $data->sale_note->total - $data->sale_note->advances;

                $deuda = $data->sale_note->total - $data->sale_note->advances - ($payments->total_payment);
            }
        } else {
            $payments = DocumentPayment::select(DB::raw('SUM(payment) as total_payment'))->where('document_id', $data->document_id)->first();
            $deuda = $data->document->total - $data->document->advances - $payments->total_payment;
            $give = $data->document->total - $data->document->advances;
        }

        if (!$data) throw new Exception("El código {$external_id} es inválido, no se encontro la cotización relacionada");
        $company = Company::first();
        $user = User::findOrFail($data->user_id);
        $establishment = Establishment::find($user->establishment_id);
        $penalties = 0;
        if ($data->sale_note_id) {
            $penalties = Payment::where('sale_note_id', $data->sale_note_id)->where('paid', 0)->sum('penalty_amount');
        }
        $payments_ = Payment::where('sale_note_id', $data->sale_note_id)
            ->where('paid', 0)
            ->orderBy('date_payment', 'asc')
            ->get();

        $next_payment = $payments_->first();
        $position = 0;
        if ($next_payment) {
            $all_payments = Payment::where('sale_note_id', $data->sale_note_id)
                ->get();
            $position = $all_payments->search(function ($item) use ($next_payment) {
                return ($item->id == $next_payment->id);
            });
        }
        if ($data->num_cuota != $position + 1) {
            $next_payment = null;
        }
        $recibo = PDF::loadView('tenant.receipt.index', [
            'give' => $give,
            'previous_receipt' => $previous_receipt,
            'quote' => number_format($quote, 2, ".", ""),
            'position' => $position,
            'next_payment' => $next_payment,
            'penalties' => $penalties,
            'payment_method_type' => $payment_method_type,
            'data' => $data, 'company' => $company, 'interes' => $interes, 'establishment' => $establishment, "deuda" => $deuda, "payments" => $payments, "user" => $user
        ]);
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
        if ($last_receipt) {
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
