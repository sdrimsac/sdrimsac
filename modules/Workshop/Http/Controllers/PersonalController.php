<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\workshop\Http\Resources\WorkshopPersonalCollection;
use Modules\workshop\Http\Resources\WorkshopPersonalResource;
use Modules\workshop\Http\Requests\WorkshopPersonalRequest;
use App\Http\Controllers\Controller;
use Modules\workshop\Models\WorkshopPersonal;
use Exception;

class PersonalController extends Controller
{
    public function index()
    {
        return view('workshop::mecanico.index');
    }
    public function records()
    {
        $records = workshopPersonal::all();

        return new WorkshopPersonalCollection($records);
    }

    public function record($id)
    {
        $record = new WorkshopPersonalResource(WorkshopPersonal::findOrFail($id));

        return $record;
    }

    public function store(WorkshopPersonalRequest $request)
    {
        $id = $request->input('id');
        $bank = WorkshopPersonal::firstOrNew(['id' => $id]);
        $bank->fill($request->all());
        $bank->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Mecanico editado con éxito' : 'Mecanico registrado con éxito'
        ];
    }

public function destroy($id)
    {
        try {

            $bank = WorkshopPersonal::findOrFail($id);
            $bank->delete();

            return [
                'success' => true,
                'message' => 'Mecanico eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El Mecanico esta siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar Mecanico'];
        }
    }

}
