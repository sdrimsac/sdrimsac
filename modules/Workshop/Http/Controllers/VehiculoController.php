<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\workshop\Http\Resources\VehiculoCollection;
use Modules\workshop\Http\Resources\VehiculoResource;
use Modules\workshop\Http\Requests\VehiculoRequest;
use App\Http\Controllers\Controller;
use Modules\workshop\Models\WorkshopSeller;
use Exception;
use Modules\Workshop\Models\Vehiculo;

class VehiculoController extends Controller
{
    public function index()
    {
        return view('workshop::vehiculo.index');
    }
    public function records()
    {
        $records = Vehiculo::all();

        return new VehiculoCollection($records);
    }

    public function record($id)
    {
        $record = new VehiculoResource(Vehiculo::findOrFail($id));

        return $record;
    }

    public function store(VehiculoRequest $request)
    {
        $id = $request->input('id');
        $bank = Vehiculo::firstOrNew(['id' => $id]);
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

            $bank = Vehiculo::findOrFail($id);
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
