<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\EstablishmentNotificationNumber;
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
use Throwable;

class WhatsappSendMessageProccess implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobReportTrait;

    protected $website_id;
    protected $message;
    protected $number;
    protected $subdomain;
    protected $establishment_id;


    public function __construct($website_id, $message, $number, $subdomain = null, $establishment_id = null)
    {

        $this->website_id = $website_id;
        $this->message = $message;
        $this->number = $number;
        $this->subdomain = $subdomain;
        $this->establishment_id = $establishment_id;
    }


    public function handle()
    {
        $website = $this->findWebsite($this->website_id);

        $tenancy = app(Environment::class);
        $tenancy->tenant($website);
        $number = $this->number;
        $message = $this->message;
        $configuration = Configuration::first();
        $numbers = [];
        try {
            if ($number == null) {
                $configuration_establishments_numbers = $configuration->configuration_establishments_numbers;
                /* if ($configuration_establishments_numbers && $this->establishment_id) {
                    $numbers = EstablishmentNotificationNumber::whereIn('establishment_id', $this->establishment_id)->get()->transform(function ($row) {
                        return  (object)[
                            'number' => $row->getNumber(),
                        ];
                    });
                } */
                if ($configuration_establishments_numbers && $this->establishment_id) {
                    $numbers = EstablishmentNotificationNumber::whereIn('establishment_id', [$this->establishment_id])->get()
                        ->transform(function ($row) {
                            return  (object)[
                                'number' => $row->getNumber(),
                            ];
                        });
                } else {
                    $numbers = NumberActivity::all();
                }
            } else {
                $numbers[] = (object) [
                    'number' => $number,
                ];
            }
            $company = Company::first();
            $api_extern_whatsapp_url = $company->api_extern_whatsapp_url;
            $api_extern_whatsapp_token = $company->api_extern_whatsapp_token;
            $api_extern_whatsapp_token2 = $company->api_extern_whatsapp_token_2;

            if (!$number && $numbers == []) {
                Log::alert("No se ha configurado el número de whatsapp para enviar notificaciones");
                return;
            }
            /* $url = "https://sdrimsac.xyz/api/send-message"; */
            $url = "https://https://sdrpersonal.shop/api/send-messages";
            // Log::info("Enviando mensaje a whatsapp".$number." mensaje: ".$message);
            foreach ($numbers as $number) {
                if ($number->number) {
                    if ($api_extern_whatsapp_url != null && $api_extern_whatsapp_token != null && $api_extern_whatsapp_token2 != null) {
                        $client = new Client([
                            'verify' => false,
                            'stream' => false,
                            'headers' => [
                                'User-Agent' => 'Testing 1.0'
                            ]
                        ]);

                        try {
                            $response = $client->post($api_extern_whatsapp_url . "/api/create-message", [
                                'json' => [
                                    'appkey' => $api_extern_whatsapp_token,
                                    'authkey' => $api_extern_whatsapp_token2,
                                    'to' => "+51" . $number->number,
                                    'message' => $message,
                                ]
                            ]);
                            Log::info($response->getBody()->getContents());
                            return  $response->getBody()->getContents();
                        } catch (\Exception $e) {
                            Log::alert("Error al enviar mensaje a whatsapp: " . $e->getMessage());
                            return [
                                "message" => $e->getMessage(),
                                "line" => $e->getLine(),
                            ];
                        }
                    } else {
                        $sender = 'sdrimsac';
                        if ($this->subdomain != null && $configuration->whatsapp_client) {
                            $url = "https://" . $this->subdomain . ".sdrpersonal.shop/api/send-messages";
                            $sender = $this->subdomain;
                        } else {
                            $web_whatsapp = config('app.web_whatsapp');
                            $url = "https://" . $web_whatsapp . '/api/send-messages';
                        }
                        $response = Http::withoutVerifying()->post($url, [
                            // $response = Http::post($url, [
                            'number' => "51" . $number->number,
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
            }
        } catch (Exception $e) {
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
    /* public function failed(Exception $exception)
    {
        Log::error($exception->getMessage());
    } */
    public function failed(Throwable $exception)
    {
        Log::error("Error en WhatsappSendMessageProccess: " . $exception->getMessage());
    }
}
