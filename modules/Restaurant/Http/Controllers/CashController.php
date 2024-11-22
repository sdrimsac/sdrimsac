<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Exports\CashPrincipalExport;
use Exception;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\UserSerie;
use App\Models\Tenant\Box;
use App\Models\Tenant\Cash;
use App\Models\Tenant\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Tenant\CashDocument;
use App\Models\Tenant\DocumentItem;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Catalogs\UnitType;
use App\Models\Tenant\PaymentMethodType;
use App\Http\Requests\Tenant\CashRequest;
use App\Http\Resources\Tenant\BoxCollection;
use App\Http\Resources\Tenant\CashResource;
use App\Models\Tenant\Catalogs\CurrencyType;
use App\Http\Resources\Tenant\CashCollection;
use App\Http\Resources\Tenant\DocumentCollection;
use App\Http\Resources\Tenant\QuotationCollection;
use App\Http\Resources\Tenant\SaleNoteCollection;
use App\Jobs\CashReportProccess;
use App\Jobs\CashReportSmallProccess;
use App\Jobs\WhatsappSendCashReportProccess;
use App\Jobs\WhatsappSendCashReportStockProccess;
use App\Jobs\WhatsappSendMessageProccess;
use App\Models\Tenant\BankAccount;
use App\Models\Tenant\CashIncomePrincipal;
use App\Models\Tenant\Catalogs\AttributeType;
use App\Models\Tenant\Catalogs\SystemIscType;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ExcludedUser;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\NumberActivity;
use App\Models\Tenant\Quotation;
use App\Models\Tenant\Receipt;
use App\Models\Tenant\SaleNoteItem;
use App\Models\Tenant\SaleNotePayment;
use App\Traits\JobReportTrait;
use Barryvdh\Debugbar\Twig\Extension\Dump;
use GuzzleHttp\Psr7\Response;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Website;
use Modules\Restaurant\Models\Turns;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Item\Models\CategoryItem;
use Modules\Report\Exports\GainReportExport;
use Modules\Restaurant\Http\Resources\CashIncomePrincipalCollection;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\BoxesDetail;
use Mpdf\Mpdf;
use NumberFormatter;

class CashController extends Controller
{
    use JobReportTrait;
    public function adjusmentIncome(Request $request)
    {
        $cash_id = $request->cash_id;
        $amount = $request->amount;
        Box::createIncome("Efectivo", $amount, 'Ajuste por división de pagos', $cash_id);
    }
    public function cash_avaible($cash_id)
    {
        $total_credits = SaleNote::whereHas('credit_payments')
            ->where('cash_id', $cash_id)
            ->where('is_cash', true)
            ->where('state_type_id', '<>', 11)
            ->sum('total');
        $cash = Cash::findOrFail($cash_id);
        $beginning_balance = $cash->beginning_balance;
        $incomes = Box::where('cash_id', $cash_id)->where('incomes', 1)->sum('amount');
        $expenses = Box::where('cash_id', $cash_id)->where('expenses', 1)->sum('amount');
        $cash_available = $beginning_balance + $incomes - $expenses - $total_credits;

        return [
            'success' => true,
            'cash_available' => $cash_available
        ];
    }
    public function observ_register(Request $request)
    {

        $cash_income_principal = CashIncomePrincipal::findOrFail($request->id);
        $cash_income_principal->comment = $request->comment;
        $cash_income_principal->status = 2;
        $cash_income_principal->save();
        return [
            'success' => true,
            'message' => 'Observación registrada con éxito'
        ];
    }
    public function accept_register($id)
    {

        $cash_income_principal = CashIncomePrincipal::findOrFail($id);
        $cash = $cash_income_principal->cash;
        $amount = $cash_income_principal->amount;
        $user_id = $cash_income_principal->cash->user_id;
        $user = User::findOrFail($user_id);
        $user_name = $user->name;
        $establishment_id = $user->establishment_id;
        $establishment = Establishment::findOrFail($establishment_id);
        $establishment_description = $establishment->description;
        $principal_cash_id = $cash_income_principal->cash_principal_id;
        $cash_principal = Cash::findOrFail($principal_cash_id);
        $user_name_principal = $cash_principal->user->name;
        $description_cash = $cash->reference_number;
        $description = "Ingreso de la caja $description_cash del usuario $user_name del establecimiento $establishment_description";
        $soap_type_id = Company::first()->soap_type_id;
        Box::create([
            'cash_id' => $principal_cash_id,
            'amount' => $amount,
            'type' => 1,
            'incomes' => true,
            'date' => date('Y-m-d'),
            'method' => 'Efectivo',
            'group_id' => 1,
            'subcategory_id' => 1,
            'category_id' => 1,
            'soap_type_id' => $soap_type_id,
            'description' => $description,
            'state' => 1,
            'user_id' => auth()->user()->id,
        ]);
        $cash_income_principal->status = 3;
        $cash_income_principal->save();
        $total = (new CashTransferController)->available();
        $total_withouth_income = $total - $amount;
        $income = $amount;
        // $message ? 
        // El usuario Arca Administrador hasta la fecha 06-11-2021 / 11:34am contaba con monto de s/ xxxxx y ha aceptado ingreso de cierre de caja de usuario analista xxxx S/xxx, actualizando un saldo de S/xxxx
        $message = "El usuario $user_name_principal hasta la fecha " . date('d-m-Y') . " / " . date('h:i A') . " contaba con monto de S/ $total_withouth_income y ha aceptado ingreso de cierre de caja de usuario $user_name S/ $income, actualizando un saldo de S/ $total";
        $website = $this->getTenantWebsite();
        WhatsappSendMessageProccess::dispatch($website->id, $message, null);


        return [
            'success' => true,
            'message' => 'Ingreso aceptado con éxito'
        ];
    }
    public function index_main()
    {
        $cash_id = null;
        $cash = Cash::where('user_id', auth()->user()->id)
            ->where('state', 1)
            ->orderBy('id', 'desc')
            ->first();
        $total = 0;

        if ($cash) {
            $cash_id = $cash->id;
            $incomes = Box::where('cash_id', $cash_id)->where('incomes', 1)->sum('amount');
            $expenses = Box::where('cash_id', $cash_id)->where('expenses', 1)->sum('amount');
            $begging_balance = $cash->beginning_balance;
            $cash_transfer = $cash->cash_transfers->sum('amount');
            $total = $incomes - $expenses + $begging_balance - $cash_transfer;
            // $total = $incomes - $expenses;
        }
        $configuration = Configuration::first();

        return view('tenant.cash.index_main', compact('configuration', 'cash_id', 'total'));
    }
    public function index_report_closed_cash()
    {
        $configuration = Configuration::first();
        $users = User::where('active', 1)->get();
        $user_id = auth()->user()->id;
        $has_cash = 0 < Cash::where('user_id', $user_id)->where('state', 1)->count();
        $user = User::findOrFail($user_id);
        $can_open = $user->isWorkerType("arca") || $user->is_arca;
        $can_open = !$can_open;
        $cash_id = null;
        $cash = Cash::where('user_id', auth()->user()->id)
            ->where('state', 1)
            ->orderBy('id', 'desc')
            ->first();

        if ($cash) {
            $cash_id = $cash->id;
        }
        return view('tenant.cash.index_closed', compact(
            'can_open',
            'configuration',
            'users',
            'has_cash',
            'cash_id'
        ));
    }
    public function index_report_cash()
    {
        return view('restaurant::cash.report');
        // route('reports.cash.index')
    }
    //index_report_closed_cash

