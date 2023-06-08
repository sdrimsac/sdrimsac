<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\RegisterMovementCollection;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\RegisterMovement;
use App\Models\Tenant\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $all_models = [];

    //constructor
    public function __construct() {
        $this->all_models = [
            "orden" => "Modules\Restaurant\Models\Orden",
            "table" => "Modules\Restaurant\Models\Table",
            "area" => "Modules\Restaurant\Models\Area",
            "food" => "Modules\Restaurant\Models\Food",
            "ordenItem" => "Modules\Restaurant\Models\OrdenItem",
            "document" => "App\Models\Document",
            "saleNote" => "App\Models\SaleNote",
            "purchase" => "App\Models\Purchase",
            "box" => "App\Models\Box",
        ];
    }
          
            

    
    public function tables() {
        $users = User::all();

        return compact('users');

    }
    public function columns() {

        return [
            'user_id' => 'Usuario',
            'date_of_issue' => 'Fecha de actividad',
            'description' => 'Descripción',
            'event_description' => 'Evento',
            'model' => 'Modelo'
        ];
    }
    public function index() {
        $configuration = Configuration::first();
        $user_type = auth()->user()->type;
            
        return view('tenant.registers.index', compact('configuration', 'user_type'));
    }
    
    public function records(Request $request){

        $records = RegisterMovement::query();
        $column = $request->column;
        $value = $request->value;

        if($column && $value){
            switch ($column) {
                case 'user_id':
                    $records = $records->where('user_id', $value);
                    break;
                case 'date_of_issue':
                    $records = $records->whereDate('created_at', $value);
                    break;
                case 'description':
                    $records = $records->where('description', 'like', "%{$value}%");
                    break;
                case 'event_description':
                    $records = $records->where('event', $value);
                    break;
                case 'model':
                    $model = $this->get_model($value);
                    if($model){
                        $records = $records->where('model', $model);
                    }
                    break;
            }
        }

        $records = $records->orderBy('id', 'desc');


        return new RegisterMovementCollection($records->paginate(config('tenant.items_per_page')));

    }
     function get_model($model){
        if(array_key_exists($model, $this->all_models)){
            return $this->all_models[$model];
        }else{
            return null;
        }
     }

    public function record(){


    }

    public function store(){


    }

    public function destroy(){


    }

}
