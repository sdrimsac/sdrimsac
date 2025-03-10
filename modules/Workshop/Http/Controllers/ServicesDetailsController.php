<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\Workshop\Http\Resources\ServicesDetailsCollection;
use Modules\Workshop\Http\Resources\ServicesDetailsResource;
use Modules\Workshop\Http\Requests\ServicesDetailsRequest;
use App\Http\Controllers\Controller;
use Modules\Workshop\Models\ServicesDetails;
use Exception;
use Illuminate\Http\Request;
use Modules\Workshop\Models\Services;

class ServicesDetailsController extends Controller
{
    public function index()
    {
        return view('workshop::servicesdetails.index');
    }

    public function records(Request $request)
    {
        $records = $this->getRecords($request);

        return new ServicesDetailsCollection($records->paginate(20));
    }

    public function recordsAdmin(Request $request)
    {
        $records = ServicesDetails::query()->get(); 

        return new ServicesDetailsCollection($records);
    }


    public function getRecords(Request $request)
    {
        $service_id = $request->service_id;
        $name = $request->name;

        $records = ServicesDetails::query();

        if ($service_id) {
            $records->where('service_id', $service_id);
        }

        if ($name) {
            $records->where('name', 'like', '%' . $name . '%');
        }

        return $records;
    }

    public function tables()
    {
        $service = Services::all();
        return compact('service');
    }


    public function record($id)
    {
        $record = new ServicesDetailsResource(ServicesDetails::findOrFail($id));

        return $record;
    }

    public function store(ServicesDetailsRequest $request)
    {
        $id = $request->input('id');
        $serviceDetail = ServicesDetails::firstOrNew(['id' => $id]);
        $serviceDetail->fill($request->all());
        $serviceDetail->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Sub Servicio editado con éxito' : 'Sub Servicio registrado con éxito'
        ];
    }

    public function destroy($id)
    {
        try {
            $serviceDetail = ServicesDetails::findOrFail($id);
            $serviceDetail->delete();

            return [
                'success' => true,
                'message' => 'Sub Servicio eliminado con éxito'
            ];
        } catch (Exception $e) {
            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El Sub Servicio está siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar Sub Servicio'];
        }
    }
}