    public function incomes_expenses_delete($id, $type)
    {

        $box = Box::findOrFail($id);
        if ($type == 'expenses') {
            BoxesDetail::where('boxes_id', $id)->delete();
        }
        $box->delete();
        $message = $type == 'expenses' ? 'Gasto' : 'Ingreso';
        return [
            'success' => true,
            'message' => $message . ' eliminado con éxito'
        ];
    }
    public function report_cash_export($type, Request $request)
    {
        ini_set('max_execution_time', "3000");
        ini_set('memory_limit', '2048M');
        $type = $type ?? 'pdf';
        $item_id = $request->item_id;
        $categoria_id = $request->categoria_id;
        $establishment_id = $request->establishment_id;
        $establishment = null;
        if ($establishment_id) {
            $establishment = Establishment::find(1);
        }
        $company = Company::find(1);
        $date_start = $request->date_start ? Carbon::parse($request->date_start)->format("Y-m-d") : null;
        $date_end = $request->date_end ? Carbon::parse($request->date_end)->format("Y-m-d") : null;
        $month = 11;
        $items = [];
        $total = 0;
        //total venta -> jalar documentos
        $recordsDocument =  Document::where('state_type_id', '<>', 11);
        if ($date_start) {
            if ($date_end) {
                $recordsDocument = $recordsDocument->whereBetween('date_of_issue', [$date_start, $date_end]);
            } else {
                $recordsDocument = $recordsDocument->whereDate('date_of_issue', '=', $date_start);
            }
        }
        if ($establishment_id) {
            $recordsDocument = $recordsDocument->where('establishment_id', $establishment_id);
        }

        $recordsDocument->chunk(50, function ($documents)
        use (&$items, &$total, &$categoria_id, &$item_id) {

            foreach ($documents as  $document) {
                $total_items = 0;
                // $documents_items = DocumentItem::where('document_id', $document->id)->get();
                $documents_items = DocumentItem::where('document_id', $document->id);
                if ($item_id) {
                    $documents_items = $documents_items->where('item_id', $item_id);
                }
                $documents_items = $documents_items->get();
                foreach ($documents_items as  $d_it) {

                    $item = is_string($d_it->item) ? json_decode($d_it->item, true) : (array) $d_it->item;

                    if (isset($item['categoriaMadera'])) {
                        $selectedAncho = isset($item['categoriaMadera']->selectedAncho) ? $item['categoriaMadera']->selectedAncho : '';
                        $selectedLargo = isset($item['categoriaMadera']->selectedLargo) ? $item['categoriaMadera']->selectedLargo : '';
                        $selectedGrosor = isset($item['categoriaMadera']->selectedGrosor) ? $item['categoriaMadera']->selectedGrosor : '';
                    } else {
                        $selectedAncho = $selectedLargo = $selectedGrosor = null;
                    }

                    if ($categoria_id == null) {
                        $item = $d_it->item;
                        $factor = null;
                        $unit_type = null;
                        $unit_item =  $d_it->relation_item->unit_type->description;
                        $purchase_unit_price =  $d_it->relation_item->purchase_unit_price;
                        if ($d_it->affectation_igv_type_id == '10') {
                            $purchase_unit_price /= 1.18;
                        }
                        $max_quantity_item = null;
                        if ($d_it->relation_item->max_quantity) {
                            $max_quantity_item = $d_it->relation_item->max_quantity;
                            $purchase_unit_price /= $d_it->m_item->max_quantity;
                            $uit = ItemUnitType::where('quantity_unit', $d_it->m_item->max_quantity)->where('item_id', $d_it->item_id)->first();
                            if ($uit) {
                                $unit_type = $uit->unit_type->description;
                            }
                        }
                        $unit_type_name = null;
                        $quantity = $d_it->quantity;
                        if (isset($item->has_unit_type)) {
                            $uit = ItemUnitType::where('description', $item->has_unit_type)->where('item_id', $d_it->item_id)->first();
                            if ($uit) {
                                $unit_type_name = $item->has_unit_type;
                                $factor = floatval($uit->quantity_unit);
                                $quantity *= $factor;
                            }
                        }
                        $total += $d_it->total_value;
                        $total_items += $d_it->total_value;
                        $price = $d_it->unit_price;
                        if ($d_it->affectation_igv_type_id == '10') {
                            $price = number_format($price/1.18,2,'.','');
                        }
                        if (array_key_exists($d_it->item_id, $items)) {

    
                            if (array_key_exists($price, $items[$d_it->item_id]["prices"])) {
                                $items[$d_it->item_id]["prices"][$price]["count"] +=  $d_it->quantity;
                               
                            } else {
                               
                                $items[$d_it->item_id]["prices"][$price] =  [
                                    "count" =>  $d_it->quantity,
                                    "factor" => $factor,
                                    "unit_type_name" => $unit_type_name,
                                    "selectedAncho" => $selectedAncho,
                                    "selectedLargo" => $selectedLargo,
                                    "selectedGrosor" => $selectedGrosor,
                                ];
                            }
                            $items[$d_it->item_id]["count"] +=   $quantity;
                            //$items[$d_it->item_id]["total"] += $d_it->unit_price * $d_it->quantity;
                            $items[$d_it->item_id]["total"] += $d_it->total_value;
                        } else {
                          
                            $items[$d_it->item_id] = [
                                "description" => $d_it->item->description,
                                "count" => $quantity,
                                "purchase_unit_price" => $purchase_unit_price,
                                "total" => $d_it->total_value,
                                "unit_type" => $unit_type,
                                "factor" => $factor,
                                "max_quantity_item" => $max_quantity_item,
                                "unit_type_name" => $unit_type_name,
                                "unit_item" => $unit_item,
                                "prices" => [
                                    $price => [
                                        "count" =>  $d_it->quantity,
                                        "factor" => $factor,
                                        "unit_type_name" => $unit_type_name,
                                        "selectedAncho" => $selectedAncho,
                                        "selectedLargo" => $selectedLargo,
                                        "selectedGrosor" => $selectedGrosor,
                                    ]
                                ],
                            ];
                        }
                    } else {
                        $item = $d_it->item;
                        $itemCattegoria =  Item::findOrFail($d_it->item_id);
                        if ($itemCattegoria->category_id == $categoria_id) {
                            $factor = null;
                            $unit_type = null;
                            $unit_item =  $d_it->relation_item->unit_type->description;
                            $purchase_unit_price =  $d_it->relation_item->purchase_unit_price;
                            if ($d_it->affectation_igv_type_id == '10') {
                                $purchase_unit_price /= 1.18;
                            }
                            $max_quantity_item = null;
                            if ($d_it->relation_item->max_quantity) {
                                $max_quantity_item = $d_it->relation_item->max_quantity;
                                $purchase_unit_price /= $d_it->m_item->max_quantity;
                                $uit = ItemUnitType::where('quantity_unit', $d_it->m_item->max_quantity)->where('item_id', $d_it->item_id)->first();
                                if ($uit) {
                                    $unit_type = $uit->unit_type->description;
                                }
                            }
                            $unit_type_name = null;
                            $quantity = $d_it->quantity;
                            if (isset($item->has_unit_type)) {
                                $uit = ItemUnitType::where('description', $item->has_unit_type)->where('item_id', $d_it->item_id)->first();
                                if ($uit) {
                                    $unit_type_name = $item->has_unit_type;
                                    $factor = floatval($uit->quantity_unit);
                                    $quantity *= $factor;
                                }
                            }

                            $total += $d_it->total_value;
                            $total_items += $d_it->total_value;
                            $price = $d_it->unit_price;
                            if ($d_it->affectation_igv_type_id == '10') {
                                $price = number_format($price/1.18,2,'.','');
                            }
                            if (array_key_exists($d_it->item_id, $items)) {


                                if (array_key_exists($price, $items[$d_it->item_id]["prices"])) {
                                    $items[$d_it->item_id]["prices"][$price]["count"] +=  $d_it->quantity;
                                   
                                } else {
                                   
                                    $items[$d_it->item_id]["prices"][$price] =  [
                                        "count" =>  $d_it->quantity,
                                        "factor" => $factor,
                                        "unit_type_name" => $unit_type_name,
                                    ];
                                }
                                $items[$d_it->item_id]["count"] +=   $quantity;
                                //$items[$d_it->item_id]["total"] += $d_it->unit_price * $d_it->quantity;
                                $items[$d_it->item_id]["total"] += $d_it->total_value;
                            } else {
                               
                                $items[$d_it->item_id] = [
                                    "description" => $d_it->item->description,
                                    "count" => $quantity,
                                    "purchase_unit_price" => $purchase_unit_price,
                                    "total" => $d_it->total_value,
                                    "unit_type" => $unit_type,
                                    "factor" => $factor,
                                    "max_quantity_item" => $max_quantity_item,
                                    "unit_type_name" => $unit_type_name,
                                    "unit_item" => $unit_item,
                                    "prices" => [
                                        $price => [
                                            "count" =>  $d_it->quantity,
                                            "factor" => $factor,
                                            "unit_type_name" => $unit_type_name,
                                            "selectedAncho" => $selectedAncho,
                                            "selectedLargo" => $selectedLargo,
                                            "selectedGrosor" => $selectedGrosor,
                                        ]
                                    ],
                                ];
                            }
                        }
                    }
                }
            }
        });
        // $recordsSaleNote = null;
        $recordsSaleNote = SaleNote::where('state_type_id', '<>', 11);
        if ($date_start) {
            if ($date_end) {
                $recordsSaleNote = $recordsSaleNote->whereBetween('date_of_issue', [$date_start, $date_end]);
            } else {
                $recordsSaleNote = $recordsSaleNote->whereDate('date_of_issue', '=', $date_start);
            }
        }
        if ($establishment_id) {
            $recordsSaleNote = $recordsSaleNote->where('establishment_id', $establishment_id);
        }

        $recordsSaleNote->chunk(50, function ($sale_notes)

        use (&$items, &$total, &$categoria_id, &$item_id) {

            foreach ($sale_notes as  $sale_note) {
                $total_items = 0;
                $sale_notes_items = SaleNoteItem::where('sale_note_id', $sale_note->id);

                if ($item_id) {
                    $sale_notes_items = $sale_notes_items->where('item_id', $item_id);
                }
                $sale_notes_items = $sale_notes_items->get();

                foreach ($sale_notes_items as  $d_it) {

                    $item = is_string($d_it->item) ? json_decode($d_it->item, true) : (array) $d_it->item;


                    if (isset($item['categoriaMadera'])) {
                        $selectedAncho = isset($item['categoriaMadera']->selectedAncho) ? $item['categoriaMadera']->selectedAncho : '';
                        $selectedLargo = isset($item['categoriaMadera']->selectedLargo) ? $item['categoriaMadera']->selectedLargo : '';
                        $selectedGrosor = isset($item['categoriaMadera']->selectedGrosor) ? $item['categoriaMadera']->selectedGrosor : '';
                    } else {
                        $selectedAncho = $selectedLargo = $selectedGrosor = null;
                    }
                    if ($categoria_id == null) {
                        $item = $d_it->item;
                        $factor = null;
                        $unit_type = null;
                        $max_quantity_item = null;
                        $unit_item =  $d_it->relation_item->unit_type->description;
                        $purchase_unit_price =  $d_it->relation_item->purchase_unit_price;
                        if ($d_it->affectation_igv_type_id == '10') {
                            $purchase_unit_price /= 1.18;
                        }
                        if ($d_it->relation_item->max_quantity) {
                            $purchase_unit_price /= $d_it->relation_item->max_quantity;
                            $max_quantity_item = $d_it->relation_item->max_quantity;
                            $uit = ItemUnitType::where('quantity_unit', $d_it->relation_item->max_quantity)->where('item_id', $d_it->item_id)->first();
                            if ($uit) {
                                $unit_type = $uit->unit_type->description;
                            }
                        }
                        $unit_type_name = null;
                        $quantity = $d_it->quantity;
                        if (isset($item->from_unit_type_id)) {
                            $uit_id = $item->from_unit_type_id;
                            foreach ($item->item_unit_types as $iut) {
                                if ($uit_id == $iut->id) {
                                    $factor = floatval($iut->quantity_unit);
                                    $unit_type_name = $iut->description;
                                    $quantity *= $factor;
                                    break;
                                }
                            }
                        }
                        $total += $d_it->total_value;
                        $total_items += $d_it->total_value;
                        $price = $d_it->unit_price;
                        if ($d_it->affectation_igv_type_id == '10') {
                            $price = number_format($price/1.18,2,'.','');
                            
                            
                        }
                        if (array_key_exists($d_it->item_id, $items)) {


                            if (array_key_exists($price, $items[$d_it->item_id]["prices"])) {
                                $items[$d_it->item_id]["prices"][$price]["count"] +=  $d_it->quantity;
                               
                            } else {
                               
                                $items[$d_it->item_id]["prices"][$price] =  [
                                    "count" =>  $d_it->quantity,
                                    "factor" => $factor,
                                    "unit_type_name" => $unit_type_name,
                                    "selectedAncho" => $selectedAncho,
                                    "selectedLargo" => $selectedLargo,
                                    "selectedGrosor" => $selectedGrosor,
                                ];
                            }
                            $items[$d_it->item_id]["count"] +=  $quantity;
                            //$items[$d_it->item_id]["total"] += $d_it->unit_price * $d_it->quantity;
                            $items[$d_it->item_id]["total"] += $d_it->total_value;
                        } else {
                           
                            $items[$d_it->item_id] = [
                                "description" => $d_it->item->description,
                                "count" =>  $quantity,
                                "purchase_unit_price" => $purchase_unit_price,
                                "total" => $d_it->total_value,
                                "factor" => $factor,
                                "unit_type" => $unit_type,
                                "max_quantity_item" => $max_quantity_item,
                                "unit_type_name" => $unit_type_name,
                                "unit_item" => $unit_item,
                                "prices" => [
                                    $price => [
                                        "count" =>  $d_it->quantity,
                                        "factor" => $factor,
                                        "unit_type_name" => $unit_type_name,
                                        "selectedAncho" => $selectedAncho,
                                        "selectedLargo" => $selectedLargo,
                                        "selectedGrosor" => $selectedGrosor,
                                    ]
                                ],
                            ];
                        }
                    } else {
                        $item = $d_it->item;
                        $catItem = $d_it->item->category->id;
                        if ($catItem == $categoria_id) {
                            $factor = null;
                            $unit_type = null;
                            $max_quantity_item = null;
                            $unit_item =  $d_it->relation_item->unit_type->description;
                            $purchase_unit_price =  $d_it->relation_item->purchase_unit_price;
                            if ($d_it->affectation_igv_type_id == '10') {
                                $purchase_unit_price /= 1.18;
                            }
                            if ($d_it->relation_item->max_quantity) {
                                $purchase_unit_price /= $d_it->relation_item->max_quantity;
                                $max_quantity_item = $d_it->relation_item->max_quantity;
                                $uit = ItemUnitType::where('quantity_unit', $d_it->relation_item->max_quantity)->where('item_id', $d_it->item_id)->first();
                                if ($uit) {
                                    $unit_type = $uit->unit_type->description;
                                }
                            }
                            $unit_type_name = null;
                            $quantity = $d_it->quantity;
                            if (isset($item->from_unit_type_id)) {
                                $uit_id = $item->from_unit_type_id;
                                foreach ($item->item_unit_types as $iut) {
                                    if ($uit_id == $iut->id) {
                                        $factor = floatval($iut->quantity_unit);
                                        $unit_type_name = $iut->description;
                                        $quantity *= $factor;
                                        break;
                                    }
                                }
                            }
                            $total += $d_it->total;
                            $total_items += $d_it->total;
                            $price = $d_it->unit_price;
                            if ($d_it->affectation_igv_type_id == '10') {
                                $price = number_format($price/1.18,2,'.','');
                            }
                            if (array_key_exists($d_it->item_id, $items)) {

    
                                if (array_key_exists($price, $items[$d_it->item_id]["prices"])) {
                                    $items[$d_it->item_id]["prices"][$price]["count"] +=  $d_it->quantity;
                                  
                                } else {
                                  
                                    $items[$d_it->item_id]["prices"][$price] =  [
                                        "count" =>  $d_it->quantity,
                                        "factor" => $factor,
                                        "unit_type_name" => $unit_type_name,
                                    ];
                                }
                                $items[$d_it->item_id]["count"] +=  $quantity;
                                //$items[$d_it->item_id]["total"] += $d_it->unit_price * $d_it->quantity;
                                $items[$d_it->item_id]["total"] += $d_it->total_value;
                            } else {
                                $items[$d_it->item_id] = [
                                    "description" => $d_it->item->description,
                                    "count" =>  $quantity,
                                    "purchase_unit_price" => $purchase_unit_price,
                                    "total" => $d_it->total_value,
                                    "factor" => $factor,
                                    "unit_type" => $unit_type,
                                    "max_quantity_item" => $max_quantity_item,
                                    "unit_type_name" => $unit_type_name,
                                    "unit_item" => $unit_item,
                                    "prices" => [
                                        $price => [
                                            "count" =>  $d_it->quantity,
                                            "factor" => $factor,
                                            "unit_type_name" => $unit_type_name,
                                            "selectedAncho" => $selectedAncho,
                                            "selectedLargo" => $selectedLargo,
                                            "selectedGrosor" => $selectedGrosor,
                                        ]
                                    ],
                                ];
                            }
                        }
                    }
                }
            }
        });
        $is_service = false;
        // if($)
        if ($item_id !== null) {
            $item = Item::findOrFail($item_id);
            $is_service = $item->unit_type_id == "ZZ";
        }
        array_multisort(array_column($items, 'count'), SORT_DESC, $items);
        if ($type == 'pdf') {
            $pdf = PDF::loadView('report::cash.report_pdf_cash', compact(
                "establishment",
                "total",
                "company",
                "items",
                "date_start",
                "date_end",
                "is_service"
            ));

            $filename = "Reporte_POS";

            return $pdf->stream($filename . '.pdf');
        } else {
            return (new GainReportExport)
                ->establishment($establishment)
                ->total($total)
                ->company($company)
                ->items($items)
                ->date_start($date_start)
                ->date_end($date_end)
                ->is_service($is_service)
                ->download('ReporteGanan.' . Carbon::now() . '.xlsx');
        }
    }

