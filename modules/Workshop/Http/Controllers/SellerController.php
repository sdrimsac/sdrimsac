<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\workshop\Http\Resources\WorkshopSellerCollection;
use Modules\workshop\Http\Resources\WorkshopSellerResource;
use Modules\workshop\Http\Requests\WorkshopSellerRequest;
use App\Http\Controllers\Controller;
use Modules\workshop\Models\WorkshopSeller;
use Exception;

class SellerController extends Controller
{
    public function index()
    {
        return view('workshop::mecanico.index');
    }
    public function records()
    {
        $records = workshopSeller::all();

        return new WorkshopSellerCollection($records);
    }

    public function record($id)
    {
        $record = new WorkshopSellerResource(WorkshopSeller::findOrFail($id));

        return $record;
    }

    public function store(WorkshopSellerRequest $request)
    {
        $id = $request->input('id');
        $bank = WorkshopSeller::firstOrNew(['id' => $id]);
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

            $bank = WorkshopSeller::findOrFail($id);
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
