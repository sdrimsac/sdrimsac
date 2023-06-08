<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\System\Client;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class HomeController extends Controller
{
    public function index()
    {
        $clients = Client::get();
        $delete_permission = config('tenant.admin_delete_client');
         return view('system.dashboard')->with('clients', count($clients))
                ->with('delete_permission', $delete_permission)
                ->with('disc_used',0)
                ->with('i_used', 0)
                ->with('storage_size',0)
                ->with('version', 0);
    }
}
