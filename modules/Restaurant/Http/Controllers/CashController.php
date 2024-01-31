<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Exports\CashPrincipalExport;
use Exception;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
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
use App\Models\Tenant\BankAccount;
use App\Models\Tenant\CashIncomePrincipal;
use App\Models\Tenant\Catalogs\AttributeType;
use App\Models\Tenant\Catalogs\SystemIscType;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\NumberActivity;
use App\Models\Tenant\Quotation;
use App\Models\Tenant\Receipt;
use App\Models\Tenant\SaleNoteItem;
use App\Models\Tenant\SaleNotePayment;
use Barryvdh\Debugbar\Twig\Extension\Dump;
use GuzzleHttp\Psr7\Response;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Website;
use Modules\Restaurant\Models\Turns;
use Illuminate\Support\Facades\DB;
use Modules\Item\Models\CategoryItem;
use Modules\Report\Exports\GainReportExport;
use Modules\Restaurant\Http\Resources\CashIncomePrincipalCollection;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\BoxesDetail;
use Mpdf\Mpdf;
use NumberFormatter;

class CashController extends Controller
{

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
        $description_cash = $cash->reference_number;
        $description = "Ingreso de la caja $description_cash del usuario $user_name del establecimiento $establishment_description";

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
            'soap_type_id' => 1,
            'description' => $description,
            'state' => 1,
            'user_id' => auth()->user()->id,
        ]);
        $cash_income_principal->status = 3;
        $cash_income_principal->save();
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
            $total = $incomes - $expenses;
        }
        $configuration = Configuration::first();

        return view('tenant.cash.index_main', compact('configuration', 'cash_id', 'total'));
    }
    public function index_report_closed_cash()
    {
        $configuration = Configuration::first();
        $users = User::where('active', 1)->get();
        return view('tenant.cash.index_closed', compact('configuration', 'users'));
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

        $type = $type ?? 'pdf';
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
        $recordsDocument = null;
        if ($date_end) {
            $recordsDocument = Document::whereBetween('date_of_issue', [$date_start, $date_end]);
        } else {
            $recordsDocument = Document::whereDate('date_of_issue', '=', $date_start);
        }
        if ($establishment_id) {
            $recordsDocument = $recordsDocument->where('establishment_id', $establishment_id);
        }

        $recordsDocument->chunk(50, function ($documents)
        use (&$items, &$total, &$categoria_id) {

            foreach ($documents as  $document) {
                $total_items = 0;
                $documents_items = DocumentItem::where('document_id', $document->id)->get();

                foreach ($documents_items as  $d_it) {
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

                            $price = $d_it->unit_price;

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
                                        ]
                                    ],
                                ];
                            }
                        }
                    }
                }
            }
        });
        $recordsSaleNote = null;
        if ($date_end) {
            $recordsSaleNote = SaleNote::whereBetween('date_of_issue', [$date_start, $date_end]);
        } else {
            $recordsSaleNote = SaleNote::whereDate('date_of_issue', '=', $date_start);
        }
        if ($establishment_id) {
            $recordsSaleNote = $recordsSaleNote->where('establishment_id', $establishment_id);
        }

        $recordsSaleNote->chunk(50, function ($sale_notes)

        use (&$items, &$total, &$categoria_id) {

            foreach ($sale_notes as  $sale_note) {
                $total_items = 0;
                $sale_notes_items = SaleNoteItem::where('sale_note_id', $sale_note->id)->get();

                foreach ($sale_notes_items as  $d_it) {
                    if ($categoria_id == null) {
                        $item = $d_it->item;
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
                                        ]
                                    ],
                                ];
                            }
                        }
                    }
                }
            }
        });
        array_multisort(array_column($items, 'count'), SORT_DESC, $items);
        if ($type == 'pdf') {
            $pdf = PDF::loadView('report::cash.report_pdf_cash', compact(
                "establishment",
                "total",
                "company",
                "items",
                "date_start",
                "date_end"
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
                ->download('ReporteDoc' . Carbon::now() . '.xlsx');
        }
    }

    public function report_cash(Request $request)
    {
        $categoria_id = $request->categoria_id;
        $item_id = $request->item_id;
        $establishment_id = $request->establishment_id;
        $date_start = $request->date_start ? Carbon::parse($request->date_start)->format("y-m-d") : null;
        $date_end = $request->date_end ? Carbon::parse($request->date_end)->format("y-m-d") : null;
        $month = 11;
        $items = [];
        $total = 0;

        //total venta -> jalar documentos
        $recordsDocument = null;
        if ($date_end) {
            $recordsDocument = Document::where('state_type_id', '<>', 11)->whereBetween('date_of_issue', [$date_start, $date_end]);
        } else {
            $recordsDocument = Document::where('state_type_id', '<>', 11)->whereDate('date_of_issue', '=', $date_start);
        }
        $config = Configuration::first();
        $item_id_variation = $config->item_variation_id;
        if ($establishment_id) {
            $recordsDocument = $recordsDocument->where('establishment_id', $establishment_id);
        }

        $recordsDocument->chunk(50, function ($documents)
        use (&$items, &$total, &$categoria_id, $item_id_variation, $item_id) {

            foreach ($documents as  $document) {
                $total_items = 0;
                $documents_items = DocumentItem::where('document_id', $document->id);
                if ($item_id) {
                    $documents_items = $documents_items->where('item_id', $item_id);
                }
                if ($item_id_variation) {
                    $documents_items = $documents_items->where('item_id', '<>', $item_id_variation);
                }

                $documents_items = $documents_items->get();

                foreach ($documents_items as  $d_it) {


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

                            $price = $d_it->unit_price;

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
                                        ]
                                    ],
                                ];
                            }
                        }
                    }
                }
            }
        });
        $recordsSaleNote = null;
        if ($date_end) {
            $recordsSaleNote = SaleNote::where('state_type_id', '<>', 11)->whereBetween('date_of_issue', [$date_start, $date_end]);
        } else {
            $recordsSaleNote = SaleNote::where('state_type_id', '<>', 11)->whereDate('date_of_issue', '=', $date_start);
        }

        if ($establishment_id) {
            $recordsSaleNote = $recordsSaleNote->where('establishment_id', $establishment_id);
        }

        $recordsSaleNote->chunk(50, function ($sale_notes)

        use (&$items, &$total, &$categoria_id, $item_id) {

            foreach ($sale_notes as  $sale_note) {

                $total_items = 0;
                $sale_notes_items = SaleNoteItem::where('sale_note_id', $sale_note->id)->get();

                if ($item_id) {
                    $sale_notes_items = $sale_notes_items->where('item_id', $item_id);
                }

                foreach ($sale_notes_items as  $d_it) {
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
        //
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
        $type_document = $request->typeDocument;
        $establishment_id = auth()->user()->establishment_id;
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
        $documents = $model::where('establishment_id', $establishment_id)
            ->where('soap_type_id', $company->soap_type_id);
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
                    $query->where('name', 'like', '%' . $value . '%')->orWhere('number', 'like', '%' . $value . '%');
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
        $documents = [];
        foreach ($boxes as $box) {

            if ($box->document_id) {
                $document = Document::find($box->document_id);
                $name_document =  $document->getNumberFullAttribute();
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
                            $data = $item->item;
                            $data = (array)$data;
                            $id_exist  = false;

                            if (count($all_items) > 0) {
                                $id_exist = array_search($data['description'], array_column($all_items, 'description'));
                            }

                            if (gettype($id_exist) == "integer") {
                                $all_items[$id_exist] = [
                                    "price" => $item->unit_price,
                                    "description" => $data['description'],
                                    "quantity" => $all_items[$id_exist]["quantity"] + $item->quantity,
                                    "total" => $all_items[$id_exist]["total"] + $item->total
                                ];
                            } else {
                                $all_items[] = [
                                    "price" => $item->unit_price,
                                    "description" => $data['description'],
                                    "quantity" => $item->quantity,
                                    "total" => $item->total
                                ];
                            }
                        }
                    }
                }
            }
            if ($box->sale_note_id) {

                $sale_note = SaleNote::find($box->sale_note_id);
                $name_sale_note =  $sale_note->getNumberFullAttribute();
                $column = array_column($documents, 'name');
                if (!in_array($name_sale_note, $column)) {
                    $documents[] = [
                        "name" => $sale_note->getNumberFullAttribute(),
                        "total" => $sale_note->total,
                    ];
                    $items = SaleNoteItem::where("sale_note_id", $box->sale_note_id)->get();
                    foreach ($items as $item) {
                        $data = $item->item;
                        $data = (array)$data;
                        $id_exist  = false;
                        if (count($all_items) > 0) {
                            $id_exist = array_search($data['description'], array_column($all_items, 'description'));
                        }

                        if (gettype($id_exist) == "integer") {
                            $all_items[$id_exist] = [
                                "price" => $data["sale_unit_price"],
                                "description" => $data['description'],
                                "quantity" => $all_items[$id_exist]["quantity"] + $item->quantity,
                                "total" => $all_items[$id_exist]["total"] + $item->total
                            ];
                        } else {
                            $all_items[] = [
                                "price" => $data["sale_unit_price"],
                                "description" => $data['description'],
                                "quantity" => $item->quantity,
                                "total" => $item->total
                            ];
                        }
                        $all_documents["notas"] += $item->total;
                    }
                }
            }
        }

        return [
            "items" => $all_items,
            "documents" => $all_documents,
            "documents_info" => $documents,
        ];
    }
    public function print_report(Request $request)
    {
        $cash_id = $request->cash_id;
        $sales = Box::where('cash_id', $cash_id)->where('expenses', 0)->where('incomes', 0)->OrderBy('date', 'asc');
        $sales_quantity = $sales->count();
        $sales_amount = $sales->where('method', '<>', 'Efectivo')->sum('amount');

        $sales_cash = Box::where('method', 'Efectivo')->where('expenses', 0)->where('incomes', 0)->where('cash_id', $cash_id)->OrderBy('date', 'asc');
        $sales_cash_sum = 0;
        $sales_cash_records = $sales_cash->get();
        foreach ($sales_cash_records as $ringreso) {
            if ($ringreso["sale_note_id"]) {
                $sale_note = SaleNote::find($ringreso["sale_note_id"]);
                $sales_cash_sum += $sale_note->total;
            }
            if ($ringreso["document_id"]) {
                $sale_note = Document::find($ringreso["document_id"]);
                $sales_cash_sum += $sale_note->total;
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
        try {
            $pdf = PDF::loadView('restaurant::cash.ticket_cash', compact(
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
                "cash",
                "date",
                "time",
                "counter"
            ))
                ->setPaper(array(0, 0, 249.45, 300 + (100 + $counter_length * 15)));
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
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
            'reference_number' => 'Codigo de Referencias'

        ];
    }
    public function recordsClosed(Request $request)
    {
        $user_id  = $request->input('user_id');
        $date_close = $request->input('date_close');
        $records = Cash::query();
        // $records = Cash::where('state', '=', 0);
        if ($user_id) {
            $records = $records->where('user_id', '=', $user_id);
        }
        if ($date_close) {
            $records = $records->where('date_closed', '=', $date_close);
        }

        $records->orderBy('date_opening', 'desc');

        return new CashCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function records(Request $request)
    {
        $fromAdmin = $request->input('fromAdmin');

        $records = Cash::query();
        if ($request->column) {

            $records = $records->where($request->column, 'like', "%{$request->value}%");
        }

        $records->whereTypeUser($fromAdmin);
        $records->orderBy('date_opening', 'desc')
        ->orderBy('time_opening', 'desc')
        ;

        return new CashCollection($records->paginate(config('tenant.items_per_page')));
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
        $turnsTable = [];
        switch ($type) {
            case 'admin':
                $users = User::where('type', 'seller')->get();
                $users->push($user);
                break;
            case 'seller':
                $users = User::where('id', $user->id)->get();
                $turnsTable = Turns::where('turn_active',  1)->get();
                break;
        }

        return compact('users', 'user', 'turnsTable');
    }

    public function opening_cash()
    {

        $cash = Cash::where([['user_id', auth()->user()->id], ['state', true]])->first();

        return compact('cash');
    }

    public function opening_cash_check($user_id)
    {
        $cash = Cash::where([['user_id', $user_id], ['state', true]])->first();
        return compact('cash');
    }


    public function record($id)
    {
        $record = new CashResource(Cash::findOrFail($id));

        return $record;
    }

    public function store(CashRequest $request)
    {

        $id = $request->input('id');
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
        if($area){
            $area_description = $area->description;
            $message = "$area_description con usuario:$name, ha sido aperturada con S/ $amount en $establishment_description";
        }else{
            
            $message = "usuario:$name, aperturó caja con S/ $amount en $establishment_description";
        }
        (new WhatsappController)->sendMessageAll($message);
        return [
            "cash_id" => $cash->id,
            'success' => true,
            'message' => ($id) ? 'Caja actualizada con éxito' : 'Caja aperturada con éxito'
        ];
    }

    public function tables_principal(){
        $users = User::where('type', 'seller')->get();

        return [
            'users' => $users,
        ];
    }
    public function columns_principal(){
        return [
            'user_id' => 'Usuario',
            'date_closed' => 'Fecha de Cierre',
        ];
    }
    public function records_principal_excel(Request $request){
        $column = $request->column;
        $value = $request->value;
        $state = $request->input('status');
        $user_id_principal = auth()->user()->id;
        $records = CashIncomePrincipal::whereHas('cash_principal', function ($query) use ($user_id_principal) {
            $query->where('user_id', $user_id_principal);

        })
        ->whereHas('cash', function ($query) use ($column,$value) {
            if($column && $value){
                $query->where($column, 'like', $value);
            }
        });
        if($state){
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
        ->whereHas('cash', function ($query) use ($column,$value) {
            if($column && $value){
                $query->where($column, 'like', $value);
            }
        });
        if($state){
            $records = $records->where('status', $state);
        }

       $records =  $records->orderBy('id', 'desc');

        return new CashIncomePrincipalCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function close(Request $request)
    {


        $id = $request->id;
        $final_balance = $request->final_balance;
        $counter = $request->counter;
        $difference = $request->difference ?? 0.00;
        $cash = Cash::findOrFail($id);
        $cash->final_balance = $final_balance;
        $cash->counter = $counter;
        $cash->difference = $difference;
        $cash->state = 0;
        $cash->date_closed = date('Y-m-d');
        $cash->time_closed = date('H:i:s');
        $cash->save();
        Box::where('cash_id', $id)->update(['close' => date('Y-m-d'), 'state' => 0]);
        $all_cash = Box::where('cash_id', $id)->where('method', 'Efectivo')->sum('amount');
        $user_name = $cash->user->name;
        $configuration = Configuration::first();
        $principal_cash =  $configuration->principal_cash;
        if ($principal_cash) {
            $cash_principal = Cash::where('state', 1)
                ->where('principal', 1)
                ->first();
            if ($cash_principal) {
                $cash_principal_id = $cash_principal->id;
                $user_principal = $cash_principal->user;
                $user_principal_telephone = $user_principal->telephone;
                $cash_id = $cash->id;
                CashIncomePrincipal::create([
                    'cash_principal_id' => $cash_principal_id,
                    'cash_id' => $cash_id,
                    'amount' => $all_cash,
                ]);
                $user = User::find($cash->user_id);
                $name = $user->name;
                $message = "La caja de $name ha sido cerrada, el monto total es de $all_cash";
                if ($user_principal_telephone) {
                    (new WhatsappController)->sendMessage($message, $user_principal_telephone);
                }
            }else{
            
            }
        }
        $number_activity = $configuration->number_activity;
        $hostname =  app(Environment::class)->hostname();
        $resource = "http://" . $hostname->fqdn . "/caja/report-boxes/reports_resumen_type?cash_id=" . $id;
        $request = new Request(
            [
                'from_server' => true,
                'sender' => 'sdrimsac',
                'number' => $number_activity,
                'resource' => $resource,
                'file_name' => 'Reporte_Caja' . Carbon::now()->format("Y-m-d"),
                'message' => "Caja cerrada por " . $user_name
            ]
        );
        if ($number_activity) {

            (new WhatsappController)->sendHistorial($request);
        }
        $numbers = NumberActivity::all();
        foreach ($numbers as $number) {
            $request['number'] = $number->number;
            (new WhatsappController)->sendHistorial($request);
        }

        $resource = "http://" . $hostname->fqdn . "/caja/report-product-warehouse-w?user_id=" . $cash->user_id."&cash_id=".$cash->id;
        $file = file_get_contents($resource);

        $file_name = $cash->id . "_" . "Stock_al_cerrar_caja_" . Carbon::now()->format("Y-m-d") . ".xlsx";

        $directory = 'public' . DIRECTORY_SEPARATOR . 'stock_excel_cierre_caja';
        Storage::disk('tenant')->put($directory . DIRECTORY_SEPARATOR . $file_name, $file);

        $cash->stock_file = $file_name;
        $cash->save();


        $request = new Request(
            [
                'from_server' => true,
                'sender' => 'sdrimsac',
                'number' => $number_activity,
                'resource' => $resource,
                'file_name' => 'Stock_al_cerrar_caja_' . Carbon::now()->format("Y-m-d") . ".xlsx",
                'message' => "Caja cerrada por " . $user_name
            ]
        );
        if ($number_activity) {
            (new WhatsappController)->sendHistorial($request);
        }
        $numbers = NumberActivity::all();
        foreach ($numbers as $number) {
            $request['number'] = $number->number;
            (new WhatsappController)->sendHistorial($request);
        }
        

        return [
            'success' => true,
            'message' => 'Caja cerrada con éxito',
        ];
    }


    public function get_stock_file($id){
        $cash = Cash::findOrFail($id);
        $file_path = $cash->stock_file;
        $directory = 'public' . DIRECTORY_SEPARATOR.'stock_excel_cierre_caja'.DIRECTORY_SEPARATOR.$file_path;
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
