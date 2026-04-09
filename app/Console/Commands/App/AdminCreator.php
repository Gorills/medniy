<?php

namespace App\Console\Commands\App;

use App\Models\Access\Role;
use App\Models\Access\User;

use DB;
use Illuminate\Console\Command;

/**
 * Class CreateAdmin
 * @package App\Console\Commands\App
 */
class AdminCreator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:admin-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates administrator for project.';

    protected $credentials;

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        try {
            DB::transaction(function () {
                $user = $this->getUser();

                if (!$user->hasRole('admin')) {
                    $user->attachRole($this->getRole());
                    $this->info(sprintf('User %s has been successfully created!', $user->email));
                } else {
                    $this->info('Old user used instead of new...');
                }

                $this->info('Admin creation completed!');
            });
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Returns existing user or creates new one.
     *
     * @return \App\Models\Access\User
     */
    protected function getUser(): User
    {
        $credentials = $this->getCredentials();
        $user = User::where('email', '=', $credentials['email'])->first();

        if ($user) {
            if ($this->confirm('User had already been created. Do you want to delete this user and create new one?', true)) {
                $user->delete();
                $user = factory(User::class)->create($credentials);
            }
        } else {
            $user = factory(User::class)->create($credentials);
        }

        return $user;
    }

    /**
     * @param array $credentials
     *
     * @return \App\Models\Access\User
     */
    protected function createUser(array $credentials): User
    {
        return User::create($credentials);
    }

    /**
     * Returns role with permission to manage.
     *
     * @return mixed
     */
    public function getRole()
    {
        $role = Role::with('perms')
            ->firstOrCreate(
                ['name' => 'admin'],
                ['display' => 'Администраторы']
            );

        return $role;
    }

    /**
     * Retrieves new user credentials.
     *
     * @return array
     */
    protected function getCredentials()
    {
        return $this->credentials ?: $this->credentials = [
            'name' => $this->ask('Name'),
            'email' => $this->ask('Email'),
            'password' => $this->secret('Password'),
        ];
    }
}
