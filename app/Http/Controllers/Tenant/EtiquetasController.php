<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\BankRequest;
use App\Http\Resources\Tenant\BankCollection;
use App\Http\Resources\Tenant\BankResource;
use App\Models\Tenant\Bank;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EtiquetasController extends Controller
{
    public function index()
    {
        return view('tenant.etiquetas.index');
    }
    

}
