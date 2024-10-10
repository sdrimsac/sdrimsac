<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;


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

class CashReportProccess implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobReportTrait;

    protected $cash_id;
    protected $website_id;
    protected $fqdn;


    public function __construct($website_id, $cash_id, $fqdn)
    {
        $this->cash_id = $cash_id;
        $this->website_id = $website_id;
        $this->fqdn = $fqdn;
    }


    public function handle()
    {
        $website = $this->findWebsite($this->website_id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($website);
        try {
            $resource = "http://" . $this->fqdn . "/caja/report-boxes/reports_resumen_type?cash_id=" . $this->cash_id;
            Log::info("resource: " . $resource);
            Http::get($resource);
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
