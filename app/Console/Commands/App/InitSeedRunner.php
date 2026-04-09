<?php

namespace App\Console\Commands\App;

use Illuminate\Console\Command;
use InitDbSeeder;
use App\Models\{
    Access\Role,
    System\Setting
};

/**
 * Class InitSeeder
 * @package App\Console\Commands\App
 */
class InitSeedRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeder to fill DB with initial data';

    /**
     * New admin credentials
     * @var array
     */
    protected $credentials;

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
        $this->createRoles();
        $this->createAdmin();
        $this->inputSettings();
        $this->seedInitData();
    }

    /**
     * Creating basic user roles
     */
    protected function createRoles()
    {
        try {
            $rolesAr = [
                [
                    'name' => 'admin',
                    'display_name' => 'Администратор'
                ],
                [
                    'name' => 'content',
                    'display_name' => 'Контент-менеджер'
                ],
            ];
            foreach ($rolesAr as $roleAr) {
                $role = new Role();
                $role->name = $roleAr['name'];
                $role->display_name = $roleAr['display_name'];
                $role->save();
            }
            $this->info('Roles have been added');
        } catch (\Exception $exception) {
            $this->info($exception->getMessage());
        }
    }

    /**
     * Creating admin
     */
    protected function createAdmin()
    {
        $this->call('app:admin-create');
    }

    /**
     * Setting up settings values
     */
    protected function inputSettings()
    {
        foreach (Setting::all() as $setting) {
            $setting->value = $this->ask('"' . $setting->code . '" setting value');
            $setting->save();
        }
    }

    /**
     * Runs init seeding
     */
    protected function seedInitData()
    {
        (new InitDbSeeder())->setCommand($this)->run();
    }
}
