<?php

namespace Modules\Consignment\Http\Controllers;

use App\Models\Tenant\Configuration;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Consignment\Models\ConsignmentPenalty;

class ConsignmentPenaltyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $configuration = Configuration::first();
        return view(
            'consignment::penalty.index',
            compact('configuration')
            
        );
    }
    
    public function records(){
       
        $penalties = ConsignmentPenalty::query();
        return $penalties->get();
    }
    public function store(Request $request){
        $id = $request->input('id');
        $consignment = ConsignmentPenalty::findOrNew($id);
        $consignment->fill($request->all());
        $consignment->save();
        return [
            'success' => true,
            'message' => $id ? 'Penalidad editada con éxito' : 'Penalidad registrada con éxito'
        ];
    }
    public function items(){}
}
