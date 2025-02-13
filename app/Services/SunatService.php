<?php

namespace App\Services;

use App\Dni;
use Exception;
use App\District;
use App\Empresas;
use App\Province;
use App\Districts;
use App\Provinces;
use App\Department;
use App\UbigeoInei;
use App\Departments;
use App\UbigeoReniec;
use GuzzleHttp\Client;
use App\Traits\ApiResults;
use App\Traits\ApiResponser;
use DiDom\Document as DiDom;
use App\Traits\ExtractorTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use App\Contracts\Services\ZipContractService;
use App\Contracts\Services\SunatContractService;
use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;

class SunatService
{
    use ApiResponser, StorageDocument, ApiResults, ExtractorTrait;
    private $delimiter;
    private $url;
    private $zipService;
    private $login;
    private $httprequest;
    protected $_cookieFileLocation;
    protected $_user_auth;
    protected $_cookieSunat;
    protected $directorio;
    const METHOD_SHOW = 'show';
    const METHOD_DOWNLOAD = 'download';
    const METHOD_COMPRA = 'compras';
    private $estadoCp = [
        '-' => '-',
        '0' => 'NO EXISTE',
        '1' => 'ACEPTADO',
        '2' => 'ANULADO',
        '3' => 'AUTORIZADO',
        '4' => 'NO AUTORIZADO',
    ];

    private $estadoRuc = [
        '-'  => '-',
        '00' => 'ACTIVO',
        '01' => 'BAJA PROVISIONAL',
        '02' => 'BAJA PROV. POR OFICIO',
        '03' => 'SUSPENSION TEMPORAL',
        '10' => 'BAJA DEFINITIVA',
        '11' => 'BAJA DE OFICIO',
        '12' => 'BAJA MULT.INSCR. Y OTROS',
        '20' => 'NUM. INTERNO IDENTIF.',
        '21' => 'OTROS OBLIGADOS',
        '22' => 'INHABILITADO-VENT.UNICA',
        '30' => 'ANULACION - ERROR SUNAT',
    ];

    private $estadoDomicilio = [
        '-'  => '-',
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
        '40' => 'DEVUELTO',
    ];

    public function __construct()
    {
        $this->client = new Client([
            'connect_timeout' => 0,
            'base_uri' => 'https://www.sunat.gob.pe/ol-ti-itconsultaunificadalibre/consultaUnificadaLibre/',
            'stream' => false,
            'headers' => [
                'User-Agent' => 'Testing 1.0'
            ]
        ]);
        //$this->directorio =  dirname(__FILE__) . '//tempo';
        //$FileNameCookie =  uniqid();
        //$this->cookieFileLocation = $this->directorio . '//' . $FileNameCookie;
        //$this->cookieSunat =(!file_exists('cookies.txt')) ? null: 'cookies.txt' ;
        // $this->user_auth=false;
    }


    public function processRuc10($userRuc, $userSunat, $userPassword, $ruc)
    {
        $this->loginInSunat($userRuc, $userSunat, $userPassword, 'view_address');
        $responses = $this->requestHttp("https://ww1.sunat.gob.pe/ol-ti-itemisionfactura/emitir.do?action=obtenerDomicilioFiscal&tipoDocumento=6&numeroDocumento=" . $ruc);
        $result = json_decode($responses['data']);
        //        dd($result->data,$result->codeError);
        return [
            "success" => ($result->codeError == 0) ? true : false,
            "data" => ($result->codeError == 0) ? $result->data : "Ocurrio un error"
        ];
    }





