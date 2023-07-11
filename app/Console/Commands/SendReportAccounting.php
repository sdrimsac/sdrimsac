<?php

namespace App\Console\Commands;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Document;
use App\Models\Tenant\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Modules\Format\Http\Controllers\FormatController;

class SendReportAccounting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:report-accounting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar reportes contables';

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
        Auth::login(User::firstOrFail());
        if ($this->isFirstDayOfMonth(date('Y-m-d'))) {
            $range_date = $this->createStartAndEndofMonth();
            $documents = Document::whereBetween('date_of_issue', $range_date);
            $documents_not_ok = $documents->where(function ($q) {
                $q->where('state_type_id', '01')
                    ->orWhere('state_type_id', '03');
            })
                ->select('number', 'date_of_issue', 'state_type_id', 'series')
                ->get()
                ->transform(function ($row) {
                    return [
                        'Número' => $row->getNumberFullAttribute(),
                        'Fecha de emisión' => Carbon::parse($row->date_of_issue)->format('Y-m-d'),
                        'Estado' => $row->state_type->description,
                    ];
                });
            if (count($documents_not_ok) > 0) {
                $this->sendAlert($documents_not_ok);
            } else {
                $count_documents =  Document::whereBetween('date_of_issue', $range_date)->get()->count();
                if ($count_documents == 0) {
                    $this->isEmpty();
                } else {
                    $configuration = Configuration::first();
                    $number = $configuration->number_activity;
                    if (!$number) {
                        $this->notHasNumber();
                    } else {

                        $month = $range_date[0];
                        $month = Carbon::parse($month)->format('Y-m');
                        $hostname = config('tenant.app_url_base');
                        $file_name =  'ReporteContable' .  Carbon::now()->format("Y-m-d") . '.xlsx';
                        $resource = "http://$hostname/account/format/download?export=EXCEL&month=$month&type=sale";
                        $request = new Request(
                            [
                                'from_server' => true,
                                'sender' => 'sdrimsac',
                                'number' => $number,
                                'resource' => $resource,
                                'file_name' => 'ReporteContable' . Carbon::now()->format("Y-m-d") . '.xlsx',
                                'message' => 'Reporte contable del mes de ' . Carbon::parse($month)->format('m-Y')
                            ]
                        );

                        (new WhatsappController)->sendHistorial($request);

                        $file = (new FormatController)->download(
                            new Request(
                                [
                                    'export' => 'EXCEL',
                                    'month' => $month,
                                    'type' => 'sale'
                                ]
                            )
                        );
                        $file = new File($file->getFile());
                        $directory = 'public' . DIRECTORY_SEPARATOR . 'reportes';
                        Storage::disk('tenant')->put($directory . DIRECTORY_SEPARATOR . $file_name, $file->getContent());
                    }
                }
            }
        }
        return 0;
    }
    function getCompanyName()
    {
        $company = Company::first();
        $company_name = null;
        if ($company->trade_name) {
            $company_name = $company->trade_name;
        } else {
            $company_name = $company->name;
        }

        return $company_name;
    }
    function notHasNumber()
    {
        $company_name = $this->getCompanyName();
        $message = "CLIENTE $company_name\n";
        $message .= "No se ha configurado el número de celular para enviar el reporte contable";
        $this->sendMessageToSupport($message);
    }
    function isEmpty()
    {
        $company_name = $this->getCompanyName();
        $message = "CLIENTE $company_name\n";
        $message .= "No hay documentos emitidos en el mes pasado";
        $this->sendMessageToSupport($message);
    }
    function sendAlert($documents)
    {
        $company_name = $this->getCompanyName();
        $message = "DOCUMENTOS NO ACEPTADOS DE $company_name\n";
        foreach ($documents as $document) {
            $message .= $document['Número'] . " - " . $document['Fecha de emisión'] . " - " . $document['Estado'] . "\n";
        }
        $this->sendMessageToSupport($message);

        // (new WhatsappController)->sendMessage($message, '972053723');
    }

    function isFirstDayOfMonth($date)
    {
        return date('Y-m-01', strtotime($date)) == $date;
    }
    function createStartAndEndofMonth()
    {
        $month = date('m');
        $year = date('Y');
        $month = $month - 1;
        if ($month == 0) {
            $month = 12;
            $year = $year - 1;
        }
        $start = date('Y-m-d', strtotime("first day of $year-$month"));
        $end = date('Y-m-d', strtotime("last day of $year-$month"));
        return [$start, $end];
    }

    function sendMessageToSupport($message)
    {
        $numbers = [927383973, 995764963,  987828697];
        foreach ($numbers as $number) {
            sleep(1);
            (new WhatsappController)->sendMessage($message, $number);
        }
    }
}
