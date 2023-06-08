<?php

namespace App\Console\Commands;

use GuzzleHttp\Client as ClientGuzzleHttp;
use Illuminate\Console\Command;
use App\Models\Tenant\{
    Configuration,
    Summary,
    Company,
    User
};
use Auth;
use Illuminate\Support\Facades\Log;

class SummaryQueryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summary:query';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatic query of summaries';

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

        Auth::login(User::firstOrFail());

        if (Configuration::firstOrFail()->cron) {
            // $hostname = Website::query()
            //     ->where('uuid', app(\Hyn\Tenancy\Environment::class)->tenant()->uuid)
            //     ->first()
            //     ->hostnames
            //     ->first();
            $hostname=config('tenant.app_url_base');
            $summaries = Summary::query()
                ->where([
                    'soap_type_id' => Company::firstOrFail()->active()->soap_type_id,
                    'summary_status_type_id' => '1',
                    'state_type_id' => '03',
                ])
                ->get();
            $curl = curl_init();
            foreach ($summaries as $summary) {

                /* curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://{$hostname}".'/api/summaries/status',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                    "external_id": "'.$summary->external_id.'",
                    "ticket": "'.$summary->ticket.'"
                  }
                  ',
                    CURLOPT_HTTPHEADER => array(
                      'Content-Type: application/json',
                      'Authorization: Bearer '.auth()->user()->api_token
                    ),
                  ));

                $response = curl_exec($curl);
                 $res = json_decode($response, true); */
                 $constructor_params = [
                    'base_uri' => config('tenant.force_https') ? "https://{$hostname}" : "https://{$hostname}",
                    'verify' => false
                ];
                //dump($constructor_params);

                $clientGuzzleHttp = new ClientGuzzleHttp($constructor_params);

                $response = $clientGuzzleHttp->post('/api/summaries/status', [
                    'http_errors' => false,
                    'headers' => [
                        'Authorization' => 'Bearer '.auth()->user()->api_token,
                        'Accept' => 'application/json',
                    ],
                    'form_params' => [
                        'external_id' => $summary->external_id,
                        'ticket' => $summary->ticket
                    ]
                ]);

                
                
                $res = json_decode($response->getBody()->getContents(), true);
                
                $longitud = count($res);
               
                if($longitud == 1 ){
                    Log::error($res["message"]);
                    
                }
                if (!$res['success']) $this->info("{$summary->external_id} - {$summary->ticket} - {$res['message']}");
                

            }
        }
        else {
            $this->info('The crontab is disabled');
        }

        $this->info('The command is finished');
    }
}
