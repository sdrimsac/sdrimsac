<?php

namespace Modules\Restaurant\Http\Controllers;


use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use App\Models\Tenant\User;
use App\Models\Tenant\UserItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\UserSchedule;
use Modules\Restaurant\Models\UserScheduleDay;

class EstilistaController extends Controller
{

    public function index()
    {
        $configuration = Configuration::first();
        $establishment = Establishment::find(auth()->user()->establishment_id);
        return view('restaurant::estilista.timework', compact('configuration', 'establishment'));
    }

    public function workers()
    {
        $users = User::whereHas('worker_type', function ($query) {
            $query->where('description', 'ESTILISTA');
        })->get()->transform(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];
        });
        return response()->json($users);
    }

    public function getUserItems(Request $request){
        $user = User::find($request->user_id);
        $items = $user->user_items()->get()->transform(function ($item) {
            return [
                'id' => $item->item->id,
                'description' => $item->item->description,
                'sale_unit_price' => $item->item->sale_unit_price,
                'internal_id' => $item->item->internal_id,
            ];
        });
        return response()->json($items);
    }
    public function getIndividualServices(Request $request){
        $input = $request->input;
        $services = Item::where('description', 'like', '%'.$input.'%')->where('unit_type_id', 'ZZ')->get()->transform(function ($item) {
            return [
                'id' => $item->id,
                'description' => $item->description,
                'internal_id' => $item->internal_id,
                'sale_unit_price' => $item->sale_unit_price,
            ];
        });
        return [
            'items' => $services,
        ];
    }
    public function getServices($category_id)
    {
        $services = Item::where('category_id', $category_id)->where('unit_type_id', 'ZZ')->get()->transform(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->description,
                'internal_id' => $item->internal_id,
                'sale_unit_price' => $item->sale_unit_price,
                'users_id' => UserItem::where('item_id', $item->id)->pluck('user_id'),
            ];
        });
        return response()->json($services);
    }
    
    public function schedule(Request $request)
    {
        $user = User::find($request->user_id);
        $date = $request->date;
        $get_number_day = date('w', strtotime($date));
        $schedule = UserScheduleDay::where('day_of_week', $get_number_day)->whereHas('schedule', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->first();
        return response()->json($schedule);
    }
}
