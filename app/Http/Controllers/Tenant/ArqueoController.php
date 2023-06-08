<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\ArqueoRequest;
use App\Http\Resources\Tenant\ArqueoCollection;
use App\Http\Resources\Tenant\ArqueoResource;
use App\Models\Tenant\Arqueo;
use App\Models\Tenant\Box;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Vault;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ArqueoController extends Controller
{
    function __construct()
    {
        ini_set('max_execution_time', 3600); //3 minutes
    }
    public function index()//Llama al template Blade de laravel
    {
        return view('tenant.arqueos.index');
    }

    public function columns()//buscador x campo
    {
            return [
            'id'       => 'Código',
            'fecha'    => 'Fecha',
            
        ];
    }
    // ini_set('max_execution_time', 3600); //3 minutes
    public function records(Request $request)//Genera lista de registro para el grid
    {
        $records = Arqueo::where($request->column, 'like', "%{$request->value}%")->orderBy('id','desc');//para ordenar
        return new ArqueoCollection ($records->paginate(config('tenant.items_per_page')));
    }
    public function apertura(){
        $fecha_actual = Carbon::now();
        $arqueo=Cash::where('date_opening',$fecha_actual->format('Y-m-d'))->count();
        if($arqueo>0){
            $apertura=true;
        }else{
            $apertura=false;
        }
        $fecha_actual = Carbon::now();
        $arqueo=Arqueo::where('fecha',$fecha_actual->format('Y-m-d'))->count();
        if($arqueo>0){
            $caja_cerrada=true;
        }else{
            $caja_cerrada=false;
        }
        return compact("apertura","caja_cerrada");
    }
    public function statusarqueo(){
        $fecha_actual = Carbon::now();
        $arqueo=Arqueo::where('fecha',$fecha_actual->format('Y-m-d'))->where('state',"0")->count();
        if($arqueo>0){
            $status_caja=true;
        }else{
            $status_caja=false;
        }
        return compact("status_caja");
    }
    public function record($id)//Selecccionar un Registro
    {
        $fecha_actual = Carbon::now();
        $model_Caja=Box::where('date',$fecha_actual->format('Y-m-d'))->get();
        $cash=Cash::where('date_opening',$fecha_actual->format('Y-m-d'))->first(); 
        $cash_row=Cash::findOrFail($cash->id);
        $cash_row->state=1;
        $cash_row->save();
        foreach ($model_Caja as $key => $rows_caja) {
            $update_box=Box::findOrFail($rows_caja->id);
            $update_box->state='1';
            $update_box->close=null;
            $update_box->save();
         }

        $record = new ArqueoResource(Arqueo::findOrFail($id));
        return $record;
    }

    public function tables(Request $request)
    {
     $fecha_actual = Carbon::now();
     $establecimiento= Establishment::select('id','description')->first();
     $total_sistema=0;
     $egresos_total=0;
     $apertura=0.00;
     $ingresos= Box::select(DB::raw('SUM(amount) as ingresos'))->where('type','1')->where('method','Efectivo')->where('date',$request->fecha)->first();
     $egresos= Box::select(DB::raw('SUM(amount) as egresos'))->where('type','2')->where('date',$request->fecha)->first();
     $cash=Cash::where('state','1')->get()->last(); 
     if($cash!=null){
        $apertura=number_format($cash->beginning_balance,2);
     }  
     if($egresos->egresos!=null){
         $egresos_total=floatval($egresos->egresos);
    }
    if($ingresos->ingresos!=null){
        $total_sistema=floatval($ingresos->ingresos);
   }
     return compact("establecimiento","total_sistema","egresos_total","apertura");
        
    }

    public function store(ArqueoRequest $request){       
        //Artisan::call("stock:update");
        $fecha_actual = Carbon::now();
        $id = $request->input('id');
        $arqueo = Arqueo::firstOrNew(['id' => $id]);
        $arqueo->fill($request->all());
        $arqueo->fecha=Carbon::parse($request->input('fecha'))->format('Y-m-d');
        $arqueo->establishment_id=$request->input('establishment_id');
        $arqueo->state="0";
        $arqueo->save();
        $vault = Vault::firstOrNew(['id' => 0]);
        $vault->fill($request->all());
        $vault->date=Carbon::parse($request->input('date'))->format('Y-m-d');
        $vault->amount=$request->total;
        $vault->destination=$request->input('transferir_a');
        $vault->movement="INGRESO";
        $vault->save();
        Arqueo::where('state',"=",'1')->update(['state' => '0']);
        $model_Caja=Box::where('date',$request->input('fecha'))->update(['state' => '0','close'=>$request->input('fecha')]);
        Cash::where('state','1')->update(['state'=>'0','date_closed' => $request->input('fecha'),'time_closed'=>$fecha_actual->format('H:i:s'),'final_balance'=>$request->total]);
        return [
            'success' => true,
            'message' => ($id)?'Actualizado con éxito':'Registrado con éxito'
        ];
    }

    public function cerrar_caja($id)//Eliminar
    {
        $arqueo = Arqueo::findOrFail($id);
        $arqueo->state='1';
        $arqueo->save();
        $fecha_actual = Carbon::now();
        $model_Caja=Box::where('date',$fecha_actual->format('Y-m-d'))->get();
        $cash=Cash::where('date_opening',$fecha_actual->format('Y-m-d'))->first(); 
        $cash_rows = Cash::findOrFail($cash->id);
        $cash_rows->state=0;
        $cash_rows->save();
        foreach ($model_Caja as $key => $rows_caja) {
           $update_box=Box::findOrFail($rows_caja->id);
           $update_box->state='0';
           $update_box->close=$fecha_actual->format('Y-m-d');
           $update_box->save();
        }
        return [
            'success' => true,
            'message' => 'Arqueo de Caja Cerrada'
        ];
    }

    public function abrircaja($id)//Eliminar
    {
        $fecha_actual = Carbon::now();
        $arqueo = Arqueo::findOrFail($id);
        $arqueo->state='0';
        $arqueo->save();
        $model_Caja=Box::where('date',$fecha_actual->format('Y-m-d'))->get();
        foreach ($model_Caja as $key => $rows_caja) {
            $update_box=Box::findOrFail($rows_caja->id);
            $update_box->state='0';
            $update_box->close=null;
            $update_box->save();
         }
        return [
            'success' => true,
            'message' => 'Arqueo de Caja Abierta'
        ];
    }
    
    public function destroy($id)//Eliminar
    {
        $arqueo = Arqueo::findOrFail($id);
       // $arqueo->state='0';
        $arqueo->delete();
        return [
            'success' => true,
            'message' => 'Eliminado con éxito'
        ];
    }
    
}
