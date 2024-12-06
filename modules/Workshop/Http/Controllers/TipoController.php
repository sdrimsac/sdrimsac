<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\Workshop\Http\Resources\TipoVehiculoResource;
use Modules\Workshop\Http\Requests\TipoVehiculoRequest;
use App\Http\Controllers\Controller;
use Modules\Workshop\Models\TipoVehiculo;
use Exception;
use Modules\Workshop\Http\Resources\TipoVehiculoCollection;

class TipoController extends Controller
{
    public function index()
    {
        return view('workshop::tipo.index');
    }
    public function records()
    {
        $records = TipoVehiculo::all();

        return new TipoVehiculoCollection($records);
    }

    public function record($id)
    {
        $record = new TipoVehiculoResource(TipoVehiculo::findOrFail($id));

        return $record;
    }

    public function store(TipoVehiculoRequest $request)
    {
        $id = $request->input('id');
        $tipoVehiculo = TipoVehiculo::firstOrNew(['id' => $id]);
        $tipoVehiculo->fill($request->all());
        $tipoVehiculo->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Vehículo editado con éxito' : 'Vehículo registrado con éxito'
        ];
    }

    public function destroy($id)
    {
        try {
            $tipoVehiculo = TipoVehiculo::findOrFail($id);
            $tipoVehiculo->delete();

            return [
                'success' => true,
                'message' => 'Vehículo eliminado con éxito'
            ];
        } catch (Exception $e) {
            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El vehículo está siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar vehículo'];
        }
    }
}
