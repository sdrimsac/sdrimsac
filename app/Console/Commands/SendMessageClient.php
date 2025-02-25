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
        $now = Carbon::now();
        
        // Validar si es día 25 o último día del mes
        $isLastDay = $now->endOfMonth()->day === $now->day;
        $isDay25 = $now->day === 25;
        
        if (!$isDay25 && !$isLastDay) {
            $this->info('No es fecha de envío de mensajes');
            return 0;
        }
        
        $now = $now->startOfDay();
        $payments = ClientPayment::where('state', 0)->get();
        


        // Enviar mensajes según la fecha
        if ($isDay25) {
            foreach ($payments as $payment) {

                $payment->send_message_before_end();
                sleep(rand(1, 3));
            }
            $this->info('Línea 45 before_payment: ' . count($payments));
        }

        if ($isLastDay) {
            foreach ($payments as $payment) {
                $payment->send_message_after_end();
                sleep(rand(1, 3));
            }
            $this->info('Línea 51 after_payment: ' . count($payments));
        }

        $this->info('Envío de mensajes a los clientes finalizados');
        return 0;
    }
}
