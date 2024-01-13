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


        /**
         * Only run in production environment
         */
        if (config('app.env') == 'production') {
            #--------------------------------------------------------------------
            # The following command will delete all records telescope created over 18 hours ago
            #--------------------------------------------------------------------
            $schedule->command('telescope:prune --hours=18')->name('telescope-prune')->withoutOverlapping()->evenInMaintenanceMode()->dailyAt('01:15');

            #--------------------------------------------------------------------
            # The following command will monitor backup health and clean up old/unhealthy backups.
            #--------------------------------------------------------------------
            $schedule->command('backup:monitor')->name('backup-moniter')->withoutOverlapping(500)->evenInMaintenanceMode()->dailyAt('03:00');
            $schedule->command('backup:clean')->name('backup-clean')->withoutOverlapping(500)->evenInMaintenanceMode()->dailyAt('05:00');

            #--------------------------------------------------------------------
            # The following command will back up a database daily.
            #--------------------------------------------------------------------
            $schedule->command('backup:database')->name('backup-database')->withoutOverlapping(500)->evenInMaintenanceMode()->dailyAt('12:01')->appendOutputTo(storage_path('logs/backup_database.log'));

            #--------------------------------------------------------------------
            # The following command will back up a filesystem on a monthly basis.
            #--------------------------------------------------------------------
            $schedule->command('backup:filesystem')->evenInMaintenanceMode()->monthly()->appendOutputTo(storage_path('logs/backup_filesystem.log'));

            #--------------------------------------------------------------------
            # The following command will run a full backup twice per month.
            #--------------------------------------------------------------------
            $schedule->command('backup:run')
                ->twiceMonthly(1, 16, '04:30')  // Run the task monthly on the 1st and 16th at 04:30
                ->name('backup-full')
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
                ->appendOutputTo(storage_path('logs/backup_full.log'));
        }
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
