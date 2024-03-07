<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\NumberActivity;
use App\Traits\JobReportTrait;
use Carbon\Carbon;
use Exception;
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


    public function __construct($website_id, $message, $number)
    {
        $this->website_id = $website_id;
        $this->message = $message;
        $this->number = $number;
    }


    public function handle()
    {
        $website = $this->findWebsite($this->website_id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($website);
        $number = $this->number;
        $message = $this->message;
        if ($number == null) {
            $configuration = Configuration::first();
            $number = $configuration->number_activity;
        }

        if (!$number) {
            Log::alert("No se ha configurado el número de whatsapp para enviar notificaciones");
            return;
        }
        $url = "https://angelcross.xyz/api/send-message";



            $response = Http::post($url, [
                'number' => "51" . $number,
                'sender' => 'sdrimsac',
                'message' => $message,
            ]);

            $status = $response->status();
            $body = $response->body();
            return [
                "success" => $status == 200,
                "message" => $body


            ];

        
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
