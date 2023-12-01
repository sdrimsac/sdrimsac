<?php

namespace Modules\Restaurant\Http\Controllers;


use App\Models\Tenant\Configuration;
use Illuminate\Routing\Controller;




class MaintenanceController extends Controller
{


    public function index()
    {
        $configurations = Configuration::first();
        return view('restaurant::maintenance.index', compact('configurations'));
    }
 
}
