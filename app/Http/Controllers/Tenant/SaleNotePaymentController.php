<?php

namespace App\Http\Controllers\Tenant;

use Mpdf\Mpdf;
use Carbon\Carbon;
use Mpdf\HTMLParserMode;
use App\Models\Tenant\Box;
use Illuminate\Support\Str;
use FontLib\Table\Type\loca;
use App\Models\Tenant\Company;
use App\Models\Tenant\Payment;
use App\Models\Tenant\Receipt;
use Mpdf\Config\FontVariables;
use App\CoreFacturalo\Template;
use App\Models\Tenant\SaleNote;
use Mpdf\Config\ConfigVariables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Tenant\SaleNotePayment;
use App\Models\Tenant\PaymentMethodType;
use Modules\Finance\Traits\FinanceTrait;
use Modules\Finance\Traits\FilePaymentTrait;
use App\Http\Requests\Tenant\SaleNotePaymentRequest;
use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\Http\Resources\Tenant\SaleNotePaymentCollection;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Configuration;
use Exception;
use Illuminate\Http\Request;
use Modules\Restaurant\Events\PrintEvent;

class SaleNotePaymentController extends Controller
{
    use StorageDocument, FinanceTrait, FilePaymentTrait;

    public function records($sale_note_id)
    {
        $records = SaleNotePayment::where('sale_note_id', $sale_note_id)->where('payment', '>', 0)->get();

        return new SaleNotePaymentCollection($records);
    }

    public function tables()
    {
        return [
            'payment_method_types' => PaymentMethodType::all(),
            'payment_destinations' => $this->getPaymentDestinations()
        ];
    }

    public function document($sale_note_id)
    {
        $sale_note = SaleNote::find($sale_note_id);
        $penalty = $sale_note->credit_cash == 0 ? $sale_note->getPenalties() : 0;
        if ($sale_note->creditPayments->count() > 0) {
            $total_paid = $sale_note->creditPayments->sum('penalty');
        } else {
            $total_paid = round(collect($sale_note->payments)->sum('payment'), 2);
        }
        // $total_paid = round(collect($sale_note->payments)->sum('payment'), 2);
        $penalties_payed = Payment::where('sale_note_id', $sale_note_id)
            ->where('paid', 1)
            ->sum('penalty_amount');
        // $total_paid -= $penalties_payed;
        $payment = Payment::where('sale_note_id', $sale_note_id);
        $payment_tasa = $payment->first();
        $schedule = $payment->count();
        $advances = $sale_note->advances;
        $amount_schedule = 0;
        if ($schedule > 0) {
            $btn_schedule = true;
            $schedule_first = $payment->first();
            $amount_schedule = $schedule_first->amount;
            $interes = ($sale_note->total - $advances) * ($payment_tasa->tasa / 100);
        } else {
            $btn_schedule = false;
            $interes = 0;
        }
        // $total = $sale_note->total  + $penalty;
        if ($sale_note->total_payment == 0) {
            $total = $sale_note->total - $sale_note->advances;
        } else {
            $total =$sale_note->total - $sale_note->advances -   $sale_note->total_payment;
        }
        $total_difference = round($total  - $total_paid, 2);
        $total_difference_document = round($total_difference + $penalties_payed, 2);

        // if ($total_difference_document < 0.01) {
        //     $sale_note->paid = true;
        // }else{
        //     $sale_note->paid = false;
        // }
        $sale_note->save();
        $num_schedule = Payment::where('sale_note_id', $sale_note_id)->where('paid', 0)->count();
        ///the first  payment by id with paid 0
        $all_payment = Payment::where('sale_note_id', $sale_note_id)
            ->get();
        $current_payment = [];

        foreach ($all_payment as $key => $value) {
            if ($value->paid == 0) {
                $amount = floatval($value->amount);
                $amount_paid = floatval($value->amount_paid);
                $penalty_amount = floatval($value->penalty_amount);
                $amount  = $amount + $penalty_amount;
                $amount = $amount - $amount_paid;
                $diff_days = 0;
                $today = Carbon::now();
                $date_of_payment = Carbon::parse($value->date_payment);
                $diff_days = $today->diffInDays($date_of_payment);
                $amount_withouth_penalty = $value->amount - $value->amount_paid;
                if ($amount_withouth_penalty < 0) {
                    $value->penalty_amount += $amount_withouth_penalty;
                    $value->save();
                    $amount_withouth_penalty = 0;
                }
                $current_payment = [
                    'num' => $key + 1,
                    'amount' => $amount,
                    'amount_withouth_penalty' => $amount_withouth_penalty,
                    'penalty' => $penalty_amount,
                    'diff_days' => $diff_days,

                ];
                break;
            }
        }
        $customer_name = $sale_note->customer->name;
        return [
            'total_difference_document' => $total_difference_document,
            'credit_cash' => $sale_note->credit_cash,
            'customer_name' => $customer_name,
            'current_payment' => $current_payment,
            'amount_schedule' => floatval($amount_schedule),
            'btn_schedule' => $btn_schedule,
            'num_schedule' => $num_schedule,
            'number_full' => $sale_note->identifier,
            'series' => $sale_note->series,
            'number' => $sale_note->number,
            'total_paid' => $total_paid,
            // 'total' => $total + $penalty,
            'total' => $total + $interes + $penalty,
            //lo que falta por pagar
            'total_difference' => $total_difference + $interes + $penalty,
            'paid' => (bool) $sale_note->paid,
            'penalties_payed' => $penalties_payed,

        ];
    }

