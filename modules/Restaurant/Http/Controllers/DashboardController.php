<?php

namespace Modules\Restaurant\Http\Controllers;

use Exception;
use App\Models\Tenant\Cash;
use App\Models\Tenant\User;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Desarrollador;
use App\Models\Tenant\Establishment;
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

class DashboardController extends Controller
{


    public function foods(Request $request)
    {
        $category_id = $request->category;
        $value = $request->value;
        $foods = Food::query();
        if ($category_id) {

            $foods = $foods->where('category_food_id', $category_id);
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
    public function pos()
    {
        $user = auth()->user();
        $cash_worker = WorkersType::where('description', 'like', '%CAJ%')->orWhere('description', 'like', '%caj%')->first();
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
        return view('restaurant::pos.dashboard', compact('pending_order', 'area_id', 'cash_id', 'worker', 'establishments', 'configuration', 'auth_login', 'company', 'desarrollador'));
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
            if ($table != null) {
                $tables_active = new TableCollection(Table::where('area_id', $areas[0]->id)->first());
                $tables =Table::where('area_id', $areas[0]->id);
                // dump($establishment_table_id);
                if($establishment_table_id){
                    $tables = $tables->where('establishment_id', $establishment_table_id);
                }
                $tables_area = collect($tables->get())->transform(function ($row) {
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

            $select_category = CategoryItem::first();
            $select_category_id = $select_category->id;
            $categories = CategoryItem::all();
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
}
