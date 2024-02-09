<?php

namespace Modules\Restaurant\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tenant\Box;
use App\Models\Tenant\Cash;
use App\Models\Tenant\User;
use App\Models\Tenant\Group;
use App\Models\Tenant\Company;
use App\Models\Tenant\Category;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Subcategory;
use Illuminate\Http\Request;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\PaymentMethodType;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\Orden;
use App\Http\Resources\Tenant\BoxCollection;
use App\Models\Tenant\BankAccount;
use App\Models\Tenant\CreditList;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\HotelRent;
use App\Models\Tenant\HotelRentItem;
use App\Models\Tenant\Item;
use App\Models\Tenant\Receipt;
use App\Models\Tenant\SaleNoteCredit;
use App\Models\Tenant\SaleNoteItem;
use App\Models\Tenant\SaleNotePayment;
use App\Models\Tenant\SaleNotePromotion;
use Exception;
use Modules\Report\Exports\BoxesExport;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Report\Exports\BoxesExportPos;
use Modules\Restaurant\Models\WorkersType;
use Modules\Report\Exports\BoxesResumenExportPos;
use Modules\Report\Exports\BoxesExportBancarioPos;
use Modules\Dashboard\Helpers\DashboardSalePurchase;
use Modules\Restaurant\Models\BoxesDetail;
use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\HotelRentItemServices;

class BoxesController extends Controller
{

    protected $configuration;
    public function __construct()
    {
        $this->configuration = Configuration::first();
        //ini_set('memory_limit', '4096M');
    }
    function get_receipts($cash_id)
    {
        $receipts = [];
        $receipts = Receipt::where('cash_id', $cash_id)->get()
            ->transform(function ($row) {
                $number = "RC01-" . $row->number;
                $time = Carbon::parse($row->hour)->format('H:m:s');
                $date = Carbon::parse($row->date_of_issue)->format('d-m-Y');
                $customer = $row->customer;
                $customer_number = $customer->number;
                $customer_name = $customer->name;
                $sale_note_id = $row->sale_note_id;
                $document_id = $row->document_id;
                if ($sale_note_id) {
                    $box = Box::where('sale_note_id', $row->sale_note_id)
                        ->where('sale_note_payment_id', $row->sale_note_payment_id)
                        ->first();
                }
                if ($document_id) {
                    $box = Box::where('document_id', $row->document_id)
                        ->where('document_payment_id', $row->document_payment_id)
                        ->first();
                }

                $method  = null;

                if ($box) {
                    $method = $box->method;
                }
                $amount = $row->amount;
                if ($sale_note_id) {
                    $paid = (bool) $row->sale_note->paid;
                    $amount_payment = SaleNotePayment::where('sale_note_id', $sale_note_id)->sum('payment');
                    $remaining = number_format($row->sale_note->total - $amount_payment, 2, ".", "");
                }
                if ($document_id) {
                    $amount_payment = DocumentPayment::where('document_id', $document_id)->sum('payment');
                    $remaining = number_format($row->document->total - $amount_payment, 2, ".", "");
                    if ($remaining == 0) {
                        $paid = true;
                    } else {
                        $paid = false;
                    }
                }

                return
                    [
                        "id" => $row->id,
                        "number" => $number,
                        "time" => $time,
                        "date" => $date,
                        "customer_number" => $customer_number,
                        "customer_name" => $customer_name,
                        "method" => $method,
                        "amount" => $amount,
                        "paid" => $paid,
                        "remaining" => $remaining,
                    ];
            });

        return $receipts;
    }
    function get_invoice_credit($cash_id)
    {
        $items = [];
        $documents_credit = [];
        $invoice_credit = Document::where('cash_id', $cash_id)
            ->where('payment_condition_id', '02')
            ->get();
        foreach ($invoice_credit as $idx => $invoice) {

            $invoice_items = $invoice->items;
            foreach ($invoice_items as $idx => $invoice_item) {
                $item = $invoice_item->item;
                $item = (array)$item;
                $id_exist  = false;
                if (count($items) > 0) {
                    $id_exist = array_search($item['description'], array_column($items, 'description'));
                }
                if (gettype($id_exist) == "integer") {
                    $items[$id_exist] = [
                        "price" => $invoice_item->unit_price,
                        "description" => $item['description'],
                        "category" => isset($invoice_item->item->category) ?  $invoice_item->item->category->name : "OTROS",
                        "quantity" => $items[$id_exist]["quantity"] + $invoice_item->quantity,
                        "total" => $items[$id_exist]["total"] + $invoice_item->total
                    ];
                } else {
                    $items[] = [
                        "price" => $invoice_item->unit_price,
                        "description" => $item['description'],
                        "category" => isset($invoice_item->item->category) ?  $invoice_item->item->category->name : "OTROS",
                        "quantity" => $invoice_item->quantity,
                        "total" => $invoice_item->total
                    ];
                }
            }
            $documents_credit[] =    [
                "id" => $invoice->id,
                "number" => $invoice->getNumberFullAttribute(),
                "time" => Carbon::parse($invoice->time_of_issue)->format('H:m:s'),
                "date" => Carbon::parse($invoice->date_of_issue)->format('d-m-Y'),
                "customer_number" => $invoice->customer->number,
                "customer_name" => $invoice->customer->name,
                "method" => "-",
                "amount" => "-",
                "paid" => false,
                "remaining" => $invoice->total,
            ];
        }
        $grouped = array_reduce($items, function ($carry, $item) {
            $category = $item['category'];
            $carry[$category][] = $item;
            return $carry;
        }, []);
        usort($grouped, function ($a, $b) {
            return count($a) < count($b);
        });
        return [
            "items" => $grouped,
            "documents" => $documents_credit
        ];
    }
    function get_items_from_credit($cash_id)
    {
        $items = [];
        $documents_credit = [];
        $sale_notes_credit = SaleNoteCredit::where('cash_id', $cash_id)->get();
        foreach ($sale_notes_credit as $idx => $sale_note_credit) {
            $sale_note = SaleNote::find($sale_note_credit->sale_note_id);
            $sale_note_items = $sale_note->items;
            foreach ($sale_note_items as $idx => $sale_note_item) {
                $item = $sale_note_item->item;
                $item = (array)$item;
                $id_exist  = false;
                if (count($items) > 0) {
                    $id_exist = array_search($item['description'], array_column($items, 'description'));
                }
                if (gettype($id_exist) == "integer") {
                    $items[$id_exist] = [
                        "price" => $sale_note_item->unit_price,
                        "description" => $item['description'],
                        "category" => isset($sale_note_item->item->category) ?  $sale_note_item->item->category->name : "OTROS",
                        "quantity" => $items[$id_exist]["quantity"] + $sale_note_item->quantity,
                        "total" => $items[$id_exist]["total"] + $sale_note_item->total
                    ];
                } else {
                    $items[] = [
                        "price" => $sale_note_item->unit_price,
                        "description" => $item['description'],
                        "category" => isset($sale_note_item->item->category) ?  $sale_note_item->item->category->name : "OTROS",
                        "quantity" => $sale_note_item->quantity,
                        "total" => $sale_note_item->total
                    ];
                }
            }
            $documents_credit[] =    [
                "id" => $sale_note->id,
                "number" => $sale_note->getNumberFullAttribute(),
                "time" => Carbon::parse($sale_note->time_of_issue)->format('H:m:s'),
                "date" => $sale_note->date_of_issue->format('d-m-Y'),
                "customer_number" => $sale_note->customer->number,
                "customer_name" => $sale_note->customer->name,
                "method" => "-",
                "amount" => "-",
                "paid" => false,
                "remaining" => $sale_note->total,
            ];
        }
        $grouped = array_reduce($items, function ($carry, $item) {
            $category = $item['category'];
            $carry[$category][] = $item;
            return $carry;
        }, []);
        usort($grouped, function ($a, $b) {
            return count($a) < count($b);
        });
        return [
            "items" => $grouped,
            "documents" => $documents_credit
        ];
    }
    function get_category($item)
    {
        $hotels = $this->configuration->hotels;
        if ($hotels) {
            $item_hotel = $item->item;
            $description = $item_hotel->description;
            if (mb_stripos($description, 'HABITACIÓN') !== false) {
                return "HABITACIONES";
            }
        }
        $category = isset($item->item->category) ?  $item->item->category : null;
        if ($category == null) {
            // $item_id = $item->item_id;
            // $item = Item::select('category_id')->find($item_id);
            // if ($item) {
            //     $category = Category::find($item->category_id);
            //     return $category->name;
            // } else {
            // }
            return "OTROS";
        }
        if (gettype($category) == "string") {
            return $category;
        } else {
            return isset($item->item->category) ?  $item->item->category->name : "OTROS";
        }
    }
    function get_items_from_box($cash_id)
    {

        $boxes = Box::where('cash_id', $cash_id)
            ->select('document_id', 'sale_note_id')
            // ->addSelect(DB::raw('false as is_credit'))
            ->whereNull('sale_note_payment_id')
            ->get();

        $all_items = [];
        $all_documents = [
            "facturas" => ["total" => 0, "quantity" => 0],
            "boletas" => ["total" => 0, "quantity" => 0],
            "notas" => ["total" => 0, "quantity" => 0],
        ];

        $documents = [];
        foreach ($boxes as $box) {
            $total = 0;
            if ($box->document_id) {
                $document = Document::find($box->document_id);
                $boxes = Box::where('document_id', $box->document_id)->get()->pluck('amount')->toArray();
                $name_document =  $document->getNumberFullAttribute();
                $column = array_column($documents, 'name');
                if (!in_array($name_document, $column)) {
                    if ($document != null) {
                        if ($document->document_type_id == '03') {
                            $all_documents["boletas"]["total"] += $document->total;
                            $all_documents["boletas"]["quantity"] += 1;
                        } else {
                            $all_documents["facturas"]["total"] += $document->total;
                            $all_documents["facturas"]["quantity"] += 1;
                        }
                        $documents[] = [
                            "name" => $document->getNumberFullAttribute(),
                            "total" => $document->total,
                        ];
                        $items = $document->items;

                        foreach ($items as $item) {
                            $data = $item->item;
                            $data = (array)$data;
                            $id_exist  = false;
                            $key = $data['description'] . "-" . $item->unit_price;
                            if (count($all_items) > 0) {
                                // $id_exist = array_search($data['description'], array_column($all_items, 'description'));
                                $id_exist = array_search($key, array_column($all_items, 'key'));
                            }

                            if (gettype($id_exist) == "integer") {
                                $all_items[$id_exist] = [
                                    "price" => $item->unit_price,
                                    "key" => $key,
                                    // "category" => isset($item->item->category) ?  $item->item->category->name : "OTROS",
                                    "category" => $this->get_category($item),
                                    "description" => $data['description'],
                                    "quantity" => $all_items[$id_exist]["quantity"] + $item->quantity,
                                    "total" => $all_items[$id_exist]["total"] + $item->total
                                ];
                            } else {
                                // $key = $data['description']."-".$item->unit_price;
                                $all_items[] = [
                                    "key" => $key,
                                    "price" => $item->unit_price,
                                    "description" => $data['description'],
                                    "quantity" => $item->quantity,
                                    "category" => $this->get_category($item),

                                    // "category" => isset($item->item->category) ?  $item->item->category->name : "OTROS",
                                    "total" => $item->total
                                ];
                            }
                        }
                    }
                }
            }
            if ($box->sale_note_id && $box->sale_note_payment_id == null) {
                $sale_note = SaleNote::find($box->sale_note_id);
                $boxes = Box::where('sale_note_id', $box->sale_note_id)

                    ->get()->pluck('amount')->toArray();
                $name_sale_note =  $sale_note->getNumberFullAttribute();
                $column = array_column($documents, 'name');

                if (!in_array($name_sale_note, $column)) {


                    if (!$box->is_credit) {
                        $documents[] = [
                            "name" => $name_sale_note,
                            "total" => $sale_note->total,
                        ];
                    }
                    $items = SaleNoteItem::where("sale_note_id", $box->sale_note_id)->get();

                    foreach ($items as $item) {
                        $data = $item->item;
                        $data = (array)$data;
                        $id_exist  = false;
                        $key = $data['description'] . "-" . $item->unit_price;
                        if (count($all_items) > 0) {
                            // $id_exist = array_search($data['description'], array_column($all_items, 'description'));
                            $id_exist = array_search($key, array_column($all_items, 'key'));
                        }
                        if (gettype($id_exist) == "integer") {
                            $all_items[$id_exist] = [
                                "price" => $data["sale_unit_price"],
                                "description" => $data['description'],
                                "category" => $this->get_category($item),
                                "key" => $key,
                                // "category" => isset($item->item->category) ?  $item->item->category->name : "OTROS",
                                "quantity" => $all_items[$id_exist]["quantity"] + $item->quantity,
                                "total" => $all_items[$id_exist]["total"] + $item->total
                            ];
                        } else {
                            $all_items[] = [
                                "key" => $key,
                                "price" => $data["sale_unit_price"],
                                "description" => $data['description'],
                                "category" => $this->get_category($item),
                                // "category" => isset($item->item->category) ?  $item->item->category->name : "OTROS",
                                "quantity" => $item->quantity,
                                "total" => $item->total
                            ];
                        }
                    }
                    $all_documents["notas"]["total"] += $sale_note->total;
                    $all_documents["notas"]["quantity"] += 1;
                }
            }
        }
        $grouped = array_reduce($all_items, function ($carry, $item) {
            $category = $item['category'];
            $carry[$category][] = $item;
            return $carry;
        }, []);
        usort($grouped, function ($a, $b) {
            return count($a) < count($b);
        });

        //grouped es un array de arrays, y quisiera que cojas un elemento de cada array 
        //y de este obtengas la key "category" si esta es "HABITACIONES" entonces colocas ese array en
        //primera posicion del array grouped
        $values_grouped = array_values($grouped);
        $cat_habitaciones = array_filter($values_grouped, function ($item) {
            return $item[0]["category"] == "HABITACIONES";
        });
        $grouped = array_merge($cat_habitaciones, array_filter($grouped, function ($item) {
            return $item[0]["category"] != "HABITACIONES";
        }));


        return [
            "grouped" => $grouped,
            "items" => $all_items,
            "documents" => $all_documents,
            "documents_info" => $documents,
        ];
    }