    public function generar_json_cpe($xml, $proceso)
    {
        $contents = utf8_encode(str_replace(array("\t", "ext:", "ds:", "cbc:", "cbc:", "cac:", "<![CDATA[", "]]>"), "", $xml));
        $xml   = simplexml_load_string($contents);
        $json = json_decode(json_encode($xml));
        File::deleteDirectory(public_path('temp'));
        File::deleteDirectory(public_path('tempo'));

        if (is_array($json->TaxTotal->TaxSubtotal) == true) {
            $afecto = $json->TaxTotal->TaxSubtotal[0]->TaxCategory->TaxScheme->ID;
            if ($afecto == 1000) {
                $igv = $json->TaxTotal->TaxSubtotal[0]->TaxAmount;
                $subtotal = $json->TaxTotal->TaxSubtotal[0]->TaxableAmount;
                $exonerado = 0.00;
            } else {
                $igv = 0.00;
                $exonerado = $json->TaxTotal->TaxSubtotal[0]->TaxableAmount; //$json->TaxTotal->TaxSubtotal->TaxExclusiveAmount;
                $subtotal = 0.00;
            }
        } else {
            $afecto = $json->TaxTotal->TaxSubtotal->TaxCategory->TaxScheme->ID;
            if ($afecto == 1000) {
                $igv = $json->TaxTotal->TaxSubtotal->TaxAmount;
                $subtotal = $json->TaxTotal->TaxSubtotal->TaxableAmount;
                $exonerado = 0.00;
            } else {
                $igv = 0.00;
                $exonerado = $json->TaxTotal->TaxSubtotal->TaxableAmount; //$json->TaxTotal->TaxSubtotal->TaxExclusiveAmount;
                $subtotal = 0.00;
            }
        }
        $detalle = [];
        if (is_array($json->InvoiceLine) == true) {
            foreach ($json->InvoiceLine as $key => $rows) {
                $detalle[] =   [
                    "cantidad" => $rows->InvoicedQuantity,
                    "descripcion" => $rows->Item->Description,
                    "valor_unitario" => $rows->Price->PriceAmount,
                    "precio_unitario" => $rows->PricingReference->AlternativeConditionPrice->PriceAmount,
                    "igv" => $rows->TaxTotal->TaxSubtotal->TaxAmount,
                    "impuesto" => $rows->TaxTotal->TaxSubtotal->TaxCategory->Percent,
                    "afecto" => $rows->TaxTotal->TaxSubtotal->TaxCategory->TaxExemptionReasonCode,
                    "valor_importe" => $rows->TaxTotal->TaxSubtotal->TaxableAmount,
                    "importe" => number_format($rows->TaxTotal->TaxSubtotal->TaxableAmount + $rows->TaxTotal->TaxSubtotal->TaxAmount, 2),
                ];
            }
        } else {
            $detalle[] =   [
                "cantidad" => $json->InvoiceLine->InvoicedQuantity,
                "descripcion" => $json->InvoiceLine->Item->Description,
                "valor_unitario" => $json->InvoiceLine->Price->PriceAmount,
                "precio_unitario" => $json->InvoiceLine->PricingReference->AlternativeConditionPrice->PriceAmount,
                "igv" => $json->InvoiceLine->TaxTotal->TaxSubtotal->TaxAmount,
                "impuesto" => $json->InvoiceLine->TaxTotal->TaxSubtotal->TaxCategory->Percent,
                "afecto" => $json->InvoiceLine->TaxTotal->TaxSubtotal->TaxCategory->TaxExemptionReasonCode,
                "valor_importe" => $json->InvoiceLine->TaxTotal->TaxSubtotal->TaxableAmount,
                "importe" => number_format($json->InvoiceLine->TaxTotal->TaxSubtotal->TaxableAmount + $json->InvoiceLine->TaxTotal->TaxSubtotal->TaxAmount, 2),
            ];
        }
        $data_json = [
            "tipo_comprobante" => $proceso,
            "emisor" => [
                "ruc" => $json->AccountingSupplierParty->Party->PartyIdentification->ID,
                "razon_social" => $json->AccountingSupplierParty->Party->PartyLegalEntity->RegistrationName,
            ],
            "comprobante" => [
                "serie" => substr($json->ID, 0, 4),
                "numero" => str_pad(substr($json->ID, 5, strlen($json->ID)), 6, "0", STR_PAD_LEFT),
                "fecha" => $json->IssueDate,
                "hora" => "",
                "moneda" => $json->DocumentCurrencyCode,
                "cliente" => $json->AccountingCustomerParty->Party->PartyLegalEntity->RegistrationName,
                "ruc" => $json->AccountingCustomerParty->Party->PartyIdentification->ID,
                "detalle" => $detalle,
                "subtotal" => $subtotal,
                "exonerado" => $exonerado,
                "igv" => $igv,
                "total" => $json->LegalMonetaryTotal->PayableAmount
            ],
        ];

        return  json_decode(json_encode($data_json));
    }

