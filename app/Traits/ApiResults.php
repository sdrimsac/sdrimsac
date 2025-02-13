<?php
namespace App\Traits;
use App\Dni;
use App\Plan;
use App\User;
use DateTime;
use App\Query;
use Exception;
use App\Address;
use App\Company;
use App\District;
use App\Empresas;
use App\Province;
use App\Provinces;
use Carbon\Carbon;
use App\Department;
use App\Departments;
use App\ExchangeRate;
use App\UbigeoReniec;
use GuzzleHttp\Client;
use DiDom\Document as DiDom;
use App\Services\SunatService;
use Illuminate\Support\Facades\Log;
use App\CoreFacturalo\WS\Client\WsClient;
use GuzzleHttp\Exception\RequestException;
use App\Contracts\Services\ZipContractService;
use App\Contracts\Services\SunatContractService;
use App\CoreFacturalo\Services\Helpers\RequestCurl;


trait ApiResults
{
  //  protected $sunatServices_result;
    protected $document_states = [
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
    protected $client;
    function __construct(SunatContractService $sunatService, $config = array(), ZipContractService $zipService)
    {
        $this->directorio =  dirname(__FILE__) . '//tempo';
		$FileNameCookie =  uniqid();
		$this->_cookieFileLocation = $this->directorio . '//' . $FileNameCookie;
        $this->zipService = $zipService;
        $this->sunatService = $sunatService;
        ini_set('max_execution_time', 3600); //3 minutes
         $headers = [
            'User-Agent' => 'Testing 1.0'
           ];
            $this->curl = (new RequestCurl())->getCurl();
            $this->client = new Client([
            'connect_timeout' => 60,
            'base_uri' => 'https://www.sunat.gob.pe/ol-ti-itconsultaunificadalibre/consultaUnificadaLibre/',
            'cookies' => true,
            'headers' => $headers,
            'verify' => false
        ]);
        $headers = [
            'User-Agent' => 'Testing 1.0'
           ];
           $this->curl = (new RequestCurl())->getCurl();


        //$this->countquery=new QueryServices();
        $this->wsClient = new WsClient();

    }


public function tiempoTranscurrido($fechaInicio,$fechaFin)
{
    $fechaInicial = date($fechaInicio);
    $fechaFinal = date($fechaFin);
     $fechaInicialSegundos = strtotime($fechaInicial);
    $fechaFinalSegundos = strtotime($fechaFinal);
    $dias = ($fechaFinalSegundos - $fechaInicialSegundos) / 86400;
    return  round($dias, 0, PHP_ROUND_HALF_UP);

}
    public function ver_plan($id=null){
        $permissions=[];
        if(auth()->check()){
            if(!auth()->user()->active){
                return[
                    "success"=> false,
                    "message"=> "Su cuenta esta desactivada"
                ];
            }
            $user = User::whereHas('queries', function($q) use ($id){
                $q->where('user_id', $id);
            })->first();


            $tiempoTranscurrido =$this->tiempoTranscurrido(date('Y-m-d'),$user->date);
            if($tiempoTranscurrido==0){
                return[
                    "success"=> false,
                    "message"=> "Su cuenta vencio el dia ".\Carbon\Carbon::parse($user->date)->format('d-m-Y')
                ];

            }
            if(intval($user->queries[0]->quantity)>=intval($user->queries[0]->planes->limit)){
                return[
                    "success"=> false,
                    "message"=> "Supero la cantidad de consultas"
                ];
            }
            return [
                "success"=> true,
                'permissions' => $user->permission[0], 
                "message"=> "Cuenta activa"
            ];

        }

        // if(auth()->check()){
        //     if($id!=null){
        //         $id_user=$id;
        //     }else{
        //         $id_user=auth()->user()->id;
        //     }
        //     $users= User::findOrFail($id_user);
        //     if($users->active==0){
        //         return [
        //             "success" =>false,
        //             "message" => "Su cuenta esta desactivada",
        //             "fecha_expiracion" => \Carbon\Carbon::parse($users->date)->format('d-m-Y')
        //          ];
        //     }
        //     if($users->date!=null){
        //         $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
        //         $fecha_entrada = strtotime($users->date." 00:00:00");
        //         if($fecha_actual > $fecha_entrada){
        //             return [
        //                 "success" =>false,
        //                 "message" => "Su cuenta expiro",
        //                 "fecha_expiracion" => \Carbon\Carbon::parse($users->date)->format('d-m-Y')
        //             ];
        //         }
        //     }
        //     $query=Query::where('user_id',$users->id)->first();
        //     $id_query=$query->id;
        //     $acumulado=$query->quantity;
        //     $planes=Plan::where('id',$query->plan_id)->first();
        //     $total_query=$planes->limit;
        //     if($acumulado==$total_query){
        //         $date_hoy=date('d-m');
        //         $dia="01";
        //         $mes=date('m');
        //         $meses=date('m');
        //         if($mes=="12"){
        //             $meses="01";
        //         }else{
        //             $meses=$meses+1;
        //         }
        //         $meses=str_pad($meses, 2, "0", STR_PAD_LEFT);
        //         $nuevafecha=$dia."-".$meses;
        //         if($acumulado==$total_query &&  $query->meses=="01"."-".date('m')){
        //             $querys= Query::findOrFail($id_query);
        //             $querys->quantity="0";
        //             $querys->meses=$nuevafecha;
        //             $querys->save();
        //             return [
        //                 "success"=>true,
        //              ];
        //         }else{
        //             return [
        //                 "success"=>false,
        //                 "message"=>"consultas al limite"
        //             ];
        //         }

        //     }else{
        //         return [
        //             "success"=>true,
        //          ];
        //     }
        // }else{
        //     return [
        //         "success"=>true,
        //      ];
        // }

    }
    public function getAddress($site){

        $tipo_via = ($site->tipo_via && $site->tipo_via != '-') ? $site->tipo_via : '';
        $nombre_via = ($site->nombre_via && $site->nombre_via != '-') ? ' '.$site->nombre_via : '';
        $codigo_zona = ($site->codigo_zona && $site->codigo_zona != '-') ? ' '.$site->codigo_zona : '';
        $tipo_zona = ($site->tipo_zona && $site->tipo_zona != '-') ? ' '.$site->tipo_zona : '';
        $numero = ($site->numero && $site->numero != '-') ? " NRO. {$site->numero}" : '';

        $manzana = ($site->manzana && $site->manzana != '-') ? " MZ. {$site->manzana}" : '';
        $lote = ($site->lote && $site->lote != '-') ? " LT. {$site->lote}" : '';
        $departamento = ($site->departamento && $site->departamento != '-') ? " DPTO. {$site->departamento}" : '';
        $interior = ($site->interior && $site->interior != '-') ? " INT. {$site->interior}" : '';
        $kilometro = ($site->kilometro && $site->kilometro != '-') ? " KM. {$site->kilometro}" : '';

        $address = "{$tipo_via}{$nombre_via}{$numero}{$codigo_zona}{$tipo_zona}{$manzana}{$lote}{$departamento}{$interior}{$kilometro}";

        return $address;
    }
    private function curl($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $info = curl_exec($ch);
        curl_close($ch);
        return $info;
    }
    private function curl_sunat() {

        try {
            $configuration = Company::first();
            $this->client = new Client([
                'connect_timeout' => 60,
                'verify' => false,
                'http_errors' => false
            ]);
           $curl = [
             CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
             CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
            ),
           ];
          $responses = $this->client->request(strtoupper("GET"),"https://www.sunat.gob.pe/a/txt/tipoCambio.txt", [
               'curl' => $curl,
           ]);
           $data = explode("|",(string)$responses->getBody(true));
           $fecha =explode("/",$data[0]);
           return response()->json(
            [
                "success" => true ,
                "data" => [
                 "fecha_busqueda" => $fecha[2]."-".$fecha[1]."-".$fecha[0],
                 "fecha_sunat" =>  $fecha[2]."-".$fecha[1]."-".$fecha[0],
                 "compra" => $data[1],
                 "venta" => $data[2],
                ] ]
           );

      } catch (RequestException $exception) {
         return $exception->getResponse()->getBody();
      }

    }
    private function curl_sbs($moneda,$desde,$hasta) {

        $explode_desde=explode("-",$desde);
        $explode_hasta=explode("-",$hasta);

        $dia_desde= $explode_desde[0];
        $mes_desde= $explode_desde[1];
        $anio_desde= $explode_desde[2];
        $dia_hasta= $explode_hasta[0];
        $mes_hasta= $explode_hasta[1];
        $anio_hasta= $explode_hasta[2];

        try {
            $configuration = Company::first();
            $this->client = new Client([
                'connect_timeout' => 60,
                'verify' => false,
                'http_errors' => false
            ]);
           $curl = [
            CURLOPT_URL => "https://www.sbs.gob.pe/app/stats/seriesH_TC-CV-Historico.asp",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "FECHA_CONSULTA_1=".$dia_desde."%2F".$mes_desde."%2F".$anio_desde."&FECHA_CONSULTA_2=".$dia_hasta."%2F".$mes_hasta."%2F".$anio_hasta."&s_moneda=".$moneda."&button22=Consultar",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
            ),
           ];
          $responses = $this->client->request(strtoupper("POST"),"https://www.sbs.gob.pe/app/stats/seriesH_TC-CV-Historico.asp", [
               'curl' => $curl,
           ]);

           return (string)$responses->getBody(true);
       } catch (RequestException $exception) {
         return $exception->getResponse()->getBody();
      }

    }
    private function digit_control($dni){
		if (strlen($dni) == 8 && is_numeric($dni)) {
			$suma = 0;
			$hash = array(5, 4, 3, 2, 7, 6, 5, 4, 3, 2);
			$suma = 5; // 10[NRO_DNI]X (1*5)+(0*4)
			for ($i = 2; $i < 10; $i++) {
				$suma += ($dni[$i - 2] * $hash[$i]); //3,2,7,6,5,4,3,2
			}
			$entero = (int) ($suma / 11);

			$digito = 11 - ($suma - $entero * 11);

			if ($digito == 10) {
				$digito = 0;
			} else if ($digito == 11) {
				$digito = 1;
			}
			return $digito;
		}
		return NULL;
    }
    private function eliminar_acentos($cadena){

		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );

		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );

		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );

		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );

		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena
		);

		return $cadena;
	}

    public function getDataLocation($location_id, $address,$numero=null,$ruc_diez=false,$ruc=null){

        if(substr($ruc,0,2)=="20" && strlen($ruc)==11){
           if($location_id=="-" || $location_id==""){
            return [
                'ubigeo' => [null,null,null],
                'address' => "",
                'address_full' => "",
            ];
        }
        }
        $district = District::find($location_id);
        // $company=Company::first();
        // $result=$this->sunatService->processRuc10($company->ruc,$company->usuario_sol,$company->clave_sol,$ruc);
        $ubigeo=str_pad($district->id,6,"0", STR_PAD_LEFT);
        $departamento_ubigeo=Departments::where('id',substr($district->id,0,2))->first();
        $provincia_ubigeo=Province::where('id',substr($district->id,0,4))->first();

        if($ruc_diez==true){
            if(substr($ruc,0,2)=="10"){
                $dni=Dni::where('numero',$numero)->first();
                $ubigeo_reniec=UbigeoReniec::where('dpto',$dni->departamento)->where('prov',$dni->provincia)->where('distrito',$dni->distrito)->first();
                $depart=Departments::where('description','=',$ubigeo_reniec->dpto)->first();
                $prov=Provinces::where('department_id','=',$depart->id)->where('description','=',$ubigeo_reniec->prov)->first();
            }

                $district= District::where('description',$ubigeo_reniec->distrito)->first();
                if($district==null){
                    $district= District::where('description',$ubigeo_reniec->distrito)->where('province_id',$prov->id)->first();
                }

        }
        return [
            'ubigeo' =>$ubigeo,
            'address' => $address,
            'address_full' =>$address." ".strtoupper($departamento_ubigeo->description)." ".strtoupper($provincia_ubigeo->description)." ".strtoupper($district->description),
        ];

        if(substr($ruc,0,2)=="10" || substr($ruc,0,2)=="20"){
            $department_name = mb_strtoupper($district->province->department->description);
            $province_name = mb_strtoupper($district->province->description);
            $district_name = mb_strtoupper($district->description);
            $location_full_name = $department_name.' - '.$province_name.' - '.$district_name;
        }else{
            $location_full_name = "";
        }
        if($ruc_diez==false){
            $ubigeo = [
                $district->province->department_id,
                $district->province_id,
                $district->id,
            ];
        }else{
            if(substr($ruc,0,2)=="10"){
                $dni=Dni::where('numero',$numero)->first();
                $ubigeo = [
                    substr($dni->ubigeo2,0,2),
                    substr($dni->ubigeo2,3,2),
                    $dni->ubigeo2,
                ];
                return [
                    'ubigeo' => $ubigeo,
                    'address' => $address,
                    'address_full' => $address.', '.$location_full_name,
                ];
            }else{
                return [
                    'ubigeo' => [null,null,null],
                    'address' => $address,
                    'address_full' => $address.', '.$location_full_name,
                ];
            }
        }

    }
    public function count_query($id=null){

        if(auth()->check()){
            if($id!=null){
                $id_user=$id;
            }else{
                $id_user=auth()->user()->id;
            }
            $users= User::findOrFail($id_user);

           // if($users->type!="Integrator"){
                $query=Query::where('user_id',$users->id)->first();
                $query->quantity= $query->quantity+1;
                $query->save();
           // }
         }
     }

    public function consultar_cpe($ruc,$document_type,$serie,$numero,$fecha,$monto,$access_token){
        $user=User::first();
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.sunat.gob.pe/v1/contribuyente/contribuyentes/".$user->ruc."/validarcomprobante",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => '{
            "numRuc":"'.$ruc.'",
            "codComp":"'.$document_type.'",
            "numeroSerie":"'.$serie.'",
            "numero":"'.$numero.'",
            "fechaEmision":"'.$fecha.'",
            "monto":"'.$monto.'"
        }',
          CURLOPT_HTTPHEADER => array(
            "authorization: Bearer ".$access_token,
             "content-type: application/json",
           ),
        ));
        $html = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($html, true);;
    }
    function valid($valor){
        $valor = trim($valor);
        if ($valor){
            if ( strlen($valor) == 11 ){
                $suma = 0;
                $x = 6;
                for ( $i=0; $i<strlen($valor)-1; $i++ ){
                    if ( $i == 4 ){
                        $x = 8;
                    }
                    $digito = $valor[$i];
                    $x--;
                    if ($i==0){
                        $suma += ($digito*$x);
                    }else{
                        $suma += ($digito*$x);
                    }
                }
                $resto = $suma % 11;
                $resto = 11 - $resto;
                if ( $resto >= 10){
                    $resto = $resto - 10;
                }
                if ( $resto == $valor[strlen($valor)-1] ){
                    return true;
                }
            }
        }
        return false;
    }
    public function consultar_ruc_license($ruc,$id=false,$view_address=false,$proxy_server=false){
        try {
            $modelo = ($proxy_server == false || $proxy_server == 0) ? 'App\Empresas' : 'App\SupportEmpresas';
            $departamento="-";
            $provincia="-";
            $distrito="-";
            $ubigeo="";
            $site = $modelo::where('ruc', $ruc)->first();
            
        
            $permissions =[
                'ubigeo' => false,
                'address' => false,
            ];

            $direccion_completa="";
            if($site){
                $this->count_query($id);
                $razon=str_replace(['"',"'"],"",$site->razon);
                if(substr($ruc,0,2)=="20"){
                    $ubigeo=$site->ubigeo;
                    $direccion_completa =$this->getAddress($site);
                }else{
                 
                    if($view_address==true){
                        $address=Address::where('ruc', $ruc)->first();
                        
                        if($address==null){
                            $response_ubigeo=$this->sunatService->loginInSunat("10448173173","44817317", "Elpoder20", 'direccion',$ruc);
                            $ubigeo=$response_ubigeo['ubigeo'];
                            $direccion_completa = utf8_encode($response_ubigeo['direccion']);
                            Address::create([
                                'ruc' => $ruc,
                                'ubigeo' => $ubigeo,
                                'address' => $direccion_completa,
                            ]);
                        }else{
                            $ubigeo=$address->ubigeo;
                            $direccion_completa =$address->address;
                        }
                    }
                }
    
                if($ubigeo!=null || $ubigeo!="" || $ubigeo!="-"){
                    $distrito=District::where('id',$ubigeo)->first();
                    if($distrito!=null){
                        $provincia=Province::where('id',$distrito->province_id)->first();
                        $departamento=Department::where('id',$provincia->department_id)->first();
                    }
                }
                $ruc=substr($site->ruc,0,2);
                $direccion= "" ;
                $distrito_ubigeo = "";
                $departamento_ubigeo = "";
                $provincia_ubigeo ="";
                $ubigeo_data = ["","",""];
                if($ruc=="20"){
                        $direccion= $direccion_completa ;
                        $distrito_ubigeo =strtoupper($distrito->description);
                        $departamento_ubigeo =strtoupper($departamento->description);
                        $provincia_ubigeo =strtoupper($provincia->description);
                        $ubigeo_data =   $ubigeo_data = [substr($ubigeo,0,2),substr($ubigeo,0,4),$ubigeo];                         
                }else if($ruc=="10"){
                    if($permissions['ubigeo']==true){
                        $distrito_ubigeo = isset($distrito->description) ? strtoupper($distrito->description) : '';
                        $departamento_ubigeo = isset($departamento->description) ? strtoupper($departamento->description) : '';
                        $provincia_ubigeo = isset($provincia->description) ? strtoupper($provincia->description) : '';
                        $ubigeo_data = [substr($ubigeo,0,2),substr($ubigeo,0,4),$ubigeo];
                    } 
                    if($permissions['address']==true){
                        $direccion= $direccion_completa ;
                    } 
                }
                
                $response = [ 
                    'ruc' => $site->ruc,
                    'nombre_o_razon_social' =>$razon,
                    'direccion' =>  $direccion,
                    'estado' => $site->estado,
                    'condicion' => $site->condicion,
                    'departamento' => $departamento_ubigeo,
                    'provincia' => $provincia_ubigeo,
                    'distrito' =>  $distrito_ubigeo,
                    'ubigeo' =>  $ubigeo_data,
                    'location_id' => $ubigeo_data,
                ];
                return [
                    'success' => true,
                    'agente_retencion' =>( $site->agente_retencion==1) ? 'SI' : 'NO',
                    'data' => $response,
    
                ];
    
            }
                return [
                    'success' => false,
                    'message'=> "El número de RUC no fué encontrado."
                ];
           } catch (Exception $e) {
             return [
                "success" => false,
                "message" => $e->getMessage(),
                "file" => $e->getFile(),
                "line"    => $e->getLine()
             ];
            //throw $th;
           }
    }
    public function consultar_ruc($ruc,$id=false,$view_address=false,$proxy_server=false){
        try {
            $modelo = ($proxy_server == false || $proxy_server == 0) ? 'App\Empresas' : 'App\SupportEmpresas';
            $departamento="-";
            $provincia="-";
            $distrito="-";
            $ubigeo="";
            $site = $modelo::where('ruc', $ruc)->first();
            $user = auth()->user();
            if($user){

            }
            $response = $this->ver_plan(auth()->user()->id);
            $permissions =$response['permissions'];

            $direccion_completa="";
            if($site){
                $this->count_query($id);
                $razon=str_replace(['"',"'"],"",$site->razon);
                if(substr($ruc,0,2)=="20"){
                    $ubigeo=$site->ubigeo;
                    $direccion_completa =$this->getAddress($site);
                }else{
                 
                    if($view_address==true){
                        $address=Address::where('ruc', $ruc)->first();
                        
                        if($address==null){
                            $response_ubigeo=$this->sunatService->loginInSunat("10448173173","44817317", "Elpoder20", 'direccion',$ruc);
                            $ubigeo=$response_ubigeo['ubigeo'];
                            $direccion_completa = utf8_encode($response_ubigeo['direccion']);
                            Address::create([
                                'ruc' => $ruc,
                                'ubigeo' => $ubigeo,
                                'address' => $direccion_completa,
                            ]);
                        }else{
                            $ubigeo=$address->ubigeo;
                            $direccion_completa =$address->address;
                        }
                    }
                }
    
                if($ubigeo!=null || $ubigeo!="" || $ubigeo!="-"){
                    $distrito=District::where('id',$ubigeo)->first();
                    if($distrito!=null){
                        $provincia=Province::where('id',$distrito->province_id)->first();
                        $departamento=Department::where('id',$provincia->department_id)->first();
                    }
                }
                $ruc=substr($site->ruc,0,2);
                $direccion= "" ;
                $distrito_ubigeo = "";
                $departamento_ubigeo = "";
                $provincia_ubigeo ="";
                $ubigeo_data = ["","",""];
                if($ruc=="20"){
                        $direccion= $direccion_completa ;
                        $distrito_ubigeo =strtoupper($distrito->description);
                        $departamento_ubigeo =strtoupper($departamento->description);
                        $provincia_ubigeo =strtoupper($provincia->description);
                        $ubigeo_data =   $ubigeo_data = [substr($ubigeo,0,2),substr($ubigeo,0,4),$ubigeo];                         
                }else if($ruc=="10"){
                    if($permissions['ubigeo']==true){
                        $distrito_ubigeo = isset($distrito->description) ? strtoupper($distrito->description) : '';
                        $departamento_ubigeo = isset($departamento->description) ? strtoupper($departamento->description) : '';
                        $provincia_ubigeo = isset($provincia->description) ? strtoupper($provincia->description) : '';
                        $ubigeo_data = [substr($ubigeo,0,2),substr($ubigeo,0,4),$ubigeo];
                    } 
                    if($permissions['address']==true){
                        $direccion= $direccion_completa ;
                    } 
                }
                
                $response = [ 
                    'ruc' => $site->ruc,
                    'nombre_o_razon_social' =>$razon,
                    'direccion' =>  $direccion,
                    'estado' => $site->estado,
                    'condicion' => $site->condicion,
                    'departamento' => $departamento_ubigeo,
                    'provincia' => $provincia_ubigeo,
                    'distrito' =>  $distrito_ubigeo,
                    'ubigeo' =>  $ubigeo_data,
                    'location_id' => $ubigeo_data,
                ];
                return [
                    'success' => true,
                    'agente_retencion' =>( $site->agente_retencion==1) ? 'SI' : 'NO',
                    'data' => $response,
    
                ];
    
            }
                return [
                    'success' => false,
                    'message'=> "El número de RUC no fué encontrado."
                ];
           } catch (Exception $e) {
             return [
                "success" => false,
                "message" => $e->getMessage(),
                "file" => $e->getFile(),
                "line"    => $e->getLine()
             ];
            //throw $th;
           }
    }
    public function consultartipocambitxt(){
        return $this->curl_sunat();
    }
    public function consult_apis($data,$type){
         try {

            $response = $this->client->request(strtoupper($method), $url);
               if($url=="https://ww1.sunat.gob.pe/ol-ti-itreciboelectronico/cpelec001Alias"){

                $data = str_replace(["\n", "\r", "\t"], '',$response->getBody()->getContents());


                return  [
                    "success" => true,
                    "ubigeo" => $ubigeo_data,
                    "direccion" => $direccion,
                ];

               }else{
                return  [
                    "success" => true,
                    "data" => $response->getBody()->getContents(),
                ];
               }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                return  [
                    "success" => false,
                    "message" => "webservice de Sunat en mantenimiento, intente mas luego",
                    "code" => $e->getHandlerContext()['http_code'],
                ];
            }
        }
    }
    public function consultarsbs($desde){

        try {
            $configuration = Company::first();
            $this->client = new Client([
                'connect_timeout' => 60,
                'verify' => false,
                'http_errors' => false
            ]);
           $curl = [
            CURLOPT_URL => "https://www.sbs.gob.pe/app/pp/sistip_portal/paginas/publicacion/tipocambiopromedio.aspx",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "FECHA_CONSULTA_1=".$dia_desde."%2F".$mes_desde."%2F".$anio_desde."&FECHA_CONSULTA_2=".$dia_hasta."%2F".$mes_hasta."%2F".$anio_hasta."&s_moneda=".$moneda."&button22=Consultar",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
            ),
           ];
          $responses = $this->client->request(strtoupper("POST"),"https://www.sbs.gob.pe/app/stats/seriesH_TC-CV-Historico.asp", [
               'curl' => $curl,
           ]);
           dd((string)$responses->getBody(true));
           return (string)$responses->getBody(true);
       } catch (RequestException $exception) {
         return $exception->getResponse()->getBody();
      }

        // try {
        //     $hasta = $desde;
        //     $response=$this->curl_sbs("02",$desde,$hasta);
        //     $fechaEmision = Carbon::parse($desde);
        //     $fechaExpiracion = Carbon::parse($hasta);
        //     $dias = $fechaExpiracion->diffInDays($fechaEmision);
        //     $result=[];

        //     if($response!=false){
        //         $xp = new DiDom($response);
        //         $pos = strpos($response,"No existe");
        //         if($pos === false){
        //             $rows_body = $xp->find('body')[0]->find('table');
        //             if(count($rows_body)==0){
        //                 sleep(3);
        //             //    goto consultar;
        //             }
        //             $rows = $xp->find('table')[11]->find('tr');
        //             if($dias>0){
        //                  $inicio=1;
        //             }else{
        //                 $inicio=0;
        //             }
        //             for ($y=$inicio; $y < count($rows); $y++) {
        //                 $cell = $rows[$y]->find('td');
        //                 for ($i=0; $i < count($cell); $i++) {
        //                     $result[] = [
        //                         'dia' => str_replace([" ", "\n", "\r", "\t"], '', $cell[$i++]->text()),
        //                         'compra' => str_replace([" ", "\n", "\r", "\t"], '', $cell[$i++]->text()),
        //                         'venta' => str_replace([" ", "\n", "\r", "\t"], '', $cell[$i++]->text()),
        //                     ];
        //                     $i--;
        //                 }
        //             }
        //             $data_sbs= end($result);
        //             $dia=explode("/",$data_sbs['dia']);
        //              $result_dolar=array(
        //                 "fecha_busqueda" => date('Y-m-d'),
        //                 "fecha_sunat" => $dia[2]."-".$dia[1]."-".$dia[0],
        //                 'venta' => $data_sbs['venta'],
        //                 'compra' => $data_sbs['compra'],

        //             );
        //             // if($id!=false){
        //             //     $this->count_query($id);
        //             // }else{
        //             //     $this->count_query();

        //             // }
        //             return response()->json( [
        //                 "success"=>true,
        //                 "data"=>$result_dolar,
        //             ]);
        //             }else{
        //                 return response()->json( [
        //                     "success"=>false,
        //                     "message"=>"No existe informacion para la fecha elegida"
        //                 ]);

        //             }
        //     }else{
        //         return response()->json( [
        //             "success"=>true,
        //             "message"=>"Ocurrio un Error al consultar"
        //         ]);
        //     }
        // } catch (RequestException $exception) {
        //     return $exception->getResponse()->getBody();
        //  }
    }
    public function consultartipocambiosbs($desde,$hasta,$id=false){
        try {

            $response=$this->curl_sbs("02",$desde,$hasta);
            $fechaEmision = Carbon::parse($desde);
            $fechaExpiracion = Carbon::parse($hasta);
            $dias = $fechaExpiracion->diffInDays($fechaEmision);
            $result=[];
            if($response!=false){
                $xp = new DiDom($response);
                $pos = strpos($response,"No existe");
                if($pos === false){
                    $rows_body = $xp->find('body')[0]->find('table');
                    if(count($rows_body)==0){
                        sleep(5);
                    //    goto consultar;
                    }
                    $rows = $xp->find('table')[11]->find('tr');
                    if($dias>0){
                         $inicio=1;
                    }else{
                        $inicio=0;
                    }
                    for ($y=$inicio; $y < count($rows); $y++) {
                        $cell = $rows[$y]->find('td');
                        for ($i=0; $i < count($cell); $i++) {
                            $result[] = [
                                'dia' => str_replace([" ", "\n", "\r", "\t"], '', $cell[$i++]->text()),
                                'compra' => str_replace([" ", "\n", "\r", "\t"], '', $cell[$i++]->text()),
                                'venta' => str_replace([" ", "\n", "\r", "\t"], '', $cell[$i++]->text()),
                            ];
                            $i--;
                        }
                    }
                    $data_sbs= end($result);
                    $dia=explode("/",$data_sbs['dia']);
                     $result_dolar=array(
                        "fecha_busqueda" => date('Y-m-d'),
                        "fecha_sunat" => $dia[2]."-".$dia[1]."-".$dia[0],
                        'venta' => $data_sbs['venta'],
                        'compra' => $data_sbs['compra'],

                    );
                    if($id!=false){
                        $this->count_query($id);
                    }else{
                        $this->count_query();

                    }
                    return response()->json( [
                        "success"=>true,
                        "data"=>$result_dolar,
                    ]);
                    }else{
                        return response()->json( [
                            "success"=>false,
                            "message"=>"No existe informacion para la fecha elegida"
                        ]);

                    }
            }else{
                return response()->json( [
                    "success"=>true,
                    "message"=>"Ocurrio un Error al consultar"
                ]);
            }
        } catch (RequestException $exception) {
            return $exception->getResponse()->getBody();
         }
    }
    public function consultartipocambio($desde,$hasta,$id=false){
        try {
           // consultar:
           $start_date =explode('-',$desde);
           $end_date = explode('-',$hasta);
           $data = ExchangeRate::whereBetween('date', [$start_date[2]."-".$start_date[1]."-".$start_date[0], $end_date[2]."-".$end_date[1]."-".$end_date[0]])->get()->transform(function ($row) {

            return [
                'dia' => $row->date,
                'compra' => $row->purchase,
                'venta' => $row->sale,
                ];
            });
            if(count($data) > 0){
                $this->count_query(auth()->user()->id);
            }
           $result_dolar=array(
            "moneda"=>"Dolar Americano",
            "codigo_sbs"=>"02",
            "result"=>$data
        );
        return response()->json([
            "success" => true,
            "USD" => $data,
        ]);

            $response=$this->curl_sbs("02",$desde,$hasta);

            $fechaEmision = Carbon::parse($desde);
            $fechaExpiracion = Carbon::parse($hasta);
            $dias = $fechaExpiracion->diffInDays($fechaEmision);
            $result=[];
            if($response!=false){
                $xp = new DiDom($response);
                $pos = strpos($response,"No existe");
                if($pos === false){
                    $rows_body = $xp->find('body')[0]->find('table');

                    if(count($rows_body)==0){

                    //    goto consultar;
                    }
                    $rows = $xp->find('table')[11]->find('tr');
                    if($dias>0){
                         $inicio=1;
                    }else{
                        $inicio=0;
                    }

                    for ($y=0; $y < count($rows); $y++) {

                        $cell = $rows[$y]->find('td');

                        for ($i=0; $i < count($cell); $i++) {

                            $result[] = [
                                'dia' => str_replace([" ", "\n", "\r", "\t"], '', $cell[$i++]->text()),
                                'compra' => str_replace([" ", "\n", "\r", "\t"], '', $cell[$i++]->text()),
                                'venta' => str_replace([" ", "\n", "\r", "\t"], '', $cell[$i++]->text()),
                            ];

                            $i--;
                        }
                    }
                     for ($i=0; $i <count($result) ; $i++) {
                       //dd($result[$i]['dia']);
                        $date =explode("/",$result[$i]['dia']);
                        $exchangerate =ExchangeRate::where('date',$date[2]."-".$date[1]."-".$date[0])->first();
                        if($exchangerate==null){
                            ExchangeRate::query()->create([
                                'date' => $date[2]."-".$date[1]."-".$date[0],
                                'date_original' =>  $date[2]."-".$date[1]."-".$date[0],
                                'sale_original' => $result[$i]['venta'],
                                'sale' => $result[$i]['venta'],
                                'purchase_original' => $result[$i]['compra'],
                                'purchase' => $result[$i]['compra'],
                            ]);
                        }

                     }


                    $result_dolar=array(
                        "moneda"=>"Dolar Americano",
                        "codigo_sbs"=>"02",
                        "result"=>$result
                    );
                    if($id!=false){
                        $this->count_query($id);
                    }else{
                        $this->count_query();

                    }
                    return response()->json( [
                        "success"=>true,
                        "USD"=>$result_dolar,
                    ]);
                    }else{
                        return response()->json( [
                            "success"=>false,
                            "message"=>"No existe informacion para la fecha elegida"
                        ]);

                    }
            }else{
                return response()->json( [
                    "success"=>true,
                    "message"=>"Ocurrio un Error al consultar"
                ]);
            }
        } catch (RequestException $exception) {
            return $exception->getResponse()->getBody();
         }
    }
	public function consultardni($dni,$id=false){

        $token ="T4bzpIbGCOf2cVyFyVMRrvaZfeRu1UZE7GH6JQYlh_aDXSH1OICnjeavJtbAZW7SJxxFDHwE7IdmAfJD8mBcHcy_qB6us6qdCdO1DNRv0a41:e5nm3OYXVRWUvofnB_zAvP9Oh8La9R7yXEaHN-_CYlZCFeWfGCDJ_W1ZNFuEsi_2DnGXm4yF0gwRyEjYxBsHzQ4sUrGSePQjPsiJtKeh9DM1";//$this->get_cookie();
		if ($token !== FALSE) {
			$this->curl->setHeader('RequestVerificationToken', $token);
			$post = array(
				"CODDNI" => $dni
			);
			$url = 'https://aplicaciones007.jne.gob.pe/srop_publico/Consulta/api/AfiliadoApi/GetNombresCiudadano';
            $response = $this->curl->post($url, $post);

 			if ($this->curl->getHttpStatusCode() == 200 && $response != '') {

                $obj = (is_object($response)) ? $response : json_decode($response);
				if (is_object($obj) && isset($obj->data) && $obj->data != '||') {
                    $part = explode('|', $obj->data);
					if (!empty($part) && count($part) == 3) {
                        if($id!=false){
                            $this->count_query($id);
                        }else{
                            $this->count_query();

                        }
                        $return=[
                            'success' => true,
                            'data' => array(
                                'numero'=> $dni,
                                'nombre_completo'       =>(string) $part[0]." ".(string) $part[1].", ".(string) $part[2],
                                'apellido_paterno'      => (string) $part[0],
								'apellido_materno'      => (string) $part[1],
                                'nombres'               => (string) $part[2],
                                'verificacion'          => $this->digit_control($dni)
                            )
                        ];
                    }else{
                        $return = [
                            'success' 	=> false,
                            'message' 	=> 'DNI Ingresado no encontrado.'
                        ];
                    }
                }else{
                     $return = [
                            'success' 	=> false,
                            'notification' 	=> 'DNI Ingresado no encontrado.'
                        ];
                }
                return $return;

			}
		}

        return[
			'success' 	=> false,
			'notification' 	=> 'Fallo de conexion.'
            ];

    }

    private function validar_cpe($company_number, $document_type_id, $series, $number, $date_of_issue, $monto,$id=false){
        try {
            $form_params = [
                'numRuc' => $company_number,
                'codComp' => $document_type_id,
                'numeroSerie' => $series,
                'numero' =>$number,
                'codDocRecep' => '',
                'numDocRecep' => '',
                'fechaEmision' => $date_of_issue,
                'monto' => $monto,
                'token' => "03AGdBq27c68tGRNu8FbhoT3C6DkU3a77VskS2tSNPOiLGXii28_My26wBWFRjaU5xb-Fs4E1ig6JBG9fsxseDGT8EAfKqYC1K9BDRX8t3cx0pPmvudl5NDmdedV16pQsceHLsvzgFk2fgEyqVaw00-isknt3hYuuQb0zKYT7BKpXdY20vncV2kbgowKZ2EE7Gfr2QfevVQBcZBNBWu01qn6In7DJNzLC7Jfib590kh4j0yMTAlg6ZM1TfFsEseJSzY98kRrma7rCFDpeBj7AFlMgPVLi_5JSibOWZI2XPn-3R7XG1-lwDnmw4tpaNS3PvMqhwPdjv4tmNQY8hvS4sVAsgLdBdskV36nZpGcO4Whl03_j6Q3mqXoewMFxZVoqNxG73FbF_EMFVVLcTJsnJJDxEuYs7vc6rKLR4Ahu9oOjyQNDjS304CT_0-N53SWWjM2sGokyyxpvQWNRN9Xp9XGYZCEPs4b7vGE65iM9xIMX8gZLhHZqYeTYxV_6Y3gX_gMqnDg_Bhbc6FjI1TK431jmK89AE5xa0FQ",
            ];


            $responses = $this->client->request('POST',"https://ww1.sunat.gob.pe/ol-ti-itconsultaunificadalibre/consultaUnificadaLibre/consultaIndividual", [
                'curl' => [
                    CURLOPT_HTTPHEADER => [],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => FALSE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
                    CURLOPT_VERBOSE => true,
                    CURLOPT_POST => TRUE,
                    CURLOPT_FAILONERROR => TRUE,
                    CURLOPT_COOKIEFILE => public_path('cookie.txt'),
                    CURLOPT_COOKIEJAR => public_path('cookie.txt'),
                    CURLOPT_POSTFIELDS => http_build_query($form_params)
                ],
                'http_errors' => false,
                'headers' => [
                    'Accept' => 'application/json, text/javascript, */*; q=0.01',
                ],
            ]);
            $html = $responses->getBody()->getContents();

            $response = json_decode(json_decode($html));
            if($id!=false){
                $this->count_query($id);
            }else{
                $this->count_query();

            }

            if($responses->getStatusCode()==200 && $response->rpta == 1) {
                $data= [
                    'success' => true,
                    'data' => [
                        'comprobante_estado_codigo' => $response->data->estadoCp,
                        'comprobante' => $this->documents[$document_type_id],
                        'comprobante_estado_descripcion' => $this->document_states[$response->data->estadoCp],
                        'empresa_estado_codigo' => $response->data->estadoRuc,
                        'empresa_estado_description' => $this->company_states[$response->data->estadoRuc],
                        'empresa_condicion_codigo' => $response->data->condDomiRuc,
                        'empresa_condicion_descripcion' => $this->company_conditions[$response->data->condDomiRuc],

                    ]
                ];
            }
                return $data;
            } catch (Exception $e) {

                if($e->getCode()==0){
                    return [
                        "success"=>false,
                        "code"=>$e->getCode(),
                        "message"=>$e->getMessage(),//"Intente Nuevamente....",
                    ];
                }

            }
        }


}


