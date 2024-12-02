<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\workshop\Http\Resources\HistorialCollection;
use Modules\workshop\Http\Resources\HistorialResource;
use Modules\workshop\Http\Requests\HistorialRequest;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Modules\Workshop\Models\Historial;
use Modules\Workshop\Models\Vehiculo;

class HistorialController extends Controller
{
    public function index()
    {
        return view('workshop::historial.index');
    }
    public function records(Request $request)
    {
        $vehiculo_id = $request->vehiculo_id;
        $records = Historial::query();
        if ($vehiculo_id == true){
            $records = $records->where('vehiculo_id', $vehiculo_id);
        }

        $records = $records->get();

        return new HistorialCollection($records);
    }

    public function record($id)
    {
        $record = new HistorialResource(Historial::findOrFail($id));

        return $record;
    }
    public function record2($id)
    {
        $historial = Historial::findOrFail($id);

        if ($historial->estado == 1) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede editar el historial porque está inactivo.'
            ], 403);
        }

        $record = new HistorialResource($historial);

        return $record;
    }

    public function store(HistorialRequest $request)
    {
        $id = $request->input('id');
        $bank = Historial::firstOrNew(['id' => $id]);
        $bank->fill($request->all());
        $bank->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Historial editado con éxito' : 'Historial registrado con éxito'
        ];
    }

    public function destroy($id)
    {
        try {

            $bank = Historial::findOrFail($id);
            $bank->delete();

            return [
                'success' => true,
                'message' => 'Historial eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El Historial esta siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar Historial'];
        }
    }
}