    public function processTxt($file)
    {
        try {
            
            $this->delimiter = '-------------' . uniqid();
            // $company = Company::first();
            $ruc = '10787188465';
            $usuario_sol = '78718846';
            $clave_sol = 'Jose0906';
            $fileContent = $this->openTxtInvoice($file);
            $this->loginInSunat($ruc, $usuario_sol, $clave_sol);


            if (empty($fileContent)) {
                return [
                    'success' => false,
                    'message' => 'El archivo contiene lineas en blanco'
                ];
            }

            $fileContent = $this->prepareFileContent($fileContent);
            // Log::info($fileContent);
            $sunatResponse = $this->sendDataToSunat($fileContent);
            //if (array_key_exists('success', $sunatResponse)) {
            if (isset($sunatResponse['success'])) {
                if ($sunatResponse['success'] == false) {
                    return $sunatResponse;
                }
            } else {

                return [
                    "success" => false,
                    "message" => "En estos momentos no se puede conectarse a sunat, intente mas tarde"
                ];
            }

            $result = $this->prepareSunatResponse($sunatResponse['data']);
            //       dd($sunatResponse);
            if ($result['success'] == false) {
                return [
                    'message' => 'Problemas con la webServices de Sunat '
                ];
            } else {
                return [
                    'success' => $result['success'],
                    // 'data' => $result['cpes'],
                    'message' => 'Cantidad de CPEs consultados: ' . $result['iterations']
                ];
            }
        } catch (ClientException $e) {
        }
    }


    public function logueo_sunat($userRuc, $userSunat, $userPassword)
    {
        $this->requestHttp(
            'https://api-seguridad.sunat.gob.pe/v1/clientessol/4f3b88b3-d9d6-402a-b85d-6a0bc857746a/oauth2/j_security_check',
            'POST',
            [
                'tipo' => '2',
                'dni' => '',
                'custom_ruc' => $userRuc,
                'j_username' => $userSunat,
                'j_password' => $userPassword,
                'captcha' => '',
                'originalUrl' => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/AutenticaMenuInternet.htm',
                'state' => 'rO0ABXNyABFqYXZhLnV0aWwuSGFzaE1hcAUH2sHDFmDRAwACRgAKbG9hZEZhY3RvckkACXRocmVzaG9sZHhwP0AAAAAAAAx3CAAAABAAAAADdAAEZXhlY3B0AAZwYXJhbXN0AEsqJiomL2NsLXRpLWl0bWVudS9NZW51SW50ZXJuZXQuaHRtJmI2NGQyNmE4YjVhZjA5MTkyM2IyM2I2NDA3YTFjMWRiNDFlNzMzYTZ0AANleGVweA',
            ]
        );
        $this->requestHttp('https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=10.5.3.1.1&s=ww1');
    }

