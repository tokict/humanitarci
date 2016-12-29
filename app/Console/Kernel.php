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
        Commands\CheckPayments::class,
        Commands\CheckTransactions::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('CheckPayments')->sendOutputTo(env('PROJECT_DIR') . "/storage/logs/paymentChecker.log")
            ->cron('* * * * *');
        $schedule->command('CheckTransactions')->sendOutputTo(env('PROJECT_DIR') . "/storage/logs/paymentChecker.log")
            ->cron('0 * * * *');
    }
}
