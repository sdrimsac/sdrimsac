<?php

namespace App\Http\Controllers\Tenant;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Tenant\Voided;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\CoreFacturalo\Facturalo;
use App\Models\Tenant\StateType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Services\Data\ServiceData;
use Illuminate\Support\Facades\Storage;
use App\Models\System\Configuration as Config;
use App\Http\Resources\Tenant\VoidedCollection;
use App\CoreFacturalo\Helpers\Storage\StorageDocument;

class ValidateController extends Controller
{
    use StorageDocument;

    protected $document_state = [
        '-' => '-',
        '0' => 'No Existe',
        '1' => 'Aceptado',
        '2' => 'Anulado',
        '3' => 'AUTORIZADO',
        '4' => 'NO AUTORIZADO'
    ];

    public function index()
    {
        return view('tenant.voided.index');
    }

    public function validar_cpe()
    {
       
        try {
            $documents = Document::query()
            ->orderBy('id')
             ->get();
    
            $count = 0;
            //$this->info('-------------------------------------------------');
            //$this->info(Company::query()->first()->name);
            //$this->info('Documentos:' . count($documents));
            $curl = curl_init();  
            $Config = Config::first();
            $company = Company::first();
            ///////////////////////////////////////////////////////////////////////////
            $records =  $documents = Document::orderBy('id');
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $correlativo=0;
            $conteo=0;  
            $contenido="";
            $num_cpe=0;
          // 
            $cantidad_rows=$records->count();
            if($num_cpe==$cantidad_rows){
                return[
                    "success"=>false,
                    "message"=>"No hay comprobantes para validar"
                ];
            }else{
            foreach ($records->get() as $row){
                $num_cpe++;
                if($num_cpe==$cantidad_rows){
                    break;
                }else{
                    $conteo= $conteo+1; 
                    $contenido .= $company->number."|";
                    $contenido .= $row->document_type_id."|";
                    $contenido .= $row->series."|";
                    $contenido .= intval($row->number)."|";
                    $contenido .= substr($row->date_of_issue,8,2)."/".substr($row->date_of_issue,5,2)."/".substr($row->date_of_issue,0,4)."|";
                    $contenido .= $row->total."\n";  
                    if($conteo==250){ //CANTIDAD_TXT=250    
                        Storage::disk('public')->put("txt/".$correlativo."_".$company->number."_validarcpe.txt", $contenido);
                        $correlativo++;
                        $conteo=-1;
                        $contenido="";
                     }
                     Storage::disk('public')->put("txt/".$correlativo."_".$company->number."_validarcpe.txt", $contenido);
                     $success=true;
                }
            }
        }

                // return [
                //     "success"=>true,
                //     "archivo_txt"=>$correlativo+1,
                //     "cantidad_cpe"=>$records->count(),
                //     "message"=>"se genero los archivos txt correctamente"
                // ];
                reValidate:
                $service = new ServiceData(); 
                for ($i=0; $i <= $correlativo; $i++) { 
                $filename=$i."_".$company->number."_validarcpe.txt";
                $file=public_path("storage/txt/{$filename}") ;
                $res = $service->validar_cpe($company->number,substr($company->soap_username,11,8),$company->soap_password,$filename);    
                $data_response=json_decode($res);
                if (array_key_exists('data',json_decode($res,true))) {
                    $res =json_decode($res);
                    $data=$res->data;
                 foreach ($data as $key => $value) {
                  
                    $sale_find=Document::where('series',$value->Serie)->where('number',$value->Numero)->where('document_type_id',$value->TipoComprobante)->first();
                    $sales=Document::findOrFail($sale_find->id);
                    if($value->EstadoComprobante=="NO EXISTE"){
                        $state_type_id="01";
                    }else{
                        $state_type=StateType::where('description', 'like', "%{$this->document_state[$value->EstadoCodComprobante]}%")->first();
                        $state_type_id=$state_type->id;
                    }
                    $sales->state_type_id=$state_type_id;
                    $sales->save();
                    //$this->info($sales->id."/ ". $state_type_id);  
                 }
              
                  return response()->json($res);
                }else{
                  //  goto reValidate;
                  return response()->json(["success"=>false,"message"=>$data_response]);
                  
                }
                }
               
            ///////////////////////////////////////////////////////////////////////////
            } catch (\Exception  $e) {
                return response()->json($e->getMessage());
                //return $e->getMessage();
            }


    } 

}
