<?php

namespace App\Console\Commands;

use App\Models\Tenant\Document;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\RegisterMovement;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNotePayment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteUserMovements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:register-movements';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Borrar registros de usuarios de hace una semana';

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

    $oneWeekAgo = Carbon::now()->subWeek();

    RegisterMovement::where('created_at', '<', $oneWeekAgo)
        ->chunkById(1000, function ($movements) {
            DB::transaction(function () use ($movements) {
                foreach ($movements as $movement) {
                    $movement->delete();
                }
            });
        });
        $this->info('Movimientos de usuarios eliminados');
    }
}
