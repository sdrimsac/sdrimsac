<?php

namespace Modules\College\Http\Controllers;

use App\Models\Tenant\Configuration;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\College\Models\CollegePeriod;

class CollegePeriodController extends Controller
{

    public function index()
    {
        $configuration = Configuration::first();
        return view('college::periods', compact('configuration'));
    }

    public function records()
    {
        $records = CollegePeriod::all();
        return $records;
    }
    public function store(Request $request)
    {
        $id = $request->id;
        $period = CollegePeriod::findOrNew($id);
        $period->description = mb_strtoupper($request->description);
        $period->default_count = $request->default_count;
        $period->save();

        return ['success' => true, 'message' => $id ? 'Periodo editado' : 'Periodo creado'];
    }
}