    public function loginInSunat($userRuc, $userSunat, $userPassword, $method = 'default', $ruc = null)
    {
        $result = $this->requestHttp(
            'https://api-seguridad.sunat.gob.pe/v1/clientessol/4f3b88b3-d9d6-402a-b85d-6a0bc857746a/oauth2/j_security_check',
            'POST',
            [
                'tipo' => '2',
                'dni' => '',
                'custom_ruc' => $userRuc,
                'j_username' => $userSunat,
                'j_password' => $userPassword,
                'captcha' => '',
                'originalUrl' => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/AutenticaMenuInternet.htm',
                'state' => 'rO0ABXNyABFqYXZhLnV0aWwuSGFzaE1hcAUH2sHDFmDRAwACRgAKbG9hZEZhY3RvckkACXRocmVzaG9sZHhwP0AAAAAAAAx3CAAAABAAAAADdAAEZXhlY3B0AAZwYXJhbXN0AEsqJiomL2NsLXRpLWl0bWVudS9NZW51SW50ZXJuZXQuaHRtJmI2NGQyNmE4YjVhZjA5MTkyM2IyM2I2NDA3YTFjMWRiNDFlNzMzYTZ0AANleGVweA',
            ]
        );
        $internalUrl = [
            'default'       => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=11.19.1.1.1&s=ww1',
            'xml'           => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=11.9.5.1.1&s=ww1',
            'empleador'     => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=10.5.3.1.1&s=ww1',
            'verificar'     => 'https://ww1.sunat.gob.pe/ol-ti-itconscpegem/consultar.do',
            'direccion'     => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=11.5.1.1.2&s=ww1',
            'view_address'  => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=11.5.3.1.1&s=ww1',
            'download_xml'  => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=11.5.3.1.2&s=ww1'
        ];
        $results = $this->requestHttp($internalUrl[$method]);
        if ($internalUrl[$method] == "https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=11.5.1.1.2&s=ww1") {
            $response = $this->requestHttp(
                'https://ww1.sunat.gob.pe/ol-ti-itreciboelectronico/cpelec001Alias',
                'POST',
                [
                    'accion' => 'VALIDATIPODOC',
                    'formaPago' => 'CREDITO',
                    'tipdoc' => '6',
                    'numdoc' => $ruc,
                    'ubigeoUsuario' => '',
                    'direccionUsuario' => '',
                    'txtUbi_Codigo' => '',
                    'txtUbi_departamento' => '',
                    'txtUbi_provincia' => '',
                    'txtUbi_distrito' => ''
                ]
            );

            return $response;
        }
    }

    public function iniciarsesion($userRuc, $userSunat, $userPassword, $method = 'download_xml', $ruc = null)
    {
        $result = $this->requestHttp(
            'https://api-seguridad.sunat.gob.pe/v1/clientessol/4f3b88b3-d9d6-402a-b85d-6a0bc857746a/oauth2/j_security_check',
            'POST',
            [
                'tipo' => '2',
                'dni' => '',
                'custom_ruc' => $userRuc,
                'j_username' => $userSunat,
                'j_password' => $userPassword,
                'captcha' => '',
                'originalUrl' => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/AutenticaMenuInternet.htm',
                'state' => 'rO0ABXNyABFqYXZhLnV0aWwuSGFzaE1hcAUH2sHDFmDRAwACRgAKbG9hZEZhY3RvckkACXRocmVzaG9sZHhwP0AAAAAAAAx3CAAAABAAAAADdAAEZXhlY3B0AAZwYXJhbXN0AEsqJiomL2NsLXRpLWl0bWVudS9NZW51SW50ZXJuZXQuaHRtJmI2NGQyNmE4YjVhZjA5MTkyM2IyM2I2NDA3YTFjMWRiNDFlNzMzYTZ0AANleGVweA',
            ]
        );
        $internalUrl = [
            'default'       => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=11.19.1.1.1&s=ww1',
            'xml'           => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=11.9.5.1.1&s=ww1',
            'empleador'     => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=10.5.3.1.1&s=ww1',
            'verificar'     => 'https://ww1.sunat.gob.pe/ol-ti-itconscpegem/consultar.do',
            'direccion'     => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=11.5.1.1.2&s=ww1',
            'view_address'  => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=11.5.3.1.1&s=ww1',
            'download_xml'  => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=11.5.3.1.2&s=ww1'
        ];
        $result = $this->requestHttp('https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=11.5.3.1.2&s=ww1');
    }


    public function login($userRuc, $userSunat, $userPassword)
    {
        $this->requestHttp(
            'https://api-seguridad.sunat.gob.pe/v1/clientessol/4f3b88b3-d9d6-402a-b85d-6a0bc857746a/oauth2/j_security_check',
            'POST',
            [
                'tipo' => '2',
                'dni' => '',
                'custom_ruc' => $userRuc,
                'j_username' => $userSunat,
                'j_password' => $userPassword,
                'captcha' => '',
                'originalUrl' => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/AutenticaMenuInternet.htm',
                'state' => 'rO0ABXNyABFqYXZhLnV0aWwuSGFzaE1hcAUH2sHDFmDRAwACRgAKbG9hZEZhY3RvckkACXRocmVzaG9sZHhwP0AAAAAAAAx3CAAAABAAAAADdAAEZXhlY3B0AAZwYXJhbXN0AEsqJiomL2NsLXRpLWl0bWVudS9NZW51SW50ZXJuZXQuaHRtJmI2NGQyNmE4YjVhZjA5MTkyM2IyM2I2NDA3YTFjMWRiNDFlNzMzYTZ0AANleGVweA',
            ]
        );
        $this->requestHttp('https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm?action=execute&code=10.5.3.1.1&s=ww1');
    }



