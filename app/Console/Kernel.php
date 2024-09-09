<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('tenancy:run tenant:run')->everyMinute();
         $schedule->command('tenancy:run delete:register-movements')->dailyAt('04:00');
        //one time per day
        // $schedule->command('delete:register-movements')->daily();
        $schedule->command('tenancy:run tenant:run')->everyMinute();

        //delete:register-movements
        //correr cada media noche
        // $schedule->command('delete:register-movements')->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
