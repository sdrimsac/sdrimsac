<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\Events\MessageEvent;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Dispatch;
use App\Models\Tenant\Document;
use App\Traits\JobReportTrait;
use Exception;
use Hyn\Tenancy\Environment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\ApiPeruDev\Http\Controllers\ServiceDispatchController;

class DispatchSendSunatJobProccess implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;



    protected $external_id;

    public function __construct($external_id = null)
    {

        $this->external_id = $external_id;
    }

    public function handle()
    {
        $document = Dispatch::where('external_id', $this->external_id)->first();
        if (!$document) return;

        $controller = new ServiceDispatchController();

        $send_response = $controller->send($document->external_id);
        Log::info('Resultado de send(): ' . json_encode($send_response));

        if ($send_response['success']) {

            $updated_document = Dispatch::where('external_id', $this->external_id)->first();

            if (!$updated_document->external_id) {
                Log::warning('No se encontró el ticket después del envío.');
                return;
            }

            $response = $controller->statusTicket($updated_document->external_id);

            if (!$response['success']) {
                $response = $controller->statusTicket($updated_document->external_id);
            }

            Log::info('Respuesta de SUNAT (statusTicket): ' . json_encode($response));
        } else {
            Log::error('Error al enviar a SUNAT: ' . json_encode($send_response));
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