    public function validation_methods(Request $request)
    {
        $payments = $request->payments;
        $message = '';
        $pass = true;
        foreach ($payments as $payment) {
            $method = $payment['method'];
            $operation_number = $payment['operation_number'];

            $exist = Box::where('operation_number', $operation_number)
                ->first();
            if ($exist) {
                $message .= $operation_number . ' (' . $method . ')' . '|';
                $pass = false;
                break;
            }
        }

        if (substr_count($message, '|') > 1) {
            $message = 'Los códigos: ' . $message;
        } else {
            $message = 'El código: ' . $message;
        }
        if (substr($message, -1) == '|') {
            $message = substr($message, 0, -1);
        }

        if ($pass) {
            return [
                'success' => true,
            ];
        } else {
            return [
                'success' => false,
                'message' => $message . ' ya existe',
            ];
        }
    }
    public function cashes()
    {
        $userid = auth()->user()->id;
        //$date_start=Cash::where('user_id',auth()->user()->id)->get()->last();


        return view('restaurant::cash', compact('userid'));
    }
    public function index()
    {
        $user = auth()->user();
        //$date_start=Cash::where('user_id',auth()->user()->id)->get()->last();

        $workersType = WorkersType::where('description', 'like', '%caja%')->first()->id;
        if ($user->type == 'admin') {
            $users = User::where('type', 'admin')->orWhere('worker_type_id', $workersType)->get();
        } else {
            $users = User::where('worker_type_id', $workersType)->get();
        }
        return view('restaurant::boxes', compact('users'));
    }
    public function tables()
    {
        $gruop = Group::all();
        $category = Category::all();
        $subcategory = Subcategory::all();
        $company = Company::first();
        $methods = PaymentMethodType::all();
        return compact('gruop', 'category', 'subcategory', 'company', 'methods');
    }
    public function data_reports(Request $request)
    {
        ///
        $operations = 0;
        $total_sales = 0;
        //
        $cash_id = $request->cash_id;
        $methods = [];
        $methods_payment = PaymentMethodType::all();
        $sales = Box::where('cash_id', $cash_id)->where('incomes', 0)->where('expenses', 0);

        $operations = $sales->count();
        $total_sales = $sales->sum('amount');
        $incomes = Box::where('cash_id', $cash_id)->where('incomes', 1)->get();
        $expenses = Box::where('cash_id', $cash_id)->where('expenses', 1)->get();
        $efectivo_method = Box::where('type', '1')->where('method', 'Efectivo')->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id);
        $efectivo = [
            'amount' => $efectivo_method->sum('amount'),
            'quantity' => $efectivo_method->count()
        ];
        $transfer_method = Box::where('type', '1')->where('method', 'Transferencia')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id);
        $tranfer = [
            'amount' => $transfer_method->sum('amount'),
            'quantity' => $transfer_method->count()
        ];
        $deposit_method = Box::where('type', '1')->where('method', 'Deposito Bancario')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id);
        $deposit = [
            'amount' => $deposit_method->sum('amount'),
            'quantity' => $deposit_method->count()
        ];

        $card_method = Box::where('type', '1')->where('method', 'Tarjeta')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id);
        $card = [
            'amount' => $card_method->sum('amount'),
            'quantity' => $card_method->count()
        ];
        $yape_method = Box::where('type', '1')->where('method', 'Yape')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id);
        $yape = [
            'amount' => $yape_method->sum('amount'),
            'quantity' => $yape_method->count()
        ];
        $plin_method = Box::where('type', '1')->where('method', 'PLIN')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id);
        $plin = [
            'amount' => $plin_method->sum('amount'),
            'quantity' => $plin_method->count()
        ];
        $izypay_method = Box::where('type', '1')->where('method', 'IZYPAY')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id);
        $izypay = [
            'amount' => $izypay_method->sum('amount'),
            'quantity' => $izypay_method->count()
        ];
        $niubiz_method = Box::where('type', '1')->where('method', 'NIUBIZ')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id);
        $niubiz = [
            'amount' => $niubiz_method->sum('amount'),
            'quantity' => $niubiz_method->count()
        ];
        $bbva_method = Box::where('type', '1')->where('method', 'BBVA')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id);
        $bbva = [
            'amount' => $bbva_method->sum('amount'),
            'quantity' => $bbva_method->count()
        ];
        $bcp_method = Box::where('type', '1')->where('method', 'BCP')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id);
        $bcp = [
            'amount' => $bcp_method->sum('amount'),
            'quantity' => $bcp_method->count()
        ];
        $nacion_method = Box::where('type', '1')->where('method', 'BCO NACION')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id);
        $nacion = [
            'amount' => $nacion_method->sum('amount'),
            'quantity' => $nacion_method->count()
        ];
        $scotiabank_method = Box::where('type', '1')->where('method', 'Scotiabank')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id);
        $scotiabank = [
            'amount' => $scotiabank_method->sum('amount'),
            'quantity' => $scotiabank_method->count()
        ];


        $documents_items = $this->get_items_from_box($cash_id);

        $items = $documents_items["items"];
        $total_items = 0;
        foreach ($items as $item) {
            $total_items += $item["total"];
        }
        $items_sale = [
            "quantity" => count($items),
            "total" => $total_items,
        ];
        return compact(
            'items_sale',
            'items',
            'operations',
            'total_sales',
            'efectivo',
            'tranfer',
            'deposit',
            'card',
            'yape',
            'plin',
            'izypay',
            'niubiz',
            "bbva",
            "bcp",
            "nacion",
            "scotiabank",
        );
    }
    public function reports_categoria_type(Request $request)
    {

        $group_id = $request['group_id'];
        $category_id = $request['category_id'];
        $subcategory_id = $request['subcategory_id'];
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $user_id = $request['user_id'];
        $d_start = null;
        $d_end = null;
        $array_data = [
            "ingresos" => [],
            "egresos" => []
        ];
        $user = User::find($user_id);
        $categories = Category::all();
        $subcategories = Subcategory::all();
        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        $data1 = Box::where('method', 'Efectivo')
            ->whereBetween('date', [$d_start, $d_end])->orderBy('date', 'asc')->orderBy('type', 'asc')->get();

        if ($user_id != null) {
            $data1 = $data1->where('user_id', $user_id);
        }
        //dd($request->all(),$data1);
        $data_by_group = $data1->groupBy('group_id');

        $records = [];

        foreach ($data_by_group as $group_id => $records_by_group) {
            $data_by_category = $records_by_group->groupBy('category_id');
            $categories = [];
            $group_name = '';
            foreach ($data_by_category as $category_id => $records_by_category) {
                //dd('1');
                $data_by_subcategory = $records_by_category->groupBy('subcategory_id');
                //dd($records_by_category->groupBy('subcategory_id'));
                $subcategories = [];
                $category_name = '';
                foreach ($data_by_subcategory as $subcategory_id => $rows) {
                    $rows_data = [];
                    $subcategory_name = '';
                    foreach ($rows as $row) {
                        $group_name = $row->groups->group;
                        $category_name = $row->categories->category;
                        $subcategory_name = $row->subcategories->subcategory;
                        if ($row->sale_note_id != null) {
                            $customer = $row->salenote->customer->name;
                        } else {
                            $customer = "";
                        }
                        if ($row->document_id != null) {
                            $customer = $row->document->customer->name;
                        } else {
                            $customer = "";
                        }
                        $rows_data[] = [
                            'id' => $row->id,
                            'description' => $row->description,
                            'type' => $row->type,
                            'sale_note_id' => $row->sale_note_id,
                            'document_id' => $row->document_id,
                            'method' => $row->method,
                            'customer_salenote' => ($row->sale_note_id == null) ? "-" : $row->salenote->customer->name,
                            'customer_document' => ($row->document_id == null) ? "-" : $row->document->customer->name,
                            'date' => Carbon::parse($row->date)->format('d-m-Y') . " " . Carbon::parse($row->created_at)->format('H:m:s'),
                            'monto' => $row->amount,
                            'user' => $row->user->name
                        ];
                    }
                    $subcategories[] = [
                        'subcategory_id' => $subcategory_id,
                        'subcategory_name' => $subcategory_name,
                        'rows' => $rows_data
                    ];
                }
                $categories[] = [
                    'category_id' => $category_id,
                    'category_name' => $category_name,
                    'subcategories' => $subcategories
                ];
            }
            $records[] = [
                'group_id' => $group_id,
                'group_name' => $group_name,
                'categories' => $categories
            ];
        }


        //$result=$data1->groupBy('group_id')->groupBy('category_id')->groupBy('subcategory_id')[''];
        //return $result;

        $pdf = PDF::loadView('report::boxes.report_category_pos', compact("user", "records", "company", "establishment", "date_start", "date_end"))->setPaper('a4', 'landscape');
        return $pdf->stream('Reporte_Ventas_' . date('YmdHis') . '.pdf');
    }
    public function balance_final($date_closed)
    {

        $cash = Cash::where('date_closed', $date_closed)->where('user_id', auth()->user()->id)->get()->last();
        $data1 = Box::where('type', '1')->where('method', 'Efectivo')->where('expenses', 0)->where('incomes', 0)->where('state', 1)->where('date', $date_closed)->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        $data2 = Box::where('type', '2')->where('date', $date_closed)->where('expenses', 1)->where('state', 1)->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        $data3 = Box::where('type', '1')->where('method', 'Transferencia')->where('expenses', 0)->where('incomes', 1)->where('state', 1)->where('date', $date_closed)->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        $data4 = Box::where('type', '1')->where('method', 'Deposito Bancario')->where('expenses', 0)->where('incomes', 1)->where('state', 1)->where('date', $date_closed)->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        $data5 = Box::where('type', '1')->where('method', 'Tarjeta')->where('expenses', 0)->where('incomes', 0)->where('state', 1)->where('date', $date_closed)->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        $data6 = Box::where('type', '1')->where('method', 'Yape')->where('expenses', 0)->where('incomes', 0)->where('state', 1)->where('date', $date_closed)->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        $data7 = Box::where('type', '1')->where('method', 'PLIN')->where('expenses', 0)->where('incomes', 0)->where('state', 1)->where('date', $date_closed)->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        $dataingresos_all = Box::where('type', '1')->where('method', 'Efectivo')->where('incomes', 1)->where('state', 1)->where('date', $date_closed)->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');

        $row_ingresos = $data1->get();

        // if ($request->type_box == "1") {
        $data_ingresos = $data1->sum('amount');

        $data_ingresos_all = $dataingresos_all->sum('amount');

        $row_egresos = $data2->sum('amount');
        $row_transferencia = $data3->sum('amount');

        $row_depositos = $data4->sum('amount');

        $row_tarjetas = $data5->sum('amount');

        $row_yape = $data6->sum('amount');

        $row_plin = $data7->sum('amount');

        if ($row_egresos != null || $row_egresos != 0.0) {
            $data_egresos = $data2->sum('amount');
        } else {
            $data_egresos = "0.00";
        }


        // $row_cierre = Box::where('state', '0')->get()->last();
        // $row_apertura = Cash::orderBy('state')->get()->last();

        if ($row_transferencia != null || $row_transferencia != 0.0) {
            $transferencias = $data3->sum('amount');
        } else {
            $transferencias = "0.00";
        }

        if ($row_depositos != null) {
            $depositos = $row_depositos->depositos;
        } else {
            $depositos = "0.00";
        }

        if ($row_tarjetas != null) {
            $tarjetas = $row_tarjetas;
        } else {
            $tarjetas = "0.00";
        }

        if ($row_yape != null) {
            $yape = $row_yape;
        } else {
            $yape = "0.00";
        }
        if ($row_plin != null) {
            $plin = $row_plin;
        } else {
            $plin = "0.00";
        }
        $balance_total = ($data_ingresos + $yape + $plin + $transferencias + $tarjetas + $data_ingresos_all + $depositos) - $data_egresos;
        return compact('balance_total');
    }
    public function paymentorden($type, $id, $orderId)
    {

        $Orden = Orden::FindOrFail($orderId);
        if ($type == "80") {
            $saleNote = SaleNote::where('id', $id)->first();
            $Orden->sale_note_id = $saleNote->id;
            $Orden->status_orden_id = 4;
            $Orden->customer_id = $saleNote->customer_id;
            $Orden->save();
        }
        if ($type == "01") {
            $document = Document::where('id', $id)->first();
            $Orden->document_id = $document->id;
            $Orden->status_orden_id = 4;
            $Orden->customer_id = $document->customer_id;
            $Orden->save();
        }
        return [
            "success" => true,
            "message" => "Se genero con  exito"
        ];
    }
    public function listfoods($date)
    {
        // $items=$this->list_food_sales($request);

        $data_item = DB::connection('tenant')->table('orden_item')->select(DB::raw("DISTINCT(orden_item.food_id) as food_id"))->where('date', $date)->get();
        $items = [];
        foreach ($data_item as $key => $data) {
            $orden_item = OrdenItem::where('food_id', $data->food_id)->where('date', $date);
            $quantity_total = $orden_item->sum('quantity');
            array_push($items, [
                'id' => $orden_item->first()->food->id,
                'description' => $orden_item->first()->food->description,
                'move_quantity' => $quantity_total,
                'price' => $orden_item->first()->food->price,
                'total' => $orden_item->first()->food->price * $quantity_total,
            ]);
        }
        $items = collect($items);
        return $items;
        return [
            "success" => true,
            "data"    => $items,
        ];
    }
    function formatPromotions($promotions)
    {
        $formated = [];

        foreach ($promotions as $promotion) {
            $hotel_rent_item_service = $promotion->hotel_rent_item_service;
            $room_service = $hotel_rent_item_service->room_service;
            $promotion_name = $room_service->name;
            $promotion_quantity = $hotel_rent_item_service->quantity;
            $hotel_rent_item = $hotel_rent_item_service->hotel_rent_item;
            $room_name = $hotel_rent_item->getName();


            if (array_key_exists($room_name, $formated)) {
                if (array_key_exists($promotion_name, $formated[$room_name])) {


                    $formated[$room_name][$promotion_name] += $promotion_quantity;
                } else {

                    $formated[$room_name][$promotion_name] = $promotion_quantity;
                }
            } else {
                $formated[$room_name] = [
                    $promotion_name => $promotion_quantity
                ];
            }
        }
        return $formated;
    }
    function get_to_carry($model)
    {
        $info = null;
        if (!$model->to_carry) {
            return;
        }
        $customer = $model->customer;
        if (isset($customer->sum_coins) && $customer->sum_coins) {
            $info = [
                "coins" => $customer->sum_coins,
            ];
        }
        return $info;
    }
    function credit_list_ordens($cash_id)
    {

        //obten los registros del modelo CreditList que tenga cash_id 
        $credit_list = CreditList::where('cash_id', $cash_id)->get();
        $items = [];
        $customers = [];
        foreach ($credit_list as $credit) {
            $customer = $credit->customer;
            $customer_name = $customer->name;

            $orden = $credit->orden;
            $orden_date = $orden->created_at->format('Y-m-d H:i:s');
            $orden_items = $orden->orden_items;
            $totals = 0;
            foreach ($orden_items as  $orden_item) {
                $food = Food::find($orden_item->food_id);
                $description = $food->description;
                $key = $description . "-" . $orden_item->price;
                $price = floatval($orden_item->price);
                $quantity = floatval($orden_item->quantity);
                $total = $price * $quantity;

                if (array_key_exists($key, $items)) {
                    $items[$key]['quantity'] += $quantity;
                    $items[$key]['total'] += $total;
                } else {
                    $items[$key] = [
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $total,
                        'description' => $description
                    ];
                }
                $totals += $total;
            }

            $customers[$customer_name][] = [
                "date" => $orden_date,
                "total" => $totals,
            ];
        }

        return [
            "items" => $items,
            "customers" => $customers
        ];
    }
    function get_anulate_documents($cash_id)
    {
        $all = [];
        $documents = Document::select(['series', 'number', 'date_of_issue', 'total'])
            ->where('cash_id', $cash_id)->where('state_type_id', '11')->get();
        $sale_notes = SaleNote::select(['series', 'number', 'date_of_issue', 'total'])
            ->where('cash_id', $cash_id)->where('state_type_id', '11')->get();

        foreach ($documents as $document) {
            $all[] = [
                'series' => $document->series,
                'full_number' => $document->series . "-" . $document->number,
                'date_of_issue' => $document->date_of_issue,
                'total' => $document->total,
            ];
        }
        foreach ($sale_notes as $sale_note) {
            $all[] = [
                'series' => $sale_note->series,
                'full_number' => $sale_note->series . "-" . $sale_note->number,
                'date_of_issue' => $sale_note->date_of_issue,
                'total' => $sale_note->total,
            ];
        }

        usort($all, function ($a, $b) {
            return $a['date_of_issue'] < $b['date_of_issue'];
        });
        return $all;
    }
    public function reports_resumen_type(Request $request)
    {
        $configuration = Configuration::first();
        $total_discount = 0;
        $cash_id = $request->cash_id;
        Box::where('cash_id', $cash_id)->update(['state' => 0]);
        $credit_list_ordens = $this->credit_list_ordens($cash_id);
        $credit_list_orden = $credit_list_ordens["items"];
        $credit_list_ordens_customers = $credit_list_ordens["customers"];
        $deliveries = [];
        $promotions = [];
        $promotions_give = [];
        $anulate_documents = $this->get_anulate_documents($cash_id);;

        if ($configuration->hotels) {
            $promotions = SaleNotePromotion::where('cash_id', $cash_id)->get();
            $promotions = $this->formatPromotions($promotions);
            $hotel_rent_items = HotelRentItemServices::whereHas(
                'hotel_rent_item',
                function ($query) use ($cash_id) {
                    $query->whereHas('hotel_rent', function ($query) use ($cash_id) {
                        $query->where('cash_id', $cash_id);
                    });
                }
            )

                ->get()

                ->transform(function ($item) {
                    return [
                        "room" => $item->hotel_rent_item->getName(),
                        "service" => $item->room_service->name,
                        "quantity" => $item->quantity,
                    ];
                });

            $promotions_give = $hotel_rent_items->groupBy('room');
        }

        $sales = Box::where('cash_id', $cash_id)->where('expenses', 0)->where('incomes', 0)->OrderBy('date', 'asc');
        $sales_quantity = $sales->count();
        $sales_amount = $sales->where('method', '<>', 'Efectivo')->sum('amount');

        $sales_cash = Box::where('type', '1')->where('method', 'Efectivo')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_cash_records = $sales_cash->get();
        $sales_cash_sum = 0;
        // $sales_cash_sum = $sales_cash->sum('amount');
        foreach ($sales_cash_records as $ringreso) {
            if ($ringreso["sale_note_id"]) {
                $sale_note = SaleNote::find($ringreso["sale_note_id"]);
                $coins = $this->get_to_carry($sale_note);
                if ($coins) {
                    // $deliveries[] = 
                    // $coins["coins"];
                    //insertar en $deliveries cada elemento de $coins["coins"]
                    foreach ($coins["coins"] as $coin) {
                        $deliveries[] = $coin;
                    }
                }
                if ($sale_note->total > $ringreso["amount"]) {
                    $sales_cash_sum += $ringreso["amount"];
                } else {
                    $sales_cash_sum += $sale_note->total;
                }
                if ($sale_note->total_discount) {
                    $total_discount += $sale_note->total_discount;
                }
            }
            if ($ringreso["document_id"]) {
                $document = Document::find($ringreso["document_id"]);
                $coins = $this->get_to_carry($document);
                if ($coins) {

                    foreach ($coins["coins"] as $coin) {
                        $deliveries[] = $coin;
                    }
                }
                if ($document->total > $ringreso["amount"]) {
                    $sales_cash_sum +=  $ringreso["amount"];
                } else {
                    $sales_cash_sum += $document->total;
                }
                if ($document->total_discount) {
                    $total_discount += $document->total_discount;
                }
            }
        }
        $sales_amount += $sales_cash_sum;
        $sales_cash_quantity = $sales_cash->count();

        $sumArray = [];
        foreach ($deliveries as $delivery) {
            $id = $delivery->id;

            if (isset($sumArray[$id])) {
                $sumArray[$id]->quantity += $delivery->quantity;
            } else {
                $sumArray[$id] = $delivery;
            }
        }

        $coinsReceive = array_values($sumArray);
        //ordenar por value
        usort($coinsReceive, function ($a, $b) {
            return $a->value < $b->value;
        });

        $sales_izypay = Box::where('type', '1')->where('method', 'TARJETA: IZYPAY')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_izypay_sum = $sales_izypay->sum('amount');
        $sales_izypay_quantity = $sales_izypay->count();

        $sales_niubiz = Box::where('type', '1')->where('method', 'TARJETA: NIUBIZ')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_niubiz_sum = $sales_niubiz->sum('amount');
        $sales_niubiz_quantity = $sales_niubiz->count();


        $sales_openpay = Box::where('type', '1')->where('method', 'TARJETA: OPENPAY')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_openpay_sum = $sales_openpay->sum('amount');
        $sales_openpay_quantity = $sales_openpay->count();

        $sales_transfer = Box::where('type', '1')->where('method', 'Transferencia')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_transfer_sum = $sales_transfer->sum('amount');
        $sales_transfer_quantity = $sales_transfer->count();

        $sales_bank = Box::where('type', '1')->where('method', 'Deposito Bancario')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_bank_sum = $sales_bank->sum('amount');
        $sales_bank_quantity = $sales_bank->count();

        $sales_card = Box::where('type', '1')->where('method', 'Tarjeta')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_card_sum = $sales_card->sum('amount');
        $sales_card_quantity = $sales_card->count();


        $sales_yape = Box::where('type', '1')->where('method', 'Yape')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_yape_sum = $sales_yape->sum('amount');
        $sales_yape_quantity = $sales_yape->count();

        $sales_plin = Box::where('type', '1')->where('method', 'PLIN')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_plin_sum = $sales_plin->sum('amount');
        $sales_plin_quantity = $sales_plin->count();

        $sales_culqui = Box::where('type', '1')->where('method', 'Culqui')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_culqui_sum = $sales_culqui->sum('amount');
        $sales_culqui_quantity = $sales_culqui->count();

        $sales_bbva = Box::where('type', '1')->where('method', 'BBVA')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_bbva_sum = $sales_bbva->sum('amount');
        $sales_bbva_quantity = $sales_bbva->count();

        $sales_bcp = Box::where('type', '1')->where('method', 'BCP')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_bcp_sum = $sales_bcp->sum('amount');
        $sales_bcp_quantity = $sales_bcp->count();


        $sales_nacion = Box::where('type', '1')->where('method', 'BCO NACION')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_nacion_sum = $sales_nacion->sum('amount');
        $sales_nacion_quantity = $sales_nacion->count();


        $sales_scotiabank = Box::where('type', '1')->where('method', 'Scotiabank')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_scotiabank_sum = $sales_scotiabank->sum('amount');
        $sales_scotiabank_quantity = $sales_scotiabank->count();

        $expenses = Box::where('type', '2')->where('expenses', 1)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $expenses_cash = $expenses->where('method', 'Efectivo');
        $expenses_records = $expenses_cash->get()->transform(function ($row) {
            $id = $row->id;
            $items = BoxesDetail::where('boxes_id', $id)->count();
            return [
                "items" => $items,
                "description" => $row->description,
                "amount" => $row->amount
            ];
        });
        $expenses_cash_sum = $expenses_cash->sum('amount');
        $expenses_cash_quantity = $expenses_cash->count();

        $incomes = Box::where('type', '1')->where('incomes', 1)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $incomes_cash =  $incomes->where('method', 'Efectivo');
        $incomes_cash_sum =  $incomes_cash->sum('amount');

        $incomes_cash_quantity = $incomes_cash->count();
        $incomes_records = $incomes_cash->get()->transform(function ($row) {

            return [
                "description" => $row->description,
                "amount" => $row->amount
            ];
        });




        $cash = Cash::find($cash_id);
        $counter = $cash->counter ?? [];
        $user = User::find($cash->user_id);
        //    $establishment =  auth()->user()->establishment;
        $info = $this->get_items_from_box($cash_id);
        $items = $info['items'];
        $grouped = $info['grouped'];
        $documents = $info['documents'];
        $documents_info = $info['documents_info'];
        $saldo = 0;

        $uniques = array_unique(array_column($items, 'description'));
        $unds = array_reduce($items, function ($init, $item) {
            return $init + floatval($item["quantity"]);
        });
        $items_detail = [
            "items" => $items,
            "uniques" => count($uniques),
            "unds" => $unds,
        ];
        $sales_detail = [
            "cash" => [
                "desc" => "Efectivo",
                "quantity" => $sales_cash_quantity,
                "sum" => $sales_cash_sum,
            ],
            "card" => [
                "desc" => "Tarjeta",
                "quantity" => $sales_card_quantity,
                "sum" => $sales_card_sum,
            ],
            "yape" =>
            [
                "desc" => "Yape",
                "quantity" => $sales_yape_quantity,
                "sum" => $sales_yape_sum,
            ],
            "plin" => [
                "desc" => "Plin",
                "quantity" => $sales_plin_quantity,
                "sum" => $sales_plin_sum,
            ],
            "culqui" => [
                "desc" => "Culqui",
                "quantity" => $sales_culqui_quantity,
                "sum" => $sales_culqui_sum,
            ],
            "izypay" => [
                "desc" => "Izypay",
                "quantity" => $sales_izypay_quantity,
                "sum" => $sales_izypay_sum,
            ], "niubiz" => [
                "desc" => "Niubiz",
                "quantity" => $sales_niubiz_quantity,
                "sum" => $sales_niubiz_sum,
            ],
            "openpay" => [
                "desc" => "Openpay",
                "quantity" => $sales_openpay_quantity,
                "sum" => $sales_openpay_sum,
            ],

            "bbva" => [
                "desc" => "BBVA",
                "quantity" => $sales_bbva_quantity,
                "sum" => $sales_bbva_sum,
            ],
            "bcp" => [
                "desc" => "BCP",
                "quantity" => $sales_bcp_quantity,
                "sum" => $sales_bcp_sum,
            ],
            "nacion" => [
                "desc" => "BCO NACION",
                "quantity" => $sales_nacion_quantity,
                "sum" => $sales_nacion_sum,
            ],
            "scotiabank" => [
                "desc" => "Scotiabank",
                "quantity" => $sales_scotiabank_quantity,
                "sum" => $sales_scotiabank_sum,
            ],



        ];
        $banks = Box::where('type', '1')
            ->whereNotNull('bank_account_id')
            ->where('cash_id', $cash_id);
        $total_coins_bank = $banks->sum('amount');

        $bank_accounts = $banks->get();
        foreach ($bank_accounts as $bank_account) {
            $method = $bank_account->method;
            if (isset($sales_detail[$method])) {
                $sales_detail[$method]["quantity"] += 1;
                $sales_detail[$method]["sum"] += $bank_account->amount;
            } else {
                $bk_account = BankAccount::find($bank_account->bank_account_id);
                $bank_description = $bk_account->bank->description;
                $sales_detail[$method] = [
                    "desc" => $bank_description . " " . $bank_account->method,
                    "quantity" => 1,
                    "sum" => $bank_account->amount,
                ];
            }
        }
        $incomes_expenses_cash = [
            "incomes" => [
                "quantity" => $incomes_cash_quantity,
                "amount" => $incomes_cash_sum,
            ],
            "expenses" => [
                "quantity" => $expenses_cash_quantity,
                "amount" => $expenses_cash_sum,
            ],
        ];

        $date = Carbon::now()->format("d/m/Y");
        $time = Carbon::now()->format("H:i");
        $counter = $cash->counter ?? [];

        $total_coins = 0.0;
        $total_coins_virtual = $sales_card_sum +
            $sales_yape_sum +
            $sales_plin_sum +
            $sales_culqui_sum +
            $sales_izypay_sum +
            $sales_openpay_sum +
            $sales_niubiz_sum;
        $total_coins_transfert = $sales_bbva_sum
            + $sales_bcp_sum + $sales_nacion_sum + $sales_scotiabank_sum;
        $counter_length = 0;
        if ($counter != null) {
            $counter_length = count($counter);
            ksort($counter);
            foreach ($counter as $c => $v) {
                $total_coins += floatval($c) * floatval($v);
            }
        }
        $user = User::find($cash->user_id);
        $company = Company::first();
        $difference = 0;
        $requestSales = new Request();
        $requestSales->merge([
            'cash_id' => $cash_id,
            'only_cash' => '1'
        ]);

        $total_sales = (new PosController())->total_sales($requestSales);

        if ($total_sales) {

            $difference = $total_sales["total_sales"];
        }
        $establishment = Establishment::find($user->establishment_id);

        $seriesDocs = DB::connection('tenant')->select('SELECT document_items.* ,
            documents.series as  doc_series, 
            documents.number as  doc_number   
            FROM      boxes      INNER JOIN ordens ON boxes.orden_id = ordens.id      
            INNER JOIN documents ON ordens.document_id = documents.id       AND ordens.id = documents.orden_id      INNER JOIN document_items ON documents.id = document_items.document_id   WHERE      boxes.cash_id = ?', [$cash_id]);

        $seriesSalesNotes = DB::connection('tenant')->select('SELECT
                        sale_note_items.* ,sale_notes.series as salenotes_series,
	                    sale_notes.number as salenotes_number
                    FROM
                        boxes
                        INNER JOIN ordens ON boxes.orden_id = ordens.id
                        INNER JOIN sale_notes ON ordens.sale_note_id = sale_notes.id 
                        AND ordens.id = sale_notes.orden_id
                        INNER JOIN sale_note_items ON sale_notes.id = sale_note_items.sale_note_id  WHERE      boxes.cash_id = ?', [$cash_id]);

        $datosSeries = [];
        if (!empty($seriesDocs)) {
            foreach ($seriesDocs as $key => $value) {
                $detalleSell =  json_decode($value->item, true);
                foreach ($detalleSell['lots'] as $key => $valueDetalle) {
                    $datosSeries[] =  [$value->doc_series . '-' . $value->doc_number, $detalleSell['description'], $valueDetalle['series']];
                }
            }
        }

        if (!empty($seriesSalesNotes)) {
            foreach ($seriesSalesNotes as $key => $value) {
                $detalleSalesNotes =  json_decode($value->item, true);
                if (isset($detalleSalesNotes['lots'])) {
                    foreach ($detalleSalesNotes['lots'] as $key => $valueDetalle) {
                        $datosSeries[] =  [$value->salenotes_series . '-' . $value->salenotes_number, $detalleSalesNotes['description'], $valueDetalle['series']];
                    }
                }
            }
        }
        $receipts = $this->get_receipts($cash_id); // receipts
        $quantity_receipts = count($receipts);
        $total_receipts = $receipts->sum('amount');
        $documents["recibos"] = ["total" => $total_receipts, "quantity" => $quantity_receipts];

        $documents_credit = $this->get_items_from_credit($cash_id);
        $all_credit_items = $documents_credit['items'];
        $credit_grouped = $documents_credit['documents'];
        $array_receipts = $receipts->toArray();
        $all_credit_documents = array_merge($credit_grouped, $array_receipts);
        $invoices_credit = $this->get_invoice_credit($cash_id);
        $all_credit_invoices_items = $invoices_credit['items'];
        $all_credit_invoices_documents = $invoices_credit['documents'];

        $all_credit_items = array_merge($all_credit_items, $all_credit_invoices_items);
        try {
            $pdf = PDF::loadView('report::boxes.report_resumen_pdf_pos', compact(
                "credit_list_ordens_customers",
                "credit_list_orden",
                "anulate_documents",
                "coinsReceive",
                "promotions_give",
                "promotions",
                "all_credit_invoices_items",
                "all_credit_invoices_documents",
                "all_credit_items",
                "all_credit_documents",
                "user",
                "company",
                "establishment",
                "total_coins_virtual",
                "total_coins_transfert",
                "total_coins_bank",
                "total_coins",
                "sales_quantity",
                "sales_amount",
                "sales_detail",
                "items_detail",
                "incomes_expenses_cash",
                "documents",
                "documents_info",
                "cash",
                "date",
                "time",
                "counter",
                "grouped",
                "expenses_records",
                "incomes_records",
                "difference",
                "total_discount",
                "datosSeries"
            ))
                ->setPaper('a4');
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }
        return $pdf->stream('pdf_file.pdf');
    }
    public function reports_resumen_type_(Request $request)
    {

        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $cash_id = $request['cash_id'];
        $user_id = $request['user_id'];
        $type_box = $request['type_box'];
        $request->request->add(['enabled_move_item' => false]);
        $request->request->add(['enabled_transaction_customer' => false]);
        $d_start = null;
        $d_end = null;
        $cash = Cash::find($cash_id);
        $user = User::find($cash->user_id);
        $request->request->add(['establishment_id' => $user->establishment_id]);

        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }
        $time_closed = date('H:i:s');
        // Box::where('date', $date_start)
        //     ->where('user_id', auth()->user()->id)
        //     ->update(['state' => '0', 'close' => $date_start]);
        // $cash_open = Cash::where('date_opening', $date_start)->where('user_id', auth()->user()->id)->get()->last();

        //BUSCA LA ULTIMA CAJA ABIERA (LA UNICA?)
        if ($cash_id) {

            $data1 = Box::where('type', '1')->where('method', 'Efectivo')->where('expenses', 0)->where('incomes', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
            $data2 = Box::where('type', '2')->where('expenses', 1)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
            $expenses = Box::where('type', '2')->where('cash_id', $cash_id)->where('expenses', 1)->OrderBy('date', 'asc')->get();
            $dataingresos_all = Box::where('type', '1')->where('method', 'Efectivo')->where('incomes', 1)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
            $data3 = Box::where('type', '1')->where('method', 'Transferencia')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
            $data4 = Box::where('type', '1')->where('method', 'Deposito Bancario')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
            $data5 = Box::where('type', '1')->where('method', 'Tarjeta')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
            $data9 = Box::where('type', '1')->where('method', 'TARJETA: IZYPAY')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
            $data10 = Box::where('type', '1')->where('method', 'TARJETA: NIUBIZ')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
            $data6 = Box::where('type', '1')->where('method', 'Yape')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
            $data7 = Box::where('type', '1')->where('method', 'PLIN')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
            $data8 = Box::where('type', '1')->where('method', 'Culqui')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
            $egresos_efectivo = $data2->where('method', 'Efectivo')->sum('amount');
            $row_ingresos = $data1->get();

            $ingresos_efectivo =  $dataingresos_all->where('method', 'Efectivo')->sum('amount');
            // if ($request->type_box == "1") {
            $data_ingresos = 0;
            foreach ($row_ingresos as $ringreso) {
                if ($ringreso["sale_note_id"]) {
                    $sale_note = SaleNote::find($ringreso["sale_note_id"]);
                    $data_ingresos += $sale_note->total;
                }
                if ($ringreso["document_id"]) {
                    $sale_note = Document::find($ringreso["document_id"]);
                    $data_ingresos += $sale_note->total;
                }
            }
            $dataingresos_all = $dataingresos_all->get();
            $data_ingresos_all = $dataingresos_all->sum('amount');
            $date_egresos_all = Box::where('type', '2')->where('cash_id', $cash_id)->where('expenses', 1)->OrderBy('date', 'asc')->sum('amount');
            $row_egresos = $data2->sum('amount');
            $row_transferencia = $data3->sum('amount');

            $row_depositos = $data4->sum('amount');

            $row_tarjetas = $data5->sum('amount');

            $row_yape = $data6->sum('amount');
            $row_niubiz = $data10->sum('amount');
            $row_izypay = $data9->sum('amount');
            $row_plin = $data7->sum('amount');
            $row_culqui = $data8->sum('amount');
            if ($request->type_box == "2") {
                if ($row_egresos != null || $row_egresos != 0.0) {
                    $data_egresos = $data2->sum('amount');
                } else {
                    $data_egresos = "0.00";
                }
            } else {
                $data_egresos = "0.00";
            }
            if ($request->type_box == null) {
                if ($row_egresos != null || $row_egresos != 0.0) {
                    $data_egresos = $data2->sum('amount');
                } else {
                    $data_egresos = "0.00";
                }
            }
            //dd($request->final_balance);

            $row_cierre = Box::where('state', '0')->get()->last();
            $row_apertura = Cash::orderBy('state')->get()->last();
            $fecha_apertura = $row_apertura->date_opening . " " . $row_apertura->created_at->format('h:m:s');
            $cash = Cash::find($cash_id);
            $counter = $cash->counter ?? [];
            $user = User::find($cash->user_id);
            $fecha_cierre = '';
            if ($row_cierre && $row_apertura) {

                $fecha_cierre = $row_cierre->close . " " . $row_cierre->created_at->format('h:m:s');
            }

            if ($row_transferencia != null || $row_transferencia != 0.0) {
                $transferencias = $data3->sum('amount');
            } else {
                $transferencias = "0.00";
            }

            if ($row_depositos != null) {
                $depositos = $row_depositos->depositos;
            } else {
                $depositos = "0.00";
            }

            if ($row_tarjetas != null) {
                $tarjetas = $row_tarjetas;
            } else {
                $tarjetas = "0.00";
            }
            if ($row_niubiz != null) {
                $niubiz = $row_niubiz;
            } else {
                $niubiz = "0.00";
            }
            if ($row_izypay != null) {
                $izypay = $row_izypay;
            } else {
                $izypay = "0.00";
            }
            if ($row_yape != null) {
                $yape = $row_yape;
            } else {
                $yape = "0.00";
            }
            if ($row_plin != null) {
                $plin = $row_plin;
            } else {
                $plin = "0.00";
            }
            if ($row_culqui != null) {
                $culqui = $row_culqui;
            } else {
                $culqui = "0.00";
            }
            $company = Company::first();
            $establishment =  Establishment::findOrFail($request->establishment_id);


            $info = $this->get_items_from_box($cash_id);
            $items = $info['items'];
            $documents = $info['documents'];
            $saldo = 0;
            $uniques = array_unique(array_column($items, 'description'));
            $unds = array_reduce($items, function ($init, $item) {
                return $init + floatval($item["quantity"]);
            });
            $items_detail = [
                "items" => $items,
                "uniques" => count($uniques),
                "unds" => $unds,
            ];

            $pdf = PDF::loadView('report::boxes.report_resumen_pdf_pos', compact(
                "items_detail",
                "egresos_efectivo",
                "ingresos_efectivo",
                "user",
                "counter",
                "dataingresos_all",
                "documents",
                "type_box",
                'yape',
                "plin",
                "izypay",
                "niubiz",
                "culqui",
                "items",
                "expenses",
                "cash",
                "data_ingresos_all",
                "date_egresos_all",
                "data_ingresos",
                "data_egresos",
                "establishment",
                "date_start",
                "date_end",
                "company",
                "fecha_apertura",
                "fecha_cierre",
                "transferencias",
                "depositos",
                "tarjetas",
                "user"
            ))->setPaper('a4');
            return $pdf->stream('Resumen_Arqueo_Caja_' . date('Y-m-d-His') . '.pdf');
        }

        return response()->json([
            "message" => "No sé encontró registros",
            "success" => false
        ], 404);
        // $cash_close = Cash::where('date_opening', $cash_open->date_opening)
        //     ->where('state', 1)
        //     ->where('user_id', auth()->user()->id)
        //     ->update(['state' => '0', 'date_closed' => $date_start, 'time_closed' => $time_closed]);

        // $date = \Carbon\Carbon::now();
        // $hoy = $date->format('Y-m-d');
        // $data1 = Box::where('type', '1')->where('method', 'Efectivo')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        // $data2 = Box::where('type', '2')->whereBetween('date', [$d_start, $d_end])->where('expenses', 1)->where('state', 0)->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        // $expenses = Box::where('type', '2')->whereBetween('date', [$d_start, $d_end])->where('expenses', 1)->where('user_id', auth()->user()->id)->OrderBy('date', 'asc')->get();

        // $data3 = Box::where('type', '1')->where('method', 'Transferencia')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        // $data4 = Box::where('type', '1')->where('method', 'Deposito Bancario')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        // $data5 = Box::where('type', '1')->where('method', 'Tarjeta')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        // $data6 = Box::where('type', '1')->where('method', 'Yape')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        // $data7 = Box::where('type', '1')->where('method', 'PLIN')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');
        // $dataingresos_all = Box::where('type', '1')->where('method', 'Efectivo')->where('incomes', 1)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', auth()->user()->id)->OrderBy('date', 'asc');

        // $row_ingresos = $data1->get();

        // // if ($request->type_box == "1") {
        // $data_ingresos = $data1->sum('amount');

        // $data_ingresos_all = $dataingresos_all->sum('amount');

        // $row_egresos = $data2->sum('amount');
        // $row_transferencia = $data3->sum('amount');

        // $row_depositos = $data4->sum('amount');

        // $row_tarjetas = $data5->sum('amount');

        // $row_yape = $data6->sum('amount');

        // $row_plin = $data7->sum('amount');

        // if ($request->type_box == "2") {
        //     if ($row_egresos != null || $row_egresos != 0.0) {
        //         $data_egresos = $data2->sum('amount');
        //     } else {
        //         $data_egresos = "0.00";
        //     }
        // } else {
        //     $data_egresos = "0.00";
        // }
        // if ($request->type_box == null) {
        //     if ($row_egresos != null || $row_egresos != 0.0) {
        //         $data_egresos = $data2->sum('amount');
        //     } else {
        //         $data_egresos = "0.00";
        //     }
        // }
        // //dd($request->final_balance);

        // $row_cierre = Box::where('state', '0')->get()->last();
        // $row_apertura = Cash::orderBy('state')->get()->last();
        // $fecha_apertura = $row_apertura->date_opening . " " . $row_apertura->created_at->format('h:m:s');
        // $cash = Cash::where('date_closed',)->where('user_id', auth()->user()->id)->get()->last();

        // $fecha_cierre = '';
        // if ($row_cierre && $row_apertura) {

        //     $fecha_cierre = $row_cierre->close . " " . $row_cierre->created_at->format('h:m:s');
        // }

        // if ($row_transferencia != null || $row_transferencia != 0.0) {
        //     $transferencias = $data3->sum('amount');
        // } else {
        //     $transferencias = "0.00";
        // }

        // if ($row_depositos != null) {
        //     $depositos = $row_depositos->depositos;
        // } else {
        //     $depositos = "0.00";
        // }

        // if ($row_tarjetas != null) {
        //     $tarjetas = $row_tarjetas;
        // } else {
        //     $tarjetas = "0.00";
        // }

        // if ($row_yape != null) {
        //     $yape = $row_yape;
        // } else {
        //     $yape = "0.00";
        // }
        // if ($row_plin != null) {
        //     $plin = $row_plin;
        // } else {
        //     $plin = "0.00";
        // }

        // $company = Company::first();
        // $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;


        // $items = $this->list_food_sales($request);
        // //dd($items);
        // $saldo = 0;

        // if ($request['type'] == "pdf") {
        //     $pdf = PDF::loadView('report::boxes.report_resumen_pdf_pos', compact("type_box", 'yape', "plin", "items", "expenses", "cash", "data_ingresos_all", "data_ingresos", "yape", "plin", "data_egresos", "establishment", "date_start", "date_end", "company", "fecha_apertura", "fecha_cierre", "transferencias", "depositos", "tarjetas", "user"))->setPaper('a4', 'landscape');
        //     return $pdf->stream('Resumen_Arqueo_Caja_' . date('Y-m-d-His') . '.pdf');
        // } else if ($request['type'] == "excel") {

        //     return (new BoxesResumenExportPos)
        //         ->records($data_ingresos)
        //         ->records2($data_egresos)
        //         ->records3($transferencias)
        //         ->records4($depositos)
        //         ->records4($tarjetas)
        //         ->records4($yape)
        //         ->records4($plin)
        //         ->company($company)
        //         ->user($user)
        //         ->establishment($establishment)
        //         ->download('Reporte_arqueo_resumen_' . Carbon::now() . '.xlsx');
        // }
    }
    public function get_boxes($cash_id)
    {
        $sales = Box::where('cash_id', $cash_id)->where('expenses', 0)->where('incomes', 0)->OrderBy('date', 'asc');
        $sales_quantity = $sales->count();
        $sales_amount = $sales->where('method', '<>', 'Efectivo')->sum('amount');
        $sales_cash = Box::where('method', 'Efectivo')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_cash_records = $sales_cash->get();
        // $sales_cash_sum = $sales_cash->sum('amount');
        $sales_cash_sum = 0;

        foreach ($sales_cash_records as $ringreso) {
            if ($ringreso["sale_note_id"]) {
                $sale_note = SaleNote::find($ringreso["sale_note_id"]);
                if ($sale_note->total > $ringreso["amount"]) {
                    $sales_cash_sum += $ringreso["amount"];
                } else {
                    $sales_cash_sum += $sale_note->total;
                }
            }
            if ($ringreso["document_id"]) {
                $sale_note = Document::find($ringreso["document_id"]);
                if ($sale_note->total > $ringreso["amount"]) {
                    $sales_cash_sum += $ringreso["amount"];
                } else {
                    $sales_cash_sum += $sale_note->total;
                }
            }
        }
        $sales_amount += $sales_cash_sum;
        $sales_cash_quantity = $sales_cash->count();


        //TARJETA: NIUBIZ

        $sales_izypay = Box::where('type', '1')->where('method', 'TARJETA: IZYPAY')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_izypay_sum = $sales_izypay->sum('amount');
        $sales_izypay_quantity = $sales_izypay->count();

        $sales_niubiz = Box::where('type', '1')->where('method', 'TARJETA: NIUBIZ')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_niubiz_sum = $sales_niubiz->sum('amount');
        $sales_niubiz_quantity = $sales_niubiz->count();


        $sales_transfer = Box::where('type', '1')->where('method', 'Transferencia')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_transfer_sum = $sales_transfer->sum('amount');
        $sales_transfer_quantity = $sales_transfer->count();

        $sales_bank = Box::where('type', '1')->where('method', 'Deposito Bancario')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_bank_sum = $sales_bank->sum('amount');
        $sales_bank_quantity = $sales_bank->count();

        $sales_card = Box::where('type', '1')->where('method', 'Tarjeta')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_card_sum = $sales_card->sum('amount');
        $sales_card_quantity = $sales_card->count();

        $sales_openpay = Box::where('type', '1')->where('method', 'TARJETA: OPENPAY')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_openpay_sum = $sales_openpay->sum('amount');
        $sales_openpay_quantity = $sales_openpay->count();

        $sales_yape = Box::where('type', '1')->where('method', 'Yape')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_yape_sum = $sales_yape->sum('amount');
        $sales_yape_quantity = $sales_yape->count();

        $sales_plin = Box::where('type', '1')->where('method', 'PLIN')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_plin_sum = $sales_plin->sum('amount');
        $sales_plin_quantity = $sales_plin->count();

        $sales_culqui = Box::where('type', '1')->where('method', 'Culqui')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_culqui_sum = $sales_culqui->sum('amount');
        $sales_culqui_quantity = $sales_culqui->count();

        $sales_bbva = Box::where('type', '1')->where('method', 'BBVA')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_bbva_sum = $sales_bbva->sum('amount');
        $sales_bbva_quantity = $sales_bbva->count();

        $sales_bcp = Box::where('type', '1')->where('method', 'BCP')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_bcp_sum = $sales_bcp->sum('amount');
        $sales_bcp_quantity = $sales_bcp->count();


        $sales_nacion = Box::where('type', '1')->where('method', 'BCO NACION')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_nacion_sum = $sales_nacion->sum('amount');
        $sales_nacion_quantity = $sales_nacion->count();


        $sales_scotiabank = Box::where('type', '1')->where('method', 'Scotiabank')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_scotiabank_sum = $sales_scotiabank->sum('amount');
        $sales_scotiabank_quantity = $sales_scotiabank->count();

        $expenses = Box::where('type', '2')->where('expenses', 1)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $expenses_cash = $expenses->where('method', 'Efectivo');
        $expenses_cash_sum = $expenses_cash->sum('amount');
        $expenses_cash_quantity = $expenses_cash->count();

        $incomes = Box::where('type', '1')->where('incomes', 1)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $incomes_cash =  $incomes->where('method', 'Efectivo');
        $incomes_cash_sum =  $incomes_cash->sum('amount');
        $incomes_cash_quantity = $incomes_cash->count();


        $cash = Cash::find($cash_id);
        $counter = $cash->counter ?? [];
        $user = User::find($cash->user_id);
        $establishment =  auth()->user()->establishment;
        $info = $this->get_items_from_box($cash_id);
        $items = $info['items'];
        $documents = $info['documents'];
        $documents_info = $info['documents_info'];
        $saldo = 0;

        $uniques = array_unique(array_column($items, 'description'));
        $unds = array_reduce($items, function ($init, $item) {
            return $init + floatval($item["quantity"]);
        });
        $items_detail = [
            "items" => $items,
            "uniques" => count($uniques),
            "unds" => $unds,
        ];
        $sales_detail = [
            "cash" => [
                "desc" => "Efectivo",
                "quantity" => $sales_cash_quantity,
                "sum" => $sales_cash_sum,
            ],
            "card" => [
                "desc" => "Tarjeta",
                "quantity" => $sales_card_quantity,
                "sum" => $sales_card_sum,
            ],
            "yape" =>
            [
                "desc" => "Yape",
                "quantity" => $sales_yape_quantity,
                "sum" => $sales_yape_sum,
            ],
            "plin" => [
                "desc" => "Plin",
                "quantity" => $sales_plin_quantity,
                "sum" => $sales_plin_sum,
            ],
            "culqui" => [
                "desc" => "Culqui",
                "quantity" => $sales_culqui_quantity,
                "sum" => $sales_culqui_sum,
            ],
            "izypay" => [
                "desc" => "Izypay",
                "quantity" => $sales_izypay_quantity,
                "sum" => $sales_izypay_sum,
            ], "niubiz" => [
                "desc" => "Niubiz",
                "quantity" => $sales_niubiz_quantity,
                "sum" => $sales_niubiz_sum,
            ],
            "bbva" => [
                "desc" => "BBVA",
                "quantity" => $sales_bbva_quantity,
                "sum" => $sales_bbva_sum,
            ],
            "bcp" => [
                "desc" => "BCP",
                "quantity" => $sales_bcp_quantity,
                "sum" => $sales_bcp_sum,
            ],
            "nacion" => [
                "desc" => "BCO NACION",
                "quantity" => $sales_nacion_quantity,
                "sum" => $sales_nacion_sum,
            ],
            "scotiabank" => [
                "desc" => "Scotiabank",
                "quantity" => $sales_scotiabank_quantity,
                "sum" => $sales_scotiabank_sum,
            ],

            "openpay" => [
                "desc" => "Openpay",
                "quantity" => $sales_openpay_quantity,
                "sum" => $sales_openpay_sum,
            ],


        ];
        $banks = Box::where('type', '1')
            ->whereNotNull('bank_account_id')
            ->where('cash_id', $cash_id);
        $total_coins_bank = $banks->sum('amount');

        $bank_accounts = $banks->get();
        foreach ($bank_accounts as $bank_account) {
            $method = $bank_account->method;
            if (isset($sales_detail[$method])) {
                $sales_detail[$method]["quantity"] += 1;
                $sales_detail[$method]["sum"] += $bank_account->amount;
            } else {
                $bk_account = BankAccount::find($bank_account->bank_account_id);
                $bank_description = $bk_account->bank->description;
                $sales_detail[$method] = [
                    "desc" => $bank_description . " " . $bank_account->method,
                    "quantity" => 1,
                    "sum" => $bank_account->amount,
                    "is_bank" => true,
                ];
            }
        }
        $incomes_expenses_cash = [
            "incomes" => [
                "quantity" => $incomes_cash_quantity,
                "amount" => $incomes_cash_sum,
            ],
            "expenses" => [
                "quantity" => $expenses_cash_quantity,
                "amount" => $expenses_cash_sum,
            ],
        ];
        $receipts = $this->get_receipts($cash_id); // receipts
        $quantity_receipts = count($receipts);
        $total_receipts = $receipts->sum('amount');
        $documents["recibos"] = ["total" => $total_receipts, "quantity" => $quantity_receipts];

        // $documents_credit = $this->get_items_from_credit($cash_id); 
        // $all_credit_items = $documents_credit['items'];
        // $credit_grouped = $documents_credit['documents'];
        // $array_receipts = $receipts->toArray();
        // $all_credit_documents = array_merge($credit_grouped,$array_receipts );
        return compact(
            "sales_quantity",
            "sales_amount",
            "sales_detail",
            "items_detail",
            "incomes_expenses_cash",
            "documents",
            "documents_info",
        );
    }
    public function list_food_sales(Request $request)
    {

        $data_item = DB::connection('tenant')->table('orden_item')->select(DB::raw("DISTINCT(orden_item.food_id) as food_id"))->where('date', $request['date_start'])->get();

        $items = [];
        foreach ($data_item as $key => $data) {

            $orden = OrdenItem::where('food_id', $data->food_id)->where('date', $request['date_start']);
            $importe_total = 0;
            foreach ($orden->get() as $row) {
                //  $price[]=$row->price;
                $importe_total += $row->price * $row->quantity;
            }
            //$price_mayor=min($price);
            $quantity_total = $orden->sum('quantity');

            array_push($items, [
                'id' => $orden->first()->food->id,
                'description' => $orden->first()->food->description,
                'move_quantity' => $quantity_total,
                'total' => $importe_total,
            ]);
        }
        $items = collect($items);
        return $items;
    }
    public function reports_type(Request $request)
    {

        $column = $request->column;
        $value = $request->value;
        $data = Box::query();
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $user_id = $request['user_id'];
        $user = User::find($user_id);
        $type_box = $request['type_box'];


        // switch ($period) {
        //     case 'month':
        //         $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
        //         $d_end = Carbon::parse($month_start . '-01')->endOfMonth()->format('Y-m-d');

        //         break;
        //     case 'between_months':
        //         $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
        //         $d_end = Carbon::parse($month_end . '-01')->endOfMonth()->format('Y-m-d');
        //         break;
        //     case 'date':
        //         $d_start = $date_start;
        //         $d_end = $date_end;
        //         break;
        //     case 'between_dates':
        //         $d_start = $date_start;
        //         $d_end = $date_end;
        //         break;
        // }
        // Box::whereBetween('date', [$date_start, $date_end])
        //->OrderBy('sale_note_id')->OrderBy('document_id')
        //latest

        if ($column == 'date' && isset($value)) {
            $d = explode(",", $value);
            $d_start = $d[0];
            $d_end = $d[1];
            $data = $data->whereBetween('date', [$d_start, $d_end])->where('method', 'Efectivo');
        }
        //  dd($data);
        if ($user_id) {
            $data =  $data->where('user_id', $user_id);
        }
        if ($type_box == 'expenses') {
            $data =  $data->where('type', 2)->where('expenses', 1);
        } else {
            $data =  $data->where('type', 1)->where('incomes', 1);
        }

        $boxes_report = new BoxCollection($data->latest()->get());

        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        $saldo = 0;
        // if ($request['type'] == "pdf") {
        $pdf = PDF::loadView('report::boxes.report_type_pdf', compact("user", "boxes_report", "establishment", "date_start", "date_end", "company", "type_box"))->setPaper('a4', 'landscape');
        return $pdf->stream('Reporte_Ventas_' . date('YmdHis') . '.pdf');
        // } else if ($request['type'] == "excel") {

        //     return (new BoxesExport)
        //         ->records($data->get())
        //         ->company($company)

        //         ->establishment($establishment)
        //         ->download('Reporte_arqueo_caja_' . Carbon::now() . '.xlsx');
        // }
    }
    public function reports_bancario_type(Request $request)
    {
        $group_id = $request['group_id'];
        $category_id = $request['category_id'];
        $subcategory_id = $request['subcategory_id'];
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $user_id = $request['user_id'];
        $type_box = $request['type_box'];
        $d_start = null;
        $d_end = null;

        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }

        $data = Box::whereBetween('date', [$d_start, $d_end])->where('amount', '>', "0.00")->where('type', '1')->orderBy('date', 'asc')->latest();
        $data = $data->where('method', '!=', "Efectivo")->Where('method', '!=', 'Credito')->orderBy('date', 'asc')->latest();

        if ($user_id) {
            $data =  $data->where('user_id', $user_id);
        }
        $boxes_report = new BoxCollection($data->get());

        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;

        $saldo = 0;
        if ($request['type'] == "pdf") {
            $pdf = PDF::loadView('report::boxes.report_bancario_pdf_pos', compact("boxes_report", "establishment", "company", "date_start", "date_end"))->setPaper('a4', 'landscape');
            return $pdf->stream('Reporte_Ventas_' . date('YmdHis') . '.pdf');
        } else if ($request['type'] == "excel") {

            return (new BoxesExportBancarioPos)
                ->records($data->get())
                ->company($company)
                ->type_box($type_box)
                ->establishment($establishment)
                ->download('Reporte_arqueo_caja_' . Carbon::now() . '.xlsx');
        }
    }
    public function reports_results(Request $request)
    {
        $group_id = $request['group_id'];
        $category_id = $request['category_id'];
        $subcategory_id = $request['subcategory_id'];
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $user_id = $request['user_id'];
        $d_start = null;
        $d_end = null;
        $type_box = $request['type_box'];;
        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start . '-01')->endOfMonth()->format('Y-m-d');

                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end . '-01')->endOfMonth()->format('Y-m-d');

                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_end;
                // $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }
        $data = Box::whereBetween('date', [$d_start, $d_end])->where('amount', '>', "0.00")->OrderBy("date", "asc")->OrderBy("type", "desc")->latest();
        if ($type_box) {
            $data =  $data->where('type', $type_box);
        }
        if ($user_id) {
            $data =  $data->where('user_id', $user_id);
        }
        return new BoxCollection($data->paginate(config('tenant.items_per_page')));
    }

    public function report()
    {
        $user = auth()->user();
        $caja_area_id = Area::where('description', 'like', '%aja%')->first()->id;
        if ($user->type == 'admin') {
            $users = User::where('type', 'admin')->orWhere('area_id', $caja_area_id)->get();
        } else {
            $users = User::where('id', $user->id)->orWhere('area_id', $caja_area_id)->get();
        }
        return view('restaurant::report.index', compact('users'));
    }
}
