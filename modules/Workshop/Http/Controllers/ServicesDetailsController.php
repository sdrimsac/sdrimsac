<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\Workshop\Http\Resources\ServicesDetailsCollection;
use Modules\Workshop\Http\Resources\ServicesDetailsResource;
use Modules\Workshop\Http\Requests\ServicesDetailsRequest;
use App\Http\Controllers\Controller;
use Modules\Workshop\Models\ServicesDetails;
use Exception;


class ServicesDetailsController extends Controller
{
    public function index()
    {
        return view('workshop::servicesdetails.index');
    }
    public function records()
    {
        $records = ServicesDetails::all();

        return new ServicesDetailsCollection($records);
    }

    public function record($id)
    {
        $record = new ServicesDetailsResource(ServicesDetails::findOrFail($id));

        return $record;
    }

    public function store(ServicesDetailsRequest $request)
    {
        $id = $request->input('id');
        $bank = ServicesDetails::firstOrNew(['id' => $id]);
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

            $bank = ServicesDetails::findOrFail($id);
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