    /* public function report_cash(Request $request)
    {
        ini_set('max_execution_time', "3000");
        ini_set('memory_limit', '2048M');
        $categoria_id = $request->categoria_id;
        $item_id = $request->item_id;
        $establishment_id = $request->establishment_id;
        $date_start = $request->date_start ? Carbon::parse($request->date_start)->format("y-m-d") : null;
        $date_end = $request->date_end ? Carbon::parse($request->date_end)->format("y-m-d") : null;
        $month = 11;
        $items = [];
        $total = 0;

        //total venta -> jalar documentos
        $recordsDocument =  Document::whereNotIn('state_type_id', ['09', '11']);
        if ($date_start) {
            if ($date_end) {
                $recordsDocument = $recordsDocument->whereBetween('date_of_issue', [$date_start, $date_end]);
            } else {
                $recordsDocument = $recordsDocument->whereDate('date_of_issue', '=', $date_start);
            }
        }
        $config = Configuration::first();
        $item_id_variation = $config->item_variation_id;
        if ($establishment_id) {
            $recordsDocument = $recordsDocument->where('establishment_id', $establishment_id);
        }
        // [1,2,3,4,5,6,7,8,9]
        //[[1,2,3],...]

        $recordsDocument->chunk(50, function ($documents)
        use (&$items, &$total, &$categoria_id, $item_id_variation, $item_id) {

            foreach ($documents as  $document) {
                $total_items = 0;
                $documents_items = $document->items; //nogal
                // $documents_items = DocumentItem::where('document_id',$document->id)->get();
                if ($item_id) {
                    $documents_items = $documents_items->where('item_id', $item_id);
                }
                if ($item_id_variation) {
                    $documents_items = $documents_items->where('item_id', '<>', $item_id_variation);
                }

                foreach ($documents_items as  $d_it) {

                    $item = is_string($d_it->item) ? json_decode($d_it->item, true) : (array) $d_it->item;


                    if (isset($item['categoriaMadera'])) {
                        $selectedAncho = isset($item['categoriaMadera']->selectedAncho) ? $item['categoriaMadera']->selectedAncho : '';
                        $selectedLargo = isset($item['categoriaMadera']->selectedLargo) ? $item['categoriaMadera']->selectedLargo : '';
                        $selectedGrosor = isset($item['categoriaMadera']->selectedGrosor) ? $item['categoriaMadera']->selectedGrosor : '';
                    } else {
                        $selectedAncho = $selectedLargo = $selectedGrosor = null;
                    }

                    if ($categoria_id == null) {
                        $item = $d_it->item;
                        $factor = null;
                        $unit_type = null;
                        $unit_item =  $d_it->relation_item->unit_type->description;
                        $purchase_unit_price =  $d_it->relation_item->purchase_unit_price;
                        $max_quantity_item = null;
                        if ($d_it->relation_item->max_quantity) {
                            $max_quantity_item = $d_it->relation_item->max_quantity;
                            $purchase_unit_price /= $d_it->m_item->max_quantity;
                            $uit = ItemUnitType::where('quantity_unit', $d_it->m_item->max_quantity)->where('item_id', $d_it->item_id)->first();
                            if ($uit) {
                                $unit_type = $uit->unit_type->description;
                            }
                        }
                        $unit_type_name = null;
                        $quantity = $d_it->quantity;
                        if (isset($item->has_unit_type)) {
                            $uit = ItemUnitType::where('description', $item->has_unit_type)->where('item_id', $d_it->item_id)->first();
                            if ($uit) {
                                $unit_type_name = $item->has_unit_type;
                                $factor = floatval($uit->quantity_unit);
                                $quantity *= $factor;
                            }
                        }

                        $total += $d_it->total;
                        $total_items += $d_it->total;
                        if (array_key_exists($d_it->item_id, $items)) {
                            //[1,2,3,4,5]
                            //[0=>1,1=>3]

                            $price = $d_it->unit_price;

                            if (array_key_exists($price, $items[$d_it->item_id]["prices"])) {
                                $items[$d_it->item_id]["prices"][$price]["count"] +=  $d_it->quantity;
                            } else {
                                $items[$d_it->item_id]["prices"][$price] =  [
                                    "count" =>  $d_it->quantity,
                                    "factor" => $factor,
                                    "unit_type_name" => $unit_type_name,
                                    "selectedAncho" => $selectedAncho,
                                    "selectedLargo" => $selectedLargo,
                                    "selectedGrosor" => $selectedGrosor,
                                ];
                            }
                            $items[$d_it->item_id]["count"] +=   $quantity;
                            $items[$d_it->item_id]["total"] += $d_it->unit_price * $d_it->quantity;
                        } else {

                            $items[$d_it->item_id] = [
                                "description" => $d_it->item->description,
                                "count" => $quantity,
                                "purchase_unit_price" => $purchase_unit_price,
                                "total" => $d_it->total,
                                "unit_type" => $unit_type,
                                "factor" => $factor,
                                "max_quantity_item" => $max_quantity_item,
                                "unit_type_name" => $unit_type_name,
                                "unit_item" => $unit_item,
                                "prices" => [
                                    $d_it->unit_price => [
                                        "count" =>  $d_it->quantity,
                                        "factor" => $factor,
                                        "unit_type_name" => $unit_type_name,
                                        "selectedAncho" => $selectedAncho,
                                        "selectedLargo" => $selectedLargo,
                                        "selectedGrosor" => $selectedGrosor,
                                    ]
                                ],
                            ];
                        }
                    } else {
                        //'categor8ia no es nulla '
                        $item = $d_it->item;

                        $itemCattegoria =  Item::findOrFail($d_it->item_id);

                        if ($itemCattegoria->category_id == $categoria_id) {
                            $factor = null;
                            $unit_type = null;
                            $unit_item =  $d_it->relation_item->unit_type->description;
                            $purchase_unit_price =  $d_it->relation_item->purchase_unit_price;
                            $max_quantity_item = null;
                            if ($d_it->relation_item->max_quantity) {
                                $max_quantity_item = $d_it->relation_item->max_quantity;
                                $purchase_unit_price /= $d_it->m_item->max_quantity;
                                $uit = ItemUnitType::where('quantity_unit', $d_it->m_item->max_quantity)->where('item_id', $d_it->item_id)->first();
                                if ($uit) {
                                    $unit_type = $uit->unit_type->description;
                                }
                            }
                            $unit_type_name = null;
                            $quantity = $d_it->quantity;
                            if (isset($item->has_unit_type)) {
                                $uit = ItemUnitType::where('description', $item->has_unit_type)->where('item_id', $d_it->item_id)->first();
                                if ($uit) {
                                    $unit_type_name = $item->has_unit_type;
                                    $factor = floatval($uit->quantity_unit);
                                    $quantity *= $factor;
                                }
                            }


                            $total += $d_it->total;
                            $total_items += $d_it->total;
                            if (array_key_exists($d_it->item_id, $items)) {

                                $price = $d_it->unit_price;

                                if (array_key_exists($price, $items[$d_it->item_id]["prices"])) {
                                    $items[$d_it->item_id]["prices"][$price]["count"] +=  $d_it->quantity;
                                } else {
                                    $items[$d_it->item_id]["prices"][$price] =  [
                                        "count" =>  $d_it->quantity,
                                        "factor" => $factor,
                                        "unit_type_name" => $unit_type_name,
                                        "selectedAncho" => $selectedAncho,
                                        "selectedLargo" => $selectedLargo,
                                        "selectedGrosor" => $selectedGrosor,
                                    ];
                                }
                                $items[$d_it->item_id]["count"] +=   $quantity;
                                $items[$d_it->item_id]["total"] += $d_it->unit_price * $d_it->quantity;
                            } else {
                                $items[$d_it->item_id] = [
                                    "description" => $d_it->item->description,
                                    "count" => $quantity,
                                    "purchase_unit_price" => $purchase_unit_price,
                                    "total" => $d_it->total,
                                    "unit_type" => $unit_type,
                                    "factor" => $factor,
                                    "max_quantity_item" => $max_quantity_item,
                                    "unit_type_name" => $unit_type_name,
                                    "unit_item" => $unit_item,
                                    "prices" => [
                                        $d_it->unit_price => [
                                            "count" =>  $d_it->quantity,
                                            "factor" => $factor,
                                            "unit_type_name" => $unit_type_name,
                                            "selectedAncho" => $selectedAncho,
                                            "selectedLargo" => $selectedLargo,
                                            "selectedGrosor" => $selectedGrosor,
                                        ]
                                    ],
                                ];
                            }
                        }
                    }
                }
            }
        });
        $recordsSaleNote = SaleNote::where('state_type_id', '<>', 11);
        if ($date_start) {
            if ($date_end) {
                $recordsSaleNote = $recordsSaleNote->whereBetween('date_of_issue', [$date_start, $date_end]);
            } else {
                $recordsSaleNote = $recordsSaleNote->whereDate('date_of_issue', '=', $date_start);
            }
        }

        if ($establishment_id) {
            $recordsSaleNote = $recordsSaleNote->where('establishment_id', $establishment_id);
        }

        $recordsSaleNote->chunk(50, function ($sale_notes)

        use (&$items, &$total, &$categoria_id, $item_id) {

            foreach ($sale_notes as  $sale_note) {

                $total_items = 0;
                $sale_notes_items = SaleNoteItem::where('sale_note_id', $sale_note->id);

                if ($item_id) {
                    $sale_notes_items = $sale_notes_items->where('item_id', $item_id);
                }
                $sale_notes_items = $sale_notes_items->get();

                foreach ($sale_notes_items as  $d_it) {

                    $item = is_string($d_it->item) ? json_decode($d_it->item, true) : (array) $d_it->item;

                    if (isset($item['categoriaMadera'])) {
                        $selectedAncho = isset($item['categoriaMadera']->selectedAncho) ? $item['categoriaMadera']->selectedAncho : '';
                        $selectedLargo = isset($item['categoriaMadera']->selectedLargo) ? $item['categoriaMadera']->selectedLargo : '';
                        $selectedGrosor = isset($item['categoriaMadera']->selectedGrosor) ? $item['categoriaMadera']->selectedGrosor : '';
                    } else {
                        // Asignar valores vacíos si 'categoriaMadera' no existe
                        $selectedAncho = $selectedLargo = $selectedGrosor = null;
                    }

                    if ($categoria_id == null) {
                        $item = $d_it->item;
                        $catI = $d_it->item->category;
                        if ($catI != null) {
                            if (gettype($catI) == "string") {
                                $categ = CategoryItem::where('name', $catI)->first();
                                $catItem = $categ->id;
                            } else {

                                $catItem = $d_it->item->category->id;
                            }

                            $factor = null;
                            $unit_type = null;
                            $max_quantity_item = null;
                            $unit_item =  $d_it->relation_item->unit_type->description;
                            $purchase_unit_price =  $d_it->relation_item->purchase_unit_price;
                            if ($d_it->relation_item->max_quantity) {
                                $purchase_unit_price /= $d_it->relation_item->max_quantity;
                                $max_quantity_item = $d_it->relation_item->max_quantity;
                                $uit = ItemUnitType::where('quantity_unit', $d_it->relation_item->max_quantity)->where('item_id', $d_it->item_id)->first();
                                if ($uit) {
                                    $unit_type = $uit->unit_type->description;
                                }
                            }
                            $unit_type_name = null;
                            $quantity = $d_it->quantity;
                            if (isset($item->from_unit_type_id)) {
                                $uit_id = $item->from_unit_type_id;
                                foreach ($item->item_unit_types as $iut) {
                                    if ($uit_id == $iut->id) {
                                        $factor = floatval($iut->quantity_unit);
                                        $unit_type_name = $iut->description;
                                        $quantity *= $factor;
                                        break;
                                    }
                                }
                            }
                            $total += $d_it->total;
                            $total_items += $d_it->total;
                            if (array_key_exists($d_it->item_id, $items)) {

                                $price = $d_it->unit_price;

                                if (array_key_exists($price, $items[$d_it->item_id]["prices"])) {
                                    $items[$d_it->item_id]["prices"][$price]["count"] +=  $d_it->quantity;
                                } else {

                                    $items[$d_it->item_id]["prices"][$price] =  [
                                        "count" =>  $d_it->quantity,
                                        "factor" => $factor,
                                        "unit_type_name" => $unit_type_name,
                                        "selectedAncho" => $selectedAncho,
                                        "selectedLargo" => $selectedLargo,
                                        "selectedGrosor" => $selectedGrosor,
                                    ];
                                }
                                $items[$d_it->item_id]["count"] +=  $quantity;
                                $items[$d_it->item_id]["total"] += $d_it->unit_price * $d_it->quantity;
                            } else {
                                $items[$d_it->item_id] = [
                                    "description" => $d_it->item->description,
                                    "count" =>  $quantity,
                                    "purchase_unit_price" => $purchase_unit_price,
                                    "total" => $d_it->total,
                                    "factor" => $factor,
                                    "unit_type" => $unit_type,
                                    "max_quantity_item" => $max_quantity_item,
                                    "unit_type_name" => $unit_type_name,
                                    "unit_item" => $unit_item,
                                    "prices" => [
                                        $d_it->unit_price => [
                                            "count" =>  $d_it->quantity,
                                            "factor" => $factor,
                                            "unit_type_name" => $unit_type_name,
                                            "selectedAncho" => $selectedAncho,
                                            "selectedLargo" => $selectedLargo,
                                            "selectedGrosor" => $selectedGrosor,
                                        ]
                                    ],
                                ];
                            }
                        }
                    } else {

                        $item = $d_it->item;
                        $catItem = $d_it->item->category->id;

                        if ($catItem == $categoria_id) {
                            $factor = null;
                            $unit_type = null;
                            $max_quantity_item = null;
                            $unit_item =  $d_it->relation_item->unit_type->description;
                            $purchase_unit_price =  $d_it->relation_item->purchase_unit_price;
                            if ($d_it->relation_item->max_quantity) {
                                $purchase_unit_price /= $d_it->relation_item->max_quantity;
                                $max_quantity_item = $d_it->relation_item->max_quantity;
                                $uit = ItemUnitType::where('quantity_unit', $d_it->relation_item->max_quantity)->where('item_id', $d_it->item_id)->first();
                                if ($uit) {
                                    $unit_type = $uit->unit_type->description;
                                }
                            }
                            $unit_type_name = null;
                            $quantity = $d_it->quantity;
                            if (isset($item->from_unit_type_id)) {
                                $uit_id = $item->from_unit_type_id;
                                foreach ($item->item_unit_types as $iut) {
                                    if ($uit_id == $iut->id) {
                                        $factor = floatval($iut->quantity_unit);
                                        $unit_type_name = $iut->description;
                                        $quantity *= $factor;
                                        break;
                                    }
                                }
                            }
                            $total += $d_it->total;
                            $total_items += $d_it->total;
                            if (array_key_exists($d_it->item_id, $items)) {

                                $price = $d_it->unit_price;

                                if (array_key_exists($price, $items[$d_it->item_id]["prices"])) {
                                    $items[$d_it->item_id]["prices"][$price]["count"] +=  $d_it->quantity;
                                } else {

                                    $items[$d_it->item_id]["prices"][$price] =  [
                                        "count" =>  $d_it->quantity,
                                        "factor" => $factor,
                                        "unit_type_name" => $unit_type_name,
                                        "selectedAncho" => $selectedAncho,
                                        "selectedLargo" => $selectedLargo,
                                        "selectedGrosor" => $selectedGrosor,
                                    ];
                                }
                                $items[$d_it->item_id]["count"] +=  $quantity;
                                $items[$d_it->item_id]["total"] += $d_it->unit_price * $d_it->quantity;
                            } else {
                                $items[$d_it->item_id] = [
                                    "description" => $d_it->item->description,
                                    "count" =>  $quantity,
                                    "purchase_unit_price" => $purchase_unit_price,
                                    "total" => $d_it->total,
                                    "factor" => $factor,
                                    "unit_type" => $unit_type,
                                    "max_quantity_item" => $max_quantity_item,
                                    "unit_type_name" => $unit_type_name,
                                    "unit_item" => $unit_item,
                                    "prices" => [
                                        $d_it->unit_price => [
                                            "count" =>  $d_it->quantity,
                                            "factor" => $factor,
                                            "unit_type_name" => $unit_type_name,
                                            "selectedAncho" => $selectedAncho,
                                            "selectedLargo" => $selectedLargo,
                                            "selectedGrosor" => $selectedGrosor,
                                        ]
                                    ],
                                ];
                            }
                        }
                    }
                }
            }
        });
        return compact(
            'total',
            'items'
        );
    } */

