<?php

namespace App\Http\Controllers\Tenant;

use Carbon\Carbon;
use App\Models\Tenant\Vault;
use Illuminate\Http\Request;
use App\Models\Tenant\Company;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Establishment;
use Modules\Report\Exports\VaultExport;
use App\Http\Resources\Tenant\VaultCollection;

class VaultController extends Controller
{
    public function columns()
    {
        return [
            'date' => 'Fecha',
            'destination' => 'Destino',
          
        ];
    }
    public function index()
    {
      return view('tenant.vault.index');
    }
    public function reports(){
        return view('tenant.vault.report');
    }

    public function reportsresults(Request $request){
    
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
             $user_id = $request['user_id'];
        $d_start = null;
        $d_end = null;

        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start.'-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end.'-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_end;
                // $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }
           $data = Vault::whereBetween('date', [$d_start, $d_end])->latest();
            return new VaultCollection($data->paginate(config('tenant.items_per_page')));
    }
    public function exportreport(Request $request)//Genera lista de registro para el grid
    {
        $group_id = $request['group_id'];
        $category_id = $request['category_id'];
        $subcategory_id = $request['subcategory_id'];
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $user_id = $request['user_id'];
        $d_start = null;
        $d_end = null;

        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start.'-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end.'-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }
         
        
            $boxes = Vault::whereBetween('date', [$d_start, $d_end])->latest()->get();
          
            $company = Company::first();
            $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        
            if($request['type']=="pdf"){
                $pdf = PDF::loadView('report::vault.report_pdf', compact("boxes","establishment","company"));
                return $pdf->stream('Reporte_Ventas_'.date('YmdHis').'.pdf');
            }else if($request['type']=="excel"){
                return (new VaultExport)
                ->records($boxes)
                ->company($company)
                ->establishment($establishment)
                ->download('Reporte_boveda_'.Carbon::now().'.xlsx');
            }

    }
    public function records(Request $request)//Genera lista de registro para el grid
    {
        $records = Vault::where($request->column, 'like', "%{$request->value}%")->orderBy($request->column);//para ordenar
        return new VaultCollection ($records->paginate(config('tenant.items_per_page')));
    }

    public function store(Request $request)
    {
        //
    }

    
    public function destroy(Vault $vault)
    {
        //
    }
}
