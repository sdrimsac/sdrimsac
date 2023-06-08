<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\VehicleRequest;
use App\Http\Resources\Tenant\VehicleResource;
use App\Models\Tenant\Vehicle;
  use Illuminate\Http\Request;
use App\Http\Resources\Tenant\VehicleCollection;
 
class VehicleController extends Controller
{
    public function index()
    {
     //   $type = [['type' => 'admin', 'description'=>'Administrador'], ['type' => 'seller', 'description'=>'Vendedor'],['type' => 'driver', 'description'=>'Conductor']];
     $type ='vehicle';
     return view('tenant.vehicle.index');
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
        $record = new VehicleResource(User::findOrFail($id));
        return $record;
    }

    public function tables()
    {

    }

    public function store(UserRequest $request)
    {
        $id = $request->input('id');
        $user = User::firstOrNew(['id' => $id]);
        $box->fill($request->all());
        $user->save();
        return [
            'success' => true,
            'message' => ($id)?'Usuario actualizado':'Usuario registrado'
        ];
    }
 
    public function records($type)
    {
 
        $records = Vehicle::where('type', $type) ;
        return new VehicleCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->save();


        return [
            'success' => true,
             'message' => 'Vehiculo eliminado con éxito'
        ];

    }
}
