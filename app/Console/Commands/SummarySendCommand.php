<?php

namespace App\Console\Commands;

use GuzzleHttp\Client as ClientGuzzleHttp;
use Illuminate\Console\Command;
use App\Models\Tenant\{
    Configuration,
    Document,
    Company,
    User
};
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Log;

class SummarySendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summary:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatic send of summaries';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $this->info('The command was started');
        
        //Log::debug('Aqui se ejecuta');

        Auth::login(User::firstOrFail());

        if (Configuration::firstOrFail()->cron) {
            // $hostname = Website::query()
            //     ->where('uuid', app(\Hyn\Tenancy\Environment::class)->tenant()->uuid)
            //     ->first()
            //     ->hostnames
            //     ->first();
            $hostname=config('tenant.app_url_base');
            $documents = Document::query()
                ->select('date_of_issue')
                ->where([
                    'soap_type_id' => Company::firstOrFail()->active()->soap_type_id,
                    'state_type_id' => '01',
                    'group_id' => '02'
                ])
                ->groupBy('date_of_issue')
                ->get();
            $curl = curl_init();
            foreach ($documents as $document) {

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://{$hostname}".'/api/summaries',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                    "fecha_de_emision_de_documentos": "'.$document->date_of_issue.'",
                    "codigo_tipo_proceso": "1"
                  }
                  ',
                    CURLOPT_HTTPHEADER => array(
                      'Content-Type: application/json',
                      'Authorization: Bearer '.auth()->user()->api_token
                    ),
                  ));

                $response = curl_exec($curl);
                $res = json_decode($response, true);
                if (!$res['success']) $this->info("{$document->date_of_issue} - {$res['message']}");
            }
        }
        else {
            $this->info('The crontab is disabled');
        }

        $this->info('The command is finished');
    }
}