    public function requestHttp($url, $method = 'get', $data = [], $headers = [], $photo = false)
    {
        $directorio = dirname(__FILE__) . '..//..//..//public//tempo';
        $cookieFileLocation = $directorio . '//' . uniqid();
        try {
            $curl = [
                CURLOPT_USERAGENT =>  "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0",
                CURLOPT_HTTPHEADER => [],
                CURLOPT_ENCODING => "",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_COOKIESESSION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_VERBOSE => true,
                CURLOPT_POST => strtoupper($method) == 'POST',
                CURLOPT_FAILONERROR => true,
                CURLOPT_COOKIEFILE => $cookieFileLocation,
                CURLOPT_COOKIEJAR => $cookieFileLocation,
            ];
            if ($method == 'get') {
                $curl[CURLOPT_MAXREDIRS] = 2;
                $curl[CURLOPT_TIMEOUT] = 10;
                $curl[CURLOPT_CONNECTTIMEOUT] = 10;
                $curl[CURLOPT_FOLLOWLOCATION] = true;
            }
            if (!empty($data)) {
                $curl[CURLOPT_POSTFIELDS] = is_array($data) ? http_build_query($data) : $data;
            }
            if (!empty($headers)) {
                $curl[CURLOPT_CUSTOMREQUEST] = "POST";
                $curl[CURLOPT_HTTPHEADER] = $headers;
            }

            $response = $this->client->request(strtoupper($method), $url, [
                'curl' => $curl,
                'http_errors' => false,
            ]);
            if ($url == "https://ww1.sunat.gob.pe/ol-ti-itreciboelectronico/cpelec001Alias") {

                $data = str_replace(["\n", "\r", "\t"], '', $response->getBody()->getContents());

                //  dd($response->getBody()->getContents());
                $buscar_ubigeo = 'document.getElementById("txtUbi_Codigo").value = "';
                $buscar_fin = 'onchange="this.value=this.value.toUpperCase()" disabled>';
                $pos   = strripos($data, $buscar_ubigeo);
                $buscar_direccion = 'id="direccionUsuarioTemp" value="';
                if ($pos === false) {
                    $ubigeo_data = "";
                } else {
                    $ubigeo_data = substr($data, $pos + 50, 6);
                }
                $pos_direccion   = strripos($data, $buscar_direccion);
                if ($pos_direccion === false) {
                    $direccion = "";
                } else {

                    $direccion = substr(trim(substr($data, $pos_direccion + 33, (strripos($data, $buscar_fin)) - ($pos_direccion + 33) - 1)), 0, strlen(trim(substr($data, $pos_direccion + 33, (strripos($data, $buscar_fin)) - ($pos_direccion + 33) - 1))) - 1);
                }
                return  [
                    "success" => true,
                    "ubigeo" => $ubigeo_data,
                    "direccion" => $direccion,
                ];
            } else {
                return  [
                    "success" => true,
                    "data" => $response->getBody()->getContents(),
                ];
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                return  [
                    "original_message" => $e->getMessage(),
                    "success" => false,
                    "message" => "webservice de Sunat en mantenimiento, intente mas luego",
                    "code" => $e->getHandlerContext()['http_code'],
                ];
            }
        }
    }




    private function openTxtInvoice($file)
    {
        return file_get_contents(public_path("storage/txt/{$file}"));
    }

