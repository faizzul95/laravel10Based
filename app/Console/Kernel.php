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
        // the following command will delete all records telescope created over 16 hours ago
        $schedule->command('telescope:prune --hours=16')->runInBackground()->evenInMaintenanceMode()->dailyAt('01:30');

        $schedule->command('backup:monitor')->runInBackground()->evenInMaintenanceMode()->dailyAt('03:00');
        $schedule->command('backup:clean')->runInBackground()->evenInMaintenanceMode()->dailyAt('05:00');

        $schedule->command('billing:UpdateStatusInvoice')->withoutOverlapping()->evenInMaintenanceMode()->everyMinute();

        // // BACKUP ONLY DB (Daily)
        $schedule->command('backup:database')->runInBackground()->evenInMaintenanceMode()->dailyAt('12:01')->appendOutputTo(storage_path('logs/backup.log'));

        // // BACKUP ONLY FILES (Monthly)
        $schedule->command('backup:filesystem')->runInBackground()->evenInMaintenanceMode()->monthly()->appendOutputTo(storage_path('logs/backup.log'));

        // FULL BACKUP
        $schedule->command('backup:run')
            ->twiceMonthly(1, 16, '04:30')  // Run the task monthly on the 1st and 16th at 04:30
            ->runInBackground()
            ->evenInMaintenanceMode()
            ->before(function () {
                // Artisan::call('down');  // Put the application into maintenance mode
                Artisan::call('down', [
                    '--secret' => "ABC0189031045KEY", // use as a token to bypass maintenance
                    '--refresh' => 60,
                    '--retry' => 7200
                ]);
            })
            ->after(function () {
                Artisan::call('up'); // Bring the application out of maintenance mode
            })
            ->appendOutputTo(storage_path('logs/backup.log'));
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