    public function report_cash(Request $request)
    {
        ini_set('max_execution_time', "3000");
        ini_set('memory_limit', '2048M');
        $categoria_id = $request->categoria_id;
        $item_id = $request->item_id;
        $establishment_id = $request->establishment_id;
        $date_start = $request->date_start ? Carbon::parse($request->date_start)->format("y-m-d") : null;
        $date_end = $request->date_end ? Carbon::parse($request->date_end)->format("y-m-d") : null;
        $month = 11;
        $items = [];
        $total = 0;

        //total venta -> jalar documentos
        $recordsDocument =  Document::whereNotIn('state_type_id', ['09', '11']);
        if ($date_start) {
            if ($date_end) {
                $recordsDocument = $recordsDocument->whereBetween('date_of_issue', [$date_start, $date_end]);
            } else {
                $recordsDocument = $recordsDocument->whereDate('date_of_issue', '=', $date_start);
            }
        }
        $config = Configuration::first();
        $item_id_variation = $config->item_variation_id;
        if ($establishment_id) {
            $recordsDocument = $recordsDocument->where('establishment_id', $establishment_id);
        }
        // [1,2,3,4,5,6,7,8,9]
        //[[1,2,3],...]

        $recordsDocument->chunk(50, function ($documents)
        use (&$items, &$total, &$categoria_id, $item_id_variation, $item_id) {

            foreach ($documents as  $document) {
                $total_items = 0;
                $documents_items = $document->items; //nogal
                // $documents_items = DocumentItem::where('document_id',$document->id)->get();
                if ($item_id) {
                    $documents_items = $documents_items->where('item_id', $item_id);
                }
                if ($item_id_variation) {
                    $documents_items = $documents_items->where('item_id', '<>', $item_id_variation);
                }

                foreach ($documents_items as  $d_it) {

                    $item = is_string($d_it->item) ? json_decode($d_it->item, true) : (array) $d_it->item;


                    if (isset($item['categoriaMadera'])) {
                        $selectedAncho = isset($item['categoriaMadera']->selectedAncho) ? $item['categoriaMadera']->selectedAncho : '';
                        $selectedLargo = isset($item['categoriaMadera']->selectedLargo) ? $item['categoriaMadera']->selectedLargo : '';
                        $selectedGrosor = isset($item['categoriaMadera']->selectedGrosor) ? $item['categoriaMadera']->selectedGrosor : '';
                    } else {
                        $selectedAncho = $selectedLargo = $selectedGrosor = null;
                    }

                    if ($categoria_id == null) {
                        $item = $d_it->item;
                        $factor = null;
                        $unit_type = null;
                        $unit_item =  $d_it->relation_item->unit_type->description;
                        $purchase_unit_price =  $d_it->relation_item->purchase_unit_price;
                        if ($d_it->affectation_igv_type_id == '10') {
                            $purchase_unit_price /= 1.18;
                        }
                        $max_quantity_item = null;
                        if ($d_it->relation_item->max_quantity) {
                            $max_quantity_item = $d_it->relation_item->max_quantity;
                            $purchase_unit_price /= $d_it->m_item->max_quantity;
                            $uit = ItemUnitType::where('quantity_unit', $d_it->m_item->max_quantity)->where('item_id', $d_it->item_id)->first();
                            if ($uit) {
                                $unit_type = $uit->unit_type->description;
                            }
                        }
                        $unit_type_name = null;
                        $quantity = $d_it->quantity;
                        if (isset($item->has_unit_type)) {
                            $uit = ItemUnitType::where('description', $item->has_unit_type)->where('item_id', $d_it->item_id)->first();
                            if ($uit) {
                                $unit_type_name = $item->has_unit_type;
                                $factor = floatval($uit->quantity_unit);
                                $quantity *= $factor;
                            }
                        }

                        $total += $d_it->total_value;
                        $total_items += $d_it->total_value;
                        if (array_key_exists($d_it->item_id, $items)) {
                            //[1,2,3,4,5]
                            //[0=>1,1=>3]

                            $price = $d_it->unit_price;

                            if (array_key_exists($price, $items[$d_it->item_id]["prices"])) {
                                $items[$d_it->item_id]["prices"][$price]["count"] +=  $d_it->quantity;
                            } else {
                                $items[$d_it->item_id]["prices"][$price] =  [
                                    "count" =>  $d_it->quantity,
                                    "factor" => $factor,
                                    "unit_type_name" => $unit_type_name,
                                    "selectedAncho" => $selectedAncho,
                                    "selectedLargo" => $selectedLargo,
                                    "selectedGrosor" => $selectedGrosor,
                                ];
                            }
                            $items[$d_it->item_id]["count"] +=   $quantity;
                            //$items[$d_it->item_id]["total"] += $d_it->unit_price * $d_it->quantity;
                            $items[$d_it->item_id]["total"] += $d_it->total_value;
                        } else {

                            $items[$d_it->item_id] = [
                                "description" => $d_it->item->description,

                                "count" => $quantity,
                                "purchase_unit_price" => $purchase_unit_price,
                                "total" => $d_it->total_value,
                                "unit_type" => $unit_type,
                                "factor" => $factor,
                                "max_quantity_item" => $max_quantity_item,
                                "unit_type_name" => $unit_type_name,
                                "unit_item" => $unit_item,
                                "prices" => [
                                    $d_it->unit_price => [
                                        "count" =>  $d_it->quantity,
                                        "factor" => $factor,
                                        "unit_type_name" => $unit_type_name,
                                        "selectedAncho" => $selectedAncho,
                                        "selectedLargo" => $selectedLargo,
                                        "selectedGrosor" => $selectedGrosor,
                                    ]
                                ],
                            ];
                        }
                    } else {
                        //'categor8ia no es nulla '
                        $item = $d_it->item;

                        $itemCattegoria =  Item::findOrFail($d_it->item_id);

                        if ($itemCattegoria->category_id == $categoria_id) {
                            $factor = null;
                            $unit_type = null;
                            $unit_item =  $d_it->relation_item->unit_type->description;
                            $purchase_unit_price =  $d_it->relation_item->purchase_unit_price;
                            if ($d_it->affectation_igv_type_id == '10') {
                                $purchase_unit_price /= 1.18;
                            }
                            $max_quantity_item = null;
                            if ($d_it->relation_item->max_quantity) {
                                $max_quantity_item = $d_it->relation_item->max_quantity;
                                $purchase_unit_price /= $d_it->m_item->max_quantity;
                                $uit = ItemUnitType::where('quantity_unit', $d_it->m_item->max_quantity)->where('item_id', $d_it->item_id)->first();
                                if ($uit) {
                                    $unit_type = $uit->unit_type->description;
                                }
                            }
                            $unit_type_name = null;
                            $quantity = $d_it->quantity;
                            if (isset($item->has_unit_type)) {
                                $uit = ItemUnitType::where('description', $item->has_unit_type)->where('item_id', $d_it->item_id)->first();
                                if ($uit) {
                                    $unit_type_name = $item->has_unit_type;
                                    $factor = floatval($uit->quantity_unit);
                                    $quantity *= $factor;
                                }
                            }


                            $total += $d_it->total;
                            $total_items += $d_it->total;
                            if (array_key_exists($d_it->item_id, $items)) {

                                $price = $d_it->unit_price;

                                if (array_key_exists($price, $items[$d_it->item_id]["prices"])) {
                                    $items[$d_it->item_id]["prices"][$price]["count"] +=  $d_it->quantity;
                                } else {
                                    $items[$d_it->item_id]["prices"][$price] =  [
                                        "count" =>  $d_it->quantity,
                                        "factor" => $factor,
                                        "unit_type_name" => $unit_type_name,
                                        "selectedAncho" => $selectedAncho,
                                        "selectedLargo" => $selectedLargo,
                                        "selectedGrosor" => $selectedGrosor,
                                    ];
                                }
                                $items[$d_it->item_id]["count"] +=   $quantity;
                                /* $items[$d_it->item_id]["total"] += $d_it->unit_price * $d_it->quantity; */
                                $items[$d_it->item_id]["total"] += $d_it->total_value;
                            } else {

                                $items[$d_it->item_id] = [
                                    "description" => $d_it->item->description,

                                    "count" => $quantity,
                                    "purchase_unit_price" => $purchase_unit_price,
                                    "total" => $d_it->total_value,
                                    "unit_type" => $unit_type,
                                    "factor" => $factor,
                                    "max_quantity_item" => $max_quantity_item,
                                    "unit_type_name" => $unit_type_name,
                                    "unit_item" => $unit_item,
                                    "prices" => [
                                        $d_it->unit_price => [
                                            "count" =>  $d_it->quantity,
                                            "factor" => $factor,
                                            "unit_type_name" => $unit_type_name,
                                            "selectedAncho" => $selectedAncho,
                                            "selectedLargo" => $selectedLargo,
                                            "selectedGrosor" => $selectedGrosor,
                                        ]
                                    ],
                                ];
                            }
                        }
                    }
                }
            }
        });
        $recordsSaleNote = SaleNote::where('state_type_id', '<>', 11);
        if ($date_start) {
            if ($date_end) {
                $recordsSaleNote = $recordsSaleNote->whereBetween('date_of_issue', [$date_start, $date_end]);
            } else {
                $recordsSaleNote = $recordsSaleNote->whereDate('date_of_issue', '=', $date_start);
            }
        }

        if ($establishment_id) {
            $recordsSaleNote = $recordsSaleNote->where('establishment_id', $establishment_id);
        }

        $recordsSaleNote->chunk(50, function ($sale_notes)

        use (&$items, &$total, &$categoria_id, $item_id) {

            foreach ($sale_notes as  $sale_note) {

                $total_items = 0;
                $sale_notes_items = SaleNoteItem::where('sale_note_id', $sale_note->id);

                if ($item_id) {
                    $sale_notes_items = $sale_notes_items->where('item_id', $item_id);
                }
                $sale_notes_items = $sale_notes_items->get();

                foreach ($sale_notes_items as  $d_it) {

                    $item = is_string($d_it->item) ? json_decode($d_it->item, true) : (array) $d_it->item;

                    if (isset($item['categoriaMadera'])) {
                        $selectedAncho = isset($item['categoriaMadera']->selectedAncho) ? $item['categoriaMadera']->selectedAncho : '';
                        $selectedLargo = isset($item['categoriaMadera']->selectedLargo) ? $item['categoriaMadera']->selectedLargo : '';
                        $selectedGrosor = isset($item['categoriaMadera']->selectedGrosor) ? $item['categoriaMadera']->selectedGrosor : '';
                    } else {
                        // Asignar valores vacíos si 'categoriaMadera' no existe
                        $selectedAncho = $selectedLargo = $selectedGrosor = null;
                    }

                    if ($categoria_id == null) {
                        $item = $d_it->item;
                        $catI = $d_it->item->category;
                        if ($catI != null) {
                            if (gettype($catI) == "string") {
                                $categ = CategoryItem::where('name', $catI)->first();
                                $catItem = $categ->id;
                            } else {

                                $catItem = $d_it->item->category->id;
                            }

                            $factor = null;
                            $unit_type = null;
                            $max_quantity_item = null;
                            $unit_item =  $d_it->relation_item->unit_type->description;
                            $purchase_unit_price =  $d_it->relation_item->purchase_unit_price;
                            if ($d_it->affectation_igv_type_id == '10') {
                                $purchase_unit_price /= 1.18;
                            }
                            if ($d_it->relation_item->max_quantity) {
                                $purchase_unit_price /= $d_it->relation_item->max_quantity;
                                $max_quantity_item = $d_it->relation_item->max_quantity;
                                $uit = ItemUnitType::where('quantity_unit', $d_it->relation_item->max_quantity)->where('item_id', $d_it->item_id)->first();
                                if ($uit) {
                                    $unit_type = $uit->unit_type->description;
                                }
                            }
                            $unit_type_name = null;
                            $quantity = $d_it->quantity;
                            if (isset($item->from_unit_type_id)) {
                                $uit_id = $item->from_unit_type_id;
                                foreach ($item->item_unit_types as $iut) {
                                    if ($uit_id == $iut->id) {
                                        $factor = floatval($iut->quantity_unit);
                                        $unit_type_name = $iut->description;
                                        $quantity *= $factor;
                                        break;
                                    }
                                }
                            }
                            $total += $d_it->total_value;
                            $total_items += $d_it->total_value;
                            if (array_key_exists($d_it->item_id, $items)) {

                                $price = $d_it->unit_price;

                                if (array_key_exists($price, $items[$d_it->item_id]["prices"])) {
                                    $items[$d_it->item_id]["prices"][$price]["count"] +=  $d_it->quantity;
                                } else {

                                    $items[$d_it->item_id]["prices"][$price] =  [
                                        "count" =>  $d_it->quantity,
                                        "factor" => $factor,
                                        "unit_type_name" => $unit_type_name,
                                        "selectedAncho" => $selectedAncho,
                                        "selectedLargo" => $selectedLargo,
                                        "selectedGrosor" => $selectedGrosor,
                                    ];
                                }
                                $items[$d_it->item_id]["count"] +=  $quantity;
                                //$items[$d_it->item_id]["total"] += $d_it->unit_price * $d_it->quantity;
                                $items[$d_it->item_id]["total"] += $d_it->total_value;
                            } else {
                                $items[$d_it->item_id] = [
                                    "description" => $d_it->item->description,
                                    "count" =>  $quantity,
                                    "purchase_unit_price" => $purchase_unit_price,
                                    "total" => $d_it->total_value,
                                    "factor" => $factor,
                                    "unit_type" => $unit_type,
                                    "max_quantity_item" => $max_quantity_item,
                                    "unit_type_name" => $unit_type_name,
                                    "unit_item" => $unit_item,
                                    "prices" => [
                                        $d_it->unit_price => [
                                            "count" =>  $d_it->quantity,
                                            "factor" => $factor,
                                            "unit_type_name" => $unit_type_name,
                                            "selectedAncho" => $selectedAncho,
                                            "selectedLargo" => $selectedLargo,
                                            "selectedGrosor" => $selectedGrosor,
                                        ]
                                    ],
                                ];
                            }
                        }
                    } else {

                        $item = $d_it->item;
                        $catItem = $d_it->item->category->id;

                        if ($catItem == $categoria_id) {
                            $factor = null;
                            $unit_type = null;
                            $max_quantity_item = null;
                            $unit_item =  $d_it->relation_item->unit_type->description;
                            $purchase_unit_price =  $d_it->relation_item->purchase_unit_price;
                            if ($d_it->affectation_igv_type_id == '10') {
                                $purchase_unit_price /= 1.18;
                            }
                            if ($d_it->relation_item->max_quantity) {
                                $purchase_unit_price /= $d_it->relation_item->max_quantity;
                                $max_quantity_item = $d_it->relation_item->max_quantity;
                                $uit = ItemUnitType::where('quantity_unit', $d_it->relation_item->max_quantity)->where('item_id', $d_it->item_id)->first();
                                if ($uit) {
                                    $unit_type = $uit->unit_type->description;
                                }
                            }
                            $unit_type_name = null;
                            $quantity = $d_it->quantity;
                            if (isset($item->from_unit_type_id)) {
                                $uit_id = $item->from_unit_type_id;
                                foreach ($item->item_unit_types as $iut) {
                                    if ($uit_id == $iut->id) {
                                        $factor = floatval($iut->quantity_unit);
                                        $unit_type_name = $iut->description;
                                        $quantity *= $factor;
                                        break;
                                    }
                                }
                            }
                            $total += $d_it->total;
                            $total_items += $d_it->total;
                            if (array_key_exists($d_it->item_id, $items)) {

                                $price = $d_it->unit_price;

                                if (array_key_exists($price, $items[$d_it->item_id]["prices"])) {
                                    $items[$d_it->item_id]["prices"][$price]["count"] +=  $d_it->quantity;
                                } else {

                                    $items[$d_it->item_id]["prices"][$price] =  [
                                        "count" =>  $d_it->quantity,
                                        "factor" => $factor,
                                        "unit_type_name" => $unit_type_name,
                                        "selectedAncho" => $selectedAncho,
                                        "selectedLargo" => $selectedLargo,
                                        "selectedGrosor" => $selectedGrosor,
                                    ];
                                }
                                $items[$d_it->item_id]["count"] +=  $quantity;
                                //$items[$d_it->item_id]["total"] += $d_it->unit_price * $d_it->quantity;
                                $items[$d_it->item_id]["total"] += $d_it->total_value;
                            } else {
                                $items[$d_it->item_id] = [
                                    "description" => $d_it->item->description,
                                    "count" =>  $quantity,
                                    "purchase_unit_price" => $purchase_unit_price,
                                    "total" => $d_it->total_value,
                                    "factor" => $factor,
                                    "unit_type" => $unit_type,
                                    "max_quantity_item" => $max_quantity_item,
                                    "unit_type_name" => $unit_type_name,
                                    "unit_item" => $unit_item,
                                    "prices" => [
                                        $d_it->unit_price => [
                                            "count" =>  $d_it->quantity,
                                            "factor" => $factor,
                                            "unit_type_name" => $unit_type_name,
                                            "selectedAncho" => $selectedAncho,
                                            "selectedLargo" => $selectedLargo,
                                            "selectedGrosor" => $selectedGrosor,
                                        ]
                                    ],
                                ];
                            }
                        }
                    }
                }
            }
        });
        return compact(
            'total',
            'items'
        );
    }