    function createBoxRegister($amount, $date_of_payment, $payment_method_description, $cash_id, $sale_note, $sale_note_payment_id)
    {
        $boxes = new Box;
        $company = Company::first();
        $boxes->group_id = 1;
        $boxes->category_id = 1;
        $boxes->subcategory_id = 1;
        $boxes->amount = $amount;
        $boxes->date = $date_of_payment;
        $boxes->type = '1';
        $boxes->state = '1';
        $boxes->method = $payment_method_description;
        $boxes->user_id = auth()->user()->id;
        $type_document = "NOTA DE VENTA";
        $boxes->sale_note_id = $sale_note->id;
        $boxes->description = "PAGO DE " . $type_document . " N° " . $sale_note->series . " - " . $sale_note->number;
        $boxes->soap_type_id = $company->soap_type_id;
        $boxes->sale_note_payment_id = $sale_note_payment_id;
        $boxes->cash_id = $cash_id;
        $boxes->save();
    }


    function createSaleNotePayment($amount, $payment_id, $payment_method_type_id, $sale_note, $cash, $payment_destination_id)
    {
        $payment_method = PaymentMethodType::where('id', $payment_method_type_id)->first();
        $sale_note_payment = new SaleNotePayment();
        $sale_note_payment->payment = $amount;
        $sale_note_payment->sale_note_id = $sale_note->id;
        $sale_note_payment->payment_method_type_id = $payment_method_type_id;
        $sale_note_payment->payment_id = $payment_id;
        $sale_note_payment->date_of_payment = date('Y-m-d');
        $sale_note_payment->save();
        $this->createGlobalPayment($sale_note_payment, ['payment_destination_id' => $payment_destination_id]);
        $this->createBoxRegister($amount, $sale_note_payment->date_of_payment, $payment_method->description, $cash->id, $sale_note, $sale_note_payment->id);

        return $sale_note_payment->id;
    }
    function getIndexPayment($payment_id)
    {
        $payment = Payment::find($payment_id);
        if (!$payment) {
            throw new Exception("No se encontró el pago con ID: $payment_id");
        }

        $payments = Payment::where('sale_note_id', $payment->sale_note_id)
            ->orderBy('date_payment', 'asc')
            ->get();

        foreach ($payments as $index => $p) {
            if ($p->id == $payment_id) {
                return $index + 1;
            }
        }
        return 0;
    }
    function createReceipt($cash_id, $sale_note, $sale_note_payment_id, $date_of_payment, $amount, $num_cuota)
    {
        $receipt = new Receipt;
        $receipt->user_id = auth()->user()->id;
        $receipt->cash_id = $cash_id;
        $receipt->establishment_id = auth()->user()->establishment_id;
        $receipt->customer_id = $sale_note->customer_id;
        $receipt->sale_note_id = $sale_note->id;
        $receipt->sale_note_payment_id = $sale_note_payment_id;
        $receipt->detail = "PAGO DE NOTA DE VENTA" . " N° " . $sale_note->series . " - " . $sale_note->number;
        $receipt->hour = date('H:i:s');
        $receipt->date_of_issue = $date_of_payment;
        $receipt->num_cuota = $num_cuota;
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
        $receipt->amount = $amount;
        $receipt->external_id = Str::uuid()->toString();
        $receipt->save();
    }
    public function returnPayment($id)
    {
        try {
            DB::connection('tenant')->beginTransaction();
            $sale_note_payment = SaleNotePayment::find($id);
            $sale_note = SaleNote::find($sale_note_payment->sale_note_id);
            $amount = $sale_note_payment->payment;
            $payment = Payment::find($sale_note_payment->payment_id);
            $payment_method_description = "Efectivo";
            $payment_method_type_id = $sale_note_payment->payment_method_type_id;
            $payment_method = PaymentMethodType::where('id', $payment_method_type_id)->first();
            if ($payment_method) {
                $payment_method_description = $payment_method->description;
            }
            $payment->amount_paid -= $amount;
            if ($payment->paid == 1) {
                $payment->paid = 0;
            }
            $payment->save();
            $receipt = Receipt::where('sale_note_payment_id', $id)->first();
            $cash_id = $receipt->cash_id;
            $receipt->delete();
            $description_register = "EXTORNO DE PAGO DE NOTA DE VENTA" . " N° " . $sale_note->series . " - " . $sale_note->number;
            
            if ($cash_id) {
                /** @var  User $user */
                $user = auth()->user();
                $user_cash_id = $user->get_cash_id();

                if (!$user_cash_id != $cash_id) {
                
                    Box::createExpense(
                        $amount,
                        $payment_method_description,
                        $description_register,
                        $cash_id,
                        $sale_note->id,
                        null,
                        $sale_note_payment->id
                    );
                }
            }

            $box = Box::where('sale_note_payment_id', $id)->first();
            Box::where('sale_note_payment_id', $id)
            ->where('amount', $amount)
            ->update(['sale_note_payment_id' => null]);
            $sale_note_payment->delete();
            DB::connection('tenant')->commit();
            return [
                'success' => true,
                'message' => 'Pago eliminado con éxito'
            ];
        } catch (Exception $e) {
            DB::connection('tenant')->rollBack();
            return [
                'success' => false,
                'message' => 'Error al eliminar el pago: ' . $e->getMessage(),
            ];
        }
    }
    public function payLastPayment(Request $request, $id)
    {
        $amount = floatval($request->amount);
        $payment_method_type_id = $request->payment_method_type_id;
        $payment_destination_id = $request->payment_destination_id;
        $sale_note = SaleNote::find($id);
        $user_id = auth()->user()->id;
        $cash = Cash::where('state', 1)->where('user_id', $user_id)->first();
        if (!$cash) {
            throw new Exception("No se encontró caja activa para el usuario");
        }
        try {
            DB::connection('tenant')->beginTransaction();
            while ($amount > 0) {
                $payment = Payment::where('sale_note_id', $id)
                    ->where('paid', 0)
                    ->orderBy('date_payment', 'asc')
                    ->first();

                if (!$payment) {
                    break;
                }

                $amount_to_pay = $payment->amount - $payment->amount_paid + $payment->penalty_amount;
                $amount_payed = 0;
                if ($amount >= $amount_to_pay) {
                    $payment->amount_paid = $payment->amount;
                    $payment->paid = 1;
                    $amount -= $amount_to_pay;
                    $amount_payed = $amount_to_pay;
                } else {
                    $amount_payed = $amount;
                    $payment->amount_paid += $amount;
                    $amount = 0;
                }

                $payment->save();
                if ($amount_payed > 0) {
                    $sale_note_payment_id = $this->createSaleNotePayment($amount_payed, $payment->id, $payment_method_type_id, $sale_note, $cash, $payment_destination_id);
                    $num_cuota = $this->getIndexPayment($payment->id);
                    $this->createReceipt($cash->id, $sale_note, $sale_note_payment_id, $payment->date_payment, $amount_payed, $num_cuota);
                }
            }
            DB::connection('tenant')->commit();
            return [
                'success' => true,
                'message' => 'Pago realizado',
            ];
        } catch (Exception $e) {
            DB::connection('tenant')->rollBack();
            return [
                'success' => false,
                'message' => 'Error al realizar el pago: ' . $e->getMessage(),
            ];
        }
    }
    public function store(SaleNotePaymentRequest $request)
    {

        $user_id = auth()->user()->id;
        $cash = Cash::where('state', 1)->where('user_id', $user_id)->first();
        if ($cash == null) {
            $cash = Cash::create([
                'user_id' => auth()->user()->id,
                'date_opening' => date('Y-m-d'),
                'time_opening' => date('H:i:s'),
                'date_closed' => null,
                'time_closed' => null,
                'beginning_balance' => 0,
                'final_balance' => 0,
                'income' => 0,
                'state' => true,
                'reference_number' => null
            ]);
        }
        //dd($request->all());   
        $id = $request->input('id');
        $document_save = SaleNote::where('id', $request->sale_note_id)->first();
        $credit_discount = $request->input('creditDiscount');
        $creditDiscountPenalty = $request->input('creditDiscountPenalty');
        $record = SaleNotePayment::firstOrNew(['id' => $id]);
        $documentRealAmount = $request->input('documentRealAmount');
        $amount = $request->input('payment');
        $remain_pay = $amount - $documentRealAmount;
        $record->fill($request->all());
        if ($documentRealAmount) {
            $record->payment = $documentRealAmount;
        } else {
            $documentRealAmount = $amount;
        }
        $record->save();
        $this->createGlobalPayment($record, $request->all());
        $this->saveFiles($record, $request, 'sale_notes');
        $payment = PaymentMethodType::where('id', $request->payment_method_type_id)->first();
        if ($request->payment_method_type_id == "01" || $request->payment_method_type_id == "04" || $request->payment_method_type_id == "11") {
            $boxes = new Box;
            $company = Company::first();
            $boxes->group_id = 1;
            $boxes->category_id = 1;
            $boxes->subcategory_id = 1;
            $boxes->amount = $documentRealAmount;
            $boxes->date = Carbon::parse($request->input('date_of_payment'))->format('Y-m-d');
            $boxes->type = '1';
            $boxes->state = '1';
            $boxes->method = $payment->description;
            $boxes->user_id = auth()->user()->id;
            $type_document = "NOTA DE VENTA";
            $boxes->sale_note_id = $document_save->id;
            $boxes->description = "PAGO DE " . $type_document . " N° " . $document_save->series . " - " . $document_save->number;
            $boxes->soap_type_id = $company->soap_type_id;
            $boxes->sale_note_payment_id = $record->id;
            $boxes->cash_id = $cash->id;
            $boxes->save();
        }
        $num_cuota = 1;
        /////////////////////////////////////////////////////////////////////////////////////////////////
        $receipt = Receipt::firstOrNew(['id' => $request->id]);
        $receipt->fill($request->all());
        $receipt->user_id = auth()->user()->id;
        $receipt->cash_id = $cash->id;
        $receipt->establishment_id = auth()->user()->establishment_id;
        $receipt->customer_id = $document_save->customer_id;
        $receipt->sale_note_id = $document_save->id;
        $receipt->sale_note_payment_id = $record->id;
        $receipt->detail = "PAGO DE NOTA DE VENTA" . " N° " . $document_save->series . " - " . $document_save->number;
        $receipt->hour = date('H:i:s');
        $receipt->date_of_issue = Carbon::parse($request->date)->format('Y-m-d');
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
        $receipt->amount = $documentRealAmount;
        $receipt->external_id = Str::uuid()->toString();
        $receipt->save();

        $payment = Payment::where('sale_note_id', $request->sale_note_id)
            ->where('paid', 0);
        // ->where('penalty_amount', '>', 0);

        $penalty_paid = 0;

        if ($request->paid == true) {
            $sale_note = SaleNote::find($request->sale_note_id);
            $sale_note->paid = true;
            if ($credit_discount) {
                $factor = $credit_discount / $sale_note->total;
                $sale_note->total_discount = $credit_discount;
                $sale_note->discounts = [
                    "base" => $sale_note->total,
                    "amount" => $credit_discount,
                    "factor" => number_format($factor, 4, ".", ""),
                    "description" => "Descuentos globales que no afectan la base imponible del IGV/IVAP",
                    "discount_type_id" => "03"
                ];
                $total_after_discount = $sale_note->total - $credit_discount;
                $sale_note->total = $total_after_discount;
                $sale_note->total_rounded = $total_after_discount;
                $sale_note->total_payment = $total_after_discount;

                $payment = Payment::where('sale_note_id', $request->sale_note_id)
                    ->where('paid', 1)
                    ->first();
                if ($payment) {
                    $payment->paid = true;
                    $payment->amount_paid = $documentRealAmount;
                    $payment->save();
                }
            }
            Payment::where('sale_note_id', $request->sale_note_id)
                ->update(['paid' => true]);
            $sale_note->save();
        } else {
            // if($document_save->credit_cash == 1){

            // }else{
            if ($document_save->sale_note_credit) {
                $count_payment = $payment->count();
                if ($count_payment == 1) {
                    $payment = $payment->first();
                    if ($payment) {
                        $sale_note = SaleNote::find($request->sale_note_id);

                        $amount_to_paid = $payment->amount;
                        $penalty_paid += $payment->penalty_amount;
                        $payment->amount_paid += $documentRealAmount;
                        if ($payment->amount_paid >= $payment->amount) {
                            $payment->paid = true;
                        }
                        $payment->save();
                        $all_payed = Payment::where('sale_note_id', $request->sale_note_id)
                            ->where('paid', 0)->count();
                        $num_cuota = Payment::where('sale_note_id', $request->sale_note_id)
                            ->where('paid', 1)->count() + 1;
                        if ($all_payed == 0) {
                            $sale_note->paid = true;
                            $sale_note->save();
                            Payment::where('sale_note_id', $request->sale_note_id)
                                ->update(['amount_paid' => $amount_to_paid]);
                        }
                    }
                } else {
                    $amount_to_paid = $payment->first() ? $payment->first()->amount : 0;
                    $amount_payed = $documentRealAmount;
                    $last_payment = Payment::where('sale_note_id', $request->sale_note_id)
                        ->where('paid', 0)
                        ->first();
                    if ($last_payment && $last_payment->amount_paid > 0) {
                        $amount_payed += $last_payment->amount_paid;
                    }


                    $payments = Payment::where('sale_note_id', $request->sale_note_id)
                        ->get();

                    $amount_payed_remain = $amount_payed;
                    foreach ($payments as $key => $value) {
                        if ($value->paid == 0) {
                            if ($amount_payed_remain <= 0) {
                                break;
                            }

                            if ($amount_payed_remain > 0.01) {
                                $amount_to_pay = $value->amount + $value->penalty_amount - $creditDiscountPenalty;

                                if ($amount_payed_remain >= $amount_to_pay) {
                                    $value->paid = true;
                                    $num_cuota = $key + 1;
                                    $penalty_paid += $value->penalty_amount;
                                    $value->amount_paid = $amount_to_pay;
                                    $amount_payed_remain -= $amount_to_pay;
                                } else {
                                    $value->paid = false;
                                    $num_cuota = $key + 1;
                                    $value->amount_paid = $amount_payed_remain;
                                    $amount_payed_remain = 0;
                                }

                                $value->save();
                            }
                        }
                    }
                    $all_payed = Payment::where('sale_note_id', $request->sale_note_id)
                        ->where('paid', 0)->count();
                    if ($all_payed == 0) {
                        $sale_note = SaleNote::find($request->sale_note_id);
                        $sale_note->paid = true;
                        $sale_note->save();
                        Payment::where('sale_note_id', $request->sale_note_id)
                            ->update(['amount_paid' => $amount_to_paid, 'penalty_amount' => 0]);
                    }
                    // }
                }
            }
        }


        $receipt->num_cuota = $num_cuota;
        $receipt->penalty_paid = $penalty_paid;
        $receipt->save();
        //    $document_save->updateCreditsPayment();
        $this->createPdf($request->input('sale_note_id'));
        $pdf = "/receipt/print/{$receipt->external_id}";
        // event(new PrintEvent($receipt->id, $pdf, 'receipt', 'print'));
        $configuration = Configuration::first();
        if ($configuration->print_payment_credit_sale_note) {
            event(new PrintEvent(null, 'URL', true, null, [], false, false, $pdf));
        }

        if ($remain_pay > 0 && $configuration->sale_note_credit_confirm) {
            $this->generaIncomeAdjust($cash->id, $remain_pay);
        }
        return response()->json([
            "success" => true,
            "message" => ($id) ? 'Pago editado con éxito' : 'Pago registrado con éxito',
            'pdf' => url('') . "/receipt/print/{$receipt->external_id}",

        ]);

        //});


        // return [
        //     'success' => true,
        //     'message' => ($id)?'Pago editado con éxito':'Pago registrado con éxito'
        // ];
    }
    function generaIncomeAdjust($cash_id, $amount)
    {
        $box = new Box();
        $box->cash_id = $cash_id;
        $box->date = date('Y-m-d');
        $box->amount = $amount;
        $box->establishment_id = auth()->user()->establishment_id;
        $box->user_id = auth()->user()->id;
        $box->group_id = 1;
        $box->category_id = 1;
        $box->soap_type_id = 1;
        $box->state = 2;
        $box->subcategory_id = 1;
        $box->description = 'Ajuste de caja por centavos';
        $box->method = 'Efectivo';
        $box->type = 1;
        $box->incomes = 1;
        $box->save();
    }
    public function destroy($id)
    {
        $item = SaleNotePayment::findOrFail($id);

        Box::where('sale_note_payment_id', '=', $item->id)->delete();
        Receipt::where('sale_note_payment_id', '=', $item->id)->delete();
        $sale_note_id = $item->sale_note_id;
        $item->delete();
        $sale_note = SaleNote::find($item->sale_note_id);
        $sale_note->paid = false;
        $sale_note->save();

        $this->createPdf($sale_note_id);

        return [
            'success' => true,
            'message' => 'Pago eliminado con éxito'
        ];
    }

