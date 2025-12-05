<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Dispatch;
use App\Models\Tenant\Document;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Quotation;
use App\Models\Tenant\SaleNote;
use App\Traits\JobReportTrait;
use Exception;
use GuzzleHttp\Client;
use Hyn\Tenancy\Environment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WhatsappSendDocumentProccess implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobReportTrait;

    protected $message;
    protected $website_id;
    protected $url_file;
    protected $document_id;
    protected $document_type_id;
    protected $xml;
    protected $customer_telephone;
    protected $url;
    
    /**
     * Log adicional para debugging
     */
    private function debugLog($message, $context = [])
    {
        // Log normal
        Log::info($message, $context);
        
        // Log adicional en archivo específico
        try {
            $logFile = storage_path('logs/whatsapp_job_debug.log');
            $timestamp = now()->format('Y-m-d H:i:s');
            $contextStr = !empty($context) ? ' - ' . json_encode($context, JSON_UNESCAPED_UNICODE) : '';
            $logLine = "[{$timestamp}] {$message}{$contextStr}\n";
            file_put_contents($logFile, $logLine, FILE_APPEND);
        } catch (\Exception $e) {
            // Si falla el log adicional, no hacer nada
        }
    }


    public function __construct(
        $message,
        $website_id,
        $url_file,
        $document_id,
        $document_type_id,
        $xml,
        $customer_telephone,
        $url
    ) {
        $this->message = $message;
        $this->website_id = $website_id;
        $this->url_file = $url_file;
        $this->document_id = $document_id;
        $this->document_type_id = $document_type_id;
        $this->xml = $xml;
        $this->customer_telephone = $customer_telephone;
        $this->url = $url;
    }


    public function handle()
    {
        try {
            $this->debugLog('=== INICIO WhatsappSendDocumentProccess ===', [
                'document_id' => $this->document_id,
                'document_type_id' => $this->document_type_id,
                'customer_telephone' => $this->customer_telephone,
                'website_id' => $this->website_id,
                'url' => $this->url,
                'message_length' => strlen($this->message ?? ''),
            ]);
            
            $this->debugLog('Buscando website...');
            $website = $this->findWebsite($this->website_id);
            
            if (!$website) {
                $this->debugLog('ERROR: Website no encontrado', ['website_id' => $this->website_id]);
                throw new Exception('Website no encontrado: ' . $this->website_id);
            }
            
            $this->debugLog('Website encontrado OK', ['website_id' => $website->id]);
            
            $this->debugLog('Configurando tenancy...');
            $tenancy = app(Environment::class);
            $tenancy->tenant($website);
            $this->debugLog('Tenancy configurado OK');
        } catch (Exception $e) {
            $this->debugLog('ERROR CRITICO al inicializar', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            Log::error('Error al inicializar el Job', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
        
        $this->debugLog('Obteniendo configuración...');
        $configuration = Configuration::first();
        $this->debugLog('Configuración obtenida', [
            'whatsapp_client' => $configuration->whatsapp_client ?? 'N/A'
        ]);
        
        try {
            $this->debugLog('Iniciando proceso principal...');
            $message = $this->message;
            $url1 = "http://" . $this->url;
            ///si el ambito es local cambiar https por http
            if (env('APP_ENV') == 'local') {
                $url1 = str_replace("https", "http", $url1);
            }
            
            $this->debugLog('URL generada', ['url' => $url1, 'env' => env('APP_ENV')]);
            
            $external_id = "";
            $xml = $this->xml ?? false;
            $this->debugLog('Configuración', ['xml' => $xml, 'document_type' => $this->document_type_id]);
            
            if ($this->document_type_id == "01" || $this->document_type_id == "03") {
                $this->debugLog('Buscando documento tipo Factura/Boleta...');
                $document = Document::find($this->document_id);
                if (!$document) {
                    throw new Exception('Documento no encontrado: ' . $this->document_id);
                }
                $document_filename = $document->filename;
                $external_id = $document->external_id;

                $url1 = $url1 . "/print/document/" . $external_id . "/ticket";
                $this->debugLog('Documento Factura/Boleta encontrado', ['external_id' => $external_id, 'url' => $url1]);
            } else if ($this->document_type_id == "80") {
                $this->debugLog('Buscando nota de venta...');
                $document = SaleNote::find($this->document_id);
                if (!$document) {
                    throw new Exception('Nota de venta no encontrada: ' . $this->document_id);
                }
                $document_filename = $document->filename;
                $external_id = $document->external_id;
                $url1 = $url1 . "/sale-notes/print/" . $external_id . "/ticket";
                $this->debugLog('Nota de venta encontrada', ['external_id' => $external_id, 'url' => $url1]);
            } else if ($this->document_type_id == "09") {
                $this->debugLog('Buscando guía de remisión...');
                $document = Dispatch::find($this->document_id);
                if (!$document) {
                    throw new Exception('Guía de remisión no encontrada: ' . $this->document_id);
                }
                $company = Company::first();
                $company_name = $company->name;
                //si en $message existe la palabra "de undefined" reemplazalo con "de $company_name"
                $message = str_replace("de *undefined*", "de " . $company_name, $message);
                $document_filename = $document->filename;
                $external_id = $document->external_id;
                $url1 = $url1 . "/print/dispatch/" . $external_id . "/ticket";
                $this->debugLog('Guía de remisión encontrada', ['external_id' => $external_id, 'url' => $url1]);
            } else if ($this->document_type_id == "COT") {
                $this->debugLog('Buscando cotización...');
                $document = Quotation::find($this->document_id);
                if (!$document) {
                    throw new Exception('Cotización no encontrada: ' . $this->document_id);
                }
                $document_filename = $document->filename;
                $external_id = $document->external_id;
                $url1 = $url1 . "/quotations/print/" . $external_id . "/ticket";
                $this->debugLog('Cotización encontrada', ['external_id' => $external_id, 'url' => $url1]);
            }
            //"" 
            $company = Company::first();
            $api_extern_whatsapp_url = $company->api_extern_whatsapp_url;
            $api_extern_whatsapp_token = $company->api_extern_whatsapp_token;
            $api_extern_whatsapp_token2 = $company->api_extern_whatsapp_token_2;
            
            Log::info('API Externa WhatsApp URL: ' . ($api_extern_whatsapp_url ?? 'NO CONFIGURADO'));
            Log::info('Token configurado: ' . ($api_extern_whatsapp_token ? 'SI' : 'NO'));
            Log::info('Token2 configurado: ' . ($api_extern_whatsapp_token2 ? 'SI' : 'NO'));
            
            $message .= "\n\n *Número solo para envíos de documentos*";
            $document_establishment = null;
            if ($document->establishment_id) {
                $document_establishment = Establishment::find($document->establishment_id);
                $establishment_telephone = $document_establishment->telephone;
                if ($establishment_telephone) {
                    $message .= "\n\n *Cualquier consulta adicional comunicarse al teléfono:*\n\nwa.me/+51" . $establishment_telephone;
                }
            }
            if ($api_extern_whatsapp_url != null && $api_extern_whatsapp_token != null && $api_extern_whatsapp_token2 != null) {
                Log::info('Usando API Externa de WhatsApp');
                Log::info('URL API: ' . $api_extern_whatsapp_url);
                Log::info('Teléfono destino: +51' . $this->customer_telephone);
                Log::info('URL del archivo: ' . $url1);
                
                $client = new Client([
                    'verify' => false,
                    'stream' => false,
                    'headers' => [
                        'User-Agent' => 'Testing 1.0'
                    ]
                ]);

                try {
                    $response = $client->post($api_extern_whatsapp_url."/api/create-message", [
                        'json' => [
                            'appkey' => $api_extern_whatsapp_token,
                            'authkey' => $api_extern_whatsapp_token2,
                            'to' => "+51" . $this->customer_telephone,
                            'message' => $message,
                            'file' => $url1,
                        ]
                    ]);
                    
                    $responseBody = $response->getBody()->getContents();
                    Log::info('Respuesta API Externa: ' . $responseBody);
                    return $responseBody;
                } catch (\Exception $e) {
                    Log::error('Error en API Externa WhatsApp: ' . $e->getMessage());
                    Log::error('Línea: ' . $e->getLine());
                    Log::error('Trace: ' . $e->getTraceAsString());
                    
                    return [
                        "message" => $e->getMessage(),
                        "line" => $e->getLine(),
                    ];
                }
            } else {
                Log::info('Usando API Interna de WhatsApp (SDR Personal)');
                
                $sender = 'sdrimsac';
                if ($sender == 'tunegociofactvillacorpnet') {
                    $sender = 'sdrimsac';
                }

                if ($sender == "sdrimsac") {
                    if ($configuration->whatsapp_client) {
                        $subdomain = explode(".", parse_url($url1, PHP_URL_HOST))[0];
                        $sender = $subdomain;
                        $url = "https://" . $subdomain . ".sdrpersonal.shop" . '/api/send-medias';
                        Log::info('Usando URL cliente: ' . $url);
                    } else {
                        $web_whatsapp = config('app.web_whatsapp');
                        $url = "https://" . $web_whatsapp . '/api/send-medias';
                        Log::info('Usando URL configuración: ' . $url);
                    }
                } else {
                    $url = config('app.whatsapp_url') . '/api/send-medias';
                    Log::info('Usando URL alternativa: ' . $url);
                }
                // $url = 'http://localhost:3800/api/send-media';
                Log::info('url: ' . $url);
                Log::info('Sender: ' . $sender);
                
                $content_file = null;

                if (!$xml) {
                    Log::info('Obteniendo contenido del PDF desde: ' . $url1);
                    try {
                        $content_file = file_get_contents($url1);
                        Log::info('PDF obtenido correctamente, tamaño: ' . strlen($content_file) . ' bytes');
                    } catch (\Exception $e) {
                        Log::error('Error al obtener PDF: ' . $e->getMessage());
                        throw $e;
                    }
                    // $content_file = ($this->document_type_id == "80")  ? file_get_contents(Storage::disk('tenant')->path("sale_note" . DIRECTORY_SEPARATOR . $document_filename . ".pdf")) :   file_get_contents(Storage::disk('tenant')->path("pdf" . DIRECTORY_SEPARATOR . $document_filename . ".pdf"));
                } else {
                    Log::info('Obteniendo contenido del XML: ' . $document_filename . '.xml');
                    try {
                        $content_file = file_get_contents(Storage::disk('tenant')->path("signed" . DIRECTORY_SEPARATOR . $document_filename . ".xml"));
                        Log::info('XML obtenido correctamente, tamaño: ' . strlen($content_file) . ' bytes');
                    } catch (\Exception $e) {
                        Log::error('Error al obtener XML: ' . $e->getMessage());
                        throw $e;
                    }
                }
                $client = new Client([
                    'verify' => false,
                    'stream' => false,
                    'headers' => [
                        'User-Agent' => 'Testing 1.0'
                    ]
                ]);
                
                Log::info('Preparando envío multipart a WhatsApp');
                Log::info('Teléfono: 51' . $this->customer_telephone);
                Log::info('Filename: ' . $document_filename . ($xml ? ".xml" : ".pdf"));
                
                try {
                    $response = $client->post($url, [
                        'multipart' => [
                            [
                                'name'     => 'number',
                                'contents' => "51" . $this->customer_telephone
                            ],
                            [
                                'name'     => 'caption',
                                'contents' => $message
                            ],
                            [
                                'name'     => 'sender',
                                'contents' => $sender ?? 'sdrimsac'
                            ],
                            [
                                'name'     => 'file',
                                'contents' => $content_file,
                                'filename' => $document_filename . ($xml ? ".xml" : ".pdf")
                            ],

                        ]
                    ]);

                    $responseBody = $response->getBody()->getContents();
                    Log::info('Respuesta de WhatsApp API: ' . $responseBody);
                    Log::info('=== FIN WhatsappSendDocumentProccess - EXITOSO ===');
                    return $responseBody;
                } catch (\Exception $e) {
                    Log::error('Error al enviar mensaje WhatsApp: ' . $e->getMessage());
                    Log::error('Línea: ' . $e->getLine());
                    Log::error('Trace: ' . $e->getTraceAsString());
                    Log::info('=== FIN WhatsappSendDocumentProccess - ERROR ===');

                    return [
                        "message" => $e->getMessage(),
                        "line" => $e->getLine(),
                    ];
                }
            }
        } catch (Exception $e) {
            Log::error('Error general en WhatsappSendDocumentProccess: ' . $e->getMessage());
            Log::error('Línea: ' . $e->getLine());
            Log::error('Trace: ' . $e->getTraceAsString());
            Log::info('=== FIN WhatsappSendDocumentProccess - EXCEPTION ===');
        }
        // (new WhatsappController)->sendMessageAll($this->message);
    }

    /**
     * The job failed to process.
     *
     * @param Exception $exception
     *
     * @return void
     */
    public function failed(Exception $exception)
    {
        Log::error('=== JOB FAILED - WhatsappSendDocumentProccess ===');
        Log::error('Error: ' . $exception->getMessage());
        Log::error('Línea: ' . $exception->getLine());
        Log::error('Archivo: ' . $exception->getFile());
        Log::error('Trace: ' . $exception->getTraceAsString());
        Log::error('Document ID: ' . $this->document_id);
        Log::error('Document Type: ' . $this->document_type_id);
        Log::error('Customer Telephone: ' . $this->customer_telephone);
    }
}
