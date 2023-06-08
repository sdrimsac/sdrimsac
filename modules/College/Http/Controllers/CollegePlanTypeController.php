<?php

namespace Modules\College\Http\Controllers;

use App\Models\Tenant\Configuration;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CollegePlanTypeController extends Controller
{

    public function index()
    {
        $configuration = Configuration::first();
        return view('college::plan_types', compact('configuration'));
    }
}