    public function createPdf($sale_note_id, $format = null)
    {
        ini_set("pcre.backtrack_limit", "5000000");
        $sale_note = SaleNote::find($sale_note_id);
        $total_paid = round(collect($sale_note->payments)->sum('payment'), 2);
        $total = $sale_note->total;
        $total_difference = round($total - $total_paid, 2);

        if ($total_difference == 0) {
            Log::info('true ' . $total_difference);
            $sale_note->total_canceled = true;
        } else {
            Log::info('false ' . $total_difference);
            $sale_note->total_canceled = false;
        }
        $sale_note->save();


        $company = Company::first();

        $template = new Template();
        $pdf = null;
        if ($format == 'a5') {
            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [
                    78,
                    220
                ],
                'margin_top' => 2,
                'margin_right' => 5,
                'margin_bottom' => 0,
                'margin_left' => 5
            ]);
        } else {
            $pdf = new Mpdf();
        }

        $document = SaleNote::find($sale_note_id);

        $base_template = config('tenant.pdf_template');

        $html = $template->pdf($base_template, "sale_note", $company, $document, "a4");

        $pdf_font_regular = config('tenant.pdf_name_regular');
        $pdf_font_bold = config('tenant.pdf_name_bold');

        if ($pdf_font_regular != false) {
            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $pdf = new Mpdf([
                'fontDir' => array_merge($fontDirs, [
                    app_path('CoreFacturalo' . DIRECTORY_SEPARATOR . 'Templates' .
                        DIRECTORY_SEPARATOR . 'pdf' .
                        DIRECTORY_SEPARATOR . $base_template .
                        DIRECTORY_SEPARATOR . 'font')
                ]),
                'fontdata' => $fontData + [
                    'custom_bold' => [
                        'R' => $pdf_font_bold . '.ttf',
                    ],
                    'custom_regular' => [
                        'R' => $pdf_font_regular . '.ttf',
                    ],
                ]
            ]);
        }

        $path_css = app_path('CoreFacturalo' . DIRECTORY_SEPARATOR . 'Templates' .
            DIRECTORY_SEPARATOR . 'pdf' .
            DIRECTORY_SEPARATOR . $base_template .
            DIRECTORY_SEPARATOR . 'style.css');

        $stylesheet = file_get_contents($path_css);

        $pdf->WriteHTML($stylesheet, HTMLParserMode::HEADER_CSS);
        $pdf->WriteHTML($html, HTMLParserMode::HTML_BODY);

        if (config('tenant.pdf_template_footer')) {
            $html_footer = $template->pdfFooter($base_template);
            $pdf->SetHTMLFooter($html_footer);
        }

        $this->uploadStorage($document->filename, $pdf->output('', 'S'), 'sale_note');
        return $document->filename;
        //        $this->uploadFile($pdf->output('', 'S'), 'sale_note');
    }

    public function toPrint($sale_note_id, $format)
    {
        $filename = $this->createPdf($sale_note_id, $format);
        $temp = tempnam(sys_get_temp_dir(), 'sale_note');
        file_put_contents($temp, $this->getStorage($filename, 'sale_note'));
        return response()->file($temp);
    }
}
