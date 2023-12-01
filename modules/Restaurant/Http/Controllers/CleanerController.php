<?php

namespace Modules\Restaurant\Http\Controllers;


use App\Models\Tenant\Configuration;
use Illuminate\Routing\Controller;




class CleanerController extends Controller
{


    public function index()
    {
        $establishment = auth()->user()->establishment;
        $configuration = Configuration::first();
        return view('restaurant::cleaner.index', compact('configuration','establishment'));
    }
 
}
