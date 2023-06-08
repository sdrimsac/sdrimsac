<?php

namespace App\Http\Controllers\Tenant;


use App\Http\Controllers\Controller;
use App\Models\Tenant\ClientZone;
use Illuminate\Http\Request;

class ClientZoneController extends Controller
{
    public function index()
    {
        return view('tenant.client_zones.index');
    }
    public function columns()
    {
        return [
            'description' => 'Descripción'
        ];
    }

    public function active_desactive($id)
    {
        $zone = ClientZone::findOrFail($id);
        $zone->active = !$zone->active;
        $zone->save();
        return [
            'success' => true,
            'message' => 'Actualizado con éxito',
            'data'    => $zone
        ];
    }

    public function records(Request $request)
    {
        $records = ClientZone::query();
        if ($request->column) {

            $records = $records->where($request->column, 'like', "%{$request->value}%")->orderBy($request->column);
        }
        $records = $records->take(20)->get();

        return $records;
    }

    public function record($id)
    {
        $record = ClientZone::findOrFail($id);
        return $record;
    }

    public function store(Request $request)
    {
        $id       = $request->input('id');
        $zone    = ClientZone::firstOrNew(['id' => $id]);
        $zone->description = mb_strtoupper($request->input('description'));
        $zone->save();
        return [
            'success' => true,
            'message' => ($id) ? 'Actualizado con éxito' : 'Registrado con éxito',
            'data'    => $zone
        ];
    }

    public function destroy($id)
    {
        $zone = ClientZone::findOrFail($id);
        $zone->delete();
        return [
            'success' => true,
            'message' => 'Eliminado con éxito'
        ];
    }
}
