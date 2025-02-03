<?php

namespace App\Http\Controllers\Tenant;

use Exception;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Tenant\Box;
use App\Models\Tenant\Item;
use App\Models\Tenant\User;
use App\Models\Tenant\Person;
use App\Models\Tenant\Series;
use App\Models\Tenant\Company;
use App\Models\Tenant\ItemSet;
use App\Models\Tenant\Payment;
use App\Models\Tenant\Receipt;
use App\Models\Tenant\Dispatch;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use Mpdf\HTMLParserMode;
use App\Models\Tenant\Inventory;
use App\Mail\SaleNoteEmail;
use Illuminate\Support\Str;
use App\Models\Tenant\PurchaseItem;
use App\Models\Tenant\SaleNoteItem;
use Illuminate\Http\Request;
use App\Models\Tenant\Configuration;
// use App\Models\Tenant\Warehouse;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemWarehouse;
use Mpdf\Config\FontVariables;
use App\CoreFacturalo\Template;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\SaleNotePayment;
use Modules\Item\Models\ItemLot;
use Mpdf\Config\ConfigVariables;
use App\Models\Tenant\PaymentMethodType;
use App\Models\Tenant\Catalogs\PriceType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Restaurant\Models\Area;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Restaurant\Models\Orden;
use App\Models\Tenant\Catalogs\CurrencyType;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Http\Requests\Tenant\SaleNoteRequest;
use App\Models\Tenant\Catalogs\AttributeType;
use App\Models\Tenant\Catalogs\OperationType;
use App\Models\Tenant\Catalogs\SystemIscType;
use Modules\Item\Models\ItemLotsGroup;
use Illuminate\Support\Facades\Session;
use Modules\Inventory\Models\Warehouse;
use App\Http\Resources\Tenant\SaleNoteResource;
use Modules\Finance\Traits\FinanceTrait;
use App\Http\Resources\Tenant\SaleNoteResource2;
use Modules\Restaurant\Events\PrintEvent;
use App\Http\Resources\Tenant\SaleNoteCollection;
use App\Http\Resources\Tenant\SaleNoteVentaCollection;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Catalogs\ChargeDiscountType;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Finance\Traits\FilePaymentTrait;
use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\CoreFacturalo\Requests\Inputs\Common\LegendInput;
use App\CoreFacturalo\Requests\Inputs\Common\PersonInput;
use App\CoreFacturalo\Requests\Inputs\Common\EstablishmentInput;
use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Exports\CreditByClientExport;
use App\Exports\NotaVentaExport;
use App\Exports\SaleNoteExport;
use App\Http\Resources\Tenant\SaleNoteCreditPenaltyCollection;
use App\Http\Resources\Tenant\SaleNoteLiteCollection;
use App\Jobs\WhatsappSendMessageProccess;
use App\Models\Tenant\BankAccount;
use App\Models\Tenant\Cash;
use App\Models\Tenant\CreditList;
use App\Models\Tenant\HistoryPayment;
use App\Models\Tenant\HotelRent;
use App\Models\Tenant\HotelRentDocument;
use App\Models\Tenant\HotelRentInfraction;
use App\Models\Tenant\HotelRentItem;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\NumberActivity;
use App\Models\Tenant\PromotionDocument;
use App\Models\Tenant\Quotation;
use App\Models\Tenant\SaleNoteCredit;
use App\Models\Tenant\SaleNoteCreditPenalty;
use App\Models\Tenant\SaleNotePromotion;
use App\Models\Tenant\Seller;
use App\Models\Tenant\StateType;
use App\Traits\PromotionDocumentTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Item\Models\CategoryItem;
use Modules\Report\Exports\ReportConsolidatedCreditExport;
use Modules\Restaurant\Events\OrdenReadyEvent;
use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\HotelRentItemServices;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\Table;
use Modules\Workshop\Models\Historial;
use Modules\Workshop\Http\Controllers\VehiculoController;
use Mpdf\Mpdf;

class SaleNoteController extends Controller
{

    use StorageDocument, FinanceTrait, FilePaymentTrait, PromotionDocumentTrait;
    protected $sale_note;
    protected $company;
    protected $apply_change;
    protected $document;
    protected $configuration;





    public function export_consolidated(Request $request)
    {
        $data = $this->getRecordsConsolidated($request);
        $period = $request->period;
        //obtener la fecha inicial y final
        $date_start = null;
        $date_end = null;
        switch ($period) {
            case 'date':
                $date_start = $request->date_start;
                $date_end = $request->date_start;
                break;
            case 'between_dates':
                $date_start = $request->date_start;
                $date_end = $request->date_end;
                break;
            case 'month':
                $date_start = $request->month_start;
                $date_end = Carbon::createFromFormat('Y-m', $request->month_start)->endOfMonth()->format('Y-m-d');
                break;
            case 'between_months':
                $date_start = Carbon::createFromFormat('Y-m', $request->date_start)->startOfMonth()->format('Y-m-d');
                $date_end = Carbon::createFromFormat('Y-m', $request->date_end)->endOfMonth()->format('Y-m-d');
                break;
        }
        $data['date_start'] = $date_start;
        $data['date_end'] = $date_end;
        $company = Company::active();
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        return (new ReportConsolidatedCreditExport)
            ->data($data)
            ->company($company)
            ->establishment($establishment)
            ->download('Reporte_Crédito_Consolidado_' . Carbon::now() . '.xlsx');
    }
    public function checkBoxesSaleNote()
    {

        SaleNote::where('credit_cash', true)->whereDoesntHave('credit_payments')->where('state_type_id', '<>', '11')->where('paid', 0)->chunk(100, function ($sale_notes) {
            foreach ($sale_notes as $sale_note) {
                $boxes = Box::where('sale_note_id', $sale_note->id)->sum('amount');
                if ($boxes >= $sale_note->total) {
                    $sale_note->paid = 1;
                    $sale_note->save();
                }
            }
        });

        return [
            'success' => true,
            'message' => 'Créditos actualizados',
        ];
    }
    public function records_consolidated(Request $request)
    {
        $data = $this->getRecordsConsolidated($request);

        return response()->json($data);
    }
    public function getRecordsConsolidated(Request $request)
    {
        $period = $request->period;
        $expenses = Box::whereNull('purchase_id')->where('expenses', true);
        $purchases = Box::whereNotNull('purchase_id');
        $sale_notes = SaleNote::whereIn('state_type_id', ['01', '05'])
            ->where('status', 'A');

        switch ($period) {
            case 'date':
                $sale_notes->where('date_of_issue', $request->date_start);
                $expenses->where('date', $request->date_start);
                $purchases->where('date', $request->date_start);
                break;
            case 'between_dates':
                $sale_notes->whereBetween('date_of_issue', [$request->date_start, $request->date_end]);
                $expenses->whereBetween('date', [$request->date_start, $request->date_end]);
                $purchases->whereBetween('date', [$request->date_start, $request->date_end]);
                break;
            case 'month':
                $month_start = $request->month_start;
                $year = Carbon::createFromFormat('Y-m', $month_start)->year;
                $month = Carbon::createFromFormat('Y-m', $month_start)->month;
                $sale_notes->whereMonth('date_of_issue', $month)
                    ->whereYear('date_of_issue', $year);
                $expenses->whereMonth('date', $month)
                    ->whereYear('date', $year);
                $purchases->whereMonth('date', $month)
                    ->whereYear('date', $year);
                break;
            case 'between_months':
                $date_start = Carbon::createFromFormat('Y-m', $request->date_start)->startOfMonth()->format('Y-m-d');
                $date_end = Carbon::createFromFormat('Y-m', $request->date_end)->endOfMonth()->format('Y-m-d');
                $sale_notes->whereBetween('date_of_issue', [$date_start, $date_end]);
                $expenses->whereBetween('date', [$date_start, $date_end]);
                $purchases->whereBetween('date', [$date_start, $date_end]);
                break;
        }

        $plucked_ids = $sale_notes->pluck('id')->values();
        $sum_total_by_user = $sale_notes->selectRaw('user_id, SUM(total - advances) as sum_total')
            ->groupBy('user_id')
            ->get()
            ->pluck('sum_total', 'user_id');

        $user_ids = $sale_notes->select('user_id')->distinct()->get()->pluck('user_id')->values();
        $user_names = User::whereIn('id', $user_ids)->pluck('name', 'id');

        $sum_total_by_user_with_names = $sum_total_by_user->mapWithKeys(function ($sum_total, $user_id) use ($user_names) {
            return [$user_names[$user_id] => $sum_total];
        });
        $sum_total_general = $sum_total_by_user->sum();
        $payments = Payment::whereIn('sale_note_id', $plucked_ids)->selectRaw('SUM(amount) as total')->value('total');
        $expenses = $expenses->selectRaw('SUM(amount) as sum_total')
            ->value('sum_total');
        $purchases = $purchases->selectRaw('SUM(amount) as sum_total')
            ->value('sum_total');
        $gain = $payments - $sum_total_general;
        return [
            'success' => true,
            'data' => $sum_total_by_user_with_names,
            'payments' => $payments,
            'expenses' => $expenses,
            'purchases' => $purchases,
            'sum_total_general' => $sum_total_general,
            'gain' => $gain,
        ];
    }
    public function index_consolidated()
    {
        return view('tenant.sale_notes.consolidated');
    }
    public function updatePayment(Request $request)
    {
        $type = $request->type;
        $value = $request->value;
        $payment_id = $request->payment_id;
        $payment = Payment::find($payment_id);
        $old_value = $payment->$type;
        $payment->$type = $value;
        if ($type !== 'paid') {
            $to_paid_amount = $payment->amount_paid + $payment->penalty_amount;
            $paid_amount = $payment->amount;
            if ($to_paid_amount >= $paid_amount) {
                $payment->paid = 1;
            }
        }
        $payment->save();
        HistoryPayment::create([
            'user_id' => auth()->user()->id,
            'payment_id' => $payment_id,
            'type' => $type,
            'value' => $value,
            'old_value' => $old_value,
        ]);
        $payments = Payment::where('sale_note_id', $payment->sale_note_id)->where('paid', 0)->count();

        if ($payments == 0) {
            $sale_note = SaleNote::find($payment->sale_note_id);
            $sale_note->paid = 1;
            $sale_note->save();
        }


        return [
            'success' => true,
            'message' => 'Pago actualizado',
        ];
    }
    public function getPayments($sale_note_id)
    {
        $payments = Payment::where('sale_note_id', $sale_note_id)->get();
        return $payments;
    }
    public function checkCustomerLine($customer_id)
    {
        $sale_notes = SaleNote::where('customer_id', $customer_id)->whereIn('status', ['R', 'O'])->count();
        // return $sale_notes > 0;
        return [
            'success' => true,
            'has_problems' => $sale_notes > 0
        ];
    }
    public function pauseCredit(Request $request)
    {
        $sale_note_id = $request->sale_note_id;
        $reason_to_void = $request->reason_to_void;
        $sale_note = SaleNote::find($sale_note_id);
        $sale_note_credit = SaleNoteCredit::where('sale_note_id', $sale_note_id)->first();
        $sale_note_credit->reason_to_anulate_credit = $reason_to_void;
        $sale_note_credit->save();
        $sale_note->status = 'O';
        $sale_note->save();

        return [
            'success' => true,
            'message' => 'Crédito actualizado',
        ];
    }
    public function voidCredit(Request $request)
    {
        $sale_note_id = $request->sale_note_id;
        $reason_to_void = $request->reason_to_void;
        $sale_note = SaleNote::find($sale_note_id);
        $sale_note_credit = SaleNoteCredit::where('sale_note_id', $sale_note_id)->first();
        $sale_note_credit->reason_to_anulate_credit = $reason_to_void;
        $sale_note_credit->save();
        $sale_note->status = 'R';
        $user_name = auth()->user()->name;
        $message_base = "El crédito de la nota de venta N° " . $sale_note->series . "-" . $sale_note->number . " ha sido anulada. Por el usuario " . $user_name . " por el motivo: " . $reason_to_void;
        // (new WhatsappSendMessageProccess())->dispatch($sale_note->website_id, $message_base, $sale_note_credit->number);
        // (new WhatsappController)->sendMessageAll($message_base);
        $this->anulate($request, $sale_note_id);
        $sale_note->save();
        return [
            'success' => true,
            'message' => 'Nota de venta actualizada',
        ];
    }
    public function generateMessages()
    {
        $configuration = Configuration::first();
        $messages = [];
        if ($configuration->credits) {
            $sale_notes = SaleNote::where('paid', 0)->whereHas('creditPayments')
                ->where('type_payment', '<>', 'Diario')
                ->get();
            foreach ($sale_notes as $key => $row) {
                $payment = Payment::where('sale_note_id', $row->id);
                $payment_not_paid = $payment->where('paid', 0)
                    ->where('date_payment', '<=', Carbon::now()->startOfDay())
                    ->orderBy('date_payment', 'desc');
                $last_payment =  Payment::where('sale_note_id', $row->id)
                    ->where('paid', 0)
                    ->orderBy('date_payment', 'asc')
                    ->first();
                $dues = $payment_not_paid->count();
                $date_of_due = ($last_payment) ? $last_payment->date_payment : null;
                $differenc_days = 0;
                if ($date_of_due && $dues > 0) {
                    if (is_object($date_of_due)) {
                        $date_of_due = $date_of_due->format('Y-m-d');
                    }
                    $differenc_days = Carbon::parse($date_of_due)->diffInDays(Carbon::now()->startOfDay(), false);
                }
                if ($differenc_days > 0) {
                    $customer_name = $row->customer->name;
                    $customer = Person::find($row->customer_id);
                    $telephone = $customer->telephone;
                    $message = "Estimado Cliente \"" . $customer_name . "\", Ud. Tiene " . $differenc_days . " días de atraso, *por favor* tomar las consideraciones pertinentes. Si ya *pagó* omita este mensaje.";
                    $messages[] = [
                        'telephone' => $telephone,
                        'message' => $message
                    ];
                }
            }
        }
        foreach ($messages as $key => $row) {
            Log::info("Mensaje enviado a: " . $row['telephone'] . " Mensaje: " . $row['message']);
        }
        return $messages;
    }
    public function getItemsFromNotesCaja(Request $request)
    {
        $request->validate([
            'notes_id' => 'required|array',
        ]);
        $dscto_global = SaleNote::whereIn('id', $request->notes_id)->sum('total_discount');

        $result = [];
        $items = SaleNoteItem::whereIn('sale_note_id', $request->notes_id)->get();

        foreach ($items as $key => $item) {
            $item_id = $item->item_id;
            $food = Food::where('item_id', $item_id)->first();
            $quantity = $item->quantity;
            $price = $item->unit_price;
            $series = $item->item->lots;
            $lotes = [];
            $result[] = [
                "id" => $item->id,
                "item_id" => $item->item_id,
                "food" => $food,
                "quantity" => number_format($quantity, 2),
                "price" => number_format($price, 2),
                "series" => $series,
                "lotes" => $lotes,
            ];
        }


        return response()->json([
            'success' => true,
            'data' => $result,
            'dscto_global' => $dscto_global,
        ], 200);
    }
    public function credit_cash_records(Request $request)
    {
        $value = $request->value;

        $records = SaleNote::query()
            ->with([
                'customer:id,name,number,alias',
                'state_type:id,description',
                'documents', // Quitamos la selección específica de campos
                'user:id,name',
                'boxes:id,sale_note_id,amount'
            ])
            ->where('credit_cash', true)
            ->where('state_type_id', '<>', '11')
            ->whereDoesntHave('credit_payments')
            ->where('paid', 0)
            ->select('sale_notes.*')
            ->distinct(); // Usamos distinct en lugar de groupBy

        // Aplicar filtros de búsqueda si existe un valor
        if ($value) {
            $records->where(function ($query) use ($value) {
                $searchTerm = '%' . str_replace(' ', '%', $value) . '%';

                $query->whereHas('customer', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('name', 'like', $searchTerm)
                        ->orWhere('alias', 'like', $searchTerm)
                        ->orWhere('number', 'like', $searchTerm);
                })
                    ->orWhere('sale_notes.number', 'like', $searchTerm);
            });
        }

