<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\TransportRequest;
use App\Http\Resources\Tenant\TransportCollection;
use App\Http\Resources\Tenant\TransportResource;
use App\Models\Tenant\Transport;
use GuzzleHttp\Client;
use Exception;

class TransportController extends Controller
{
    public function index()
    {
        return view('tenant.transport.index');
    }

    public function records(Request $request)
    {
        try {
            $query = Transport::query();
            if ($request->has('value') && !empty($request->value)) {
                $query->where(function ($q) use ($request) {
                    $value = strtolower($request->value);
                    $q->whereRaw('LOWER(plate_number) LIKE ?', ["%{$value}%"]);
                });
            }
            $records = $query->orderBy('id', 'desc')->paginate(20);

            return new TransportCollection($records);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener registros: ' . $e->getMessage()], 500);
        }
    }


    public function columns()
    {
        return [

            'plate_number' => 'placa',
        ];
    }
    public function vehicles($plateNumber){
        $url = config('app.api_factiliza_service_url');
        $token = config('app.api_factiliza_service_token');
        $client = new Client(['base_uri' => $url]);
        $api= "/placa/info/".$plateNumber; 
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

    public function record($id)
    {
        $record = new TransportResource(Transport::findOrFail($id));

        return $record;
    }

    public function store(TransportRequest $request)
    {
        $id = $request->input('id');
        $plateNumber = $request->input('plate_number');

        // Check if plate number exists (excluding current record if editing)
        $exists = Transport::where('plate_number', $plateNumber)
            ->when($id, function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })
            ->exists();

        if ($exists) {
            return [
                'success' => false,
                'message' => 'El número de placa ya existe en la base de datos'
            ];
        }

        $transport = Transport::firstOrNew(['id' => $id]);
        $transport->fill($request->all());
        $transport->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Vehiculo editado con éxito' : 'Vehiculo registrado con éxito',
        ];
    }

    public function destroy($id)
    {
        try {

            $record = Transport::findOrFail($id);
            $record->delete();

            return [
                'success' => true,
                'message' => 'Unidad eliminada con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'La unidad esta siendo usada por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar la unidad'];
        }
    }
}
