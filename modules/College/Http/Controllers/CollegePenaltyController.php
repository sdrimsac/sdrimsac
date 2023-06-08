<?php

namespace Modules\College\Http\Controllers;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\Item;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\College\Models\CollegePenalty;
use Modules\College\Models\CollegePenaltyService;

class CollegePenaltyController extends Controller
{

    public function index()
    {
        $configuration = Configuration::first();
        return view('college::penalties', compact('configuration'));
    }

    public function tables()
    {
        $items = Item::where('unit_type_id', 'ZZ')->get()->take(15);

        return compact('items');
    }

    public function records()
    {
        $records = CollegePenalty::all();
        return $records;
    }
    public function store(Request $request)
    {
        $id = $request->id;
        CollegePenaltyService::where('penalty_id', $id)->delete();
        $penalty = CollegePenalty::findOrNew($id);
        $penalty->description = $request->description;
        $penalty->percentage = $request->percentage;
        $penalty->type = $request->type;
        $services = $request->services;

        $penalty->save();
        try {
            foreach ($services as $service) {
                $college_service = new CollegepenaltyService;
                $college_service->penalty_id = $penalty->id;
                $college_service->item_id = $service['id'];
                $college_service->price = $service['sale_unit_price'];
                $college_service->save();
            }
        } catch (Exception $e) {
            CollegePenalty::where('id', $penalty->id)->delete();
            return [
                'error' => $e->getMessage(),
                'success' => false, 'message' => 'Ocurrió un error al agregar los servicios'
            ];
        }
        return ['success' => true, 'message' => $id ? 'Penalidad editada' : 'Penalidad creada'];
    }
}
