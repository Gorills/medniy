<?php

namespace App\Console;

use App\Console\Commands\App\AdminCreator;
use App\Console\Commands\App\ImportXML;
use App\Console\Commands\App\InitSeedRunner;
use App\Console\Commands\App\AppInstaller;
use App\Console\Commands\App\RolesCreate;
use App\Console\Commands\InputSettings;
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
        AppInstaller::class,
        InitSeedRunner::class,
        ImportXML::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:import')->hourly();
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
