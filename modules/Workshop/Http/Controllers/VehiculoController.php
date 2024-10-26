<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\workshop\Http\Resources\VehiculoCollection;
use Modules\workshop\Http\Resources\VehiculoResource;
use Modules\workshop\Http\Requests\VehiculoRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Workshop\Models\Historial;
use Modules\Workshop\Models\Vehiculo;
use Modules\Workshop\Models\HistorialItem;

class VehiculoController extends Controller
{
    public function index()
    {
        return view('workshop::vehiculo.index');
    }
    public function records(Request $request)
    {
        /* $records = Vehiculo::all(); */
        $records = $this->getRecords($request);

        return new VehiculoCollection($records);
    }
    public function getRecords(Request $request)
    {

        $customer_id = $request->get('customer_id');

        $placa = $request->get('placa');

        $query = Vehiculo::query();
        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        }
        if ($placa) {
            $query->where('placa', 'like', '%' . $placa . '%');
        }
        $records = $query->get();
        return $records;
    }

    public function setItems(Request $request){
      
            $historial_id = $request->historial_id;
            $items = $request->items;
            foreach($items as $item){
            $historial_item = new HistorialItem;
            $historial_item->cantidad = $item['cantidad'];
            $historial_item->price = $item['precioUnitario'];
            $historial_item->item_id = $item['id'];
            $historial_item->historial_id = $historial_id;
            $historial_item->save();

            // {
            //     "id": 262,
            //     "description": "",
            //     "cantidad": 1,
            //     "precioUnitario": 19,
            //     "total": 19
            // }
            }
            return ["sucess"=>true];
    }
    public function record($id)
    {
        $record = new VehiculoResource(Vehiculo::findOrFail($id));

        return $record;
    }

    public function store(VehiculoRequest $request)
    {
        $id = $request->input('id');
        $plate = $request->input('vehiculo_id');

        $existengVehicle = vehiculo::where('vehiculo_placa', $plate)
           ->where($id, function($query) use ($id) {
            return $query->where('id', '!=', $id);
           })
           ->first();
        if ($existengVehicle) {
            return response()->json(['message' => false, 'El vehiculo ya existe'], 422);
        }
        
        $vehicle = Vehiculo::firstOrNew(['id' => $id]);

        $vehicle->fill($request->all());
        $vehicle->save();
        $establishment_id = auth()->user()->establishment_id;

        $historial = new Historial;
        $historial->fill($request->all());
        $historial->vehiculo_id = $vehicle->id;
        $historial->establishment_id = $establishment_id;
        $historial->save();

        $services_detail_ids = $request->services_detail_ids;
        $dataToInsert = array_map(function ($service_detail_id) use ($historial) {
            return [
                'services_detail_id' => $service_detail_id,
                'historial_id' => $historial->id
            ];
        }, $services_detail_ids);

        DB::connection('tenant')->table('historial_service_details')->insert($dataToInsert);

        return [
            'success' => true,
            'message' => ($id) ? 'Vehiculo editado con éxito' : 'Vehiculo registrado con éxito'
        ];
    }

    public function destroy($id)
    {
        try {

            $vehicle = Vehiculo::findOrFail($id);
            $vehicle->delete();

            return [
                'success' => true,
                'message' => 'Vehiculo eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El Vehiculo esta siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar Vehiculo'];
        }
    }
}
