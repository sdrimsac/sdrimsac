<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\BankAccountRequest;
use App\Http\Resources\Tenant\BankAccountCollection;
use App\Http\Resources\Tenant\BankAccountResource;
use App\Http\Resources\Tenant\FoodsShop;
use App\Http\Resources\Tenant\FoodsShopCollection;
use App\Models\Tenant\Bank;
use App\Models\Tenant\BankAccount;
use App\Models\Tenant\Box;
use App\Models\Tenant\Catalogs\CurrencyType;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use Carbon\Carbon;
use Exception;
use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LDAP\Result;
use Modules\Report\Exports\ComisionReportExport;
use Modules\Restaurant\Models\OrdenItem;

class FoodsController extends Controller
{
    public function index()
    {
        return view('tenant.foods.index');
    }
    public function columns()
    {
        return [
            'description' => 'Descripción',
        ];
    }


    public function records(Request $request)
    {
        $records = $this->getRecords($request);
        return new FoodsShopCollection($records->paginate(20));
    }

    public function getRecords(Request $request)
    {
        $food_id = $request->input('food_id');
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');
        $date = $request->input('date');

        $records = Food::select(
            'foods.id as food_id',
            'foods.description',
            'orden_item.price',
            'items.commission',
            DB::raw('SUM(orden_item.quantity) as quantity'),
            DB::raw('ROUND(SUM(orden_item.quantity * orden_item.price), 2) as total'),
            DB::raw('ROUND(SUM(orden_item.quantity * items.commission), 2) as commission_total')
        )
            ->join('orden_item', 'foods.id', '=', 'orden_item.food_id')
            ->join('items', 'foods.item_id', '=', 'items.id')
            ->where('orden_item.status_orden_id', 4)
            ->where('items.commission', '>', 0.01);

        if ($date_start && $date_end) {
            $records->whereBetween('orden_item.date', [$date_start, $date_end]);
        } elseif ($date) {
            $records->where('orden_item.date', '=', $date);
        }

        if ($food_id) {
            $records->where('foods.id', '=', $food_id);
        }

        $records->groupBy('foods.id', 'foods.description', 'orden_item.price', 'items.commission')
            ->orderBy('foods.description', 'asc');

        return $records;
    }

    public function tables()
    {
        $foods = Food::select('id', 'description')->get();

        return compact('foods');
    }

    public function exportExcel(Request $request ){

        $records = $this->getRecords($request)->get();

        $company = Company::first();
        $establishment = Establishment::first();
        $food_id = $request->input('food_id');
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');
        $date = $request->input('date');

        

        return (new ComisionReportExport)
            ->establishment($establishment)
            ->company($company)
            ->records($records)
            ->date_start($date_start)
            ->date($date)
            ->food_id($food_id)
            ->date_end($date_end)
            ->download('Reporte_productos_comision' . Carbon::now() . '.xlsx');


    }

}
