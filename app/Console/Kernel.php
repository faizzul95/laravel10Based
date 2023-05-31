<?php

namespace App\Console;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('telescope:prune --hours=336')->daily(); // the following command will delete all records created over 14 days

        $schedule->command('backup:monitor')->dailyAt('03:00');
        $schedule->command('backup:clean')->dailyAt('05:00');

        $schedule->command('backup:run')
            ->dailyAt('1:00')
            // ->everyMinute()
            ->withoutOverlapping()
            ->before(function () {
                // Artisan::call('down');  // Put the application into maintenance mode
                Artisan::call('down', [
                    '--secret' => "00-super-admin-access-99", // use ase a token
                    '--refresh' => 60,
                    '--retry' => 7200
                ]);
            })
            ->after(function () {
                Artisan::call('up'); // Bring the application out of maintenance mode
            });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