        // Ordenar y paginar
        return new SaleNoteLiteCollection(
            $records->latest()
                ->paginate(config('tenant.items_per_page'))
        );
    }
    public function getItemsFromNotes(Request $request)
    {
        $request->validate([
            'notes_id' => 'required|array',
        ]);


        if ($request->select_all) {

            $items = SaleNoteItem::whereIn('sale_note_id', $request->notes_id)->get();
        } else {

            $items = SaleNoteItem::whereIn('sale_note_id', $request->notes_id)
                ->select('item_id', 'quantity')
                ->get();
        }


        return response()->json([
            'success' => true,
            'data' => $items,
        ], 200);
    }
    public function saleNotesByClient(Request $request)
    {

        $number = $request->number;
        if ($number == null) {
            $request->validate([
                'client_id' => 'required|numeric|min:1',
            ]);
        }

        $clientId = $request->client_id;
        $records = SaleNote::without(['user', 'soap_type', 'state_type', 'currency_type', 'payments'])
            ->select('series', 'number', 'id', 'date_of_issue', 'total');
        if ($clientId) {
            $records = $records->where('customer_id', $clientId);
        }
        if ($number) {
            $records = $records->where('number', 'like', "%{$number}%");
        }

        $records  = $records->whereNull('document_id')
            ->whereIn('state_type_id', ['01', '03', '05'])
            ->orderBy('number', 'desc');

        $dateOfIssue = $request->date_of_issue;
        $dateOfDue = $request->date_of_due;
        if ($dateOfIssue && !$dateOfDue) {
            $records = $records->where('date_of_issue', $dateOfIssue);
        }

        if ($dateOfIssue && $dateOfDue) {
            $records = $records->whereBetween('date_of_issue', [$dateOfIssue, $dateOfDue]);
        }
        $sum_total = 0;
        $records = $records->take(20)
            ->get();
        $sum_total = number_format($records->sum('total'), 2);
        return response()->json([
            'success' => true,
            'data' => $records,
            'sum_total' => $sum_total,
        ], 200);
    }

    public function columns_penalty()
    {
        return [
            'amount_by_day' => 'Monto',
        ];
    }
    public function index_penalty()
    {
        $company = Company::first();
        $configuration = Configuration::first();
        return view(
            'tenant.sale_notes.penalty',
            compact('company', 'configuration')
        );
    }
    public function records_penalty(Request $request)
    {
        $records = SaleNoteCreditPenalty::query();
        return new SaleNoteCreditPenaltyCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function store_penalty(Request $request)
    {
        $id = $request->id;
        $amount_by_day = $request->amount_by_day;
        if ($id) {
            $penalty = SaleNoteCreditPenalty::findOrFail($id);
            $penalty->amount_by_day = $amount_by_day;
            $penalty->save();
        } else {
            SaleNoteCreditPenalty::create([
                'amount_by_day' => $amount_by_day,
            ]);
        }
        return [
            'success' => true,
            'message' => 'Multa actualizada',
        ];
    }
    public function index()
    {
        $company = Company::select('soap_type_id', 'name')->first();
        $soap_company  = $company->soap_type_id;
        $configuration = Configuration::first();
        $user_type = auth()->user()->type;
        $resource = "sale-notes";
        return view('tenant.sale_notes.index', compact('soap_company', 'company', 'configuration', 'user_type', 'resource'));
    }
    public function indexNota()
    {
        $company = Company::select('soap_type_id', 'name')->first();
        $soap_company  = $company->soap_type_id;
        $configuration = Configuration::first();
        $user_type = auth()->user()->type;
        $resource = "notaventa";
        return view('tenant.notaventa.index', compact('soap_company', 'company', 'configuration', 'user_type', 'resource'));
    }
    public function pos()
    {
        $company = Company::select('soap_type_id')->first();
        $soap_company  = $company->soap_type_id;
        $configuration = Configuration::first();
        $user_type = auth()->user()->type;
        $resource = "caja/sale-notes";
        return view('tenant.sale_notes.pos', compact('soap_company', 'configuration', 'user_type', 'resource'));
    }
    public function create($id = null)
    {
        $configuration = Configuration::first();
        return view('tenant.sale_notes.form', compact('id', 'configuration'));
    }
    public function getCreditPending()
    {
        $payments = Payment::select('sale_note_id', DB::raw('SUM(amount) as total_amount'))
            ->whereHas('sale_note', function ($q) {
                $q->where('paid', 0)->whereHas('credit_payments');
            })
            ->groupBy('sale_note_id')
            ->get();

        $sale_notes_total = collect($payments)->sum('total_amount');
        $sale_notes_paid = 0;
        foreach ($payments as $key => $sale_note) {
            $id = $sale_note["sale_note_id"];
            $sale_note_payment = SaleNotePayment::where('sale_note_id', $id)->sum('payment');
            $sale_notes_paid += $sale_note_payment;
        }

        $sale_notes_pending = $sale_notes_total - $sale_notes_paid;

        return compact('sale_notes_pending');
    }
    public function columns()
    {
        return [
            'number' => 'Numero de Nota de Venta',
            'date_of_issue' => 'Fecha de emisión',
            'customer_id' => 'Cliente',
            'state_type_id' => 'Estado Comprobante',
            'seller_id' => 'Asesor - Vendedor',
        ];
    }
    public function columnsVenta()
    {
        return [
            'number' => 'Numero de Nota de Venta',
            'date_of_issue' => 'Fecha de emisión',
            'customer_id' => 'Cliente',
            'state_type_id' => 'Estado Comprobante',
            'seller_id' => 'Asesor - Vendedor',
        ];
    }

    public function columns2()
    {
        return [
            'series' => Series::whereIn('document_type_id', ['80'])->get(),
        ];
    }

    public function excel(Request $request)
    {
        $records = $this->get_records($request)->get();
        $company = Company::active();
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        return (new SaleNoteExport)
            ->records($records)
            ->company($company)
            ->download('Reporte_Nota_de_Venta_' . Carbon::now() . '.xlsx');
    }
    public function excelNota(Request $request)
    {
        $records = $this->get_recordsNota($request)->get();
        $company = Company::active();
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        return (new NotaVentaExport)
            ->records($records)
            ->company($company)
            ->download('Reporte_productos_nota_venta' . Carbon::now() . '.xlsx');
    }

    public function get_recordsNota(Request $request)
    {
        $customer_id = $request->customer_id;
        $seller_id = $request->seller_id;
        $date_of_issue = $request->date_of_issue;
        $state_type_id = $request->state_type_id;
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $number = $request->number;
        $series = $request->series;
        $description = $request->description;
        $category_id = $request->category_id;
        $records = SaleNote::query();

        if ($customer_id) {
            $records = $records->where("customer_id", $customer_id);
        }
        if ($seller_id) {
            $records = $records->where("seller_id", $seller_id);
        }
        /* if ($category_id) {
            $records = $records->where("category_id", $category_id);
        } */
        if ($state_type_id) {
            $records = $records->where("state_type_id", $state_type_id);
        }
        if ($number) {
            $records = $records->where("number", $number);
        }
        if ($date_end && preg_match('/^\d{4}-\d{2}$/', $date_end)) {
            $startOfMonth = \Carbon\Carbon::createFromFormat('Y-m', $date_end)->startOfMonth()->toDateString();
            $endOfMonth = \Carbon\Carbon::createFromFormat('Y-m', $date_end)->endOfMonth()->toDateString();

            $records->whereBetween('date_of_issue', [$startOfMonth, $endOfMonth]);
        } elseif ($date_start || $date_end) {
            if ($date_start && $date_end) {
                $records->whereBetween('date_of_issue', [$date_start, $date_end]);
            } else {
                $records->where('date_of_issue', $date_start ?? $date_end);
            }
        }
        if ($series) {
            $records = $records->where('series', 'like', '%' . $series . '%');
        }
        if ($description) {
            $records = $records->whereHas('items', function ($query) use ($description) {
                $query->whereHas('item', function ($subQuery) use ($description) {
                    $subQuery->where('description', 'like', '%' . $description . '%');
                });
            });
        }
        if ($category_id) {

            $records = $records->whereHas('items', function ($query) use ($category_id) {
                $query->whereHas('relation_item', function ($q) use ($category_id) {
                    $q->where('category_id', $category_id);
                });
            });
        }


        $records = $records->orderBy('date_of_issue', 'desc')->orderBy('time_of_issue', 'desc');
        return $records;
    }
    public function get_records(Request $request)
    {
        $customer_id = $request->customer_id;
        $seller_id = $request->seller_id;
        $state_type_id = $request->state_type_id;
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $number = $request->number;
        $series = $request->series;
        $records = SaleNote::query();

        if ($customer_id) {
            $records = $records->where("customer_id", $customer_id);
        }
        if ($seller_id) {
            $records = $records->where("seller_id", $seller_id);
        }
        if ($state_type_id) {
            $records = $records->where("state_type_id", $state_type_id);
        }
        if ($number) {
            $records = $records->where("number", $number);
        }
        if ($date_start || $date_end) {
            if ($date_start && $date_end) {
                $records = $records->whereBetween('date_of_issue', [$date_start, $date_end]);
            } else {
                $records = $records->where('date_of_issue', $date_start ?? $date_end);
            }
        }
        if ($series) {
            $records = $records->where('series', 'like', '%' . $series . '%');
        }
        $records = $records->orderBy('date_of_issue', 'desc')->orderBy('time_of_issue', 'desc');
        return $records;
    }
    public function totalRecords(Request $request)
    {
        $records = $this->get_records($request)->whereDoesntHave('documents');
        return $records->sum('total');
    }
    public function records(Request $request)
    {

        // if ($request->column == 'customer_id') {
        //     $records = SaleNote::where($request->column, '=', $request->value)
        //         ->latest('id');
        //     // dd(SaleNote::where($request->column, '=',$request->value)->toSql());
        // }  else if ($request->column == 'date_of_issue') {
        //     if ($request->end != null) {
        //         $records = SaleNote::whereBetween($request->column, [$request->value, $request->end])->latest('id');
        //     } else {
        //         $records = SaleNote::where($request->column, 'like', "%{$request->value}%")->latest('id');
        //     }
        // } else {
        //     $records = SaleNote::where($request->column, 'like', "%{$request->value}%")->latest('id');
        // }

        $records = $this->get_records($request);

        // if($request->)
        return new SaleNoteCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function recordsNota(Request $request)
    {
        $records = $this->get_recordsNota($request);
        return new SaleNoteVentaCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function items($id)
    {
        $items = SaleNoteItem::where('sale_note_id', $id)->get();

        return compact('items');
    }
    public function records2(Request $request)
    {

        $date_of_issue = $request->date_of_issue;

        $customer_id = $request->customer_id;

        $records = SaleNote::where('date_of_issue', 'like', '%' . $date_of_issue . '%')

            ->latest();

        if ($customer_id) {
            $records = $records->where('customer_id', $customer_id);
        }
        return new SaleNoteCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function setStatusCredit(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $observations = $request->observations;
        $sale_note = SaleNote::find($id);
        $sale_note->status = $status;
        if ($status == 'R') {
            $this->anulate($request, $id);
            SaleNoteCredit::where('sale_note_id', $id)->delete();
            Payment::where('sale_note_id', $id)->delete();
        }
        if ($status == 'A' && $sale_note->is_cash) {
            $user = $sale_note->user;
            $area_id = $user->area_id;
            event(new PrintEvent(null, 'URL', true, $area_id, [], false, false, "/sale-notes/cash_out/" . $sale_note->id));
        }
        $sale_note->observation = $observations;
        $sale_note->save();

        return [
            'success' => true,
            'message' => 'Crédito actualizado',
        ];
    }
    public function searchCustomers(Request $request)
    {

        $customers = Person::where('number', 'like', "%{$request->input}%")
            ->orWhere('name', 'like', "%{$request->input}%")
            ->orWhere('address', 'like', "%{$request->input}%")
            ->whereType('customers')
            ->whereIsEnabled()
            ->orderBy('name')
            ->get()->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => $row->number . ' - ' . $row->name,
                    'name' => $row->name,
                    'number' => $row->number,
                    'identity_document_type_id' => $row->identity_document_type_id,
                    'identity_document_type_code' => $row->identity_document_type->code
                ];
            });

        return compact('customers');
    }

    public function tables()
    {
        $categories = CategoryItem::all();
        $sellers = Seller::where('establishment_id', auth()->user()->establishment_id)->get();
        $customers = $this->table('customers');
        $establishments = Establishment::where('id', auth()->user()->establishment_id)->get();
        $currency_types = CurrencyType::whereActive()->get();
        $discount_types = ChargeDiscountType::whereType('discount')->whereLevel('item')->get();
        $charge_types = ChargeDiscountType::whereType('charge')->whereLevel('item')->get();
        $configuration = Configuration::first();
        $tasa_interes = $configuration->rates;
        $company = Company::active();
        $state_types = StateType::whereIn('id', ['01', '11'])->get();
        $payment_method_types = PaymentMethodType::where('active', 1)->get();
        $users = User::where('active', 1)->get();
        $user_select = User::select('id')->where('id', auth()->user()->id)->first();
        $document_type_03_filter = config('tenant.document_type_03_filter');
        $promotions_document = PromotionDocument::where('active', 1)->get();
        $series = collect(Series::all())->transform(function ($row) {
            return [
                'id' => $row->id,
                'contingency' => (bool) $row->contingency,
                'document_type_id' => $row->document_type_id,
                'establishment_id' => $row->establishment_id,
                'number' => $row->number
            ];
        });
        $payment_destinations = $this->getPaymentDestinations();
        // $state_t
        return compact(
            'promotions_document',
            'categories',
            'state_types',
            'sellers',
            'customers',
            'establishments',
            'tasa_interes',
            'currency_types',
            'discount_types',
            'users',
            'user_select',
            'charge_types',
            'company',
            'payment_method_types',
            'series',
            'payment_destinations',
            'document_type_03_filter',
            'configuration'
        );
    }

    public function changed($id)
    {
        $sale_note = SaleNote::find($id);
        $sale_note->changed = true;
        $sale_note->save();
    }


    public function item_tables()
    {
        $items = $this->table('items');
        $categories = [];

        $affectation_igv_types = AffectationIgvType::whereActive()->get();
        $system_isc_types = SystemIscType::whereActive()->get();
        $price_types = PriceType::whereActive()->get();
        $discount_types = ChargeDiscountType::whereType('discount')->whereLevel('item')->get();
        $charge_types = ChargeDiscountType::whereType('charge')->whereLevel('item')->get();
        $attribute_types = AttributeType::whereActive()->orderByDescription()->get();

        return compact(
            'items',
            'categories',
            'affectation_igv_types',
            'system_isc_types',
            'price_types',
            'discount_types',
            'charge_types',
            'attribute_types'
        );
    }

    public function paymentsInit($id)
    {
        $payments = Payment::where('sale_note_id', $id)
            ->get();

        return compact('payments');
    }

    public function getLastPayment($id)
    {
        $payment = Payment::where('sale_note_id', $id)
            ->where('paid', 0)
            ->orderBy('date_payment', 'asc')
            ->first();
        $amount_paid = $payment->amount_paid;
        $amount = $payment->amount;
        $penalty_amount = $payment->penalty_amount;
        $date_payment = $payment->date_payment;
        return [
            'success' => true,
            'date_payment' => $date_payment,
            'to_pay' => $amount - ($amount_paid + $penalty_amount),
            'amount' => $amount,
            'amount_paid' => $amount_paid,
            'penalty_amount' => $penalty_amount,
        ];
    }
    public function updateCredit(Request $request, $id)
    {
        $sale_note = SaleNote::find($id);
        Payment::where('sale_note_id', $id)->delete();
        $sale_note_credit = SaleNoteCredit::where('sale_note_id', $id)->first();
        $cash_id = $sale_note_credit->cash_id;
        $date = Carbon::parse($request->date_of_issue);
        for ($i = 0; $i < $request->num_cuota; $i++) {
            switch ($request->type_payment) {
                case "Diario":
                    $dias = 1;
                    $date_payment = \Carbon\Carbon::parse($date->addDay($dias))->format('Y-m-d');
                    $Week = date("w", strtotime($date_payment)); //date('W',strtotime($date_payment));
                    if ($Week == 0) {
                        $date_payment = \Carbon\Carbon::parse($date->addDay($dias))->format('Y-m-d');
                    }
                    break;
                case "Semanal":
                    $dias = 7;
                    $date_payment = \Carbon\Carbon::parse($date->addDay($dias))->format('Y-m-d');
                    $Week = date("w", strtotime($date_payment)); //date('W',strtotime($date_payment));
                    if ($Week == 0) {
                        $date_payment = \Carbon\Carbon::parse($date->addDay($dias + 1))->format('Y-m-d');
                    }
                    break;
                case "Quincenal":
                    $dias = 15;
                    $date_payment = \Carbon\Carbon::parse($date->addDay($dias))->format('Y-m-d');
                    $week = date("w", strtotime($date_payment)); //date('W',strtotime($date_payment));
                    if ($week == 0) {
                        $date_payment = \Carbon\Carbon::parse($date->addDay(1))->format('Y-m-d');
                    }
                    break;
                case "Mensual":
                    $dias = 30;
                    $date_payment = \Carbon\Carbon::parse($date->addDay($dias))->format('Y-m-d');
                    break;
            }


            Payment::create([
                "user_id"     => auth()->user()->id,
                "amount"       => $request->amount,
                "sale_note_id" => $id,
                "type_payment" => $request->type_payment,
                "date_payment" => $date_payment,
                "tasa"         => $request->tasadefault
            ]);
            // $payment = Payment::firstOrNew(['id' => $id]);
        }
        $sale_note->date_of_issue = $request->date_of_issue;
        $sale_note->type_payment = $request->type_payment;
        $sale_note->advances = $request->advances;
        $sale_note->month = $request->month;
        $sale_note->save();
        SaleNoteCredit::where('sale_note_id', $id)->delete();
        SaleNoteCredit::create([
            'cash_id' => $cash_id,
            'sale_note_id' => $id,
        ]);

        return [
            'success' => true,
            'message' => 'Nota de venta actualizada',
        ];
    }
    public function recordCredit($id)
    {
        $sale_note = SaleNote::find($id);
        $payment = Payment::where('sale_note_id', $id)->first();
        $tasa = $payment->tasa;
        $month = $sale_note->month;
        $advances = $sale_note->advances;
        $total = $sale_note->total;
        $type_payment = $sale_note->type_payment;
        $customer_name = $sale_note->customer->name;

        return compact('tasa', 'month', 'advances', 'total', 'type_payment', 'customer_name');
    }
    public function simulate(Request $request)
    {
        $payments = $request->prepayments;

        // $customer_id = $request->customer_id;
        $customer = Person::where('name', 'like', "%clientes varios%")->first();
        if (!$customer) {
            $customer = Person::first();
        }
        $customer_name = $customer->name;
        $number_phone = $request->number;
        $customer_number = $customer->number;
        $customer_telephone = $customer->telephone;
        if ($number_phone) {
            $customer_telephone = $number_phone;
        }
        $company = Company::first();
        $date_of_issue = $request->date_of_issue;
        $total = $request->total;
        $type_payment = $request->type_payment;
        $tasa = $request->tasa;
        $amount = $request->amount;
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();

        $recibo = PDf::loadView('tenant.schedule.simulate_schedule', [
            'page' => 1,
            'establishment' => $establishment,
            'date_of_issue' => $date_of_issue,
            'customer_name' => $customer_name,
            'company' => $company,
            'customer_number' => $customer_number,
            'total' => $total,
            'type_payment' => $type_payment,
            'tasa' => $tasa,
            'data' => $payments,
            'days' => count($payments),
            'amount' => $amount,
            'quote' => $amount,
        ]);
        $altura = 250;

        if (count($payments) == 26) {
            $altura += (count($payments)) * count($payments) + 200;
        } else {
            $altura += 25 * count($payments) + 150;
        }
        //guarda el pdf con un nombre uuid y deuelve la url
        $name = Str::uuid();
        $url = $this->savePDF($recibo, $name, $altura);
        $whatsapp = $request->whatsapp;
        $print = $request->print;
        if ($print) {

            event(new PrintEvent(null, 'URL1', true, null, [], false, false, $url));
        }
        if ($whatsapp && $customer_telephone) {
            $message = "Simulación de crédito";
            $resource = $url;
            // $resource = str_replace('http://', '', $resource);
            // $resource = str_replace('https://', '', $resource);
            $new_request = new Request();
            $new_request->merge([
                'message' => $message,
                'resource' => $resource,
                'file_name' => "Simulacion de credito",
                'number' => $customer_telephone,
                'from_server' => true,
            ]);
            (new WhatsappController)->sendHistorial($new_request);
        }
        return [
            'success' => true,
            'url' => $url,
        ];
    }
    public function savePDF($recibo, $name)
    {
        $recibo->setPaper('a5', 'portrait');
        if (!file_exists(storage_path('app/public/pdf_simulate'))) {
            mkdir(storage_path('app/public/pdf_simulate'), 0777, true);
        }
        $recibo->save(storage_path('app/public/pdf_simulate/' . $name . '.pdf'));
        return url('storage/pdf_simulate/' . $name . '.pdf');
    }
    public function record($id)
    {

        return  new SaleNoteResource(SaleNote::findOrFail($id));
        // return $record;
    }

    public function record2($id)
    {

        $record = new SaleNoteResource2(SaleNote::findOrFail($id));

        return $record;
    }
    public function central_de_riesgo($id)
    {
        $company = Company::first();
        $sale = SaleNote::findOrFail($id);
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $payment = Payment::where('sale_note_id', $id)->get();
        $recibo = PDF::loadView('tenant.contract.central_de_riesgo', ['company' => $company, 'sale' => $sale, 'payment' => $payment, 'establishment' => $establishment]);
        return $recibo->setPaper('a4', 'portrait')->stream();
    }
    public function pagare($id)
    {
        $company = Company::first();
        $sale = SaleNote::findOrFail($id);
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $payment = Payment::where('sale_note_id', $id)->get();
        $recibo = PDF::loadView('tenant.contract.pagare', ['company' => $company, 'sale' => $sale, 'payment' => $payment, 'establishment' => $establishment]);
        return $recibo->setPaper('a4', 'portrait')->stream();
    }
    public function intereses_moratorios($id)
    {
        $company = Company::first();
        $sale = SaleNote::findOrFail($id);
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $payment = Payment::where('sale_note_id', $id)->get();
        $recibo = PDF::loadView('tenant.contract.intereses_moratorios', ['company' => $company, 'sale' => $sale, 'payment' => $payment, 'establishment' => $establishment]);
        return $recibo->setPaper('a4', 'portrait')->stream();
    }

    public function contrato($id)
    {
        $company = Company::first();
        $sale = SaleNote::findOrFail($id);
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $payment = Payment::where('sale_note_id', $id)->get();

        $recibo = PDF::loadView('tenant.contract.contrato', ['company' => $company, 'sale' => $sale, 'payment' => $payment, 'establishment' => $establishment]);
        return $recibo->setPaper('a4', 'portrait')->stream();
    }
    public function fianza($id)
    {
        $company = Company::first();
        $sale = SaleNote::findOrFail($id);
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $payment = Payment::where('sale_note_id', $id)->get();
        $recibo = PDF::loadView('tenant.contract.fianza', ['company' => $company, 'sale' => $sale, 'payment' => $payment, 'establishment' => $establishment]);
        return $recibo->setPaper('a4', 'portrait')->stream();
    }
    public function contract($id)
    {
        $company = Company::first();
        $sale = SaleNote::findOrFail($id);
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $payment = Payment::where('sale_note_id', $id)->get();
        $recibo = PDF::loadView('tenant.contract.index', ['company' => $company, 'sale' => $sale, 'payment' => $payment, 'establishment' => $establishment]);
        return $recibo->setPaper('a4', 'portrait')->stream();
    }
    public function allCreditClient($id)
    {
        $sale_notes = SaleNote::where('customer_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        $filename = 'Reporte_Creditos_';
        $customer = Person::find($id);
        $customer_name = $customer->name;
        //remove ,
        $customer_name = str_replace(',', '', $customer_name);
        $customer_name = str_replace(' ', '_', $customer_name);
        $today = Carbon::now()->format('d-m-Y');

        $filename = $filename . $customer_name . '_' . $today;
        return (new CreditByClientExport)
            ->records($sale_notes)
            ->download($filename . '.xlsx');
    }
    function restoreStock($qty, $item_id, $warehouse_id)
    {
        $item = Item::find($item_id);
        $item->stock = $item->stock + $qty;
        $item->save();
        $item_warehouse = ItemWarehouse::where('warehouse_id', $warehouse_id)->where('item_id', $item_id)->first();
        $item_warehouse->stock = $item_warehouse->stock + $qty;
        $item_warehouse->save();
    }
    public function store(SaleNoteRequest $request)
    {
        try {
            // SaleNote::where('currency_type_id', 'USD')->update(['currency_type_id' => 'PEN']);
            $configuration = Configuration::first();
            DB::connection('tenant')->transaction(function () use ($request, $configuration) {

                $vehiculo_id = Functions::valueKeyInArray($request->all(), "vehiculo_id", null);

                if ($vehiculo_id) {
                    (new VehiculoController)->restoreItems($vehiculo_id);
                }
                $request["list_ordens"] = Functions::valueKeyInArray($request->all(), "list_ordens", []);
                $request["is_pay_credit_list"] = Functions::valueKeyInArray($request->all(), "is_pay_credit_list", false);
                $request["is_credit"] = Functions::valueKeyInArray($request->all(), "is_credit", false);
                $request["user_id"] = Functions::valueKeyInArray($request->all(), "user_id", auth()->id());
                $quotation_id = Functions::valueKeyInArray($request->all(), "quotation_id", null);
                $request["advances"] = Functions::valueKeyInArray($request->all(), "advances", 0.0);
                $request["total_advances"] = Functions::valueKeyInArray($request->all(), "total_advances", 0.0);
                $request["total_rounded"] = Functions::valueKeyInArray($request->all(), "total", 0.0);
                $request["total_payment"] = Functions::valueKeyInArray($request->all(), "total_payment", 0.0);
                $request["sumCoins"]  = Functions::valueKeyInArray($request->all(), "sumCoins", null);
                $request["type_payment"]  = Functions::valueKeyInArray($request->all(), "type_payment", "Diario");
                $request["document_type_id"] = "80";
                $consolidated_quotations = Configuration::first()->consolidated_quotations;
                if ($consolidated_quotations && $quotation_id) {
                    $document = Document::where('quotation_id', $quotation_id)->first();
                    if ($document) {
                        $state_type_id = $document->state_type_id;
                        if ($state_type_id == '05') {
                            $new_request = new Request();
                            $new_request->merge([
                                'summary_status_type_id' => 3,
                                'date_of_reference' => $document->date_of_issue,
                                'documents' => [
                                    [
                                        'document_id' => $document->id,
                                        'description' => 'Anulación de la operación',
                                    ]
                                ]
                                // 'quotation_id' => $quotation_id,
                            ]);
                            (new VoidedController)->store($new_request);
                        } else if ($state_type_id == '01') {
                            $response = (new DocumentController)->destroyDocument($document->id);
                        }
                    }
                    if (!$document) {
                        $document = SaleNote::where('quotation_id', $quotation_id)->first();
                        $new_request = new Request();
                        if ($document) {
                            (new SaleNoteController)->anulate($new_request, $document->id);
                        }
                    }
                }
                $all_ordens = Functions::valueKeyInArray($request->all(), "all_ordens", false);
                $user = User::find($request['user_id']);
                $data = $this->mergeData($request);
                $data['time_of_issue'] = date('H:i:s');
                $this->sale_note =  SaleNote::updateOrCreate(
                    ['id' => $request->input('id')],
                    $data
                );
                if ($vehiculo_id) {
                    $historial = Historial::where('estado', false)
                        ->where('vehiculo_id', $vehiculo_id)
                        ->first();
                    if ($historial) {
                        $historial->sale_note_id = $this->sale_note->id;
                        $historial->estado = 1;
                        $historial->save();
                    }
                }
                if ($request->input('id') != null) {
                    SaleNoteItem::where('sale_note_id', $request->input('id'))->delete();
                }
                if ($request->is_pay_credit_list) {
                    SaleNoteItem::unsetEventDispatcher();
                }
                foreach ($request->list_ordens as $list_orden) {
                    CreditList::where('orden_id', $list_orden)->update(['paid' => true]);
                }
                if ($request->orden_id) {
                    $Orden = Orden::findOrFail($request->orden_id);
                    $Orden->sale_note_id = $this->sale_note->id;
                    $Orden->status_orden_id = 4;
                    $Orden->customer_id = $this->sale_note->customer_id;
                    $Orden->save();
                    $orden_items = OrdenItem::where('orden_id', $request->orden_id)->get();
                    foreach ($orden_items as $orden_item) {
                        $orden_item->status_orden_id = 4;
                        $orden_item->restoreRestaurant();
                        $orden_item->save();
                        event(new OrdenReadyEvent($orden_item->id));
                    }
                }
                if ($request->orden_ids) {
                    $ids = $request->orden_ids;
                    foreach ($ids as $id) {
                        $Orden = Orden::findOrFail($id);
                        $Orden->sale_note_id = $this->sale_note->id;
                        $Orden->status_orden_id = 4;
                        $Orden->customer_id = $this->sale_note->customer_id;
                        $Orden->save();
                        $orden_items = OrdenItem::where('orden_id', $id)->get();
                        foreach ($orden_items as $orden_item) {
                            $orden_item->status_orden_id = 4;
                            $orden_item->restoreRestaurant();
                            $orden_item->save();
                            // event(new OrdenReadyEvent($orden_item->id));
                        }
                    }
                }
                $promotion_sale = $request->promotion_sale ?? false;

                if ($request->is_pay_credit_list) {
                    SaleNoteItem::setEventDispatcher(new \Illuminate\Events\Dispatcher());
                }

                $vacate = $request->vacate;
                if ($configuration->hotels) {
                    if ($request->hotel_rent_item_ids) {
                        $hotel_rent_items = HotelRentItem::whereIn('id', $request->hotel_rent_item_ids)->get();

                        foreach ($hotel_rent_items as $item) {
                            $item->payment_status = "Pagado";
                            $id_to_document = $item->hotel_rent_id;
                            $item->sale_note_id = $this->sale_note->id;
                            $item->checkout_date = date('Y-m-d');
                            $item->checkout_time = date('H:i:s');
                            if ($vacate) {
                                $table = Table::where('id', $item->table_id)->first();
                                $table->status_table_id = 5;
                                $table->sendMessageDesocupied();
                                $table->save();
                            } else {
                                HotelRentDocument::create([
                                    'hotel_rent_id' => $id_to_document,
                                    'sale_note_id' => $this->sale_note->id,
                                    'is_advance' => false,
                                ]);
                                $item->total = 0;
                                $item->advances = 0;
                            }
                            $item->save();
                        }
                    }

                    if ($request->hotel_rent_id && !$promotion_sale) {
                        $hotel_rent = HotelRent::findOrFail($request->hotel_rent_id);
                        $hotel_rent_items = $hotel_rent->items;
                        if ($request->is_advance) {

                            HotelRentDocument::create([
                                'hotel_rent_id' => $hotel_rent->id,
                                'sale_note_id' => $this->sale_note->id,
                                'is_advance' => true,
                            ]);
                            foreach ($hotel_rent_items as $item) {
                                $advance = $item->advances;
                                $advance = floatval($advance);
                                $price = $item->getPrice();
                                if ($advance == $price) {
                                    $item->payment_status = "Pagado";
                                    $item->advances = 0;
                                    $item->save();
                                }
                            }
                        } else {
                            foreach ($hotel_rent_items as $item) {
                                $item->payment_status = "Pagado";
                                if ($vacate) {
                                    $table = Table::where('id', $item->table_id)->first();
                                    $table->status_table_id = 5;
                                    $table->sendMessageDesocupied();
                                    $table->save();
                                } else {
                                    $id_to_document = $item->hotel_rent_id;
                                    HotelRentDocument::create([
                                        'hotel_rent_id' => $id_to_document,
                                        'sale_note_id' => $this->sale_note->id,
                                        'is_advance' => false,
                                    ]);
                                    $item->total = 0;
                                    $item->advances = 0;
                                }

                                $item->checkout_date = date('Y-m-d');
                                $item->checkout_time = date('H:i:s');
                                $item->save();
                            }
                            $hotel_rent->payment_status = "Pagado";
                            $hotel_rent->sale_note_id = $this->sale_note->id;

                            $hotel_rent->paid = 1;
                            $hotel_rent->save();
                        }
                    }
                }
                if ($configuration->mod_renta && $request->hotel_rent_id) {
                    $hotel_rent_document = HotelRentDocument::create([
                        'hotel_rent_id' => $request->hotel_rent_id,
                        'sale_note_id' => $this->sale_note->id,
                        'is_advance' => false,
                        'due_date' => $request->due_date,
                    ]);

                    foreach ($data['items'] as $row) {
                        $infraction_id = isset($row['item']['infraction_id']) ? $row['item']['infraction_id'] : null;
                        $infraction = HotelRentInfraction::find($infraction_id);
                        if ($infraction) {
                            $infraction->paid = true;
                            $infraction->hotel_rent_document_id = $hotel_rent_document->id;
                            $infraction->save();
                        }
                    }
                }

                if ($request->is_list_credit) {
                    CreditList::where('customer_id', $this->sale_note->customer_id)->update(['paid' => true]);
                }
                $user_id = auth()->user()->id;
                $cash = Cash::where('state', 1)->where('user_id', $user_id)->first();
                if (!$cash) {
                    throw new Exception("No existe caja abierta para el usuario");
                }
                if ($promotion_sale && $request->hotel_rent_item_service_id) {
                    SaleNotePromotion::create([
                        'sale_note_id' => $this->sale_note->id,
                        'hotel_rent_item_service_id' => $request->hotel_rent_item_service_id,
                        'cash_id' => $cash->id,
                    ]);

                    HotelRentItemServices::where('id', $request->hotel_rent_item_service_id)->update(['active' => 0]);
                }
                if ($all_ordens) {
                    $tables = Table::where('establishment_id', auth()->user()->establishment_id)
                        ->orWhereNull('establishment_id')
                        ->where('is_room', false)
                        // ->where('status_table_id', 2)
                        ->get();
                    foreach ($tables as $table) {
                        $ordens = Orden::where('table_id', $table->id)->whereIn('status_orden_id', [1, 2, 3])->get();
                        foreach ($ordens as $orden) {
                            $orden->sale_note_id = $this->sale_note->id;
                            $orden->status_orden_id = 4;
                            $orden->customer_id = $this->sale_note->customer_id;
                            $orden->save();
                            $orden_items = OrdenItem::where('orden_id', $orden->id)->get();
                            foreach ($orden_items as $orden_item) {
                                $orden_item->status_orden_id = 4;
                                $orden_item->restoreRestaurant();
                                $orden_item->save();
                            }
                        }
                        Table::where('id', $table->id)->update(['status_table_id' => 1]);
                    }
                }
                foreach ($data['items'] as $row) {
                    $item_id = isset($row['id']) ? $row['id'] : null;
                    $sale_note_item = new SaleNoteItem;
                    $sale_note_item->percentage_igv = 18;
                    $sale_note_item->fill($row);
                    $sale_note_item->percentage_igv = 18;
                    $sale_note_item->name_product_pdf = (isset($row['name_product_pdf'])) ? $row['name_product_pdf'] : "";
                    $sale_note_item->sale_note_id = $this->sale_note->id;
                    $sale_note_item->save();
                    if (array_key_exists('toWarehouse', $row)) {
                        $quantity_to_restore = $row['toWarehouse'];
                        if ($quantity_to_restore > 0) {
                            $item_id = $row['item_id'];
                            $warehouse_id = $row['item']['warehouse_id'];
                            $this->restoreStock($quantity_to_restore, $item_id, $warehouse_id);
                        }
                    }

                    // $item = Item::find($item_id);
                    //  $item->stock = $item->stock - $row['quantity'];
                    // $item->save();
                }
                /////------------------------------------------
                if ($request->generate == true) {
                    if ($configuration->sale_note_credit_confirm) {
                        $user = User::find($request->user_id);
                        if ($user->can_accept_credit_sale_note) {
                            $this->sale_note->status = 'A';
                        } else {
                            $this->sale_note->status = 'P';
                        }
                    } else {
                        $this->sale_note->status = 'A';
                    }
                    $this->sale_note->save();
                    $payments_ = $request->prepayments;
                    $date = Carbon::parse($request->date_of_issue);
                    for ($i = 0; $i < $request->num_cuota; $i++) {
                        switch ($request->type_payment) {
                            case "Diario":
                                $dias = 1;
                                $date_payment = \Carbon\Carbon::parse($date->addDay($dias))->format('Y-m-d');
                                $Week = date("w", strtotime($date_payment)); //date('W',strtotime($date_payment));
                                if ($Week == 0) {
                                    $date_payment = \Carbon\Carbon::parse($date->addDay($dias))->format('Y-m-d');
                                }
                                break;
                            case "Semanal":
                                $dias = 7;
                                $date_payment = \Carbon\Carbon::parse($date->addDay($dias))->format('Y-m-d');
                                $Week = date("w", strtotime($date_payment)); //date('W',strtotime($date_payment));
                                if ($Week == 0) {
                                    $date_payment = \Carbon\Carbon::parse($date->addDay($dias + 1))->format('Y-m-d');
                                }
                                break;
                            case "Quincenal":
                                $dias = 15;
                                $date_payment = \Carbon\Carbon::parse($date->addDay($dias))->format('Y-m-d');
                                $week = date("w", strtotime($date_payment)); //date('W',strtotime($date_payment));
                                if ($week == 0) {
                                    $date_payment = \Carbon\Carbon::parse($date->addDay(1))->format('Y-m-d');
                                }
                                break;
                            case "Mensual":
                                $dias = 30;
                                $date_payment = \Carbon\Carbon::parse($date->addDay($dias))->format('Y-m-d');
                                break;
                            case "Unico":
                                $date_payment = Carbon::parse($request->date_of_pay)->format('Y-m-d');
                                break;
                        }


                        $payment_ = Payment::create([
                            "user_id"     => auth()->user()->id,
                            "amount"       => $request->amount,
                            "sale_note_id" => $this->sale_note->id,
                            "type_payment" => $request->type_payment,
                            "date_payment" => $date_payment,
                            "tasa"         => $request->tasadefault
                        ]);
                        if ($payments_ != null && count($payments_) > 0) {
                            if ($payments_[$i]['isPrepayment']) {
                                $payment_->paid = true;
                                $payment_->amount_paid = $payment_->amount;
                                $payment_->save();
                                $sale_note_payment_ = SaleNotePayment::create([
                                    'sale_note_id' => $this->sale_note->id,
                                    // 'payment_id' => $payment_->id,
                                    'payment_method_type_id' => '01',
                                    'date_of_payment' => $date_payment,
                                    'payment' => $payment_->amount,
                                ]);
                                $number_receipt = str_pad(($i + 1), 7, "0", STR_PAD_LEFT);
                                Receipt::create([
                                    'user_id' => $user->id,
                                    'date_of_issue' => $date_payment,
                                    'num_cuota' => $i + 1,
                                    'external_id' => Str::uuid()->toString(),
                                    'hour' => date('H:i:s'),
                                    'establishment_id' => $user->establishment_id,
                                    'customer_id' => $this->sale_note->customer_id,
                                    'sale_note_id' => $this->sale_note->id,
                                    'sale_note_payment_id' => $sale_note_payment_->id,
                                    'detail' => 'PAGO DE NOTA DE VENTA N° ' . $this->sale_note->series . '-' . $this->sale_note->number,
                                    'number' => $number_receipt,
                                    'amount' => $payment_->amount,
                                    'state' => 0,
                                ]);
                            }
                        }

                        // $payment = Payment::firstOrNew(['id' => $id]);
                    }

                    $has_payments_payed = Payment::where('sale_note_id', $this->sale_note->id)->where('paid', true)->count();
                    if ($has_payments_payed > 0) {
                        $this->sale_note->status = 'A';
                        $this->sale_note->save();
                    }

                    // if ($request["advances"] > 0) {
                    //     $payment = Payment::where('sale_note_id', $this->sale_note->id)->first();

                    //     $payment->amount_paid = $request["advances"];
                    //     if ($payment->amount < $request["advances"]) {
                    //         $payment->paid = true;
                    //         $payment->save();
                    //     }
                    // }


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
                    $sale_note_credit =  SaleNoteCredit::create([
                        'cash_id' => $cash->id,
                        'sale_note_id' => $this->sale_note->id,
                    ]);
                    if ($configuration->sale_note_credit_penalty && $request->type_payment) {
                        $type_payment = $request->type_payment;
                        if ($type_payment == "Unico") {
                            $type_payment = "Mensual";
                        }
                        $penalty = DB::connection('tenant')->table('penalties_sale_note_credit')->where('type', $type_payment)->first();
                        if ($penalty) {
                            $sale_note_credit->penalty_amount_by_day = $penalty->amount_by_day;
                            $sale_note_credit->save();
                        }
                    }
                }

                $company = Company::first();
                //obtener el primer registro de box
                $box = Box::where('sale_note_id', $this->sale_note->id)->first();
                $original_cash_id = null;
                if ($box) {
                    $original_cash_id = $box->cash_id;
                }


                Box::where('sale_note_id', $this->sale_note->id)->delete();
                $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
                if ($request->afectar_caja == true && $request->generate != true) {
                    // $payments = PaymentMethodType::where('id', $request->payment_condition_id)->first();
                    // $method = $payments->description;
                    $document_save = SaleNote::where('id', $this->sale_note->id)->first();
                    $type_document = "NOTA DE VENTA";
                    $document = $type_document . " N° " . $document_save->series . " - " . $document_save->number;

                    if ($request->boxes) {
                        $message = "";
                        foreach ($request->boxes as $currentBox) {
                            $method = $currentBox['method'];
                            $amount = $currentBox['amount'];
                            $currency_type_id = $request->currency_type_id;
                            $operation_number = Functions::valueKeyInArray($currentBox, 'operation_number');
                            $bank_account_id = Functions::valueKeyInArray($currentBox, 'bank_account_id');
                            $bank_account_operation = Functions::valueKeyInArray($currentBox, 'number_operation');
                            $cajas    = new Box;
                            $cajas->operation_number = $operation_number;
                            $cajas->group_id = 1;
                            $cajas->category_id = 1;
                            $cajas->currency_type_id = $currency_type_id;
                            $cajas->subcategory_id = 1;
                            $cajas->amount = $amount;
                            $cajas->date = Carbon::parse($request->input('date_of_issue'))->format('Y-m-d');
                            $cajas->type = '1';
                            $cajas->state = '1';
                            $cajas->method = $method;
                            if ($method == "Yape" || $method == "PLIN") {
                                $message .= "Pago por " . $method . " del establecimiento " . $establishment->description . " de usuario " . auth()->user()->name . " por S/" . $amount . "- N° Operación: " . $operation_number ?? "-";
                            }
                            $cajas->bank_account_id = $bank_account_id;
                            $cajas->bank_account_operation = $bank_account_operation;
                            $cajas->sale_note_id = $this->sale_note->id;
                            $cajas->orden_id =  $request->orden_id;
                            $cajas->cash_id = $original_cash_id ? $original_cash_id : $request->cash_id;

                            $cajas->user_id = auth()->user()->id;
                            $cajas->description = "VENTAS " . $document;
                            if ($bank_account_id) {
                                $bank_account = BankAccount::findOrFail($bank_account_id);
                                $bank_account->balance = $bank_account->balance + $currentBox["amount"];
                                $bank_account->save();
                                $cajas->description = "VENTAS " . $document . " - " . $bank_account->bank->description . " - " . $bank_account->currency_type->description;
                            }
                            $cajas->soap_type_id = $company->soap_type_id;
                            $cajas->establishment_id = auth()->user()->establishment_id;
                            $cajas->save();
                        }
                        if ($configuration->send_whatsapp_digital_pay) {

                            if ($message) {
                                (new WhatsappController)->sendMessage($message);
                                $numbers = NumberActivity::all();
                                foreach ($numbers as $key => $number) {
                                    (new WhatsappController)->sendMessage($message, $number->number);
                                }
                            }
                        }
                    } else {
                        if (!$configuration->sale_note_credit_cash) {
                            $cajas    = Box::firstOrNew(['sale_note_id' => $this->sale_note->id]);
                            $cajas->group_id = 1;
                            $cajas->currency_type_id = $request->currency_type_id;
                            $cajas->category_id = 1;
                            $cajas->subcategory_id = 1;
                            $cajas->operation_number = $request->operation_number;
                            $cajas->amount = $request->input('total');
                            $cajas->date = Carbon::parse($request->input('date_of_issue'))->format('Y-m-d');
                            $cajas->type = '1';
                            $cajas->state = '1';
                            $cajas->method =  $request->method_pay;
                            $cajas->sale_note_id = $this->sale_note->id;
                            $cajas->orden_id =  $request->orden_id;
                            $cajas->cash_id = $original_cash_id ? $original_cash_id : $request->cash_id;
                            $cajas->user_id = auth()->user()->id;
                            $cajas->description = "VENTAS " . $document;
                            $cajas->soap_type_id = $company->soap_type_id;
                            $cajas->establishment_id = auth()->user()->establishment_id;
                            $cajas->save();
                        }
                    }
                }
                $boxes = Box::where('sale_note_id', $this->sale_note->id)->get();

                if ($request->receive_promotion) {
                    $this->updatePromotion($this->sale_note);
                }
                if ($request->promotion_id) {
                    $this->savePromotion(
                        $this->sale_note,
                        $request->promotion_id
                    );
                }
                $this->setFilename();
                $this->createPdf($this->sale_note, "a4", $this->sale_note->filename, $boxes);
                $paid = $request->paid;
                if (auth()->user()->type != 'admin') {
                    // if($configuration->android_configuration){
                    //     sleep(5);
                    // }

                    event(new PrintEvent($this->sale_note->id, "80", $request->printerOn, 0, [], true));
                }
                if (count($request->payments) > 0) {
                    $total_payment = 0;

                    foreach ($request->payments as $payment) {

                        $total_payment += $payment['payment'];

                        if ($payment['payment'] > 0) {
                            $record = new SaleNotePayment;
                            if (!isset($payment['payment_method_type_id'])) {
                                $payment['payment_method_type_id'] = "01";
                            }
                            $record->fill($payment);
                            $payment["payment_destination_id"] = "cash";
                            $record->sale_note_id = $this->sale_note->id;
                            $record->save();
                            $this->createGlobalPayment($record, $payment);
                        }
                    }


                    //si el index payment_method_type_id no existe poner paid a true
                    if (!isset($request->payments[0]['payment_method_type_id']) && !$bank_account_id) {
                        $paid = 1;
                    } else {
                    }
                    if (isset($request->payments[0]['payment_method_type_id']) && $request->payments[0]['payment_method_type_id'] == "01" || isset($request->payments[0]['payment_method_type_id']) && $request->payments[0]['payment_method_type_id'] == "10") {
                        if ($total_payment >= $this->sale_note->total) {
                            $paid = 1;
                        }
                        // $paid = 1;
                    }
                }


                if ($request->generate === null || $request->generate === false) {
                    //advances


                } else {
                    $paid = 0;
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

                    if ($request->advances) {

                        $cajas    = new Box;
                        $cajas->group_id = 1;
                        $cajas->category_id = 1;
                        $cajas->subcategory_id = 1;
                        $cajas->amount = $request->advances;
                        $cajas->date = Carbon::parse($request->input('date_of_issue'))->format('Y-m-d');
                        $cajas->type = '1';
                        $cajas->state = '1';
                        $cajas->method =  "Efectivo";
                        $cajas->sale_note_id = $this->sale_note->id;
                        $cajas->orden_id = null;
                        $cajas->cash_id = $cash->id;
                        $cajas->user_id = $user_id;
                        $cajas->description = "ADELANTO CRÉDITO";
                        $cajas->soap_type_id = $company->soap_type_id;
                        $cajas->establishment_id = auth()->user()->establishment_id;
                        $cajas->save();
                    }
                }
                $saleNoteUpdate = SaleNote::findOrFail($this->sale_note->id);
                $rq_cash_id = $request->cash_id;
                if (!$rq_cash_id) {
                    $rq_cash_id = $cash->id;
                }
                $saleNoteUpdate->cash_id = $rq_cash_id;
                if (!$paid && $configuration->sale_note_credit_cash) {
                    $saleNoteUpdate->credit_cash = true;
                }
                $saleNoteUpdate->paid = $paid ?? $saleNoteUpdate->paid;
                $saleNoteUpdate->save();
            });

            if ($this->sale_note->quotation_id) {
                $quotation = Quotation::find($this->sale_note->quotation_id);
                $quotation->changed = true;
                $quotation->save();
            }


            $establishment = Establishment::where('id', $this->sale_note->establishment_id)->first();
            if ($this->sale_note->variation_document_id && $configuration->hotels) {
                $document_variation = Document::find($this->sale_note->variation_document_id);
                $total_variation = $document_variation->total;
                $total_original = $this->sale_note->total;
                $document_hotel = HotelRentDocument::where('sale_note_id', $this->sale_note->id)->first();
                $hotel_rent = HotelRent::find($document_hotel->hotel_rent_id);
                $hotel_rent_item = $hotel_rent->first_hotel_rent_item();
                $room = $hotel_rent_item->getName();
                $is_discount = $total_variation < $total_original;
                $message = "Se ha generado un documento con variación para la habitación " . $room . " por S/" . $total_variation . " Total Original: S/" . $total_original . "" . ($is_discount ? " (Descuento)" : " (Recargo)");
                (new WhatsappController)->sendMessageAll($message);
            }

            if ($this->sale_note->creditPayments) {
                $this->sale_note->calculatePenalties();
            }

            $this->saveItemWarranty($this->sale_note, $request->items);

            return [
                'success' => true,
                'data' => [
                    'id' => $this->sale_note->id,
                    'external_id' => $this->sale_note->external_id,
                    'format_printer' => $establishment->format_printer,
                    'printer' => $establishment->printer,
                    'printer_serve' => $establishment->printer_serve,
                    'direct_printing' => (bool) $establishment->direct_printing,
                    "number" => $this->sale_note->getNumberFullAttribute(),
                    'print_ticket' => url('') . "/sale-notes/print/{$this->sale_note->external_id}/ticket",
                    'print_a4' => url('') . "/sale-notes/print/{$this->sale_note->external_id}/a4",
                    'print_a5' => url('') . "/sale-notes/print/{$this->sale_note->external_id}/a5",
                    'schedule' => url('') . "/sale-notes/schedule/{$this->sale_note->id}",
                    // 'print_ticket' => url('') . "/sale-notes/print/{$this->sale_note->external_id}/ticket",
                    // 'print_a4' => url('') . "/api/sale-note/print/{$this->sale_note->external_id}/a4",
                    // 'print_a5' => url('') . "/api/sale-note/print/{$this->sale_note->external_id}/a5",
                ],
            ];
        } catch (Exception $e) {
            //create the message with the file, path and message
            $file = $e->getFile();
            $line = $e->getLine();
            $trace = $e->getTraceAsString();


            return [
                'success' => false,
                'message' => $e->getMessage(),
                'file' => $file,
                'line' => $line,
                'trace' => $trace,
            ];
        }
    }
    private function saveItemWarranty($sale_note, $items)
    {
        foreach ($items as $item) {
            if (isset($item['item']['has_warranty']) && $item['item']['has_warranty']) {
                $warranty_start_date = Carbon::parse($sale_note->date_of_issue);
                $warranty_end_date = $warranty_start_date->copy()->addMonths($item['item']['month_day']);

                // Find the document item ID
                $saleNoteItem = SaleNoteItem::where('sale_note_id', $sale_note->id)
                    ->where('item_id', $item['item_id'])
                    ->first();

                if ($saleNoteItem) {
                    DB::connection('tenant')->table('item_warranty')->insert([
                        'warranty_start_date' => $warranty_start_date,
                        'warranty_end_date' => $warranty_end_date,
                        'sale_note_item_id' => $saleNoteItem->id,
                    ]);
                    DB::connection('tenant')->table('sale_note_items')
                        ->where('id', $saleNoteItem->id)
                        ->update([
                            'warranty_end_date' => $warranty_end_date,
                        ]);
                }
            }
        }
    }
    public function updateStock($id, $is_set = false)
    {
        if ($is_set == true) {
            $ItemSet = ItemSet::where('item_id', $id)->get();
            foreach ($ItemSet as $row_item) {
                $saldo_stock = 0.00;
                //Saldo Inicial
                $saldo_inicial = floatval(Inventory::where('item_id', $id)->sum('quantity'));
                //Compras
                $compras = floatval(PurchaseItem::where('item_id', $id)->sum('quantity'));
                $sale_note = DB::connection('tenant')->table('sale_note_items')
                    ->join('sale_notes', 'sale_notes.id', '=', 'sale_note_items.sale_note_id')
                    ->select('sale_note_items.quantity', 'sale_note_items.sale_note_id')
                    ->where('item_id', $id)
                    ->whereRaw("JSON_EXTRACT(sale_note_items.item, '$.is_stock') = 'Si'")
                    ->where('sale_notes.state_type_id', "!=", "11")
                    ->get();
                $sale_note = $sale_note->sum('quantity');
                $document = DB::connection('tenant')->table('document_items')
                    //->select(DB::raw("sum(document_items.quantity) as quantity"))
                    ->select('document_items.quantity', 'document_items.document_id')
                    ->join('documents', 'documents.id', '=', 'document_items.document_id')
                    ->where('documents.state_type_id', "!=", "11")
                    ->whereRaw("JSON_EXTRACT(document_items.item, '$.is_stock') = 'Si'")
                    ->where('item_id', $id)
                    ->get();
                $document = $document->sum('quantity');

                if ($document != null) {
                    if ($document != null) {
                        $document = $document;
                    } else {
                        $document = 0;
                    }
                } else {
                    $document = 0;
                }
                if ($sale_note != null) {
                    if ($sale_note != null) {
                        $sale_note = $sale_note;
                    } else {
                        $sale_note = 0;
                    }
                } else {
                    $sale_note = 0;
                }
                $saldo_stock = ($saldo_inicial + $compras) - ($sale_note + $document);

                DB::connection('tenant')->table('items')->where('id', $id)->update(['stock' => $saldo_stock]);
                DB::connection('tenant')->table('item_warehouse')->where('item_id', $id)->update(['stock' => $saldo_stock]);
            }
        } else {
            $saldo_stock = 0.00;
            //Saldo Inicial
            $saldo_inicial = floatval(Inventory::where('item_id', $id)->sum('quantity'));
            //Compras
            $compras = floatval(PurchaseItem::where('item_id', $id)->sum('quantity'));
            $sale_note = DB::connection('tenant')->table('sale_note_items')
                ->join('sale_notes', 'sale_notes.id', '=', 'sale_note_items.sale_note_id')
                ->select('sale_note_items.quantity', 'sale_note_items.sale_note_id')
                ->where('item_id', $id)
                ->whereRaw("JSON_EXTRACT(sale_note_items.item, '$.is_stock') = 'Si'")
                ->where('sale_notes.state_type_id', "!=", "11")
                ->get();
            $sale_note = $sale_note->sum('quantity');
            $document = DB::connection('tenant')->table('document_items')
                //->select(DB::raw("sum(document_items.quantity) as quantity"))
                ->select('document_items.quantity', 'document_items.document_id')
                ->join('documents', 'documents.id', '=', 'document_items.document_id')
                ->where('documents.state_type_id', "!=", "11")
                ->whereRaw("JSON_EXTRACT(document_items.item, '$.is_stock') = 'Si'")
                ->where('item_id', $id)
                ->get();
            $document = $document->sum('quantity');

            if ($document != null) {
                if ($document != null) {
                    $document = $document;
                } else {
                    $document = 0;
                }
            } else {
                $document = 0;
            }
            if ($sale_note != null) {
                if ($sale_note != null) {
                    $sale_note = $sale_note;
                } else {
                    $sale_note = 0;
                }
            } else {
                $sale_note = 0;
            }
            $saldo_stock = ($saldo_inicial + $compras) - ($sale_note + $document);

            DB::connection('tenant')->table('items')->where('id', $id)->update(['stock' => $saldo_stock]);
            DB::connection('tenant')->table('item_warehouse')->where('item_id', $id)->update(['stock' => $saldo_stock]);
        }
    }
    public function destroy_sale_note_item($id)
    {
        $item = SaleNoteItem::findOrFail($id);

        if (isset($item->item->lots)) {
            foreach ($item->item->lots as $lot) {
                // dd($lot->id);
                $record_lot = ItemLot::findOrFail($lot->id);
                $record_lot->has_sale = false;
                $record_lot->update();
            }
        }

        $item->delete();

        return [
            'success' => true,
            'message' => 'eliminado'
        ];
    }

    public function mergeData($inputs)
    {
        $configuration = Configuration::first();
        $this->company = Company::active();
        $type_period = $inputs['type_period'];
        $quantity_period = $inputs['quantity_period'];
        $d_of_issue = new Carbon($inputs['date_of_issue']);
        $automatic_date_of_issue = null;
        // $currency_type_id = Functions::valueKeyInArray($inputs, 'currency_type_id', 'PEN');
        $currency_type_id = $inputs['currency_type_id'];
        if ($currency_type_id == 'USD' && !$configuration->other_currency_pos) {
            $currency_type_id = 'PEN';
        }

        if ($type_period && $quantity_period > 0) {

            $add_period_date = ($type_period == 'month') ? $d_of_issue->addMonths($quantity_period) : $d_of_issue->addYears($quantity_period);
            $automatic_date_of_issue = $add_period_date->format('Y-m-d');
        }

        $series = Series::find($inputs['series_id'])->number;


        $number = null;

        if ($inputs['id']) {
            $number = $inputs['number'];
        } else {

            $document = SaleNote::select('number')->where('soap_type_id', $this->company->soap_type_id)
                ->where('series', $series)
                ->orderBy('number', 'desc')
                ->first();

            $number = ($document) ? $document->number + 1 : 1;
        }

        $customer =  PersonInput::set($inputs['customer_id']);
        $sum_coins = $inputs["sumCoins"];
        if ($sum_coins) {
            $customer['sum_coins'] = $sum_coins;
        }
        $values = [
            'currency_type_id' => $currency_type_id,
            'additional_information' => $inputs['additional_information'],
            'automatic_date_of_issue' => $automatic_date_of_issue,
            'user_id' => $inputs['user_id'],
            'external_id' => Str::uuid()->toString(),
            // 'customer' => PersonInput::set($inputs['customer_id']),
            'customer' => $customer,
            'establishment' => EstablishmentInput::set($inputs['establishment_id']),
            'soap_type_id' => $this->company->soap_type_id,
            'state_type_id' => '01',
            'orden_id'  => $inputs['orden_id'],
            'type_payment'  => $inputs['type_payment'],
            'num_cuota'  => $inputs['num_cuota'],
            'advances'   => $inputs['advances'],
            'total_advances'   => $inputs['total_advances'],
            'amount'  => $inputs['amount'],
            'series' => $series,
            'number' => $number
        ];

        unset($inputs['series_id']);

        $inputs->merge($values);

        return $inputs->all();
    }

    //    public function recreatePdf($sale_note_id)
    //    {
    //        $this->sale_note = SaleNote::find($sale_note_id);
    //        $this->createPdf();
    //    }

    private function setFilename()
    {

        $name = [$this->sale_note->series, $this->sale_note->number, date('Ymd')];
        $this->sale_note->filename = join('-', $name);
        $this->sale_note->save();
    }

    public function toPrint($external_id, $format, $filename = null)
    {
        $configuration = Configuration::first();
        $android_configuration = $configuration->android_configuration;
        $sale_note = SaleNote::where('external_id', $external_id)->first();

        if (!$sale_note) {
            throw new Exception("El código {$external_id} es inválido, no se encontró la Nota de venta relacionada");
        }

        $boxes = Box::where('sale_note_id', $sale_note->id)->get();
        $this->reloadPDF($sale_note, $format, $sale_note->filename, $boxes);

        // Usa el nombre proporcionado o genera uno predeterminado
        $downloadFilename = $filename ?? "sale_note_{$sale_note->id}_" . round(microtime(true) * 1000) . ".pdf";

        $temp = tempnam(sys_get_temp_dir(), 'sale_note');
        file_put_contents($temp, $this->getStorage($sale_note->filename, 'sale_note'));
        if ($android_configuration) {
            return response()->download($temp, $downloadFilename)->deleteFileAfterSend();
        } else {
            return response()->file($temp);
        }
    }

    public function cash_out($sale_note_id, $page = 1)
    {
        $data = Payment::where('sale_note_id', $sale_note_id)->get();
        $tasa = $data->first()->tasa;
        $quote = number_format($data->first()->amount, 2);
        $days = count($data);
        $init_date = Carbon::parse($data->first()->date_payment)->format('d/m/Y');
        $end_date = Carbon::parse($data->last()->date_payment)->format('d/m/Y');
        $data = $data->forPage($page, 32);
        if (count($data) > 0) {
            $sale = SaleNote::findOrFail($data->first()->sale_note_id);
            $company = Company::first();
            $user = User::findOrFail($sale->user_id);
            $establishment = Establishment::find($user->establishment_id);
            $recibo = PDf::loadView(
                'tenant.schedule.cash_out',
                [
                    'days' => $days,
                    'tasa' => $tasa,
                    'quote' => $quote,
                    'user' => $user,
                    'init_date' => $init_date,
                    'end_date' => $end_date,
                    'data' => $data,
                    'sale' => $sale,
                    'company' => $company,
                    'establishment' => $establishment,
                    'page' => $page
                ]
            );
            return $recibo->setPaper(array(0, 0, 249.45, 260), 'portrait')->stream();
        } else {
            return view("tenant.schedule.notfound");
        }
    }
    public function hogar_schedule($sale_note_id, $page = 1)
    {
        $data = Payment::where('sale_note_id', $sale_note_id)->get();
        $tasa = $data->first()->tasa;
        $quote = $data->first()->amount;
        $days = count($data);
        $init_date = Carbon::parse($data->first()->date_payment)->format('d/m/Y');
        $end_date = Carbon::parse($data->last()->date_payment)->format('d/m/Y');
        $data = $data->forPage($page, 32);
        if (count($data) > 0) {
            $sale = SaleNote::findOrFail($data->first()->sale_note_id);
            $company = Company::first();
            $user = User::findOrFail($sale->user_id);
            $establishment = Establishment::find($user->establishment_id);
            $recibo = PDf::loadView(
                'tenant.schedule.hogar_schedule',
                [
                    'days' => $days,
                    'tasa' => $tasa,
                    'quote' => $quote,
                    'init_date' => $init_date,
                    'end_date' => $end_date,
                    'data' => $data,
                    'sale' => $sale,
                    'company' => $company,
                    'establishment' => $establishment,
                    'page' => $page
                ]
            );
            return $recibo->setPaper('a5', 'portrait')->stream();
        } else {
            return view("tenant.schedule.notfound");
        }
    }
    public function cash_schedule($sale_note_id, $page = 1)
    {
        $data = Payment::where('sale_note_id', $sale_note_id)->get();
        //corta data que es una coleccion segun $page, si es 1, se muestra los primeros 17 registros, si es 2, se muestra los siguientes 17 registros
        $data = $data->forPage($page, 26);

        if (count($data) > 0) {
            $sale = SaleNote::findOrFail($data->first()->sale_note_id);
            $company = Company::first();
            $user = User::findOrFail($sale->user_id);
            $establishment = Establishment::find($user->establishment_id);
            // return view('tenant.schedule.cash_schedule', ['data' => $data, 'sale' => $sale, 'company' => $company, 'establishment' => $establishment]);
            $recibo = PDf::loadView('tenant.schedule.cash_schedule', [
                'page' => $page,
                'data' => $data,
                'sale' => $sale,
                'company' => $company,
                'establishment' => $establishment
            ]);
            $altura = 250;

            if (count($data) == 26) {
                $altura += (count($data)) * count($data) + 200;
            } else {
                $altura += 25 * count($data) + 150;
            }

            return $recibo->setPaper('a4', 'landscape')->stream();
        } else {
            return view("tenant.schedule.notfound");
        }
    }
    public function schedule($sale_note_id)
    {
        $data = Payment::where('sale_note_id', $sale_note_id)->get();
        if (count($data) > 0) {
            $sale = SaleNote::findOrFail($data[0]->sale_note_id);
            $company = Company::first();
            $user = User::findOrFail($sale->user_id);
            $establishment = Establishment::find($user->establishment_id);
            $recibo = PDf::loadView('tenant.schedule.index', ['data' => $data, 'sale' => $sale, 'company' => $company, 'establishment' => $establishment]);
            $altura = 550;
            // $height = $height + 30; //Cronograma
            // $height = $height + 30; //FECHA
            // $height = $height + 60; //CLIENTE
            // $height = $height + 30;
            if (count($data) == 26) {
                $altura += (count($data)) * count($data) + 200;
            } else {
                $altura += 25 * count($data) + 150;
            }

            return $recibo->setPaper(array(0, 0, 249.45, $altura), 'portrait')->stream();
        } else {
            return view("tenant.schedule.notfound");
        }
    }
    private function reloadPDF($sale_note, $format, $filename, $boxes = [])
    {

        $this->createPdf($sale_note, $format, $filename, $boxes);
    }

    public function createPdf($sale_note = null, $format_pdf = null, $filename = null, $boxes = [])
    {


        ini_set("pcre.backtrack_limit", "5000000");
        $template = new Template();
        $pdf = new Mpdf();

        $this->company = ($this->company != null) ? $this->company : Company::active();
        $this->document = ($sale_note != null) ? $sale_note : $this->sale_note;
        $this->configuration = Configuration::first();
        $show_unit_types = $this->configuration->show_unit_types_ticket;
        $configuration = $this->configuration->formats;
        $base_template = $configuration;
        $html = $template->pdf($base_template, "sale_note", $this->company, $this->document, $format_pdf, $boxes);

        if (($format_pdf === 'ticket') or ($format_pdf === 'ticket_58')
            or
            ($format_pdf === 'ticket_50')
        ) {

            $width = ($format_pdf === 'ticket_58') ? 56 : 78;
            if ($format_pdf === 'ticket_50') $width = 45;
            if (config('tenant.enabled_template_ticket_80')) $width = 76;

            $company_logo      = ($this->company->logo) ? 40 : 0;
            $company_name      = (strlen($this->company->name) / 20) * 10;
            $company_address   = (strlen($this->document->establishment->address) / 30) * 10;
            $company_number    = $this->document->establishment->telephone != '' ? '10' : '0';
            $customer_name     = strlen($this->document->customer->name) > '25' ? '10' : '0';
            $customer_address  = (strlen($this->document->customer->address) / 200) * 10;
            $p_order           = $this->document->purchase_order != '' ? '10' : '0';

            $total_exportation = $this->document->total_exportation != '' ? '10' : '0';
            $total_free        = $this->document->total_free != '' ? '10' : '0';
            $total_unaffected  = $this->document->total_unaffected != '' ? '10' : '0';
            $total_exonerated  = $this->document->total_exonerated != '' ? '10' : '0';
            $total_taxed       = $this->document->total_taxed != '' ? '10' : '0';
            $quantity_rows     = count($this->document->items);

            $extra_by_item_description = 0;
            $discount_global = 0;
            foreach ($this->document->items as $it) {
                if (strlen($it->item->description) > 100) {
                    $extra_by_item_description += 24;
                    if ($it->item->from_unit_type_id_desc) {
                        $extra_by_item_description += strlen($it->item->from_unit_type_id_desc);
                    }
                    if ($it->item->second_name) {
                        $extra_by_item_description += strlen($it->item->second_name);
                    }
                    if ($show_unit_types) {
                        $extra_by_item_description += 5;
                    }
                }
                if ($it->discounts) {
                    $discount_global = $discount_global + 1;
                }
            }
            $legends = $this->document->legends != '' ? '10' : '0';
            $factor_q = 6;
            if ($quantity_rows > 20) {

                $factor_q = 4;
            }
            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [
                    $width,
                    50 +
                        (($quantity_rows * $factor_q) + $extra_by_item_description) +
                        ($discount_global * 3) +
                        $company_logo +
                        $company_name +
                        $company_address +
                        $company_number +
                        $customer_name +
                        $customer_address +
                        $p_order +
                        $legends +
                        $total_exportation +
                        $total_free +
                        $total_unaffected +
                        $total_exonerated +
                        $total_taxed
                ],
                'margin_top' => 0,
                'margin_right' => $format_pdf === 'ticket_50' ? 0.5 : 6,
                'margin_bottom' => 0,
                'margin_left' => $format_pdf === 'ticket_50'  ? 4.5 : 6
            ]);
        } else if ($format_pdf === 'a5') {

            $company_name      = (strlen($this->company->name) / 20) * 10;
            $company_address   = (strlen($this->document->establishment->address) / 30) * 10;
            $company_number    = $this->document->establishment->telephone != '' ? '10' : '0';
            $customer_name     = strlen($this->document->customer->name) > '25' ? '10' : '0';
            $customer_address  = (strlen($this->document->customer->address) / 200) * 10;
            $p_order           = $this->document->purchase_order != '' ? '10' : '0';

            $total_exportation = $this->document->total_exportation != '' ? '10' : '0';
            $total_free        = $this->document->total_free != '' ? '10' : '0';
            $total_unaffected  = $this->document->total_unaffected != '' ? '10' : '0';
            $total_exonerated  = $this->document->total_exonerated != '' ? '10' : '0';
            $total_taxed       = $this->document->total_taxed != '' ? '10' : '0';
            $quantity_rows     = count($this->document->items);
            $discount_global = 0;
            foreach ($this->document->items as $it) {
                if ($it->discounts) {
                    $discount_global = $discount_global + 1;
                }
            }
            $legends           = $this->document->legends != '' ? '10' : '0';


            $alto = ($quantity_rows * 8) +
                ($discount_global * 3) +
                $company_name +
                $company_address +
                $company_number +
                $customer_name +
                $customer_address +
                $p_order +
                $legends +
                $total_exportation +
                $total_free +
                $total_unaffected +
                $total_exonerated +
                $total_taxed;
            $diferencia = 148 - (float)$alto;
            $orientation = $this->configuration->a5_orientation;

            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => $orientation ? 'A5-L' : 'A5-P',
                'orientation' => $orientation ? 'L' : 'P',
                // 'format' => [
                //     150,
                //     210
                // ],
                'margin_top' => 8,
                'margin_right' => 8,
                'margin_bottom' => 0,
                'margin_left' => 8
            ]);
        } else {

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

        $this->uploadFile($this->document->filename, $pdf->output('', 'S'), 'sale_note');
    }

    public function uploadFile($filename, $file_content, $file_type)
    {
        $this->uploadStorage($filename, $file_content, $file_type);
    }
    public function table($table)
    {
        switch ($table) {
            case 'customers':

                $customers = Person::whereType('customers')->whereIsEnabled()->orderBy('name')->get()->transform(function ($row) {
                    return [
                        'id' => $row->id,
                        'description' => $row->number . ' - ' . $row->name,
                        'name' => $row->name,
                        'number' => $row->number,
                        'identity_document_type_id' => $row->identity_document_type_id,
                        'identity_document_type_code' => $row->identity_document_type->code,
                        'seller_id' =>  $row->seller_id,
                    ];
                });
                return $customers;

                break;

            case 'items':

                $establishment_id = auth()->user()->establishment_id;
                $warehouse = Warehouse::where('establishment_id', $establishment_id)->first();
                $warehouse_id = ($warehouse) ? $warehouse->id : null;

                $items_u = Item::whereWarehouse()->whereIsActive()->whereNotIsSet()->orderBy('description')->get();

                $items_s = Item::where('unit_type_id', 'ZZ')->whereIsActive()->orderBy('description')->get();

                $items = $items_u->merge($items_s);

                return collect($items)->transform(function ($row) use ($warehouse_id, $warehouse) {
                    $detail = $this->getFullDescription($row, $warehouse);

                    return [

                        'id' => $row->id,
                        'full_description' => $detail['full_description'],
                        'brand' => $detail['brand'],
                        'category' => $detail['category'],
                        'stock' => $detail['stock'],
                        'description' => $row->description,
                        'currency_type_id' => $row->currency_type_id,
                        'currency_type_symbol' => $row->currency_type['symbol'],
                        'sale_unit_price' => round($row->sale_unit_price, 2),
                        'purchase_unit_price' => $row->purchase_unit_price,
                        'unit_type_id' => $row->unit_type_id,
                        'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                        'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id,
                        'has_igv' => (bool) $row->has_igv,
                        'lots_enabled' => (bool) $row->lots_enabled,
                        'series_enabled' => (bool) $row->series_enabled,
                        'is_set' => (bool) $row->is_set,
                        'is_stock' => "Si",
                        'warehouses' => collect($row->warehouses)->transform(function ($row) {
                            return [
                                'warehouse_id' => $row->warehouse->id,
                                'warehouse_description' => $row->warehouse->description,
                                'stock' => $row->stock,
                            ];
                        }),
                        'item_unit_types' => $row->item_unit_types,
                        'lots' => $row->item_lots->where('has_sale', false)->where('warehouse_id', $warehouse_id)->transform(function ($row) {
                            return [
                                'id' => $row->id,
                                'series' => $row->series,
                                'date' => $row->date,
                                'item_id' => $row->item_id,
                                'warehouse_id' => $row->warehouse_id,
                                'has_sale' => (bool)$row->has_sale,
                                'lot_code' => ($row->item_loteable_type) ? (isset($row->item_loteable->lot_code) ? $row->item_loteable->lot_code : null) : null
                            ];
                        }),
                        'lots_group' => collect($row->lots_group)->transform(function ($row) {
                            return [
                                'id'  => $row->id,
                                'code' => $row->code,
                                'quantity' => $row->quantity,
                                'date_of_due' => $row->date_of_due,
                                'checked'  => false
                            ];
                        }),
                        'lot_code' => $row->lot_code,
                        'date_of_due' => $row->date_of_due
                    ];
                });


                break;
            default:

                return [];

                break;
        }
    }


    public function getFullDescription($row, $warehouse)
    {

        $desc = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;
        $category = ($row->category) ? "{$row->category->name}" : "";
        $brand = ($row->brand) ? "{$row->brand->name}" : "";

        if ($row->unit_type_id != 'ZZ') {
            $warehouse_stock = ($row->warehouses && $warehouse) ? number_format($row->warehouses->where('warehouse_id', $warehouse->id)->first()->stock, 2) : 0;
            $stock = ($row->warehouses && $warehouse) ? "{$warehouse_stock}" : "";
        } else {
            $stock = '';
        }


        $desc = "{$desc} - {$brand}";

        return [
            'full_description' => $desc,
            'brand' => $brand,
            'category' => $category,
            'stock' => $stock,
        ];
    }


    public function searchCustomerById($id)
    {

        $customers = Person::whereType('customers')
            ->where('id', $id)
            ->get()->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => $row->number . ' - ' . $row->name,
                    'name' => $row->name,
                    'number' => $row->number,
                    'identity_document_type_id' => $row->identity_document_type_id,
                    'identity_document_type_code' => $row->identity_document_type->code
                ];
            });

        return compact('customers');
    }

    public function option_tables()
    {
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $customers = Person::whereType('customers')->get();
        $series = Series::where('establishment_id', $establishment->id)->get();
        $document_types_invoice = DocumentType::whereIn('id', ['01', '03'])->get();
        $operation_types = OperationType::whereActive()->get();
        return compact('series', 'document_types_invoice', 'customers', 'operation_types');
    }

    public function email(Request $request)
    {
        $company = Company::active();
        $record = SaleNote::find($request->input('id'));
        $customer_email = $request->input('customer_email');
        Configuration::setConfigSmtpMail();
        Mail::to($customer_email)->send(new SaleNoteEmail($company, $record));

        return [
            'success' => true
        ];
    }




    public function enabledConcurrency(Request $request)
    {

        $sale_note = SaleNote::findOrFail($request->id);
        $sale_note->enabled_concurrency = $request->enabled_concurrency;
        $sale_note->update();

        return [
            'success' => true,
            'message' => ($sale_note->enabled_concurrency) ? 'Recurrencia activada' : 'Recurrencia desactivada'
        ];
    }

    public function anulate(Request $request, $id)
    {

        DB::connection('tenant')->transaction(function () use ($id, $request) {

            $obj =  SaleNote::find($id);
            $obj->state_type_id = 11;
            $obj->save();
            Box::where('sale_note_id', $obj->id)->delete();
            $establishment = Establishment::where('id', $obj->establishment_id)->first();

            $warehouse = Warehouse::where('establishment_id', $establishment->id)->first();

            foreach ($obj->items as $item) {
                $lots = isset($item->item->lots) ? $item->item->lots : [];
                $quantity = $item->quantity;
                foreach ($lots as $lot) {
                    ItemLot::find($lot->id)->update(["has_sale" => 0]);
                }

                if (isset($item->item->from_unit_type_id)) {
                    $unit_type = ItemUnitType::where('id', $item->item->from_unit_type_id)
                        ->first();
                    if ($unit_type) {

                        $quantity = $quantity * $unit_type->quantity_unit;
                    }
                }

                $wr = ItemWarehouse::where([['item_id', $item->item_id], ['warehouse_id', $item->warehouse_id ?? $warehouse->id]])->first();
                $it = Item::find($item->item_id);
                $item->sale_note->inventory_kardex()->create([
                    'date_of_issue' => date('Y-m-d'),
                    'item_id' => $item->item_id,
                    'warehouse_id' => $wr->warehouse_id,
                    'quantity' => $quantity,
                    'user_id' => isset(auth()->user()->id) ? auth()->user()->id : null,
                ]);
                if ($it) {
                    $it->stock =  $it->stock + $quantity;
                    $it->save();
                }
                if ($wr) {
                    $wr->stock =  $wr->stock + $quantity;
                    $wr->save();
                }

                //habilito las series
                // ItemLot::where('item_id', $item->item_id )->where('warehouse_id', $warehouse->id)->update(['has_sale' => false]);
                $this->voidedLots($item);
                $is_credit = count($obj->credit_payments) > 0;
                if ($is_credit) {
                    $reason_to_void = $request->reason_to_void;
                    $sale_note_credit = SaleNoteCredit::where('sale_note_id', $id)->first();
                    $sale_note_credit->reason_to_anulate_credit = $reason_to_void;
                    $obj->status = 'R';
                    $obj->save();
                    $sale_note_credit->save();
                    $user_name = auth()->user()->name;
                    $message_base = "El crédito de la nota de venta N° " . $obj->series . "-" . $obj->number . " ha sido anulada. Por el usuario " . $user_name . " por el motivo: " . $reason_to_void;
                    (new WhatsappController)->sendMessageAll($message_base);
                }
            }
        });

        return [
            'success' => true,
            'message' => 'N. Venta anulada con éxito'
        ];
    }

    public function updateBox($id, $Payments, $method_payment, $total_payment)
    {
        // dd($id, $Payments, $method_payment, $total_payment);
        //  foreach ($Payments as $key => $row) {
        $box = Box::where('sale_note_id', $id)->first();
        $saleNote = SaleNote::where('id', $id)->first();
        if ($saleNote->paid === "1") {
            $method = "Efectivo";
        } else {
            $payment = PaymentMethodType::where('id', $method_payment)->first();
            $method = $payment->description;
        }
        if ($box == null) {
            if ($saleNote != null) {
                $boxes = Box::firstOrNew(['sale_note_id' => $id]);
                $company = Company::first();
                $boxes->group_id = 1;
                $boxes->category_id = 1;
                $boxes->subcategory_id = 1;
                $boxes->amount = $total_payment;
                $boxes->date = $Payments->date_of_payment;
                $boxes->type = '1';
                $boxes->state = '1';
                $boxes->method = $method;
                $boxes->user_id = "1";
                $boxes->state = '1';
                $type_document = "NOTA DE VENTA N° " . $saleNote->series . " " . $saleNote->number;
                $boxes->description = "PAGO DE " . $type_document;
                $boxes->soap_type_id = $company->soap_type_id;
                $boxes->save();
            }
            //Insertar
        } else {
            //Actualizar
            $payment = PaymentMethodType::where('id', $method_payment)->first();
            $boxes = Box::findOrFail($box->id);
            $boxes->amount = $total_payment;
            $boxes->method = $method;
            $boxes->date = $Payments->date_of_payment;
            $boxes->document_id = null;
            $boxes->save();
        }
        //   }


    }

    public function totals()
    {

        $records = SaleNote::where([['state_type_id', '01'], ['currency_type_id', 'PEN']])
            ->whereDoesntHave('documents')
            ->get();
        $total_pen = 0;
        $total_paid_pen = 0;
        $total_pending_paid_pen = 0;


        $total_pen = $records->sum('total');

        // foreach ($records as $sale_note) {

        //     $total_paid_pen += $sale_note->payments->sum('payment');
        // }

        // $total_pending_paid_pen = $total_pen - $total_paid_pen;

        return [
            'total_pen' => number_format($total_pen, 2, ".", ""),
            'total_paid_pen' => 0,
            'total_pending_paid_pen' => 0
        ];
    }

    public function downloadExternal($external_id)
    {
        $document = SaleNote::where('external_id', $external_id)->first();
        $this->reloadPDF($document, 'a4', null);
        return $this->downloadStorage($document->filename, 'sale_note');
    }


    private function savePayments($sale_note, $payments)
    {

        $total = $sale_note->total;
        $balance = $total - collect($payments)->sum('payment');

        $search_cash = ($balance < 0) ? collect($payments)->firstWhere('payment_method_type_id', '01') : null;

        $this->apply_change = false;

        if ($balance < 0 && $search_cash) {

            $payments = collect($payments)->map(function ($row) use ($balance) {

                $change = null;
                $payment = $row['payment'];

                if ($row['payment_method_type_id'] == '01' && !$this->apply_change) {

                    $change = abs($balance);
                    $payment = $row['payment'] - abs($balance);
                    $this->apply_change = true;
                }

                return [
                    "id" => null,
                    "document_id" => null,
                    "sale_note_id" => null,
                    "date_of_payment" => $row['date_of_payment'],
                    "payment_method_type_id" => $row['payment_method_type_id'],
                    "reference" => $row['reference'],
                    "payment_destination_id" => isset($row['payment_destination_id']) ? $row['payment_destination_id'] : null,
                    "payment_filename" => isset($row['payment_filename']) ? $row['payment_filename'] : null,
                    "change" => $change,
                    "payment" => $payment
                ];
            });
        }

        // dd($payments, $balance, $this->apply_change);

        foreach ($payments as $row) {

            if ($balance < 0 && !$this->apply_change) {
                $row['change'] = abs($balance);
                $row['payment'] = $row['payment'] - abs($balance);
                $this->apply_change = true;
            }

            $record_payment = $sale_note->payments()->create($row);

            if (isset($row['payment_destination_id'])) {
                $this->createGlobalPayment($record_payment, $row);
            }

            if (isset($row['payment_filename'])) {
                $record_payment->payment_file()->create([
                    'filename' => $row['payment_filename']
                ]);
            }
        }
    }


    private function voidedLots($item)
    {

        $i_lots_group = isset($item->item->lots_group) ? $item->item->lots_group : [];
        $lot_group_selected = collect($i_lots_group)->first();

        if ($lot_group_selected) {

            $lot = ItemLotsGroup::find($lot_group_selected->id);
            $lot->quantity =  $lot->quantity + $item->quantity;
            $lot->save();
        }

        if (isset($item->item->lots)) {

            foreach ($item->item->lots as $it) {

                if ($it->has_sale == true) {

                    $ilt = ItemLot::find($it->id);
                    $ilt->has_sale = false;
                    $ilt->save();
                }
            }
        }
    }
}
