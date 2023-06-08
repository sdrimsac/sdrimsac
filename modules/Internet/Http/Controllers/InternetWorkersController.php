<?php

namespace Modules\Internet\Http\Controllers;

use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Item;
use Illuminate\Http\Request;
use Modules\Internet\Models\InternetConcept;
use Modules\Internet\Models\InternetPlan;
use Modules\Internet\Models\InternetPlanVariation;
use Modules\Internet\Models\InternetConceptVariation;
use Modules\Internet\Models\InternetTech;
use Illuminate\Support\Facades\DB;

class InternetWorkersController extends Controller
{
    public function index()
    {
        return view('internet::worker.admin');
    }
    public function getAllRecords()
    {
        $data = InternetTech::get();

        return response()->json(['data' => $data]);
    }

    public function saveRecord(Request $request)
    {

        try {
            InternetTech::create([
                'person_id' => $request->customer_id,
                'active' => 1
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return 'record guardado con exito ';
    }
    public function changeStatus(Request $request)
    {
        $parametros = $request->all();

        $Data = InternetTech::where('id', '=', $parametros['id'])->first();

        if ($Data['active'] == true) {

            DB::update('update internet_techs set active = 0 where id = ?', [$parametros['id']]);
        } else {

            DB::update('update internet_techs set active = 1 where id = ?', [$parametros['id']]);
        }

        return 'record actualizado con exito  ';
    }
}
