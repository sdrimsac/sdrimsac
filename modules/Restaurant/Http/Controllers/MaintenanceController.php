<?php

namespace Modules\Restaurant\Http\Controllers;


use App\Models\Tenant\Configuration;
use Illuminate\Routing\Controller;




class MaintenanceController extends Controller
{


    public function index()
    {
        $establishment = auth()->user()->establishment;
        $configuration = Configuration::first();
        return view('restaurant::maintenance.index', compact('configuration', 'establishment'));
    }
}
