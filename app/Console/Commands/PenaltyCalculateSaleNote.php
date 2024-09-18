<?php

namespace App\Console\Commands;

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

class PenaltyCalculateSaleNote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sale-note:register-penalty';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcula penalidades de las notas de venta con crédito pendiente';

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
        DB::statement('SET SESSION wait_timeout = 28800'); // 8 horas

        $sale_notes =  SaleNote::where('paid', 0)
            ->whereHas('creditPayments')
            ->get();

        foreach ($sale_notes as $sale_note) {
            $date_now =  Carbon::now()->startOfDay();
            $sale_note_credit = $sale_note->sale_note_credit;
            $penalty_by_day = $sale_note_credit->penalty_amount_by_day;
            $payments = Payment::where('sale_note_id', $sale_note->id)
                ->where('paid', 0)
                ->where('date_payment', '<=', $date_now);
            $penalty_amount = 0;
            foreach ($payments as $key => $payment) {
                $days = Carbon::parse($payment->date_payment)->diffInDays($date_now);
                $penalty = $days * $penalty_by_day;
                $penalty_amount += $penalty;
                $payment->penalty_amount = $penalty;
                $payment->save();
            }
        }

        $this->info('Penalidades calculadas');
    }
}
