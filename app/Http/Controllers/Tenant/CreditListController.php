<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Exports\CreditListExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\CreditListCollection;
use App\Http\Resources\Tenant\CreditListPersonCollection;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\CreditList;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\InventoryKardex;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Series;
use App\Models\Tenant\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\Table;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Modules\Restaurant\Events\OrdenEvent;
use Modules\Restaurant\Events\PrintEvent;
use Modules\Restaurant\Models\Food;

class CreditListController extends Controller
{
    public function getData($request)
    {
        $establishment_id = $request->establishment_id;
        $person_id = $request->person_id;
        $date = $request->date;
        $paid = $request->paid != null ? ($request->paid == "0" ? false : true) : null;
        $orden_items = OrdenItem::query();
        $orden_items->whereHas('orden', function ($q) use ($establishment_id, $person_id, $date, $paid) {
            $q->whereHas('credit_list', function ($qq) use ($establishment_id, $person_id, $date, $paid) {
                $qq->where('customer_id', $person_id);
                if ($establishment_id) {
                    $qq->where('establishment_id', $establishment_id);
                }
                if ($date) {
                    $date = Carbon::parse($date)->format('m');
                    //date es un inicio de un mes, deseo buscar registros con esos mes en la columna created_at
                    $qq->whereMonth('created_at', $date);
                }
                if ($paid !== null) {
                    $qq->where('paid', $paid);
                }
            });
        });

        return $orden_items;
    }
    public function download(Request $request)
    {
        $company = Company::first();
        $records = $this->getData($request)->get();
        return (new CreditListExport)
            ->records($records)
            ->company($company)
            ->download('Lista_de_credito_' . Carbon::now() . '.xlsx');
    }

    public function receipt($id)
    {
        $credit_list = CreditList::find($id);
        $customer = $credit_list->customer;
        $user = $credit_list->seller;
        $orden = $credit_list->orden;
        $total = $orden->getTotal();
        $company = Company::first();
        $count_items = $orden->orden_items->count();


        $height = 10  * 30;
        if ($count_items > 8) {
            $height = $count_items * 30;
        }
        try {
            $pdf = PDF::loadView('restaurant::credit_list.receipt', compact(
                "credit_list",
                "customer",
                "user",
                "orden",
                "total",
                "company",
            ))
                ->setPaper(array(0, 0, 249.45, $height));
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }

        return $pdf->stream('pdf_file.pdf');
    }
    public function recordByPersonToPay(Request $request)
    {
        $request['paid'] = "0";
        $orden_items = $this->getData($request);
        $records = $orden_items->get();
        return [
            'success' => true,
            'records' => $records,
        ];
    }
    public function recordByPerson(Request $request)
    {

        $orden_items = $this->getData($request);

        return new CreditListPersonCollection($orden_items->paginate(config('tenant.items_per_page')));
    }
    public function credit_list_report_index(Request $request)
    {

        return view('tenant.credit_list.index');
    }

