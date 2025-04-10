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
    //use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobReportTrait;
    use InteractsWithQueue, Queueable, SerializesModels;

    
    
    protected $external_id;

    public function __construct( $external_id = null)
    {
        
        $this->external_id = $external_id;
    }


    public function handle()
    {
        
        $document = Dispatch::find($this->external_id);
        if (!$document) return;

        $controller = new ServiceDispatchController();
        $ticket = $controller->send($document->external_id);
        /* dump($ticket); */

        if ($ticket['success']) {
            sleep(30);
            $response = $controller->statusTicket($document->external_id);

            if (!$response['success']) {
                sleep(30);
                $response = $controller->statusTicket($document->external_id);
            }
            Log::info('Response Mensaje exitoso: ' . json_encode($response));
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
