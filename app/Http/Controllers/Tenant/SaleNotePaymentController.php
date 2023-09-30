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
        $total_paid = round(collect($sale_note->payments)->sum('payment'), 2);
        $payment = Payment::where('sale_note_id', $sale_note_id);
        $payment_tasa = $payment->first();
        $schedule = $payment->count();
        if ($schedule > 0) {
            $btn_schedule = true;
            $interes = $sale_note->total * ($payment_tasa->tasa / 100);
        } else {
            $btn_schedule = false;
            $interes = 0;
        }
        if ($sale_note->total_payment == 0) {
            $total = $sale_note->total;
        } else {
            $total = $sale_note->total_payment;
        }
        $total_difference = round($total - $total_paid, 2);

        if ($total_difference < 1) {
            $sale_note->paid = true;
            $sale_note->save();
        }

        return [
            'number_full' => $sale_note->identifier,
            'series' => $sale_note->series,
            'number' => $sale_note->number,
            'total_paid' => $total_paid,
            'total' => $total + $interes,
            'total_difference' => $total_difference + $interes,
            'paid' => $sale_note->paid,

        ];
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
        // DB::connection('tenant')->transaction(function () use ($id, $request) {
        $record = SaleNotePayment::firstOrNew(['id' => $id]);
        $record->fill($request->all());
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
            $boxes->amount = $request->input('payment');
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
        if($last_receipt){
            $number_receipt = intval($last_receipt->number);
        }
        
        if ($number_receipt !== null) {
            $number = str_pad(($number_receipt + 1), 7, "0", STR_PAD_LEFT);
        } else {
            $number = str_pad(1, 7, "0", STR_PAD_LEFT);
        }
        $receipt->number = $number;
        $receipt->amount = $request->input('payment');
        $receipt->external_id = Str::uuid()->toString();
        $receipt->save();
        $payment = Payment::where('sale_note_id', $request->sale_note_id)
            ->where('paid', 0)
            ->where('amount_paid', 0)
            ->first();
        if ($payment) {
            $payment->paid = true;
            $payment->amount_paid = $request->input('payment');
            $payment->save();
        }
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
                    $payment->amount_paid = $request->input('payment');
                    $payment->save();
                }
            }
            $sale_note->save();
        }
        //    $document_save->updateCreditsPayment();
        $this->createPdf($request->input('sale_note_id'));
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
