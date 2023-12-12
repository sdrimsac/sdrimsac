<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\UserRequest;
use App\Http\Resources\Tenant\UserResource;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Module;
use App\Models\Tenant\User;
use Illuminate\Http\Request;
use App\Http\Resources\Tenant\UserCollection;
use App\Models\Tenant\Desarrollador;
use Exception;
use Modules\LevelAccess\Models\ModuleLevel;

class UserController extends Controller
{


    public function getAreaPrinter()
    {
        try {
            $printer = null;
            $user = auth()->user();
            $area_id = $user->area_id;
            if ($area_id) {
                $printer = $user->area->printer;
            } else {
                $establishment_id = $user->establishment_id;
                $establishment = Establishment::find($establishment_id);
                $printer = $establishment->printer;
            }
            return [
                'success' => true,
                'printer' => $printer
            ];
        } catch (Exception $e) {
            return [
                'success' => false,

            ];
        }
    }
    public function index()
    {
        //   $type = [['type' => 'admin', 'description'=>'Administrador'], ['type' => 'seller', 'description'=>'Vendedor'],['type' => 'driver', 'description'=>'Conductor']];
        $type = 'users';
        return view('tenant.users.index', compact('type'));
    }
    public function driver_index()
    {
        $type = 'drivers';

        return view('tenant.users.index', compact('type'));
    }

    public function getDesarrollador()
    {

        $name = config('app.desarrollador');
        if (!$name) {
            $name = "Sdrimsac Solutions";
        }

        return $name;
    }
    public function update_pin(Request  $request)
    {
        $pin = $request->input('pin');
        $user = User::findOrFail($request->input('id'));
        $user->pin = $pin;
        $user->save();
        return [
            'success' => true,
            'message' => 'Pin actualizado con éxito'
        ];
    }
    public function columns()
    {
        return [
            'name' => 'Nombre',
            'number' => 'Número',
            'email' => 'Email'
        ];
    }
    public function record($id)
    {
        $record = new UserResource(User::findOrFail($id));

        return $record;
    }

    public function tables()
    {
        $modules = Module::orderBy('description')->get();
        $establishments = Establishment::orderBy('description')->get();
        $api_service_token = config('configuration.api_service_token');
        $types = [['type' => 'admin', 'description' => 'Administrador'], ['type' => 'seller', 'description' => 'Vendedor'], ['type' => 'drivers', 'description' => 'Conductor']];

        return compact('modules', 'establishments', 'types', 'api_service_token');
    }

    public function store(UserRequest $request)
    {
        $id = $request->input('id');

        if (!$id)  //VALIDAR EMAIL DISPONIBLE
        {
            $verify = User::where('email', $request->input('email'))->first();
            if ($verify) {
                return [
                    'success' => false,
                    'message' => 'Email no disponible. Ingrese otro Email'
                ];
            }
        }

        $user = User::firstOrNew(['id' => $id]);
        $user->name = $request->input('name');
        $user->number = $request->input('number');
        $user->email = $request->input('email');
        $user->establishment_id = $request->input('establishment_id');
        $user->type = $request->input('type');
        $user->license = $request->input('license');
        $user->category = $request->input('category');
        // 'license' => $this->license,
        if (!$id) {
            $user->api_token = str_random(50);
            $user->password = bcrypt($request->input('password'));
        } elseif ($request->has('password')) {
            if (config('tenant.password_change')) {
                $user->password = bcrypt($request->input('password'));
            }
        }
        $user->save();

        $modules = collect($request->input('modules'))->where('checked', true)->pluck('id')->toArray();
        $user->modules()->sync($modules);


        $levels = collect($request->input('levels'))->where('checked', true)->pluck('id')->toArray();
        $user->levels()->sync($levels);

        // dd($user->getModules()->transform(function($row, $key) {
        //     return [
        //         'id' => $row->id,
        //         'privot_id' => $row->pivot,
        //         'privot_user' => $row->pivot->user_id,
        //         'privot_module' => $row->pivot->module_id, 

        //     ];
        // }));

        return [
            'success' => true,
            'message' => ($id) ? 'Usuario actualizado' : 'Usuario registrado'
        ];
    }

    public function usertype()
    {
        $records = User::where('type', 'admin'); //$this->getRecords($request);
        return new UserCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function records($type)
    {

        if ($type == "users") {
            $records = User::orderBy('id');
        } else {
            $records = User::where('type', $type);
        }
        return new UserCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function filter(Request $request)
    {
        $records = User::where($request->column, 'like', "%{$request->value}%")->orderBy('number');
        return new UserCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return [
            'success' => true,
            'message' => 'Usuario eliminado con éxito'
        ];
    }
}
