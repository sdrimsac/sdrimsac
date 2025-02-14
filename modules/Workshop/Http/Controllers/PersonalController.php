<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\Workshop\Http\Resources\WorkshopPersonalCollection;
use Modules\Workshop\Http\Resources\WorkshopPersonalResource;
use Modules\Workshop\Http\Requests\WorkshopPersonalRequest;
use App\Http\Controllers\Controller;
use Modules\Workshop\Models\WorkshopPersonal;
use Exception;
use Modules\Workshop\Models\Historial;

class PersonalController extends Controller
{
    public function index()
    {
        return view('workshop::mecanico.index');
    }
    public function records()
    {
        $records = WorkshopPersonal::all();

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
        $personal = WorkshopPersonal::firstOrNew(['id' => $id]);
        $personal->fill($request->all());
        $personal->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Mecánico editado con éxito' : 'Mecánico registrado con éxito'
        ];
    }

    public function destroy($id)
    {
        try {
            $personal = WorkshopPersonal::findOrFail($id);
            $personal->delete();

            return [
                'success' => true,
                'message' => 'Mecánico eliminado con éxito'
            ];
        } catch (Exception $e) {
            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El Mecánico está siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar Mecánico'];
        }
    }
}
