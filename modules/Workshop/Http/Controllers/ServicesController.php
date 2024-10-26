<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\Workshop\Http\Resources\ServicesCollection;
use Modules\Workshop\Http\Resources\ServicesResource;
use Modules\Workshop\Http\Requests\ServicesRequest;
use App\Http\Controllers\Controller;
use Exception;
use Modules\Workshop\Models\Services;

class ServicesController extends Controller
{
    public function index()
    {
        return view('workshop::services.index');
    }
    public function records()
    {
        $records = Services::all();

        return new ServicesCollection($records);
    }

    public function record($id)
    {
        $record = new ServicesResource(Services::findOrFail($id));

        return $record;
    }

    public function store(ServicesRequest $request)
    {
        $id = $request->input('id');
        $bank = Services::firstOrNew(['id' => $id]);
        $bank->fill($request->all());
        $bank->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Sub Servicio editado con éxito' : 'Sub Servicio registrado con éxito'
        ];
    }

public function destroy($id)
    {
        try {

            $bank = Services::findOrFail($id);
            $bank->delete();

            return [
                'success' => true,
                'message' => 'Sub Servicio eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El Sub Servicio esta siendo usado por otros registros, no puede eliminar'] : ['success' => 
                                                              false, 'message' => 'Error inesperado, no se pudo eliminar Sub Servicio'];
        }
    }

}
