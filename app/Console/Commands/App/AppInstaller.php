<?php

namespace App\Console\Commands\App;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Class InstallApp
 * @package App\Console\Commands\App
 */
class AppInstaller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->alert('Welcome to kodix application installer!');

        foreach ($this->getCommands() as $command => $confirm) {
            if ($this->confirm($confirm, true)) {
                $this->call($command);
            }
        }

        $this->call('app:init-seed');

        $this->createStorageLink();

        $this->finishInstallation();
        $this->info('Installation completed!');
    }

    /**
     * Return all install commands
     * @return array
     */
    protected function getCommands()
    {
        return [
            'key:generate' => 'Add app key?',
            'migrate:reset' => 'Reset current migrations?',
            'migrate' => 'Migrate new data?',
            'db:seed' => 'Seed database with new data?',
        ];
    }

    /**
     * Finishes installation
     */
    public function finishInstallation()
    {
        $this->call('cache:clear');
        $this->comment('Application cache was cleared to flush old sessions');
    }

    /**
     * Creating storage link
     */
    protected function createStorageLink()
    {
        if (!File::exists('public/storage')) {
            $this->call('storage:link');
        }
    }
}
