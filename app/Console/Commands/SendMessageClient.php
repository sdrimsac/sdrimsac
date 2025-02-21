<?php

namespace App\Console\Commands;

use App\Models\System\ClientPayment;
use App\Models\Tenant\Document;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\Payment;
use App\Models\Tenant\RegisterMovement;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNotePayment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendMessageClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:message-client';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía mensajes a los clientes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        ini_set('memory_limit', '-1');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now()->startOfDay();
        
        $before_payment = ClientPayment::where('state', 0)
            ->whereDate('date_of_payment', $now->copy()->addDay())
            ->get();
        
        $after_payment = ClientPayment::where('state', 0)
            ->whereDate('date_of_payment', $now->copy()->subDay())
            ->get();

        foreach ($before_payment as $payment) {
            $payment->send_message_before_end();
        }

        foreach ($after_payment as $payment) {
            $payment->send_message_after_end();
        }

        $this->info('Envío de mensajes a los clientes finalizados');
    }
}
