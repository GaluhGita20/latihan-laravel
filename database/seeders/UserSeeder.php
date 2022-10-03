<?php

namespace Database\Seeders;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Administrator',
            ]
        );

        $user = User::firstOrCreate(
            ['id' => 1],
            [
                'name'     => 'Administrator',
                'username' => 'admin',
                'email'    => 'admin@email.com',
                'password' => bcrypt('password'),
            ]
        );
        $user->assignRole($role);

        // $this->command->info('----------------------------------');
        // $this->command->info('Email : ' . $user->email);
        // $this->command->info('Password : password');
        // $this->command->info('----------------------------------');
        // $this->command->info('For data dummy, run: php artisan db:seed --class=DummyAllSeeder');
        // $this->command->info('----------------------------------');
    }
}
