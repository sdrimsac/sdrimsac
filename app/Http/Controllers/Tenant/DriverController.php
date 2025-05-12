<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\DriverRequest;
use App\Http\Resources\Tenant\DriverCollection;
use App\Http\Resources\Tenant\DriverResource;
use App\Models\Tenant\Catalogs\IdentityDocumentType;
use App\Models\Tenant\Driver;
use GuzzleHttp\Client;
use Exception;

class DriverController extends Controller
{
    public function index()
    {
        return view('tenant.driver.index');
    }

    public function records(Request $request)
    {
        $query = Driver::query();
        if ($request->has('value') && !empty($request->value)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->value . '%');
            });
        }
        $records = $query->paginate(20);

        return new DriverCollection($records);
    }


    public function columns()
    {
        return [

            'name' => 'nombre',
        ];
    }
    public function tables()
    {
        $document_types = IdentityDocumentType::whereActive()
            ->whereNotIn('id', ['4', 'A', '6', '-'])
            ->get();
        return compact('document_types');
    }

    public function record($id)
    {
        $record = new DriverResource(Driver::findOrFail($id));

        return $record;
    }
    

    public function store(DriverRequest $request)
    {
        $id = $request->input('id');
        
        // Check for existing license or number
        $existingDriver = Driver::where(function($query) use ($request, $id) {
            $query->where('license', $request->license)
                  ->orWhere('number', $request->number);
            if ($id) {
                $query->where('id', '!=', $id);
            }
        })->first();

        if ($existingDriver) {
            $duplicateField = $existingDriver->license == $request->license ? 'licencia' : 'número';
            return [
                'success' => false,
                'message' => "El {$duplicateField} ya está registrado en otro conductor"
            ];
        }

        $unit_type = Driver::firstOrNew(['id' => $id]);
        $unit_type->fill($request->all());
        $unit_type->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Unidad editada con éxito' : 'Unidad registrada con éxito',
        ];
    }

    public function destroy($id)
    {
        try {

            $record = Driver::findOrFail($id);
            $record->delete();

            return [
                'success' => true,
                'message' => 'Unidad eliminada con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'La unidad esta siendo usada por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar la unidad'];
        }
    }
    public function license($Number){
        $url = config('app.api_factiliza_service_url');
        $token = config('app.api_factiliza_service_token');
        $client = new Client(['base_uri' => $url]);
        $api= "/licencia/info/".$Number; 
        $path ="/v1";
        $response = $client->request('GET',$path. $api, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
            'verify' => false,
        ]);
        return response()->json(json_decode($response->getBody()->getContents(), true));
    }
}
