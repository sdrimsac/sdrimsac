<?php

namespace Modules\Restaurant\Http\Controllers;

use Exception;
use App\Models\Tenant\Cash;
use App\Models\Tenant\User;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Desarrollador;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Mozo;
use App\Models\Tenant\Warehouse;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\Food;
use Illuminate\Support\Facades\Auth;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\Table;
use Modules\Item\Models\CategoryItem;
use Modules\Restaurant\Http\Resources\FoodCollection;
use Modules\Restaurant\Models\StatusTable;
use Modules\Restaurant\Models\CategoryFood;
use Modules\Restaurant\Http\Resources\TableCollection;
use Modules\Restaurant\Models\WorkersType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function ver($id){
        // obtener el foods con el id
        $food = Food::find($id);
        // retornar la vista con el food
        return compact('food');
    }


    public function foods(Request $request)
    {
        $category_ins =  CategoryItem::where('name', 'INSUMOS')->first();
        $category_ins_id = null;
        if ($category_ins) {
            $category_ins_id = $category_ins->id;
        }
        /* $category_id = $request->category; */
        $category_id = $request->category;
        $value = $request->value;
        $foods = Food::query();
        $user = auth()->user();
        $warehouse_product_id = $user->warehouse_product_id;
        if ($warehouse_product_id) {
            $foods = $foods->whereHas('item', function ($query) use ($warehouse_product_id) {
                $query
                    ->where('active', 1)
                    ->whereHas('warehouses', function ($query) use ($warehouse_product_id) {
                        $query->where('warehouse_id', $warehouse_product_id);
                    }) 
                    ->whereHas('warehouses', function ($query) use ($warehouse_product_id) {
                        
                        $query->where('active', 1)
                            ->where('warehouse_id', $warehouse_product_id);
                    });
            });
        }
        if ($category_id) {

            $foods = $foods->where('category_food_id', $category_id);
        }
        if ($category_ins_id) {
            $foods = $foods->where('category_food_id', '<>', $category_ins_id);
        }
        if ($value) {

            $foods = $foods->where(function ($query) use ($value) {
                $query->where('description', 'LIKE', '%' . $value . '%')->orWhere('code', 'LIKE', '%' . $value . '%');
            });
        }

        return new FoodCollection($foods->paginate(config('tenant.items_per_page')));

        //  return Food::all();
        //     return new InventoryCollection($reports->paginate(config('tenant.items_per_page')));
    }
    public function salonPos()
    {

        $user = auth()->user();
        $worker_types = WorkersType::where(function ($query) {
            $searchValue = '%search_value%';
            foreach (['CAJ', 'caj', 'VEN', 'ANALI', 'anali', 'ven'] as $value) {
                $query->orWhere('description', 'LIKE', str_replace('search_value', $value, $searchValue));
            }
        })->get();
        $worker_type_ids = $worker_types->pluck('id');
        if (!$worker_type_ids->contains($user->worker_type_id)) {

            // if ($user->worker_type_id != $id) {
            return redirect('/');
            // }
        }
        $user_id = $user->id;
        $cash = Cash::where('user_id', $user_id)
            ->where('state', 1)
            ->first();


        // if ($cash == null) {
        //     return redirect()->route('restaurant.cash.index');
        // }
        // if($cash->date_opening==$date && $cash->date_closed==null && $cash->state==1){
        //     return redirect()-> route('restaurant.cash.index');
        // }
        // if ($cash->date_opening == $date && $cash->date_closed != null && $cash->state == 0) {
        //     return redirect()->route('restaurant.cash.index');
        // }
        $worker = true;
        $area_id = auth()->user()->area_id;
        $company = Company::first();
        $desarrollador = Desarrollador::first();
        $configuration = Configuration::first();
        $establishments = Establishment::where('id', auth()->user()->establishment_id)->first();
        $auth_login = auth()->user()->id;
        $cash_id = $cash ? $cash->id : 0;
        $pending_order = Orden::where('status_orden_id', '<>', 4)->count();
        $lareaId = $area_id;
        return view('restaurant::pos.salon', compact('pending_order', 'lareaId', 'area_id', 'cash_id', 'worker', 'establishments', 'configuration', 'auth_login', 'company', 'desarrollador'));
    }
    public function rentPos()
    {

        $user = auth()->user();
        $worker_types = WorkersType::where(function ($query) {
            $searchValue = '%search_value%';
            foreach (['CAJ', 'caj', 'VEN', 'ANALI', 'anali', 'ven'] as $value) {
                $query->orWhere('description', 'LIKE', str_replace('search_value', $value, $searchValue));
            }
        })->get();
        $worker_type_ids = $worker_types->pluck('id');
        if (!$worker_type_ids->contains($user->worker_type_id)) {

            // if ($user->worker_type_id != $id) {
            return redirect('/');
            // }
        }
        $user_id = $user->id;
        $cash = Cash::where('user_id', $user_id)
            ->where('state', 1)
            ->first();


        // if ($cash == null) {
        //     return redirect()->route('restaurant.cash.index');
        // }
        // if($cash->date_opening==$date && $cash->date_closed==null && $cash->state==1){
        //     return redirect()-> route('restaurant.cash.index');
        // }
        // if ($cash->date_opening == $date && $cash->date_closed != null && $cash->state == 0) {
        //     return redirect()->route('restaurant.cash.index');
        // }
        $worker = true;
        $area_id = auth()->user()->area_id;
        $company = Company::first();
        $desarrollador = Desarrollador::first();
        $configuration = Configuration::first();
        $establishments = Establishment::where('id', auth()->user()->establishment_id)->first();
        $auth_login = auth()->user()->id;
        $cash_id = $cash ? $cash->id : 0;
        $pending_order = Orden::where('status_orden_id', '<>', 4)->count();
        $lareaId = $area_id;
        return view('restaurant::pos.rent', compact('pending_order', 'lareaId', 'area_id', 'cash_id', 'worker', 'establishments', 'configuration', 'auth_login', 'company', 'desarrollador'));
    }
    public function pos()
    {
        $now = Carbon::now()->format('Y-m-d');
        $first_day_month = Carbon::now()->startOfMonth()->format('Y-m-d');
        $company = Company::first();
        $limit_month_amount = $company->limit_month_amount;
        $month_amount = DB::connection('tenant')
            ->table('documents')
            ->whereIn('state_type_id', ['01','03','05'] )
            ->where('document_type_id', '!=', '07')
            ->where('date_of_issue', '>=', $first_day_month)
            ->where('date_of_issue', '<=', $now)
            ->sum('total');
        $user = auth()->user();
        $worker_types = WorkersType::where(function ($query) {
            $searchValue = '%search_value%';
            foreach (['CAJ', 'caj', 'VEN', 'ANALI', 'anali', 'ven'] as $value) {
                $query->orWhere('description', 'LIKE', str_replace('search_value', $value, $searchValue));
            }
        })->get();
        $worker_type_ids = $worker_types->pluck('id');
        if (!$worker_type_ids->contains($user->worker_type_id)) {

            // if ($user->worker_type_id != $id) {
            return redirect('/');
            // }
        }
        $user_id = $user->id;
        $cash = Cash::where('user_id', $user_id)
            ->where('state', 1)
            ->get()
            ->last();


        // if ($cash == null) {
        //     return redirect()->route('restaurant.cash.index');
        // }
        // if($cash->date_opening==$date && $cash->date_closed==null && $cash->state==1){
        //     return redirect()-> route('restaurant.cash.index');
        // }
        // if ($cash->date_opening == $date && $cash->date_closed != null && $cash->state == 0) {
        //     return redirect()->route('restaurant.cash.index');
        // }
        $worker = true;
        $area_id = auth()->user()->area_id;
        $company = Company::first();
        $desarrollador = Desarrollador::first();
        $configuration = Configuration::first();
        $establishments = Establishment::where('id', auth()->user()->establishment_id)->first();
        $auth_login = auth()->user()->id;
        $cash_id = $cash ? $cash->id : 0;
        $pending_order = Orden::where('status_orden_id', '<>', 4)->count();
        $lareaId = $area_id;
        return view('restaurant::pos.dashboard', compact(
            'limit_month_amount',
            'month_amount',
            'pending_order',
            'lareaId',
            'area_id',
            'cash_id',
            'worker', 'establishments', 'configuration', 'auth_login', 'company', 'desarrollador'));
    }

    public function kitchen()
    {
        $areas = Area::where('id', 3)->get();
        $user = Auth::user();
        $area_id = $user->area_id;
        $tables = new TableCollection(Table::where('area_id', $user->area_id)->get());
        $foods = Food::all();

        $configuration = Configuration::first();
        $categories = CategoryItem::all();
        $status_table = StatusTable::all();

        return view('restaurant::kitchen.dashboard', compact('configuration', 'areas', 'area_id', 'foods', 'categories', 'status_table'));
    }
    public function index()
    {

        try {
            $user = Auth::user();
            $establishment_table_id = $user->establishment_table_id;
            $areas = Area::where('id', auth()->user()->area_id)->get();
            $table = Table::where('area_id', $areas[0]->id)->first();

            //dd($areas,$table);
            $category_ins = CategoryItem::where('name', 'INSUMOS')->first();
            $category_ins_id = null;
            if ($category_ins) {
                $category_ins_id = $category_ins->id;
            }
            if ($table != null) {
                $tables_active = new TableCollection(Table::where('area_id', $areas[0]->id)->first());
                $tables = Table::where('area_id', $areas[0]->id);
                if ($establishment_table_id) {
                    $tables = $tables->where('establishment_id', $establishment_table_id);
                }
                $tables_area = collect($tables->get())->transform(function ($row) use ($category_ins_id) {
                    $orden = Orden::where('table_id', $row->id)->where('status_orden_id', '!=', 4)->get();
                    return [
                        'id'                => $row->id,
                        'number'            => $row->number,
                        'area'        => $row->area,
                        'referncia' => $row->ref,
                        'status_table'     => $row->status_table,
                        'orden'          => $orden,
                    ];
                });
            } else {
                $tables_active = [];
                $tables_area = "[]";
            }

            $configuration = Configuration::first();
            $company = Company::first();
            // $tables = new TableCollection(Table::where('area_id', $user->area_id)->get());
            // $foods =  Food::all();

            // $select_category = CategoryItem::first();
            // $select_category_id = $select_category->id;
            $categories = CategoryItem::where('id', '<>', $category_ins_id)->get();
            $status_table = StatusTable::all();
            return view('restaurant::worker.index', compact('configuration', 'areas', 'tables_active', 'categories', 'status_table', 'company', 'tables_area'));
        } catch (Exception $e) {
            return [
                "message" => $e->getMessage(),
                "line" => $e->getLine(),
                "file" => $e->getFile(),
            ];
        }
    }
    public function tables($area_id)
    {
        $tables = Table::where('area_id', $area_id)->get();

        return [
            'success' => true,
            'data' => $tables
        ];
    }

    public function data_table()
    {
        $mozos = Mozo::where('active', 1)->get();
        return compact('mozos');
    }
}
