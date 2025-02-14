<?php

namespace Modules\Workshop\Http\Controllers;

use App\Exports\MechanicExport;
use Modules\Workshop\Http\Resources\WorkshopPersonalCollection;
use Modules\Workshop\Http\Resources\WorkshopPersonalResource;
use Modules\Workshop\Http\Requests\WorkshopPersonalRequest;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use Carbon\Carbon;
use Modules\Workshop\Models\WorkshopPersonal;
use Exception;
use Modules\Workshop\Models\Historial;
use Illuminate\Http\Request;
use Modules\Workshop\Http\Resources\ExportCollection;
use Modules\Workshop\Models\Services;
use Modules\Workshop\Models\Vehiculo;

class ExportarController extends Controller
{
    public function index()
    {
        return view('workshop::exportar.index');
    }

    public function records(Request $request)
    {
        $records = $this->getRecords($request);

        return new ExportCollection($records->paginate(20));
    }

    public function getRecords(Request $request)
    {   
        $personal_id = $request->personal_id;
        $vehiculo_id = $request->vehiculo_id;

        $records = Historial::with([
            'historialServiceDetails.serviceDetail',
            'personal',
            'vehiculo',
            'vehiculo.customer', 
            'vehiculo.tipo_vehiculo',
        ]);

        if ($personal_id) {
            $records->where('personal_id', $personal_id);
        }
        if ($vehiculo_id) {
            $records->where('vehiculo_id', $vehiculo_id);
        }

        return $records->orderBy('created_at', 'desc');  
    }

    public function tables()
    {
        $service = Services::all();
        $personal = WorkshopPersonal::all();
        $vehiculos = Vehiculo::all();
        return compact('service', 'personal', 'vehiculos');
    }

    public function excelMechanic(Request $request)
    {
        ini_set('memory_limit', '10500M');
        ini_set('max_execution_time', '30000');
        $records = $this->getRecords($request, false, true)->get();
        $company = Company::active();
        $establishment = Establishment::first();
        return (new MechanicExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('Listado_de_vehiculos_' . Carbon::now() . '.xlsx');
    }
}
