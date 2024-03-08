<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\Events\MessageEvent;
use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\NumberActivity;
use App\Traits\JobReportTrait;
use Carbon\Carbon;
use Error;
use Exception;
use GuzzleHttp\Psr7\Message;
use Hyn\Tenancy\Environment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WhatsappSendCashReportStockProccess implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobReportTrait;

    protected $cash_id;
    protected $website_id;
    protected $user_name;
    protected $fqdn;


    public function __construct($website_id, $cash_id, $user_name, $fqdn)
    {
        $this->cash_id = $cash_id;
        $this->website_id = $website_id;
        $this->user_name = $user_name;
        $this->fqdn = $fqdn;
    }


    public function handle()
    {
        $website = $this->findWebsite($this->website_id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($website);
        $cash = Cash::select(['id','user_id'])->where('id', $this->cash_id)->first();
        $user = $cash->user;
        $area_id = $user->area_id;
        $resource = "http://" . $this->fqdn . "/caja/report-product-warehouse-w?user_id=" . $cash->user_id . "&cash_id=" . $this->cash_id;
        $file = file_get_contents($resource);
        $file_name = $cash->id . "_" . "Stock_al_cerrar_caja_" . Carbon::now()->format("Y-m-d") . ".xlsx";
        Log::info("resource: " . $file_name);
        Log::info("resource: " . $resource);
        $directory = 'public' . DIRECTORY_SEPARATOR . 'stock_excel_cierre_caja';
        Storage::disk('tenant')->put($directory . DIRECTORY_SEPARATOR . $file_name, $file);
        $cash->stock_file = $file_name;
        $cash->save();
        event(new MessageEvent("Se ha generado el reporte de stock al cerrar caja", $area_id));

        return true;
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
        if ($exception instanceof Exception || $exception instanceof Error) {
            // Manejar la excepción o error aquí
            Log::error("Error en la tarea WhatsappSendCashReportStockProccess: " . $exception->getMessage());
        } else {
            // Si la excepción no es ni Exception ni Error, simplemente la lanzamos de nuevo
            throw $exception;
        }
    }
}