    public function incomes_expenses(Request $request)
    {
        $is_expenses =  $request->isExpenses == "true" ? true : false;
        $cash_id = $request->cashId;

        $records = Box::where('cash_id', $cash_id);
        if ($is_expenses) {
            $records = $records->where('expenses', 1);
        } else {
            $records = $records->where('incomes', 1);
        }

        return new BoxCollection($records->paginate(20));
    }

    public function get_last_documents(Request $request)
    {
        $user = auth()->user();
        $type_document = $request->typeDocument;
        $establishment_id = auth()->user()->establishment_id;

        $seriesIds = $user->series()->pluck('user_id');

        $hasSeriesAssigned = $seriesIds->count() > 0;

        $model = null;
        switch ($type_document) {
            case 'documents':
                $model = Document::class;
                break;
            case 'saleNotes':
                $model = SaleNote::class;
                break;
            default:
                $model = Quotation::class;
                break;
        }
        $company = Company::active();
        $documents = $model::where('establishment_id', $establishment_id);
        if ($company->soap_type_id != '01') {
            $documents = $documents->where('soap_type_id', $company->soap_type_id);
        }
        if ($hasSeriesAssigned) {
            $documents = $documents->whereIn('user_id', $seriesIds);
        }
        // $documents = $is_note_sale ?  SaleNote::where('establishment_id', $establishment_id) : Document::where('establishment_id', $establishment_id);
        $column = $request->column ?? "description";
        $value = $request->value;
        $remain = $request->remain == "true" ? true : false;
        if ($value) {
            if ($column == 'date') {
                $documents = $documents->whereDate('date_of_issue', $value);
            } else if (
                $column == "document"
            ) {
                $documents = $documents->where('number', $value);
            } else {
                $documents = $documents->whereHas('person', function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')->orWhere('number', 'like', '%' . $value . '%')
                        ->orWhere('alias', 'like', '%' . $value . '%');
                });
            }
        }

