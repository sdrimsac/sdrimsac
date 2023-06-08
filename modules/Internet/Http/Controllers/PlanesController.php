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
use Illuminate\Support\Facades\DB;
use Modules\Internet\Models\InternetOperation;

class PlanesController extends Controller
{
    public function index()
    {
        return view('internet::planes.index');
    }
    public function getAllRecords(Request $request)
    {
        $concets = InternetConcept::all();
        $plan = InternetPlan::all();
        $planVariacion = InternetPlanVariation::select('internet_plan_variation.id AS plan_variation_id', 'internet_plan_variation.plan_id as variation_plan_id', 'internet_plan_variation.description as plan_variation_description', 'internet_plan_variation.price as plan_variation_price', 'internet_plan_variation.active as plan_variation_active', 'internet_plan.id as plan_id', 'internet_plan.capacity as plan_capacity', 'internet_plan.default_price as plan_default_price', 'internet_plan.active as  plan_active')
            ->join('internet_plan', 'internet_plan_variation.plan_id', '=', 'internet_plan.id')->get();


        $planConcepto = InternetConceptVariation::select('internet_concept_variation.id AS concept_variation_id', 'internet_concept_variation.description AS concept_variation_description', 'internet_concept_variation.price AS concept_variation_price', 'internet_concept_variation.active AS concept_variation_active', 'internet_concept.id AS concept_id', 'internet_concept.description AS concept_description', 'internet_concept.default_price AS concept_default_price')->join('internet_concept', 'internet_concept_variation.concept_id', '=', 'internet_concept.id')->get();





        return response()->json(['concets' => $concets, 'plan' => $plan,  'planVariacion' => $planVariacion, 'planConcepto' => $planConcepto]);
    }
    public function createPlan(Request $request)
    {
        $parametros = $request->all();

        $data = InternetPlan::where('capacity', '=', $parametros['mb'])->first();

        if ($data != null) {
            return response()->json(['error' => 'La data ya existe '], 400);
        }
        $item = Item::where('description', 'like', '%SERVICIO%')->first();
        $item_id = null;
        if ($item) {
            $item_id = $item->id;
        }
        InternetPlan::create([
            'item_id' => $item_id,
            'capacity' => $parametros['mb'],
            'default_price' =>  Functions::valueKeyInArray($parametros, 'precio', 0),


        ]);

        return 'create plan ';
    }
    public function createConcepto(Request $request)
    {
        $parametros = $request->all();

        $data = InternetConcept::where('description', '=', $parametros['desc'])->first();

        if ($data != null) {
            return response()->json(['error' => 'La data ya existe '], 400);
        }
        $item = Item::where('description', 'like', '%SERVICIO%')->first();
        $item_id = null;
        if ($item) {
            $item_id = $item->id;
        }
        InternetConcept::create([
            'item_id' => $item_id,
            'description' => $parametros['desc'],
            'default_price' => Functions::valueKeyInArray($parametros, 'precio', 0),
        ]);

        return 'create plan ';
    }
    public function desactivePlanConcepts(Request $request)
    {
        $parametros = $request->all();
        if ($parametros['tabla'] == 'planes') {
            $planData = InternetPlan::where('id', '=', $parametros['id'])->first();
            if ($planData['active'] == true) {

                DB::update('update internet_plan set active = 0 where id = ?', [$parametros['id']]);
            } else {

                DB::update('update internet_plan set active = 1 where id = ?', [$parametros['id']]);
            }
        }
        if ($parametros['tabla'] == 'conceptos') {
            $planConcept = InternetConcept::where('id', '=', $parametros['id'])->first()->toArray();


            if ($planConcept['active'] == true) {

                DB::update('update internet_concept set active = 0 where id = ?', [$parametros['id']]);
            } else {

                DB::update('update internet_concept set active = 1 where id = ?', [$parametros['id']]);
            }
        }
        return 'desactivando conceptos ';
    }
    public function editarPlanesConcepts(Request $request)
    {
        $parametros = $request->all();
        //id , plan 

        if ($parametros['plan'] == 'planes') {
            $data = InternetPlan::where('id', '=', $parametros['id'])->first();
            return $data;
        }
        if ($parametros['plan'] == 'conceptos') {
            $data = InternetConcept::where('id', '=', $parametros['id'])->first();
            return $data;
        }
    }
    public function saveEditarPlanesConcepts(Request $request)
    {

        $parametros = $request->all();


        try {
            if ($parametros['modo'] == 'planes') {
                DB::update('update internet_plan set capacity = ?, default_price = ?   where id = ?', [$parametros['mbEdit'], Functions::valueKeyInArray($parametros, 'precioPlanEdit', 0), $parametros['id']]);
            }
            if ($parametros['modo'] == 'conceptos') {
                DB::update('update internet_concept set description = ?  , default_price = ?   where id = ?', [$parametros['descConceptEdit'], Functions::valueKeyInArray($parametros, 'precioConceptoEdit'),  $parametros['id']]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    function all_operations(){
        InternetOperation::whereNull('plan')->chunk(50,function ($operations){
            foreach ($operations as $operation) {
                $operation->set_plan_concept_json();
            }
        });
    } 
    public function newPlanVar(Request $request)
    {
        $nameVariacion = $request->nameVariacion;
        $precioVariacion = $request->precioVariacion;
        $idselect = $request->select;

        InternetPlanVariation::create([
            'plan_id' => $idselect,
            'description' => $nameVariacion,
            'price' =>  $precioVariacion,
            'active' => 1
        ]);

        return;
    }
    public function newconceptVar(Request $request)
    {

        try {
            InternetConceptVariation::create([
                'concept_id' =>  $request->select,
                'description'  => $request->nameVariacion,
                'price' =>  $request->precioVariacion,
                'active' => 1
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return;
    }
    public function changestatusVar(Request $request)
    {
        $id =  $request->id;
        $tipo =  $request->tipo;

        if ($tipo == 'planes') {
            $planData = InternetPlanVariation::where('id', '=', $id)->first();
            if ($planData['active'] == true) {

                DB::update('update internet_plan_variation set active = 0 where id = ?', [$id]);
            } else {

                DB::update('update internet_plan_variation set active = 1 where id = ?', [$id]);
            }
        }
        if ($tipo == 'conceptos') {
            $planConcept = InternetConceptVariation::where('id', '=', $id)->first()->toArray();


            if ($planConcept['active'] == true) {

                DB::update('update internet_concept_variation set active = 0 where id = ?', [$id]);
            } else {

                DB::update('update internet_concept_variation set active = 1 where id = ?', [$id]);
            }
        }

        return "changestatusVar";
    }
    public function searchEditVar(Request $request)
    {
        if ($request->tipo == 'planes') {
            //buscar la data del plan para editar 
            $data = InternetPlanVariation::where('id', '=', $request->id)->first()->toArray();
            return $data;
        } else {
            //buscar concepto 
            $planConcept = InternetConceptVariation::where('id', '=', $request->id)->first()->toArray();
            return response()->json(['planConcept' => $planConcept]);
        }

        return "response searchEditVar ";
    }
    public function guardarEdicionVariacion(Request $request)
    {
        $this->all_operations();
        DB::update('update internet_plan_variation set description = ? , price = ? where id = ?', [$request->descripcion, $request->precio, $request->planPrin['plan_variation_id']]);


        return;
    }
    public function saveEdicionVariacion(Request $request)
    {
        $this->all_operations();
        $data =  $request->all();

        try {
            DB::update('update internet_concept_variation set description = ? , price = ? where id = ?', [$data['form']['description'], $data['form']['price'], $data['form']['concept_id']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return 'visualizacion de saveEdicionVariacion';
    }
}
