<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\NumberActivity;
use App\Traits\JobReportTrait;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Hyn\Tenancy\Environment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappSendMessageProccess implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobReportTrait;

    protected $website_id;
    protected $message;
    protected $number;
    protected $subdomain;


    public function __construct($website_id, $message, $number,$subdomain = null)
    {

        $this->website_id = $website_id;
        $this->message = $message;
        $this->number = $number;
        $this->subdomain = $subdomain;
    }


    public function handle()
    {
        $website = $this->findWebsite($this->website_id);
        
        $tenancy = app(Environment::class);
        $tenancy->tenant($website);
        $number = $this->number;
        $message = $this->message;
        $configuration = Configuration::first();
        
        try{
            if ($number == null) {
                $number = $configuration->number_activity;
            }
            $company = Company::first();
            $api_extern_whatsapp_url = $company->api_extern_whatsapp_url;
            $api_extern_whatsapp_token = $company->api_extern_whatsapp_token;
            $api_extern_whatsapp_token2 = $company->api_extern_whatsapp_token_2;
    
            if (!$number) {
                Log::alert("No se ha configurado el número de whatsapp para enviar notificaciones");
                return;
            }
            $url = "https://sdrpersonal.shop/api/send-message";
            // Log::info("Enviando mensaje a whatsapp".$number." mensaje: ".$message);
            if ($api_extern_whatsapp_url != null && $api_extern_whatsapp_token != null && $api_extern_whatsapp_token2 != null) {
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
                            'to' => "+51" . $number,
                            'message' => $message,
                        ]
                    ]);
                    return  $response->getBody()->getContents();
                } catch (\Exception $e) {
                    return [
                        "message" => $e->getMessage(),
                        "line" => $e->getLine(),
                    ];
                }
            }else{
                $sender = 'sdrimsac';
            if($this->subdomain != null && $configuration->whatsapp_client){
                $url = "https://".$this->subdomain.".sdrpersonal.shop/api/send-message";
                $sender = $this->subdomain;
            }else{
                $web_whatsapp = config('app.web_whatsapp');
                $url = "https://" . $web_whatsapp . '/api/send-message';
            }
                $response = Http::post($url, [
                    'number' => "51" . $number,
                    'sender' => $sender,
                    'message' => $message,
                ]);
    
                $status = $response->status();
                $body = $response->body();
                return [
                    "success" => $status == 200,
                    "message" => $body
    
    
                ];
            }
        }
        catch(Exception $e){
            Log::error($e->getMessage());
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
        

        
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
        Log::error($exception->getMessage());
    }
}
