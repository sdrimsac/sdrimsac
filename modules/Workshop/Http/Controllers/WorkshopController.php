<?php

namespace Modules\Workshop\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Tenant\Box;
use App\Models\Tenant\Group;
use App\Models\Tenant\Company;
use App\Models\Tenant\Category;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Warehouse;
use App\Models\Tenant\Subcategory;
use Illuminate\Http\Request;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Desarrollador;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Person;

use App\Models\Tenant\PaymentMethodType;
use Illuminate\Routing\Controller;

use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\Table;
use App\Http\Resources\Tenant\BoxCollection;
use App\Jobs\WhatsappSendMessageProccess;
use App\Models\Tenant\Cash;
use App\Models\Tenant\EstablishmentNotificationNumber;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Events\StockEvent;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\NumberActivity;
use App\Models\Tenant\Seller;
use App\Models\Tenant\User;
use App\Models\Tenant\ItemMedidaAlto;
use App\Models\Tenant\ItemMedidaAncho;
use App\Models\Tenant\ItemMedidaGrosor;
use App\Models\Tenant\UnitTypePerson;
use App\Traits\JobReportTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Modules\Item\Models\CategoryItem;
use Modules\Restaurant\Events\OrdenPaidEvent;
use Modules\Restaurant\Http\Requests\ExpensesRequest;
use Modules\Restaurant\Http\Resources\OrdenCollection;
use Modules\Restaurant\Http\Resources\ExpensesResource;
use Modules\Restaurant\Models\BoxesDetail;
use Modules\Restaurant\Events\OrdenPendingEvent;
use Modules\Restaurant\Events\PrintEvent;
use Modules\Restaurant\Models\WorkersType;
use Modules\Workshop\Http\Resources\FoodCollection;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('workshop::index');
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('workshop::edit');
    }
    public function expenses()
    {
        $cash = Cash::where('state', 1)
            ->where('user_id', auth()->user()->id)
            ->get()
            ->last();


        if ($cash == null) {
            return redirect()->route('workshop.cash.index');
        }
        $group = Group::where('type', '2')->first();
        $category = Category::where('type', '2')->first();
        $subcategory = Subcategory::where('type', '2')->first();
        $groupid = $group->id;
        $categoryid = $category->id;
        $userid = auth()->user()->id;
        $subcategoryid = $subcategory->id;
        $company = Company::first();
        $soaptypeid = $company->soap_type_id;
        $cashid = $cash->id;
        //dd($categoryid);
        return view('workshop::expenses.index', compact(
            'cashid',
            'groupid',
            'categoryid',
            'userid',
            'subcategoryid',
            'soaptypeid'
        ));
    }
    public function expenses_admin()
    {

        $cash = Cash::where('state', 1)
            ->where('user_id', auth()->user()->id)
            ->get()
            ->last();


        if ($cash == null) {
            return redirect()->route('workshop.cash');
        }
        $group = Group::where('type', '2')->first();
        $category = Category::where('type', '2')->first();
        $subcategory = Subcategory::where('type', '1')->first();
        $groupid = $group->id;
        $categoryid = $category->id;
        $userid = auth()->user()->id;
        $subcategoryid = $subcategory->id;
        $company = Company::first();
        $soaptypeid = $company->soap_type_id;
        $cashid = $cash->id;
        //dd($categoryid);
        return view('tenant.expenses.index', compact('cashid', 'groupid', 'categoryid', 'userid', 'subcategoryid', 'soaptypeid'));
    }
    public function foods(Request $request)
    {
        $configuration = Configuration::first();
        $customer_unit_type_id = $request->customer_unit_type_id;
        $category_ins =  CategoryItem::where('name', 'INSUMOS')->first();
        $category_ins_id = null;
        if ($category_ins) {
            $category_ins_id = $category_ins->id;
        }
        // $user = User::find(auth()->user()->id);
        $search_by_second_name = $configuration->search_by_second_name;
        $datafoods = $request->all();
        $search_by_series = $request->search_by_series == "true" ? true : false;
        $category_id = $request->category;
        $external_id =  $request->external_id == "true" ? true : false;
        $value = $request->value;
        /* agregado para buscar codido interno con comillas */
        $value = addslashes($value);
        $establishment_id = auth()->user()->establishment_id;
        $establishment = Establishment::find($establishment_id);
        $warehouse = Warehouse::where('establishment_id', $establishment_id)->first();
        $warehouse_id = $warehouse->id;
        $warehouse_product_id = auth()->user()->warehouse_product_id;
        if ($warehouse_product_id) {
            $warehouse_id = $warehouse_product_id;
        }

        $textoIntoArray =  explode(' ', $value);

        $brand = $request->brand;
        $foods = Food::query()->whereHas(
            "item",
            function ($query) use ($warehouse_id, $search_by_series, $value, $configuration, $establishment, $brand, $customer_unit_type_id) {
                $query
                    ->where('active', 1)->whereHas('warehouses', function ($query) use ($warehouse_id, $value) {
                        $query->where('warehouse_id', $warehouse_id);
                    });
                if ($search_by_series == true) {
                    $query->where('series_enabled', 1)
                        ->whereHas('item_lots', function ($query) use ($warehouse_id, $value) {
                            $query->where('warehouse_id', $warehouse_id)->where('has_sale', 0)
                                ->where('series', 'like', '%' . $value . '%');
                        });
                }
                $consolidated_quotations = $configuration->consolidated_quotations;
                if ($consolidated_quotations && $customer_unit_type_id) {
                    $item_unit_types_person = UnitTypePerson::where('customer_id', $customer_unit_type_id)->pluck('description')->values();
                    $query->whereHas('item_unit_types', function ($query) use ($item_unit_types_person) {
                        $query->whereIn('description', $item_unit_types_person);
                    });
                }
                if ($configuration->health_network) {
                    if ($establishment->is_service) {
                        $query->where('unit_type_id', 'ZZ');
                    }
                    if ($establishment->is_product) {
                        $query->where('unit_type_id', '<>', 'ZZ');
                    }
                }
                if ($brand) {
                    $query->where('brand', 'LIKE', '%' . $brand . '%');
                }
            }
        );

        if ($category_id) {

            $foods = $foods->where('category_food_id', $category_id);
        }
        if ($value && $search_by_series == null || $search_by_series == false) {
            if (count($textoIntoArray) === 1) {
                if ($external_id) {
                    $foods = $foods->whereHas('item', function ($query) use ($value) {
                        $query->where('description', 'LIKE', '%' . $value . '%')
                            ->orWhere(function ($query) use ($value) {
                                $query->where('internal_id', 'LIKE', '%' . $value . '%')->orWhere('barcode', 'LIKE', '%' . $value . '%');
                            });
                    });
                } else {

                    $foods = $foods->where(function ($query) use ($value, $search_by_second_name) {
                        $query->where('description', 'LIKE', '%' . $value . '%')
                            ->orWhere('code', 'LIKE', '%' . $value . '%');
                        if ($search_by_second_name) {
                            $query->orWhereHas('item', function ($query) use ($value) {
                                $query->where('second_name', 'LIKE', '%' . $value . '%');
                            });
                        }
                    });
                }
            } else {

                $foods = $foods->where(function ($query) use ($value, $textoIntoArray, $search_by_second_name) {
                    $query->where(function ($subquery) use ($textoIntoArray) {
                        foreach ($textoIntoArray as $key => $valor) {
                            $subquery->where('description', 'LIKE', '%' . $valor . '%');
                        }
                    });

                    if ($search_by_second_name) {
                        $query->orWhereHas('item', function ($subquery) use ($textoIntoArray) {
                            foreach ($textoIntoArray as $key => $valor) {
                                $subquery->where('second_name', 'LIKE', '%' . $valor . '%');
                            }
                        });
                    }
                });
            }
        }

        if ($category_ins_id) {
            $foods = $foods->where('category_food_id', '<>', $category_ins_id);
        }
        //orderBy('description', 'ASC')
        $configuration = Configuration::first();
        $hotels = $configuration->hotels;
        // if($hotels){
        //     $user = auth()->user();
        //     $area = $user->area;
        //     $is_hotel = $area->is_hotel();
        //     if($is_hotel){
        //         $foods = $foods->where('area_id',$area->id);
        //     }
        // }
        if ($configuration->ord_dscp) {
            // Ordena los resultados priorizando la palabra exacta
            $foods = $foods->orderByRaw("description LIKE '{$value}%' DESC")
                ->orderByRaw("description LIKE '%{$value}%' DESC")
                ->orderBy('description', 'ASC');
        }

        if ($configuration->ord_dscp) {
            $foods = $foods->orderBy('description', 'ASC');
        }
        $all_foods = $configuration->all_items_pos;
        if ($all_foods) {
            $count_foods = Food::query()->count();
            return new FoodCollection($foods->paginate($count_foods));
        } else {
            if (empty($datafoods)) {

                return new FoodCollection($foods->paginate(50));
            } else {
                return new FoodCollection($foods->paginate(100), $search_by_series);
            }
        }
        //  return Food::all();
        //     return new InventoryCollection($reports->paginate(config('tenant.items_per_page')));
    }
    public function pos()
    {
        $user = auth()->user();
        $cash_worker = WorkersType::where('description', 'like', '%CAJERO MECÁNICO%')->orWhere('description', 'like', '%cajero mecanico%')->first();
        if ($cash_worker) {
            $id = $cash_worker->id; 

            if ($user->worker_type_id != $id) {
                return redirect('/');
            }
        }
        $user_id = $user->id;
        $cash = Cash::where('user_id', $user_id)
            ->where('state', 1)
            ->get()
            ->last();
        $worker = true;
        $area_id = auth()->user()->area_id;
        $company = Company::first();
        $desarrollador = Desarrollador::first();
        $configuration = Configuration::first();
        $establishments = Establishment::where('id', auth()->user()->establishment_id)->first();
        $auth_login = auth()->user()->id;
        $cash_id = $cash ? $cash->id : 0;

        $pending_order = 0;
        return view('workshop::worker.pos', compact('pending_order', 'area_id', 'cash_id', 'worker', 'establishments', 'configuration', 'auth_login', 'company', 'desarrollador'));
    }
    public function total_sales(Request  $request)
    {
        $cash_id = $request->cash_id;
        $only_cash = $request->only_cash;
        $with_all = $request->with_all;
        $send = $request->send;
        $sum = 0;
        $total_sales = 0;
        $total_expenses = 0;
        $total_incomes = 0;

        if ($cash_id) {
            $cash = Cash::find($cash_id);
            $beginning_balance = $cash->beginning_balance;
            $sales = Box::where('cash_id', $cash_id);
            if ($only_cash) {
                $sales = $sales->where('method', 'Efectivo');
            }

            $sales = $sales->where('expenses', 0)->where('incomes', 0)->chunk(50, function ($boxes) use (&$total_sales) {
                foreach ($boxes as $box) {
                    $amount = $box->amount;
                    if ($box->sale_note_id) {
                        $sale_note = SaleNote::find($box->sale_note_id);
                        if ($sale_note) {
                            if ($box->sale_note_payment_id) {
                                $total_sales += $amount;
                            } else {
                                $total = $sale_note->total;
                                if ($total < $amount) {
                                    $total_sales += $total;
                                } else {
                                    $total_sales += $amount;
                                }
                            }
                        }
                    } else if ($box->document_id) {
                        $document = Document::find($box->document_id);
                        if ($document) {
                            $total = $document->total;
                            if ($total < $amount) {
                                $total_sales += $total;
                            } else {
                                $total_sales += $amount;
                            }
                        }
                    }
                }
            });
            $cash_out = 0;
            if ($only_cash) {
                $cash_out = SaleNote::where('cash_id', $cash_id)
                    ->where('is_cash', 1)
                    ->where('state_type_id', '01')
                    ->sum(DB::raw('total - advances'));

                $expenses = Box::where('cash_id', $cash_id)->where('method', 'Efectivo')->where('expenses', 1)->where('incomes', 0)->chunk(50, function ($boxes) use (&$total_expenses) {
                    foreach ($boxes as $box) {
                        $amount = $box->amount;
                        $total_expenses += $amount;
                    }
                });

                $incomes = Box::where('cash_id', $cash_id)->where('method', 'Efectivo')->where('expenses', 0)->where('incomes', 1)->chunk(50, function ($boxes) use (&$total_incomes) {
                    foreach ($boxes as $box) {
                        $amount = $box->amount;
                        $total_incomes += $amount;
                    }
                });
            }
            if ($request->with_all) {
                $total_sales  = $total_sales - $total_expenses + $total_incomes - $cash_out + $beginning_balance;
            } else {
                $total_sales  = $total_sales - $total_expenses + $total_incomes - $cash_out;
            }
            $configuration = Configuration::first();
            if ($configuration->send_whatsapp_daily_cash && $configuration->number_activity && $send) {
                $user = User::find(auth()->user()->id);
                $user_name = auth()->user()->name;
                // $number = $configuration->number_activity;
                $message = "Usuario *$user_name* ha solicitado consulta para visualización en Ventas del Dìa";
                // ()
                $website = $this->getTenantWebsite();
                // (new WhatsappController)->sendMessage($message, $number);
                // WhatsappSendMessageProccess::dispatch($website->id, $message, $number);
                $configuration_establishments_numbers = $configuration->configuration_establishments_numbers;
                if ($configuration_establishments_numbers && $user->establishment_id) {
                    $numbers = EstablishmentNotificationNumber::whereIn('establishment_id', $user->establishment_id)->get()->transform(function ($row) {
                        return  (object)[
                            'number' => $row->getNumber(),
                        ];
                    });
                } else {
                    $numbers = NumberActivity::all();
                }
                foreach ($numbers as $number) {
                    if($number->number){
                        $number = $number->number;
                        // (new WhatsappController)->sendMessage($message, $number);
                        WhatsappSendMessageProccess::dispatch($website->id, $message, $number);
                    }
                }
            }
            return compact('total_sales');
        } else {

            $total_sales  = $total_sales - $total_expenses + $total_incomes;
            return   $total_sales;
        }
        // $date = Carbon::now()->format('Y-m-d');
        // $document = Document::where('date_of_issue', $date)->where('user_id', auth()->user()->id);
        // $document = $document->sum('total');
        // $saleNote = SaleNote::where('date_of_issue', $date)->where('user_id', auth()->user()->id);
        // $saleNote = $saleNote->sum('total');
        // $total_sales = $document + $saleNote;
        // return compact('total_sales');
    }
    public function income()
    {
        $group = Group::where('type', '1')->first();
        $category = Category::where('type', '1')->first();
        $subcategory = Subcategory::where('type', '1')->first();
        $groupid = $group->id;
        $categoryid = $category->id;
        $userid = auth()->user()->id;
        $subcategoryid = $subcategory->id;
        $company = Company::first();
        $soaptypeid = $company->soap_type_id;
        //dd($categoryid);
        return view('workshop::income.index', compact('groupid', 'categoryid', 'userid', 'subcategoryid', 'soaptypeid'));
    }
    public function tables()
    {
        $user = auth()->user();
        $establishment = Establishment::find($user->establishment_id);
        $gruop = Group::all();
        //buscar productos del establecimiento, y preguntar
        $sellers = Seller::where('establishment_id', $user->establishment_id)->get();
        $category = Category::all();
        $subcategory = Subcategory::all();
        $company = Company::first();
        $methods = PaymentMethodType::where('active', 1)->get();
        $desarrollador = Desarrollador::first();
        $item_default = null;
        $users = User::whereType('seller')
            ->where('active', true)
            ->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'name' => $row->name
                ];
            });
        $config = Configuration::first();
        if ($config->item_variation_id) {
            $item_default = Item::find($config->item_variation_id);
        }
        return compact(
            'gruop',
            'users',
            'category',
            'subcategory',
            'company',
            'methods',
            'desarrollador',
            'item_default'
        );
    }
    public function columns() //buscador x campo
    {
        return [

            'description'       => 'Descripción - Detalle',
            'date'              => 'Fecha',
        ];
    }
    public function record($id)
    {
        $record = new ExpensesResource(Box::findOrFail($id));
        return $record;
    }
    public function records(Request $request)
    {
        if ($request->column == 'date' && isset($request->value)) {
            $d = explode(",", $request->value);
            $d_start = $d[0];
            $d_end = $d[1];
            $records = Box::whereBetween('date', [$d_start, $d_end])->where('type', '2')->where('expenses', 1)->orderBy('id', 'desc'); //para ordenar
        } else {

            $records = Box::where($request->column, 'like', "%{$request->value}%")->where('type', '2')->where('expenses', 1)->orderBy('id', 'desc'); //para ordenar
        }
        return new BoxCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function reports_expenses(Request $request)
    {
        $company = Company::first();
        $records = Box::where($request->column, 'like', "%{$request->value}%")->where('type', '2')->where('expenses', 1)->orderBy('id', 'desc');
        $pdf = PDF::loadView('report::boxes.expenses', compact("records"))->setPaper('a4', 'landscape');
        return $pdf->stream('Reporte_Gastos_' . date('YmdHis') . '.pdf');
    }
    function avaible_cash($cash_id)
    {
        $cash = Cash::find($cash_id);
        $balance_inicial = $cash->beginning_balance;
        $egresos = Box::where('cash_id', $cash_id)->where('method', 'Efectivo')->where('expenses', 1)->sum('amount');
        $ingresos = Box::where('cash_id', $cash_id)->where('method', 'Efectivo')->where('expenses', '<>', 1)->sum('amount');


        return $balance_inicial + $ingresos - $egresos;
    }
    public function store(ExpensesRequest $request)
    {
        $configuration = Configuration::first();
        $cash_id = $request->cashid;
        if ($request->expenses && $request->method == "Efectivo") {
            $available_cash = $this->avaible_cash($cash_id);
            if ($request->amount > $available_cash) {
                return response([
                    'success' => false,
                    'message' => 'Efectivo insuficiente'
                ], 400);
            }
        }
        $company = Company::first();
        $id          = $request->input('id');
        $box         = Box::firstOrNew(['id' => $id]);
        $box->cash_id = $cash_id;
        $box->fill($request->all());
        $box->date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $box->user_id = auth()->user()->id;
        $box->soap_type_id = $company->soap_type_id;
        $box->establishment_id = auth()->user()->establishment_id;
        $box->save();
        BoxesDetail::where('boxes_id', $box->id)->delete();
        if (isset($request->items)) {
            foreach ($request->items as $item) {
                $detail = new BoxesDetail([
                    "item_detail_id" => $item["item_detail_id"],
                    "quantity" => $item["quantity"],
                    "price" => $item["price"],
                    "price_extra" => $item["extra_price"],
                    "boxes_id" => $box->id
                ]);
                $detail->save();
            }
        }
        if ($configuration->print_incomes_expenses) {
            event(new PrintEvent($box->id, "box", true, 0));
        }
        return [
            'success' => true,
            'message' => ($id) ? 'Actualizado con éxito' : 'Registrado con éxito',
            'data'    => $box
        ];
    }
    public function selecttabled($idOrden)
    {
        $table = Table::where('number', "caja")->first();
        if ($table == null) {
            $table = Table::create([
                "number"          => "caja",
                "area_id"         =>  auth()->user()->area_id,
                "status_table_id" => "2"
            ]);
        }
        $list_tables = collect(Table::where('id', $table->id)->get())->transform(function ($row) use ($idOrden) {
            $ordens = new OrdenCollection(Orden::where('id', '=', $idOrden)->where('status_orden_id', '=', 1)->get());
            return [
                'id' => $row->id,
                'number' =>  $row->number,
                'status_table_id' => $row->status_table_id,
                'ordens' => $ordens,
            ];
        });
        return $list_tables;
    }
    public function listtables()
    {
        $data = Table::where('status_table_id', '2');

        if ($data->count() == 0) {
            return [
                "success" => false,
                "message" => "No existe mesas Ocupadas"
            ];
        }
        $list_tables = collect($data->get())->transform(function ($row) {
            $ordens = new OrdenCollection(Orden::where('table_id', '=', $row->id)->where('status_orden_id', '=', 1)->get());

            return [
                'id' => $row->id,
                'number' =>  $row->number,
                'status_table_id' => $row->status_table_id,
                'ordens' => $ordens,
            ];
        });

        return $list_tables;
    }
    public function payment(Request $request)
    {
        $customer_id = $request->customer_id;
        $id = $request->id;
        $orden = Orden::find($id);
        $table = null;
        if ($orden != null) {
            $table = Table::find($orden->table_id);
        }
        $orden->customer_id = $customer_id;
        $orden->status_orden_id = 4;
        $isNoteSale = $request->document['isNoteSale'];
        if ($isNoteSale) {
            $orden->sale_note_id = $request->document['id'];
        } else {
            $orden->document_id = $request->document['id'];
        }
        $orden->save();

        if ($table && !$table->is_room) {
            $tableIsFree = Orden::where('table_id', $table->id)->where(function ($query) {
                $query->where('status_orden_id',  1)
                    ->orWhere('status_orden_id',  2)
                    ->orWhere('status_orden_id',  3);
            })
                ->count();

            if ($tableIsFree == 0) {
                $table->status_table_id = 1;
                $table->save();
            }
        }
        event(new OrdenPaidEvent(true));
        event(new StockEvent($orden->id));
        event(new OrdenPendingEvent(-1));
        return [
            'success'  => true,
            'messsage' => "Se generó con éxito el pedido"
        ];
    }
    public function search_orden_document(Request $request)
    {
        $orden_id = $request->input_item;
        $ordens = Orden::where('id', $orden_id)->first();
        if ($ordens) {
            return [
                'ordens' => $ordens,
                'success' => true
            ];
        } else {
            return [
                'message' => 'No se encontraron ordenes.',
                'ordens' => [],
                'success' => false
            ];
        }
    }
    public function search(Request $request)
    {
        $configurations = Configuration::first();
        $orden_id =  $request->input_item;
        if ($configurations->commands_fisico != "1") {
            $ordens = Orden::where('id', $orden_id)->where('status_orden_id', 1)->first();
        } else {
            $ordens = Orden::where('commands_fisico', $orden_id)->where('status_orden_id', 1)->first();
        }
        if ($ordens) {
            $items = OrdenItem::where('orden_id', $ordens->id)->get();
            //foreach ($items as $item) {
            // if ($item->status_orden_id == 1) {
            //     return [
            //         'message' => 'La orden tiene pedidos por atender.',
            //         'ordens' => [],
            //         'success' => false
            //     ];
            // }
            //}
            return [
                'ordens' => $ordens,
                'success' => true
            ];
        } else {
            return [
                'message' => 'No se encontraron ordenes.',
                'ordens' => [],
                'success' => false
            ];
        }
    }
    public function orden_update($orden_id)
    {
        $configurations = Configuration::first();
        if ($configurations->commands_fisico != "1" || $configurations->commands_fisico != true) {
            $orden = Orden::findOrFail($orden_id);
        } else {
            $orden = Orden::where('commands_fisico', $orden_id)->first();
        }
        $salenote = SaleNote::where('orden_id', $orden->id)->first();
        if ($salenote != null) {
            SaleNote::where('orden_id', $orden->id)->delete();
        }
        $document = Document::where('orden_id', $orden->id)->first();
        if ($document != null) {
            Document::where('orden_id', $orden->id)->delete();
        }
        // OrdenItem::where('orden_id', $orden_id)->delete();
        $orden_items = OrdenItem::where('orden_id', $orden_id)->get();

        foreach ($orden_items as $item) {
            $item->restoreRestaurant();
            $item->delete();
        }
        $orden_delete = Orden::findOrFail($orden->id);
        $orden_delete->delete();
        return [
            "success" => true,
            "message" => "Orden eliminada correctamente"
        ];
    }
    public function destroy_items($id)
    {
        $box = OrdenItem::findOrFail($id);
        $box->delete();
        return [
            'success' => true,
            'message' => 'Eliminado con éxito'
        ];
    }
    public function destroy($id) //Eliminar
    {
        $box = Box::findOrFail($id);

        $cash = Cash::findOrFail($box->cash_id);
        if ($cash->date_closed  != null) {
            $message = 'no se puede Eliminar el registro porque la caja se encuentra cerrada ';
        } else {
            $message = 'Eliminado con éxito';

            // $boxDetalle = BoxesDetail::findOrFail($box->id); 
            DB::connection('tenant')->select('delete from boxes_detail where boxes_id = ?', [$box->id]);
            $box->delete();
        }



        return [
            'success' => true,
            'message' => $message
        ];
    }
    public function searchCustomers(Request $request)
    {
        $customers = Person::where('number', 'like', "%{$request->input}%")
            ->orWhere('name', 'like', "%{$request->input}%")
            ->orWhere('alias', 'like', "%{$request->input}%")
            ->whereType('customers')
            ->whereIsEnabled()
            ->orderBy('name');

        if ($request->credit_list) {
            $customers = $customers->where('has_credit_line', 1);
        }

        $customers = $customers->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'description' => ($row->alias ? $row->alias . ' - ' : '') . $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'has_credit_line' => (bool) $row->has_credit_line,
                'credit_line' => $row->credit_line,
                'identity_document_type_id' => $row->identity_document_type_id,
                'identity_document_type_code' => $row->identity_document_type->code,
                'addresses' => $row->addresses,
                'address' => $row->address,
                'seller_id' => $row->seller_id
            ];
        });

        return compact('customers');
    }
    public function searchCustomerById($id)
    {

        $customers = Person::with('addresses')->whereType('customers')
            ->where('id', $id)
            ->get()->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => $row->number . ' - ' . $row->name,
                    'name' => $row->name,
                    'number' => $row->number,
                    'phone' => $row->telephone,
                    'addresses' => $row->addresses,
                    'address' =>  $row->address,
                    'client_zone_id' => $row->client_zone_id,
                ];
            });

        return compact('customers');
    }
}
