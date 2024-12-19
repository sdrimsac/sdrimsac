<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\Events\MessageEvent;
use App\Http\Controllers\Tenant\DownloadFilesController;
use App\Models\Tenant\Cash;
use App\Traits\JobReportTrait;
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

class DownloadFilesProccess implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobReportTrait;

    protected $types;
    protected $month;
    protected $website_id;



    public function __construct($website_id, $types, $month)
    {
        $this->website_id = $website_id;
        $this->types = $types;
        $this->month = $month;
    
    }


    public function handle()
    {
        $website = $this->findWebsite($this->website_id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($website);
        try {
            $newRequest = new Request();
            $newRequest->merge([
                'month' => $this->month,
                'types' => $this->types,
                'is_job' => true
            ]);
            (new DownloadFilesController())->downloadZip($newRequest);
            

        } catch (Exception $e) {
            $message = $e->getMessage();
            $message .= " - " . $e->getLine();
            $message .= " - " . $e->getFile();
            Log::error($message);
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