        if ($remain && $type_document == "documents") {
            $documents = $documents->where('payment_condition_id', '02')
                ->where('total_canceled', 0);
        }

        $documents->orderBy('date_of_issue', 'desc')->orderBy('id', 'desc');
        $result = null;
        switch ($type_document) {
            case 'documents':
                $result = new DocumentCollection($documents->paginate(10));
                break;
            case 'saleNotes':
                $result = new SaleNoteCollection($documents->paginate(10));
                break;
            default:
                $result = new QuotationCollection($documents->paginate(10));
                break;
        }
        // if ($is_note_sale) {
        //     return new SaleNoteCollection($documents->paginate(10));
        // } else {
        //     return new DocumentCollection($documents->paginate(10));
        // }

        return $result;
    }

    public function get_printer($area_id)
    {
        $printer = null;

        $area = Area::find($area_id);
        if ($area) {
            $printer = $area->printer;
        }

        if ($printer == null) {
            $establishment = Establishment::find(auth()->user()->establishment_id);
            $printer = $establishment->printer;
        }

        return compact('printer');
    }

    function get_items_from_box($cash_id)
    {
        $boxes = Box::where('cash_id', $cash_id)->get();
        $all_items = [];
        $all_documents = [
            "facturas" => 0,
            "boletas" => 0,
            "notas" => 0,
        ];
        $totalCategory = 0;
        $documents = [];
        $categories = [];
        $grouped = []; // Inicializa el array para agrupar

        foreach ($boxes as $box) {
            if ($box->document_id) {
                $document = Document::find($box->document_id);
                $name_document = $document->getNumberFullAttribute();
                $column = array_column($documents, 'name');
                if (!in_array($name_document, $column)) {
                    if ($document != null) {
                        if ($document->document_type_id == '03') {
                            $all_documents["boletas"] += $document->total;
                        } else {
                            $all_documents["facturas"] += $document->total;
                        }
                        $documents[] = [
                            "name" => $document->getNumberFullAttribute(),
                            "total" => $document->total,
                        ];
                        $items = $document->items;
                        foreach ($items as $item) {
                            $item_db = Item::find($item->item_id);
                            if ($item_db->category) {
                                $category_name = $item_db->category->name;
                            } else {
                                $category_name = 'Sin categoría';
                            }

                            // Verificar si el producto ya existe en el grupo
                            if (!isset($grouped[$category_name])) {
                                $grouped[$category_name] = [];
                            }

                            $found = false;
                            foreach ($grouped[$category_name] as &$grouped_item) {
                                if ($grouped_item['description'] == $item_db->description) {
                                    $grouped_item['quantity'] += $item->quantity;
                                    $grouped_item['total'] += $item->total;
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                $grouped[$category_name][] = [
                                    "price" => $item->unit_price,
                                    "description" => $item_db->description,
                                    "quantity" => $item->quantity,
                                    "total" => $item->total
                                ];
                            }

                            // Actualizar el total de la categoría
                            if (array_key_exists($category_name, $categories)) {
                                $categories[$category_name] += $item->total;
                            } else {
                                $categories[$category_name] = $item->total;
                            }
                        }
                    }
                }
            }
            if ($box->sale_note_id) {
                $sale_note = SaleNote::find($box->sale_note_id);
                $name_sale_note = $sale_note->getNumberFullAttribute();
                $column = array_column($documents, 'name');
                if (!in_array($name_sale_note, $column)) {
                    $documents[] = [
                        "name" => $sale_note->getNumberFullAttribute(),
                        "total" => $sale_note->total,
                    ];

                    $items = SaleNoteItem::where("sale_note_id", $box->sale_note_id)->get();
                    foreach ($items as $item) {

                        $item_db = Item::find($item->item_id);
                        if ($item_db->category) {
                            $category_name = $item_db->category->name;
                        } else {
                            $category_name = 'Sin categoría';
                        }

                        // Verificar si el producto ya existe en el grupo
                        if (!isset($grouped[$category_name])) {
                            $grouped[$category_name] = [];
                        }

                        $found = false;
                        foreach ($grouped[$category_name] as &$grouped_item) {
                            if ($grouped_item['description'] == $item_db->description) {
                                $grouped_item['quantity'] += $item->quantity;
                                $grouped_item['total'] += $item->total;
                                $found = true;
                                break;
                            }
                        }
                        if (!$found) {
                            $grouped[$category_name][] = [
                                "price" => $item->unit_price,
                                "description" => $item_db->description,
                                "quantity" => $item->quantity,
                                "total" => $item->total
                            ];
                        }

                        // Actualizar el total de la categoría
                        if (array_key_exists($category_name, $categories)) {
                            $categories[$category_name] += $item->total;
                        } else {
                            $categories[$category_name] = $item->total;
                        }

                        $all_documents["notas"] += $item->total;
                    }
                }
            }
        }

        // Calcular el total de todas las categorías
        $totalCategory = array_sum($categories);

        return [
            "grouped" => $grouped, // Retornar el array agrupado
            "categories" => $categories,
            "items" => $all_items,
            "documents" => $all_documents,
            "documents_info" => $documents,
            "totalCategory" => $totalCategory,
        ];
    }
    /*  */

    public function print_report(Request $request)
    {
        $cash_id = $request->cash_id;
        $cash = Cash::find($cash_id);
        ini_set('memory_limit', '10096M');
        ini_set('max_execution_time', '30000');
        $company = Company::first();
        $company_number = $company->number;
        $path = storage_path('app/public/report_resumen_pdf_pos_small_' . $cash_id . '_' . $company_number . '.pdf');
        if (file_exists($path) && $cash->state == 0) {
            return response()->file($path);
        }

        $sales = Box::where('cash_id', $cash_id)->where('expenses', 0)->where('incomes', 0)->OrderBy('date', 'asc');
        $sales_quantity = $sales->count();
        $sales_amount = $sales->where('method', '<>', 'Efectivo')->sum('amount');

        $sales_cash = Box::where('method', 'Efectivo')->where('expenses', 0)->where('incomes', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_cash_sum = 0;
        $sales_cash_records = $sales_cash->get();
        foreach ($sales_cash_records as $ringreso) {
            if ($ringreso["sale_note_id"]) {
                $sale_note = SaleNote::find($ringreso["sale_note_id"]);
                $to_sum = 0;
                if ($sale_note->total > $ringreso["amount"]) {

                    $to_sum = $ringreso["amount"];
                } else {
                    $to_sum = $sale_note->total;
                }
                $sales_cash_sum += $to_sum;
            }
            if ($ringreso["document_id"]) {
                $sale_note = Document::find($ringreso["document_id"]);
                $to_sum = 0;
                if ($sale_note->total > $ringreso["amount"]) {
                    $to_sum =  $ringreso["amount"];
                } else {
                    $to_sum = $sale_note->total;
                }
                // $sales_cash_sum += $sale_note->total;
                $sales_cash_sum += $to_sum;
            }
        }
        $sales_amount += $sales_cash_sum;
        $sales_cash_quantity = $sales_cash->count();


        //TARJETA: NIUBIZ

        $sales_izypay = Box::where('type', '1')->where('method', 'TARJETA: IZYPAY')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_izypay_sum = $sales_izypay->sum('amount');
        $sales_izypay_quantity = $sales_izypay->count();
        $sales_izypay_records = $sales_izypay->get();

        $sales_niubiz = Box::where('type', '1')->where('method', 'TARJETA: NIUBIZ')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_niubiz_sum = $sales_niubiz->sum('amount');
        $sales_niubiz_quantity = $sales_niubiz->count();
        $sales_niubiz_records = $sales_niubiz->get();

        $sales_openpay = Box::where('type', '1')->where('method', 'TARJETA: OPENPAY')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_openpay_sum = $sales_openpay->sum('amount');
        $sales_openpay_quantity = $sales_openpay->count();
        $sales_openpay_records = $sales_openpay->get();

        $sales_transfer = Box::where('type', '1')->where('method', 'Transferencia')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_transfer_sum = $sales_transfer->sum('amount');
        $sales_transfer_quantity = $sales_transfer->count();
        $sales_transfer_recors = $sales_transfer->get();

        $sales_bank = Box::where('type', '1')->where('method', 'Deposito Bancario')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_bank_sum = $sales_bank->sum('amount');
        $sales_bank_quantity = $sales_bank->count();
        $sales_bank_recors = $sales_bank->get();

        $sales_card = Box::where('type', '1')->where('method', 'Tarjeta')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_card_sum = $sales_card->sum('amount');
        $sales_card_quantity = $sales_card->count();
        $sales_card_recors = $sales_card->get();


        $sales_yape = Box::where('type', '1')->where('method', 'Yape')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_yape_sum = $sales_yape->sum('amount');
        $sales_yape_quantity = $sales_yape->count();
        $sales_yape_recors = $sales_yape->get();

        $sales_plin = Box::where('type', '1')->where('method', 'PLIN')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_plin_sum = $sales_plin->sum('amount');
        $sales_plin_quantity = $sales_plin->count();
        $sales_plin_recors = $sales_plin->get();

        $sales_culqui = Box::where('type', '1')->where('method', 'Culqui')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_culqui_sum = $sales_culqui->sum('amount');
        $sales_culqui_quantity = $sales_culqui->count();
        $sales_culqui_recors = $sales_culqui->get();

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
        //    $establishment =  auth()->user()->establishment;
        $info = $this->get_items_from_box($cash_id);
        $grouped = $info['grouped'];
        $categories = $info['categories'];
        $totalCategory = $info['totalCategory'];
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
            ],
            "niubiz" => [
                "desc" => "Niubiz",
                "quantity" => $sales_niubiz_quantity,
                "sum" => $sales_niubiz_sum,
            ],
            "openpay" => [
                "desc" => "Openpay",
                "quantity" => $sales_openpay_quantity,
                "sum" => $sales_openpay_sum,
            ]



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

        $date = Carbon::now()->format("d/m/Y");
        $time = Carbon::now()->format("H:i");
        $counter = $cash->counter;



        $total_coins = 0.0;
        $total_cash = $sales_cash_sum;
        $total_coins_virtual = $sales_card_sum +
            $sales_yape_sum +
            $sales_plin_sum +
            $sales_culqui_sum +
            $sales_izypay_sum +
            $sales_niubiz_sum +
            $sales_openpay_sum;
        $counter_length = 0;
        if ($counter != null) {
            $counter_length = count($counter);
            ksort($counter);
            foreach ($counter as $c => $v) {
                $total_coins += floatval($c) * floatval($v);
            }
        }
        $user = User::find($cash->user_id);
        $establishment = Establishment::find($user->establishment_id);

        $receipts = $this->get_receipts($cash_id); // receipts
        // $quantity_receipts = count($receipts);
        $total_receipts = $receipts->sum('amount');
        $documents["recibos"] = $total_receipts;
        $configuration = Configuration::first();
        try {
            $pdf = PDF::loadView('restaurant::cash.ticket_cash', compact(
                "configuration",
                "categories",
                "totalCategory",
                "grouped",
                'user',
                'establishment',
                "total_coins_virtual",
                "total_coins_bank",
                "total_coins",
                "total_cash",
                "sales_quantity",
                "sales_amount",
                "sales_detail",
                "items_detail",
                "incomes_expenses_cash",
                "documents",
                "documents_info",
                "categories",
                "totalCategory",
                "grouped",
                "cash",
                "date",
                "time",
                "counter"
            ))
                ->setPaper(array(0, 0, 249.45, 650 + (100 + $counter_length * 15)));
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }
        $company = Company::first();
        $company_number = $company->number;
        if ($cash->state == 0) {
            $pdf->save(storage_path('app/public/report_resumen_pdf_pos_small_' . $cash->id . '_' . $company_number . '.pdf'));
        }
        return $pdf->stream('pdf_file.pdf');
    }
    function get_receipts($cash_id)
    {
        $receipts = [];
        $receipts = Receipt::where('cash_id', $cash_id)->get()
            ->transform(function ($row) {
                $number = "RC01-" . $row->id;
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
                } else {
                    $box = Box::where('document_id', $row->document_id)
                        ->where('document_payment_id', $row->document_payment_id)
                        ->first();
                }

                $method  = null;

                if ($box) {
                    $method = $box->method;
                }
                $amount = $row->amount;
                if ($row->sale_note) {
                    $paid = (bool) $row->sale_note->paid;
                    $amount_payment = SaleNotePayment::where('sale_note_id', $sale_note_id)->sum('payment');
                    $remaining = number_format($row->sale_note->total - $amount_payment, 2, ".", "");
                } else {
                    $paid = (bool)$row->document->total_canceled;
                    $amount_payment = DocumentPayment::where('document_id', $row->document_id)->sum('payment');
                    $remaining = number_format($row->document->total - $amount_payment, 2, ".", "");
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
    public function index()
    {
        $userid = auth()->user()->id;

        $cajaOpen = DB::connection('tenant')->table('cash')
            ->where('user_id', '=', $userid)
            ->where('state', '=', 1) // 1 indica que la caja esta en estatus abierta
            ->first();
        $cajaOpen = is_null($cajaOpen);
        //false = no pintar  y true = Pintar boton de crear nueva caja


        return view('restaurant::cash.index', compact('userid', 'cajaOpen'));
    }

    public function columns()
    {
        return [
            /* 'income' => 'Ingresos',
            'expense' => 'Egresos', */
            'date_opening' => 'Fecha de Apertura',
            'reference_number' => 'Codigo de Referencias',

        ];
    }
    public function recordsClosed(Request $request)
    {
        $user_id  = $request->input('user_id');
        $date_close = $request->input('date_close');
        $is_principal = $request->input('is_principal');
        $records = Cash::query();
        // $records = Cash::where('state', '=', 0);
        if ($user_id) {
            $records = $records->where('user_id', '=', $user_id);
        }
        if ($date_close) {
            $records = $records->where('date_closed', '=', $date_close);
        }
        if ($is_principal) {
            $records->where('principal', true);
        }
        $records->orderBy('date_opening', 'desc')
            ->orderBy('time_opening', 'desc');

        return new CashCollection($records->paginate(20));
    }
    public function records(Request $request)
    {
        ini_set('memory_limit', '3500M');
        ini_set('max_execution_time', 3000);

        $fromAdmin = $request->input('fromAdmin');
        $is_principal = $request->input('is_principal');
        $from_cash = $request->input('from_cash');
        $records = Cash::query();

        if ($request->column) {
            $records = $records->where($request->column, 'like', "%{$request->value}%");
        }

        $records->whereTypeUser($fromAdmin);
        $records->where('active', 0);
        $records->orderBy('date_opening', 'desc')
            ->orderBy('time_opening', 'desc');

        // if ($from_cash) {
        //     $records = $records->limit(10)->get();
        //     return new CashCollection($records);
        // }

        return new CashCollection($records->paginate(20));
    }

    public function getFinalBalance($id)
    {
        $row = Cash::findOrFail($id)->load(['user', 'user.establishment', 'boxes.salenote', 'boxes.document']);
        $incomes = $row->boxes->where('expenses', 0)->where('incomes', 0)->sum(function ($box) {
            $amount = $box->amount;
            if ($box->salenote) {
                if ($box->sale_note_payment_id) {
                    return $amount;
                } else {
                    return min($box->salenote->total, $amount);
                }
            }
            if ($box->document) {
                return min($box->document->total, $amount);
            }
            return $amount;
        });

        $expense = $row->boxes->where('expenses', 1)->sum('amount');
        $incomes_s = $row->boxes->where('incomes', 1)->sum('amount');

        $final_cash = $row->beginning_balance + $incomes - $expense + $incomes_s;

        return [
            'success' => true,
            'final_balance' => number_format($final_cash, 2, ".", ""),
        ];
    }
    public function create()
    {
        return view('tenant.items.form');
    }

    public function tables()
    {
        $user = auth()->user();
        $type = $user->type;
        $users = array();
        $configuration = Configuration::select(['health_network'])
            ->first();
        /*  */
        $turnsTable = Turns::where('turn_active',  1)->get();
        switch ($type) {
            case 'admin':
                $users = User::where('type', 'seller')->get();
                $users->push($user);
                break;
            case 'superadmin':
                $users = User::query()->get();
                // $users->push($user);
                break;
            case 'seller':
                $users = User::where('id', $user->id)->get();
                break;
        }

        return compact('users', 'configuration', 'user', 'turnsTable');
    }

    public function final_balance_last_principal()
    {
        $user_id = auth()->user()->id;
        $cash = Cash::where('principal', true)->where('state', 0)->where('user_id', $user_id)->latest()->first();
        $balance = 0;
        if ($cash) {
            $cash_id = $cash->id;
            $request = new Request();
            $request->merge(['cash_id' => $cash_id, 'only_cash' => 1]);
            $balance = (new PosController)->total_sales($request);
            $balance = floatval($cash->beginning_balance) + floatval($balance["total_sales"]);
            $response = [
                "total_sales" => $balance,
            ];
        }
        return [
            'success' => true,
            'balance' => $response
        ];
    }
    public function opening_cash()
    {

        $cash = Cash::where([['user_id', auth()->user()->id], ['state', true]])->first();

        return compact('cash');
    }

    public function opening_cash_check($user_id)
    {
        $cash = Cash::where([['user_id', $user_id], ['state', true]])
            // ->where('principal', false)
            ->first();
        return compact('cash');
    }


    public function record($id)
    {
        $record = new CashResource(Cash::findOrFail($id));

        return $record;
    }
    function checkIfHasOpenCash()
    {
        $user = auth()->user();
        $is_exclude = ExcludedUser::where('user_id', $user->id)->first();
        if ($is_exclude) {
            return [
                'success' => true,
            ];
        }
        $excludes_id = ExcludedUser::all()->pluck('user_id');
        $establishment_id = $user->establishment_id;
        $establishment_description = Establishment::find($establishment_id)->description;
        $cash = Cash::whereHas('user', function ($query) use ($establishment_id) {
            $query->where('establishment_id', $establishment_id)
                ->where('type', 'seller');
        })
            ->whereNotIn('user_id', $excludes_id)
            ->where('principal', false)
            ->where('state', true)
            ->first();

        if ($cash) {
            $user_cash = User::find($cash->user_id);
            $message = "Caja pendiente de cierre del usuario: " . $user_cash->name;
            $message_for_user = "El usuario: " . $user->name . " intentó abrir una caja, pero usted tiene una caja pendiente de cierre en el establecimiento: " . $establishment_description;
            if ($user_cash->telephone) {
                (new WhatsappController)->sendMessageOne($user_cash->telephone, $message_for_user);
            }
            $message_for_all = "El usuario: " . $user->name . " intentó abrir una caja, pero el usuario: " . $user_cash->name . " tiene una caja pendiente de cierre en el establecimiento: " . $establishment_description;
            (new WhatsappController)->sendMessageAll($message_for_all);
            return [
                'success' => false,
                'message' => $message
            ];
        }
        return [
            'success' => true,
        ];
    }

    public function store(CashRequest $request)
    {

        $configuration = Configuration::first();
        if ($configuration->only_cash_by_establishment) {
            $result = $this->checkIfHasOpenCash();
            if (!$result['success']) {
                return $result;
            }
        }

        $turn_principal = $configuration->turn_principal;
        $id = $request->input('id');
        $cash_user = User::find(auth()->user()->id);
        $establishment_id = $cash_user->establishment_id;
        $establishment = Establishment::find($establishment_id);
        $tab_single = (bool) $establishment->tab_single;
        $excluded = $cash_user->excluded_user;
        if ($configuration->automatic_principal_cash && !$tab_single && $request->input('principal') == false) {
            $exist_principal_cash = Cash::where('principal', true)
                ->whereHas('user', function ($query) use ($establishment_id, $configuration) {
                    if ($configuration->health_network) {
                        $query->where('establishment_id', $establishment_id);
                    }
                })
                ->where('state', true)->first();
            if (!$exist_principal_cash && !$excluded) {
                $user_arca = User::getUserArca();
                if ($user_arca) {
                    Cash::create([
                        'user_id' => $user_arca->id,
                        'beginning_balance' => 0,
                        'state' => 1,
                        'principal' => true,
                        'turn_id' => $turn_principal,
                        'date_opening' => date('Y-m-d'),
                        'time_opening' => date('H:i:s'),
                        'reference_number' => 'ARCA-' . date('H:i:s'),
                    ]);
                }
            }
        }
        $cash = Cash::firstOrNew(['id' => $id]);
        $cash->fill($request->all());

        if (!$id) {
            $cash->date_opening = date('Y-m-d');
            $cash->time_opening = date('H:i:s');
        }


        //<Preparamos la cadena de texto que guardanermos en el parametro 'reference_number)>
        if ($request->turn_id == 1) {
            if ((int)date('H') >= 6 && (int)date('H') < 12) {
                $cash->reference_number = "MAÑANA-" . date('H:i');
            } else {
                $cash->reference_number = "MAÑANA-" . date('H:i') . '-DIFF';
            }
        }
        if ($request->turn_id == 2) {
            if ((int)date('H') >= 12 && (int)date('H') < 18) {
                $cash->reference_number = "TARDE-" . date('H:i');
            } else {
                $cash->reference_number = "TARDE-" . date('H:i') . '-DIFF';
            }
        }
        if ($request->turn_id == 3) {
            if ((int)date('H') >= 18 && (int)date('H') < 24) {
                $cash->reference_number = "NOCHE-" . date('H:i');
            } else if ((int)date('H') >= 0 && (int)date('H') < 6) {
                $cash->reference_number = "NOCHE-" . date('H:i');
            } else {
                $cash->reference_number = "NOCHE-" . date('H:i') . '-DIFF';
            }
        }
        //</Preparamos la cadena de texto que guardanermos en el parametro 'reference_number) >

        $cash->save();
        //crea un mensaje con el nombre del usuario y el monto con el cual está abriendo caja
        $user = User::find($cash->user_id);
        $name = $user->name;
        $amount = $cash->beginning_balance;
        $establishment = Establishment::find($user->establishment_id);
        $establishment_description = $establishment->description;
        $area = Area::find($user->area_id);
        if ($area) {
            $area_description = $area->description;
            $message = "$area_description con usuario:$name, ha sido aperturada con S/ $amount en $establishment_description";
        } else {

            $message = "usuario:$name, aperturó caja con S/ $amount en $establishment_description";
        }
        (new WhatsappController)->sendMessageAll($message);
        return [
            "cash_id" => $cash->id,
            'success' => true,
            'message' => ($id) ? 'Caja actualizada con éxito' : 'Caja aperturada con éxito'
        ];
    }

    public function tables_principal()
    {
        $users = User::where('type', 'seller')->get();

        return [
            'users' => $users,
        ];
    }
    public function columns_principal()
    {
        return [
            'user_id' => 'Usuario',
            'date_opening' => 'Fecha de apertura',
        ];
    }
    public function records_principal_excel(Request $request)
    {
        $column = $request->column;
        $value = $request->value;
        $state = $request->input('status');
        $user_id_principal = auth()->user()->id;
        $records = CashIncomePrincipal::whereHas('cash_principal', function ($query) use ($user_id_principal) {
            $query->where('user_id', $user_id_principal);
        })
            ->whereHas('cash', function ($query) use ($column, $value) {
                if ($column && $value) {
                    $query->where($column, 'like', $value);
                }
            });
        if ($state) {
            $records = $records->where('status', $state);
        }

        $records =  $records->orderBy('id', 'desc');

        return (new CashPrincipalExport)
            ->records($records->get())
            ->company(Company::active())
            ->download('Reporte_Caja_Principal.xlsx');
    }
    public function records_principal(Request $request)
    {
        $column = $request->column;
        $value = $request->value;
        $state = $request->input('status');
        $user_id_principal = auth()->user()->id;
        $records = CashIncomePrincipal::whereHas('cash_principal', function ($query) use ($user_id_principal) {
            $query->where('user_id', $user_id_principal);
        })
            ->whereHas('cash', function ($query) use ($column, $value) {
                if ($column && $value) {
                    $query->where($column, 'like', $value);
                }
            });
        if ($state) {
            $records = $records->where('status', $state);
        }

        $records =  $records->orderBy('created_at', 'desc');

        return new CashIncomePrincipalCollection($records->paginate(config('tenant.items_per_page')));
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
    function has_two_decimals($number)
    {
        $parts = explode('.', (string)$number);
        return isset($parts[1]) && strlen($parts[1]) == 2;
    }
    public function close(Request $request)
    {


        $id = $request->id;
        $final_balance = $request->final_balance;
        $configuration = Configuration::first();
        $counter = $request->counter;
        $bill_series = $request->bill_series;
        $difference = $request->difference ?? 0.00;
        $cash = Cash::findOrFail($id);
        $amount_difference = $final_balance + $difference; //51.70
        $has_two_decimals = $this->has_two_decimals($amount_difference);
        if ($amount_difference > 0 && $configuration->sale_note_credit_confirm && $has_two_decimals) {
            try {

                if (fmod($amount_difference, 1) != 0 && substr($amount_difference, -1) > 0) {

                    $second_decimal = substr($amount_difference, -1);
                    $second_decimal = intval($second_decimal);
                    Log::info($second_decimal);
                    if ($second_decimal > 0) {
                        $second_decimal = 10 - $second_decimal;
                        $second_decimal = 0.01 * $second_decimal;
                        $difference -= $second_decimal;
                        $this->generaIncomeAdjust($id, $second_decimal);
                    }
                }
            } catch (Exception $e) {
                Log::info($e->getMessage());
                return [
                    'success' => false,
                    'message' => 'Error al generar el ajuste de caja por centavos'
                ];
            }
        }
        $cash->final_balance = $final_balance;
        $cash->counter = $counter;
        $cash->bill_series = $bill_series;
        $cash->difference = $difference;
        $cash_user = $cash->user;
        $user = User::find($cash->user_id);
        $establishment_id = $cash_user->establishment_id;
        $establishment = Establishment::find($establishment_id);
        $cash->state = 0;
        $cash->date_closed = date('Y-m-d');
        $cash->time_closed = date('H:i:s');
        $cash->save();
        Box::where('cash_id', $id)->update(['close' => date('Y-m-d'), 'state' => 0]);
        $all_cash = Box::select(['document_id', 'sale_note_id', 'sale_note_payment_id', 'amount'])
            ->where('cash_id', $id)->where('method', 'Efectivo')
            ->where('expenses', 0)
            ->get();
        $expenses = Box::where('cash_id', $id)->where('expenses', 1)
            ->where('method', 'Efectivo')
            ->sum('amount');


        $all_cash = $all_cash->map(function ($item) {

            if ($item->document_id) {
                $document = Document::find($item->document_id);
                return $document->total;
            }
            if ($item->sale_note_payment_id) {
                return $item->amount;
            }
            if ($item->sale_note_id && !$item->sale_note_payment_id) {
                $sale_note = SaleNote::find($item->sale_note_id);
                if ($sale_note->sale_note_credit) {
                    return $sale_note->advances;
                }
                return $sale_note->total;
                // $sale_note = SaleNote::whereDoesntHave('sale_note_credit')->find($item->sale_note_id);
                // if (!$sale_note) return 0;
                // return $sale_note->total - $sale_note->advances;
            }
        });
        $all_cash = $all_cash->sum();
        $all_cash += $cash->beginning_balance;
        $all_incomes = Box::where('cash_id', $id)->where('incomes', 1)->sum('amount');
        $all_expenses = Box::where('cash_id', $id)->where('expenses', 1)->sum('amount');
        $all_cash += $all_incomes;
        $all_cash -= $all_expenses;
        $user_name = $cash->user->name;
        $website = $this->getTenantWebsite();
        $hostname =  app(Environment::class)->hostname();
        $fqdn = $hostname->fqdn;
        $cash->is_loading_report = true;
        $cash->save();
        WhatsappSendCashReportProccess::dispatch($website->id, $cash->id, $user_name, $fqdn);
        CashReportSmallProccess::dispatch($website->id, $cash->id, $fqdn);
        $configuration = Configuration::first();
        WhatsappSendCashReportStockProccess::dispatch($website->id, $cash->id, $cash->user_id, $fqdn);
        // $number_activity = $configuration->number_activity;
        // $resource = "http://" . $hostname->fqdn . "/caja/report-boxes/reports_resumen_type?cash_id=" . $id;
        // $request = new Request(
        //     [
        //         'from_server' => true,
        //         'sender' => 'sdrimsac',
        //         'number' => $number_activity,
        //         'resource' => $resource,
        //         'file_name' => 'Reporte_Caja' . Carbon::now()->format("Y-m-d"),
        //         'message' => "Caja cerrada por " . $user_name
        //     ]
        // );
        // if ($number_activity) {

        //     (new WhatsappController)->sendHistorial($request);
        // }
        // $numbers = NumberActivity::all();
        // foreach ($numbers as $number) {
        //     $request['number'] = $number->number;
        //     (new WhatsappController)->sendHistorial($request);
        // }

        // $resource = "http://" . $hostname->fqdn . "/caja/report-product-warehouse-w?user_id=" . $cash->user_id."&cash_id=".$cash->id;
        // $file = file_get_contents($resource);

        // $file_name = $cash->id . "_" . "Stock_al_cerrar_caja_" . Carbon::now()->format("Y-m-d") . ".xlsx";

        // $directory = 'public' . DIRECTORY_SEPARATOR . 'stock_excel_cierre_caja';
        // Storage::disk('tenant')->put($directory . DIRECTORY_SEPARATOR . $file_name, $file);

        // $cash->stock_file = $file_name;
        // $cash->save();


        // $request = new Request(
        //     [
        //         'from_server' => true,
        //         'sender' => 'sdrimsac',
        //         'number' => $number_activity,
        //         'resource' => $resource,
        //         'file_name' => 'Stock_al_cerrar_caja_' . Carbon::now()->format("Y-m-d") . ".xlsx",
        //         'message' => "Caja cerrada por " . $user_name
        //     ]
        // );
        // if ($number_activity) {
        //     (new WhatsappController)->sendHistorial($request);
        // }
        // $numbers = NumberActivity::all();
        // foreach ($numbers as $number) {
        //     $request['number'] = $number->number;
        //     (new WhatsappController)->sendHistorial($request);
        // }

        $principal_cash =  $configuration->principal_cash;
        $health_network = $configuration->health_network;
        if ($principal_cash) {
            $cash_principal = Cash::where('state', 1)
                ->whereHas('user', function ($query) use ($establishment_id, $configuration) {
                    if ($configuration->health_network) {
                        $query->where('establishment_id', $establishment_id);
                    }
                })
                ->where('principal', 1);
            if ($health_network) {

                $establishment_id = $cash_user->establishment_id;
                $cash_principal = $cash_principal->whereHas('user', function ($query) use ($establishment_id) {
                    $query->where('establishment_id', $establishment_id);
                });
            }
            $cash_principal = $cash_principal->first();
            $excluded = $cash_user->excluded_user;
            if ($cash_principal && !$excluded) {
                $cash_principal_id = $cash_principal->id;
                $user_principal = $cash_principal->user;
                $user_principal_telephone = $user_principal->telephone;
                $cash_id = $cash->id;
                // $amount = 
                $credit_cash_out = SaleNote::where('cash_id', $cash_id)->where('is_cash', 1)->where('total', '>', 0)->sum('total');
                $t_amount = $all_cash - $credit_cash_out - $expenses;
                CashIncomePrincipal::create([
                    'cash_principal_id' => $cash_principal_id,
                    'cash_id' => $cash_id,
                    'amount' => $t_amount,
                    'status' => $t_amount > 0 ? 1 : 3,
                ]);
                $user = User::find($cash->user_id);
                $name = $user->name;
                $message = "La caja de $name ha sido cerrada, el monto total es de $all_cash";
                if ($user_principal_telephone) {
                    WhatsappSendMessageProccess::dispatch($website->id, $message, $user_principal_telephone);
                    // (new WhatsappController)->sendMessage($message, $user_principal_telephone);
                }
            }
        }
        $tab_single = (bool)$establishment->tab_single;
        if ($configuration->automatic_principal_cash && !$tab_single && !$excluded) {
            $turn_end = $configuration->turn_end;
            // if ($cash->turn_id == $turn_end) {
            if ($cash->cash_type_id == 2 || $cash->cash_type_id == 4) {
                Cash::where('principal', true)
                    ->where('state', 1)
                    ->whereHas('user', function ($query) use ($establishment_id, $configuration) {
                        if ($configuration->health_network) {
                            $query->where('establishment_id', $establishment_id);
                        }
                    })
                    ->update([
                        'state' => 0,
                        'time_closed' => date('H:i:s'),
                        'date_closed' => date('Y-m-d')
                    ]);
            }
        }
        return [
            'success' => true,
            'message' => 'Caja cerrada con éxito',
        ];
    }


    public function generate_reports($cash_id)
    {
        $cash = Cash::findOrFail($cash_id);
        $cash->is_loading_report = true;
        $cash->save();
        $website = $this->getTenantWebsite();
        $hostname =  app(Environment::class)->hostname();
        $fqdn = $hostname->fqdn;
        CashReportProccess::dispatch($website->id, $cash->id, $fqdn);
        CashReportSmallProccess::dispatch($website->id, $cash->id, $fqdn);


        return [
            'success' => true,
            'message' => 'Se está generando el reporte de caja, por favor espere unos minutos',
        ];
    }
    public function get_stock_file($id)
    {
        $cash = Cash::findOrFail($id);
        $file_path = $cash->stock_file;
        $directory = 'public' . DIRECTORY_SEPARATOR . 'stock_excel_cierre_caja' . DIRECTORY_SEPARATOR . $file_path;
        // $file = Storage::disk('tenant')->get($directory);

        // $response = Response::make($file, 200);
        // $response->header("Content-Type", $type);
        return Storage::disk('tenant')->download($directory);
    }
    public function cash_document(Request $request)
    {

        $cash = Cash::where([['user_id', auth()->user()->id], ['state', true]])->first();
        $cash->cash_documents()->create($request->all());


        return [
            'success' => true,
            'message' => 'Venta con éxito',
        ];
    }


    public function destroy($id)
    {

        $cash = Cash::findOrFail($id);

        if ($cash->global_destination->count() > 0) {
            return [
                'success' => false,
                'message' => 'No puede eliminar la caja, tiene transacciones relacionadas'
            ];
        }

        $cash->delete();

        return [
            'success' => true,
            'message' => 'Caja eliminada con éxito'
        ];
    }


    public function report($cash)
    {

        $cash = Cash::findOrFail($cash);
        $company = Company::first();

        $methods_payment = collect(PaymentMethodType::all())->transform(function ($row) {
            return (object)[
                'id' => $row->id,
                'name' => $row->description,
                'sum' => 0
            ];
        });

        set_time_limit(0);

        $pdf = PDF::loadView('tenant.cash.report_pdf', compact("cash", "company", "methods_payment"));

        $filename = "Reporte_POS - {$cash->user->name} - {$cash->date_opening} {$cash->time_opening}";

        return $pdf->stream($filename . '.pdf');
    }

    public function report_general()
    {
        $cashes = Cash::select('id')->whereDate('date_opening', date('Y-m-d'))->pluck('id');
        $cash_documents =  CashDocument::whereIn('cash_id', $cashes)->get();

        $company = Company::first();
        set_time_limit(0);

        $pdf = PDF::loadView('tenant.cash.report_general_pdf', compact("cash_documents", "company"));
        $filename = "Reporte_POS";
        return $pdf->download($filename . '.pdf');
    }

    public function report_products($id)
    {
        $cash = Cash::findOrFail($id);
        $company = Company::first();
        $cash_documents =  CashDocument::select('document_id')->where('cash_id', $cash->id)->get();

        $source = DocumentItem::with('document')->whereIn('document_id', $cash_documents)->get();

        $documents = collect($source)->transform(function ($row) {
            return [
                'id' => $row->id,
                'number_full' => $row->document->number_full,
                'description' => $row->item->description,
                'quantity' => $row->quantity,
            ];
        });


        $pdf = PDF::loadView('tenant.cash.report_product_pdf', compact("cash", "company", "documents"));

        $filename = "Reporte_POS_PRODUCTOS - {$cash->user->name} - {$cash->date_opening} {$cash->time_opening}";

        return $pdf->stream($filename . '.pdf');
    }
}
