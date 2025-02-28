<?php

namespace App\Console\Commands;

use App\Http\Controllers\System\ClientController;
use App\Models\System\ClientPayment;
use Facades\App\Http\Controllers\DocumentController;
use Illuminate\Console\Command;
use App\Traits\CommandTrait;
use App\Models\Tenant\{
    Configuration,
    Document
};
use Illuminate\Http\Request;

class BlockClientHasNoPayment extends Command
{
    use CommandTrait;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'block:client-has-no-payment';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bloquea a los clientes que no tienen pagos';
    
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

        $isFirstDayOfMonth = now()->startOfMonth()->day === now()->day;
        if(!$isFirstDayOfMonth){
            $this->info('No es el primer día del mes');
            return;
        }else{
            $payments = ClientPayment::where('state', 0)
                ->whereMonth('date_of_payment', now()->subMonth()->month)
                ->get();
            foreach ($payments as $payment) {
                $client = $payment->client;
                $client_id = $client->id;
                (new ClientController)->lockedTenant(new Request(['id' => $client_id, 'locked_tenant' => 1]));
            }
        }
        

        $this->info('The command is finished');
    }
}
