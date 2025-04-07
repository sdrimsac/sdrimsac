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
use App\Models\Tenant\Item;
use Exception;
use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\Orden;
use Illuminate\Http\Request;
use LDAP\Result;
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
        $records = OrdenItem::where('status_orden_id', '4'); 

        if ($date_start && $date_end) {
            $records->whereBetween('date', [$date_start, $date_end]);
        } elseif ($date) {
            $records->where('date', '=', $date);
        }

        if ($food_id) {
            $records->where('food_id', '=', $food_id);
        }

        return $records->orderBy('date', 'desc');
    }

    public function tables()
    {
        $foods = Food::select('id', 'description')->get();

        return compact('foods');
    }

    public function store(BankAccountRequest $request)
    {
        
    }
}
