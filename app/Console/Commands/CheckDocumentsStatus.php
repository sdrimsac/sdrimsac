<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Report\Exports\ReportDocumentStatus;
use App\Http\Controllers\Tenant\WhatsappController;
use Hyn\Tenancy\Models\Website;
use Illuminate\Http\File;
use Illuminate\Http\Request;

class CheckDocumentsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:documentstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for validate in each database project if all documents are in status Accepted';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('The command was started');
        $fechaHoy = Carbon::now()->format('Y-m-d');
        $infoCompleta = [];

        $number = [995764963,  987828697];
        $message = 'Reporte de sistemas que no completaron el envio de documentos ';
        $file_name = 'TenantProcesosCaidos' . Carbon::now() . '.xlsx';
        $sender = 'sdrimsac';
        $envio = new WhatsappController;

        $primerDiaDelMes = Carbon::now()->startOfMonth()->format('Y-m-d');




        try {
            $results = DB::select("SHOW DATABASES;            ");


            foreach ($results as $result) {
                //$this->line($result->Database);
                if (strpos($result->Database, 'xyz') !== false) {



                    $resultsPorDB = DB::select('
                    SELECT documents.id as document_id, 
                    state_types.description statusDoc,
                    soap_types.description modo,
                    documents.series as document_series,
                    documents.number as document_number,
                    documents.date_of_due as document_date_of_due,
                    ( SELECT trade_name FROM ' . $result->Database . '.companies LIMIT 1 ) AS proyecto
                    FROM ' . $result->Database . '.`documents`
                    INNER JOIN state_types ON documents.state_type_id = state_types.id
                    INNER JOIN soap_types ON documents.soap_type_id = soap_types.id 
                     where soap_type_id = "02" and documents.state_type_id in  ("01","03") and documents.date_of_issue >= "' . $primerDiaDelMes . '"  and documents.date_of_issue < "' . $fechaHoy . '" 	ORDER BY 4,5 ');
                    $resultsPorDB = json_decode(json_encode($resultsPorDB), true);

                    $companies = DB::select('select soap_type_id from ' . $result->Database . '.companies  ');
                    $companies = json_decode(json_encode($companies), true);

                    if (count($resultsPorDB) > 0) {

                        if ($companies[0]['soap_type_id'] == '02') {
                            $this->info('El Sistema ' . $result->Database . ' tiene Documentos sin procesar ' . $fechaHoy);
                            $infoCompleta[] = $resultsPorDB;
                        }
                    }
                }
            }
            $tenant = Website::all();
            $tenant = json_decode(json_encode($tenant), true);
            foreach ($tenant as $key => $value) {
                $this->info('El Sistema ' . $value['uuid'] . ' tiene Documentos sin procesar ' . $fechaHoy);
                $resultsPorDB = DB::select('
                SELECT documents.id as document_id, 
                state_types.description statusDoc,
                soap_types.description modo,
                documents.series as document_series,
                documents.number as document_number,
                documents.date_of_due as document_date_of_due,
                ( SELECT trade_name FROM ' . $value['uuid'] . '.companies LIMIT 1 ) AS proyecto
                FROM ' . $value['uuid'] . '.`documents`
                INNER JOIN state_types ON documents.state_type_id = state_types.id
                INNER JOIN soap_types ON documents.soap_type_id = soap_types.id 
                 where soap_type_id = "02" and documents.state_type_id in  ("01","03") and documents.date_of_issue >= "' . $primerDiaDelMes . '"  and documents.date_of_issue < "' . $fechaHoy . '" 	ORDER BY 4,5 ');
                $resultsPorDB = json_decode(json_encode($resultsPorDB), true);

                $companies = DB::select('select soap_type_id from ' . $value['uuid'] . '.companies  ');
                $companies = json_decode(json_encode($companies), true);

                if (count($resultsPorDB) > 0) {

                    if ($companies[0]['soap_type_id'] == '02') {
                        $this->info('El Sistema ' . $value['uuid'] . ' tiene Documentos sin procesar ' . $fechaHoy);
                        $infoCompleta[] = $resultsPorDB;
                    }
                }
            }

            $documento = (new ReportDocumentStatus)
                ->infoCompleta($infoCompleta)
                ->download('ReporteDoc' . Carbon::now() . '.xlsx');




            $file = new File($documento->getFile());
            $request = new Request(['file' => $file, 'number' => $number, 'message' => $message, 'file_name' => $file_name, 'sender' => $sender]);

            $envio->sendReporteDocumentos($request);


            $this->info('The command is finished');
        } catch (\Throwable $th) {
            $this->error('The command was failed' . $th);
        }
        return 0;
    }
}
