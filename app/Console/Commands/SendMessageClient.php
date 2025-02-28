<?php

namespace App\Console\Commands;

use App\Models\System\ClientPayment;
use App\Models\System\MessageSendSchedule;
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
        $isCloseTo8Am = ($now->hour === 7 && $now->minute >= 50) || ($now->hour === 8 && $now->minute <= 30);
        $days_messages = MessageSendSchedule::where('active', 1)->get();
        $day = $now->day;


    


        $now = $now->startOfDay();
        if($isCloseTo8Am){
            ClientPayment::where('state', 0)->update(['send_whatsapp' => 0]);
        }
        $payments = ClientPayment::where('state', 0)->where('send_whatsapp', 0)->get();

        foreach ($days_messages as $day_message) {
            
            if ($day_message->send_day_at === $day) {
                if ($day_message->id == 3) {
                    foreach ($payments as $payment) {
                        $payment_date = Carbon::parse($payment->date_of_payment);
                        $diff_days = $now->diffInDays($payment_date);
                        if ($diff_days > 6) {
                            continue;
                        }
                        $payment->send_message_after_end();
                        sleep(rand(1, 3));
                    }
                } else {
                    foreach ($payments as $payment) {
                        $payment_date = Carbon::parse($payment->date_of_payment);
                        $diff_days = $now->diffInDays($payment_date);
                        if ($diff_days > 6) {
                            continue;
                        }

                        $payment->send_message_before_end();
                        sleep(rand(1, 3));
                    }
                }
            }
        }

    

        $this->info('Envío de mensajes a los clientes finalizados');
        return 0;
    }
}
