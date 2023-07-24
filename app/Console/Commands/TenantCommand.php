<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Tenant\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class TenantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the scheduled tasks of the tenants';

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
        
        // Log::debug('Aqui se ejecuta tarea Progrmada '. Carbon::now()->format('H:i').':00');
       
        if (Schema::connection('tenant')->hasTable('tasks')) {
            // Si la tabla existe, continuar con el proceso
            foreach (Task::where('execution_time', Carbon::now()->format('H:i').':00')->get() as $task) {
                try {
                    Artisan::call($task->class);
                    $task->output = Artisan::output();
                    $task->save();
                } catch (\Exception $e) {
                    $task->output = $e->getMessage();
                    $task->save();
                }
            }
        } 
    }
}