    public function requestHttp2($url, $method = 'get', $data = '', $result = false)
    {
        try {
            $directorio = dirname(__FILE__) . '..//..//..//public//tempo';
            $cookieFileLocation = $directorio . '//' . uniqid();

            $curl = [
                CURLOPT_USERAGENT =>  "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0",
                CURLOPT_HTTPHEADER => [],
                CURLOPT_ENCODING => "",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => false,

                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_VERBOSE => true,
                CURLOPT_POST => strtoupper($method) == 'POST',
                CURLOPT_FAILONERROR => TRUE,
                CURLOPT_COOKIEFILE => $cookieFileLocation,
                CURLOPT_COOKIEJAR => $cookieFileLocation,
            ];

            if (!empty($data)) {
                $curl[CURLOPT_POSTFIELDS] = is_array($data) ? http_build_query($data) : $data;
            }
            $curl[CURLOPT_CUSTOMREQUEST] = "POST";
            $responses = $this->client->request(strtoupper($method), $url, [
                'curl' => $curl,
                'http_errors' => false,
            ]);
            // dd($responses->getBody()->getContents());
            if ($result == false) {

                return json_decode($responses->getBody()->getContents(), true);
            } else {

                return json_decode($responses->getBody()->getContents(), true);
            }
        } catch (Exception $e) {
            //    dd($e);
            return response()->json([
                $e
            ]);
        }
    }
    private function prepareFileContent($fileContent)
    {
        $fields = [];
        $files = ['txtarchivo' => $fileContent];
        $data = '';
        $eol = "\r\n";

        foreach ($fields as $name => $content) {
            $data .= "--" . $this->delimiter . $eol
                . 'Content-Disposition: form-data; name="' . $name . "\"" . $eol . $eol
                . $content . $eol;
        }

        foreach ($files as $name => $content) {
            $data .= "--"
                . $this->delimiter
                . $eol
                . 'Content-Disposition: form-data; name="' . $name . '"; filename="' . $name . '"' . $eol
                . 'Content-Type: text/plain'
                . $eol
                . $eol
                . $content
                . $eol;
        }

        return $data .= "--{$this->delimiter}--{$eol}";
    }

    private function sendDataToSunat($data)
    {
        $headers = [
            "Content-Type: multipart/form-data; boundary=" . $this->delimiter,
            "Content-Length: " . strlen($data)
        ];

        return $this->requestHttp(
            'https://ww1.sunat.gob.pe/ol-ti-itconsultaunificada/consultaUnificada/importarFromTXT',
            'post',
            $data,
            $headers
        );
    }

    private function prepareSunatResponse($response)
    {

        $response = trim($response, '"');
        $response = utf8_encode($response);
        $response = html_entity_decode($response);
        $response = stripslashes($response);
        $object = is_object($response) ? $response : json_decode($response);
        $iterations = 0;
        $cpe = [];
        if (is_object($object) && isset($object->lista) && $object->rpta == '1') {

            foreach ($object->lista as $key => $value) {
                $iterations++;
                $document_type_id = $value->codComp;
                $serie = $value->numeroSerie;
                $numero = $value->numero;
                $document = Document::where('document_type_id', $document_type_id)->where('series', $serie)->where('number', $numero)->first();
                if ($document) {
                    $state_sunat = $this->estadoCp[$value->estadoCp];
                    
                    $document->state_sunat = $state_sunat == "-" ? "NO EXISTE":$state_sunat;
                    $document->save();
                }
                // $cpe[] = [
                //     'RucEmisor' => $value->numRuc,
                //     'TipoComprobante' => $value->codComp,
                //     'Serie' => $value->numeroSerie,
                //     'Numero' => $value->numero,
                //     'TipoDocReceptor' => $value->codDocRecep,
                //     'NumDocReceptor' => $value->numDocRecep,
                //     'FechaEmision' => $value->fechaEmision,
                //     'Importe' => $value->monto,
                //     'EstadoCodComprobante' => $value->estadoCp,
                //     'EstadoComprobante' => $this->estadoCp[$value->estadoCp],
                //     'EstadoCodRuc' => $value->estadoRuc,
                //     'EstadoRuc' => $this->estadoRuc[$value->estadoRuc],
                //     'EstadoCodDomicilio' => $value->condDomiRuc,
                //     'EstadoDomicilio' => $this->estadoDomicilio[$value->condDomiRuc],
                //     'Observaciones' => isset($value->observaciones) ? $value->observaciones[0] : '-'
                // ];
            }

            return [
                'success' => true,
                'iterations' => $iterations,
                // 'cpes' => $cpe
            ];
        }

        return [
            'success' => false,
            'message' => $object->rpta,
        ];
    }
}