    private function updateStock($item_id, $quantity, $warehouse_id)
    {

        // $inventory_configuration = InventoryConfiguration::firstOrFail();
        $configuration = Configuration::firstOrFail();
        if ($configuration->college) {

            $item_warehouse = ItemWarehouse::where('item_id', $item_id)->first();
            if (!isset($item_warehouse)) {
                $item_warehouse = ItemWarehouse::firstOrNew(['item_id' => $item_id, 'warehouse_id' => $warehouse_id]);
            }
        } else {

            $item_warehouse = ItemWarehouse::firstOrNew(['item_id' => $item_id, 'warehouse_id' => $warehouse_id]);
        }
        //$item=Item::findOrFail($item_id);
        //     $item->stock=$item_warehouse->stock + $quantity;
        $item_warehouse->stock = $item_warehouse->stock + $quantity;
        if ($quantity < 0 && $item_warehouse->item->unit_type_id !== 'ZZ') {
            if (($configuration->sales_stock) && ($item_warehouse->stock < 0)) {

                throw new Exception("El producto {$item_warehouse->item->description} no tiene suficiente stock!");
            }
        }
        $item_warehouse->save();
        // $item-save();
    }
    function findWarehouse()
    {
        $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();
        if (!$warehouse) {
            $warehouse = Warehouse::create([
                'description' => 'Almacén',
                'establishment_id' => auth()->user()->establishment_id,
            ]);
        }
        return $warehouse;
    }
    function createInventoryKardex($item_id, $quantity, $warehouse_id,$credit_list)
    {
        InventoryKardex::create([
            'inventory_kardexable_id' => $credit_list->id,
            'inventory_kardexable_type' => 'App\Models\Tenant\CreditList',
            'item_id' => $item_id,
            'date_of_issue' => date('Y-m-d'),
            'warehouse_id' => $warehouse_id,
            'quantity' => $quantity,
            'type' => 'output',
        ]);
    }
    function update_stock($credit_list)
    {
        $orden = Orden::find($credit_list->orden_id);
        $items = $orden->orden_items;
        $warehouse = $this->findWarehouse();
        foreach ($items as $orden_item) {
            $food_id = $orden_item->food_id;
            $quantity = $orden_item->quantity * -1;
            $food = Food::find($food_id);
            $item_id = $food->item_id;
            $item = Item::find($item_id);
            if ($item->unit_type_id  !== 'ZZ') {
                if (!$item->is_set) {
    
                    $this->createInventoryKardex($item_id, $quantity, $warehouse->id,$credit_list);
                    $this->updateStock($item_id, $quantity, $warehouse->id);
                } else {
                }
            }
        }
      
    }
    public function send_credit(Request $request)
    {   
        $configuration = Configuration::firstOrFail();
        $user = auth()->user();
        try{
            DB::beginTransaction();
            $customer_id = $request->customer_id;
        $items = $request->items;
        $user_id = auth()->id();
        $table_caja_id = Table::get_caja();
        $status_orden_id = 4;
        $orden = Orden::create([
            'table_id' => $table_caja_id,
            'status_orden_id' => $status_orden_id,
            'date' => date('Y-m-d'),
        ]);
        $orden_items_ids = [];
        $orden_items_ids_for_kitchen = [];
        foreach ($items as $item) {
            $orden_item = new OrdenItem;
            $orden_item->food_id = $item['food']['id'];
            $orden_item->observations = $item['observation'] ?? '-';
            $orden_item->quantity = $item['quantity'];
            $orden_item->unit_type_id = Functions::valueKeyInArray($item, 'type_id', null);
            $orden_item->price = $item['price'];
            $orden_item->user_id = $user_id;
            $orden_item->orden_id = $orden->id;
            $orden_item->to_carry = Functions::valueKeyInArray($item, 'to_carry', 0);
            $orden_item->status_orden_id = 1;
            $orden_item->date = Carbon::today();
            $orden_item->time = date('H:i:s');
            $orden_item->area_id = $item['food']['area_id'];
            $orden_item->save();
            $orden_items_ids[] = $orden_item->id;
            $orden_items_ids_for_kitchen[] = [
                "orden_id" => $orden_item->id,
                "area_id" => $orden_item->area_id
            ];
            event(new OrdenEvent($orden_item->id));
        }
        $print_box = $configuration->print_commands ;
        $print_kitchen = $configuration->print_kitchen;
        if ($print_kitchen) {
            $ids_areas = array_unique(array_column($orden_items_ids_for_kitchen, "area_id"));
            foreach ($ids_areas as $area_id) {
                $filtered = array_column(array_filter($orden_items_ids_for_kitchen, function ($a) use ($area_id) {
                    return $area_id == $a['area_id'];
                }), "orden_id");
                event(new PrintEvent($orden->id, "0", true, $area_id, $filtered));
            }
        }
        // $isFromBox = $this->isArea("CAJ", $user->area_id);

        if ($print_box) {
            event(new PrintEvent($orden->id, "0", true, $this->getBoxArea(), $orden_items_ids));
        }
        $credit_list =  CreditList::create([
            'orden_id' => $orden->id,
            'customer_id' => $customer_id,
            'user_id' => $user_id,
            'establishment_id' => auth()->user()->establishment_id,
            'observation' => $request->observation,
            'paid' => false,
        ]);
        $this->update_stock($credit_list);

        event(new PrintEvent($credit_list->id, 'S', true, null, []));
        sleep(1);
        event(new PrintEvent($credit_list->id, 'S', true, null, []));

        DB::commit();

        return [
            'success' => true,
            'message' => 'Credito enviado correctamente'
        ];
        }catch(Exception $e){
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        // $orden_id = $request->orden_id;
    }
    public function tables()
    {
        $establishments = Establishment::all();
        $series = Series::all();
        return [
            'success' => true,
            'establishments' => $establishments,
            'series' => $series,
        ];
    }
    public function records()
    {
        //saca los registros que tengan paid en false pero agrupados por customer_id
        $credit_lists = CreditList::select('customer_id', DB::raw('count(*) as count'))
            ->where('paid', false)
            ->groupBy('customer_id');

        return new CreditListCollection($credit_lists->paginate(config('tenant.items_per_page')));
    }
    public function get_ordens($customer_id)
    {
        $credit_lists = CreditList::where('customer_id', $customer_id)
            ->where('paid', false)
            ->with(['orden.orden_items'])
            ->get()
            ->flatMap(function ($creditList) {
                return $creditList->orden->orden_items->map(function ($ordenItem) {
                    return [
                        'id' => $ordenItem->id,
                        'food' => $ordenItem->food,
                        'observations' => $ordenItem->observations,
                        'quantity' => $ordenItem->quantity,
                        'unit_type_id' => $ordenItem->unit_type_id,
                        'price' => $ordenItem->price,
                        'user_id' => $ordenItem->user_id,
                        'orden_id' => $ordenItem->orden_id,
                        'to_carry' => $ordenItem->to_carry,
                        'status_orden_id' => $ordenItem->status_orden_id,
                        'date' => $ordenItem->date,
                        'time' => $ordenItem->time,
                        'area_id' => $ordenItem->area_id,
                    ];
                });
            });

        return $credit_lists;
    }
    public function get_balance($customer_id)
    {
        $balance = CreditList::where('customer_id', $customer_id)
            ->where('paid', false)
            ->with(['orden.orden_items'])
            ->get()
            ->flatMap(function ($creditList) {
                return $creditList->orden->orden_items->map(function ($ordenItem) {
                    return $ordenItem->quantity * $ordenItem->price;
                });
            })
            ->sum();

        return $balance;
    }
}
