<?php

namespace App\Console\Commands;

use DateTime;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\StateType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Services\Data\ServiceData;
use Illuminate\Support\Facades\Storage;
use App\Models\System\Configuration as Config;
use App\CoreFacturalo\Services\Extras\ValidateCpe2;

class ValidateDocumentsCommand extends Command
{
    protected $document_state = [
        '-' => '-',
        '0' => 'NO EXISTE',
        '1' => 'ACEPTADO',
        '2' => 'ANULADO',
        '3' => 'AUTORIZADO',
        '4' => 'NO AUTORIZADO'
    ];
    protected $documents = [
        '01' => 'FACTURA ELECTRONICA',
        '03' => 'BOLETA DE VENTA ELECTRONICA',
        '07' => 'NOTA DE CREDITO',
        '08' => 'NOTA DE DEBITO',
        'R1' => 'RECIBO POR HONORARIOS',
        'R7' => 'NOTA DE CREDITO RECIBO POR HONORARIOS',

    ];
    protected $company_states = [
        '-' => '-',
        '00' => 'ACTIVO',
        '01' => 'BAJA PROVISIONAL',
        '02' => 'BAJA PROV. POR OFICIO',
        '03' => 'SUSPENSION TEMPORAL',
        '10' => 'BAJA DEFINITIVA',
        '11' => 'BAJA DE OFICIO',
        '12' => 'BAJA MULT.INSCR. Y OTROS ',
        '20' => 'NUM. INTERNO IDENTIF.',
        '21' => 'OTROS OBLIGADOS',
        '22' => 'INHABILITADO-VENT.UNICA',
        '30' => 'ANULACION - ERROR SUNAT   '
    ];
    protected $company_conditions = [
        '-' => '-',
        '00' => 'HABIDO',
        '01' => 'NO HALLADO SE MUDO DE DOMICILIO',
        '02' => 'NO HALLADO FALLECIO',
        '03' => 'NO HALLADO NO EXISTE DOMICILIO',
        '04' => 'NO HALLADO CERRADO',
        '05' => 'NO HALLADO NRO.PUERTA NO EXISTE',
        '06' => 'NO HALLADO DESTINATARIO DESCONOCIDO',
        '07' => 'NO HALLADO RECHAZADO',
        '08' => 'NO HALLADO OTROS MOTIVOS',
        '09' => 'PENDIENTE',
        '10' => 'NO APLICABLE',
        '11' => 'POR VERIFICAR',
        '12' => 'NO HABIDO',
        '20' => 'NO HALLADO',
        '21' => 'NO EXISTE LA DIRECCION DECLARADA',
        '22' => 'DOMICILIO CERRADO',
        '23' => 'NEGATIVA RECEPCION X PERSONA CAPAZ',
        '24' => 'AUSENCIA DE PERSONA CAPAZ',
        '25' => 'NO APLICABLE X TRAMITE DE REVERSION',
        '40' => 'DEVUELTO'
    ];
    protected $signature = 'validate:documents {establishment_id?} {state_type_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consultar el estado de los documentos electrónicos';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {


            $count = 0;
            //$this->info('-------------------------------------------------');
            //$this->info(Company::query()->first()->name);
            //$this->info('Documentos:' . count($documents));
            $curl = curl_init();
            // $Config = Config::first();
            $company = Company::first();
            ///////////////////////////////////////////////////////////////////////////
           // $date_start="01-".date('m')."-";
           $month = date('m');
           $year = date('Y');
           $day = date("d", mktime(0,0,0, $month+1, 0, $year));
           $date_start= date('Y-m-d', mktime(0,0,0, $month, 1, $year));
           $date_end=date('Y-m-d', mktime(0,0,0, $month, $day, $year));
            $records =  Document::whereIn('state_type_id',['01','03','07','09','11'])->orderBy('id');
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

                reValidate:
                $service = new ServiceData();
                for ($i=0; $i <= $correlativo; $i++) {
                $filename=$i."_".$company->number."_validarcpe.txt";
                $file=public_path("storage/txt/{$filename}") ;
                $res = $service->validar_cpe($filename);

                $data_response=json_decode($res);

                if (array_key_exists('data',json_decode($res,true))) {
                    $res =json_decode($res);
                    $data=$res->data;
                 foreach ($data as $key => $value) {
                    Log::info('End Ubigeo: '.$this->document_state[$value->EstadoCodComprobante]);
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
                  }

                 }else{
                    goto reValidate;

                }
                }

            ///////////////////////////////////////////////////////////////////////////
            } catch (\Exception  $e) {
                $this->info($e->getMessage());
                $this->info($e->getLine());
               // return response()->json($e->getMessage());
                //return $e->getMessage();
            }



}
}
