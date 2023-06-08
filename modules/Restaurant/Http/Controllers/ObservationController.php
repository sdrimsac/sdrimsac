<?php

namespace Modules\Restaurant\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Tenant\Configuration;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Http\Requests\ObservationRequest;
use Modules\Restaurant\Models\Observation;
use Modules\Restaurant\Http\Resources\ObservationCollection;



class ObservationController extends Controller
{


    public function index()
    {
        $configurations = Configuration::first();
        return view('restaurant::configuration.observations', compact('configurations'));
    }
    public function columns()
    {
        return [
            'description' => 'Descripción',
        ];
    }
    public function records(Request $request)


    {
        if (count($request->all()) != 0) {
            if ($request->value == "Activado") {
                $records = Observation::where($request->column, '=', 1);
            } else {
                $records = Observation::where($request->column, 'like', "%{$request->value}%")
                    ->where('active', 1);
            }
        } else {
            $records = Observation::orderBy('created_at', 'desc');
        }
        $user = auth()->user()->type;
        if ($user == "admin" || $user == "superadmin") {
            return new ObservationCollection($records->paginate(config('tenant.items_per_page')));
        } else {
            return $records->get()->transform(function ($row) {
                return [
                    'id'          => $row->id,
                    'description' => $row->description,
                    'active'      => $row->active,

                ];
            });
        }
        // 
    }
    public function actives()
    {
        $areas = Observation::where('active', 1)->get();

        return [
            'success' => true,
            'data' => $areas
        ];
    }

    public function active($id)
    {
        $area = Observation::find($id);
        $area->active = !$area->active;
        $area->save();
        return [
            'success' => true,
            'data' => $area,
            'message' => 'Observación ' . ($area->active ? 'activada' : 'desactivada')
        ];
    }
    public function record($id)
    {
        $area = Observation::find($id);

        return [
            'success' => true,
            'data' => $area
        ];
    }
    public function store(ObservationRequest $request)
    {
        $id = $request->input('id');
        $area = Observation::firstOrNew(['id' => $id]);

        $area->fill($request->all());
        $area->description = mb_strtoupper($area->description);
        $area->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Observación actualizada con éxito' : 'Observación creada con éxito'
        ];
    }
    public function destroy($id)
    {
        Observation::find($id)->delete();

        return [
            "succes" => true,
            "message" => "Observación eliminada"
        ];
    }
}
