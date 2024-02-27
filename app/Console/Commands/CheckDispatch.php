<?php

namespace App\Console\Commands;

use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Dispatch;
use App\Models\Tenant\Document;
use App\Models\Tenant\User;
use Hyn\Tenancy\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage;

class CheckDispatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:dispatches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar los tickets de las guias de remisión';

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
     * @return mixed
     */
    public function handle()
    {

        Auth::login(User::firstOrFail());

        if (Configuration::firstOrFail()->cron) {
            $hostname = Website::query()
                ->where('uuid', app(\Hyn\Tenancy\Environment::class)->tenant()->uuid)
                ->first()
                ->hostnames
                ->first();
            // $hostname=config('tenant.app_url_base');
            $documents = Dispatch::query()
                ->select('external_id')
                ->where([
                    'soap_type_id' => Company::firstOrFail()->active()->soap_type_id,
                    'state_type_id' => '03'
                ])
                ->whereDate('date_of_issue', '>=', now()->subDays(2))
                ->get();
            $curl = curl_init();
            foreach ($documents as $document) {

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://{$hostname->fqdn}" . '/dispatches/status_ticket',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{
                        "external_id": "' . $document->external_id . '"
                      }
                      ',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . auth()->user()->api_token
                    ),
                ));

                $response = curl_exec($curl);
                $res = json_decode($response, true);
                if (!$res['success']) $this->info("{$document->date_of_issue} - {$res['message']}");
            }
        } else {
            $this->info('The crontab is disabled');
        }
        $this->info('ha finalizado la actualización');
    }
}
