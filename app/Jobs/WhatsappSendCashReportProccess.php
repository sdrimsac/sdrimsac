<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
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
use Illuminate\Support\Facades\Log;

class WhatsappSendCashReportProccess implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobReportTrait;

    protected $cash_id;
    protected $website_id;
    protected $user_name;
    protected $fqdn;


    public function __construct($website_id, $cash_id, $user_name,$fqdn)
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
        $subdomain = explode(".", $this->fqdn)[0];
        try {
            $configuration = Configuration::first();
            $number_activity = $configuration->number_activity;
            $resource = "http://" . $this->fqdn . "/caja/report-boxes/reports_resumen_type?cash_id=" . $this->cash_id;
            Log::info("resource: " . $resource);
            $sender = 'sdrimsac';
            if($configuration->whatsapp_client){
                $sender = $subdomain;
            }
            $company = Company::first();
            $user =  Cash::find($this->cash_id)->user;
            $establishment = Establishment::find($user->establishment_id);
            $company_name = $company->name;
            $establishment_name = $establishment->description;
            $request = new Request(
                [
                    'from_server' => true,
                    'sender' => $sender,
                    'number' => $number_activity,
                    'resource' => $resource,
                    'file_name' => 'Reporte_Caja' . Carbon::now()->format("Y-m-d"),
                    'message' => "*".$company_name."*: Caja cerrada por " . $this->user_name." en ".$establishment_name,
                ]
            );
            if ($number_activity) {

                (new WhatsappController)->sendHistorial($request);
            }
            $numbers = NumberActivity::all();
            foreach ($numbers as $number) {
                $request['number'] = $number->number;
                (new WhatsappController)->sendHistorial($request);
            }
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
