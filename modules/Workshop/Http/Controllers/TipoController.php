<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\workshop\Http\Resources\TipoVehiculoResource;
use Modules\workshop\Http\Requests\TipoVehiculoRequest;
use App\Http\Controllers\Controller;
use Modules\workshop\Models\TipoVehiculo;
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
        $bank = TipoVehiculo::firstOrNew(['id' => $id]);
        $bank->fill($request->all());
        $bank->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Vehiculo editado con éxito' : 'Vehiculo registrado con éxito'
        ];
    }

public function destroy($id)
    {
        try {

            $bank = TipoVehiculo::findOrFail($id);
            $bank->delete();

            return [
                'success' => true,
                'message' => 'Vehiculo eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El Vehiculo esta siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar Vehiculo'];
        }
    }

}
