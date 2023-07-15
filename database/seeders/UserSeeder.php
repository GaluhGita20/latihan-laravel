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

        $password = bcrypt('password');

        $USERS = [
            [ 
                "name" => "zacky",
                "username" => "zacky",
                "email" => "zacky@email.com",
                "password" => $password,
                "position_id" => 4,
                "status" => "active",
                'role_ids'      => [2],
            ],
            [ 
                "name" => "malik",
                "username" => "malik",
                "email" => "malik@email.com",
                "password" => $password,
                "position_id" => 8,
                "status" => "active",
                'role_ids'      => [3],
            ]
        ];

        foreach ($USERS as $key => $value) {
            $record = User::firstOrNew(['username' => $value['username']]);
            $record->name           = $value['name'];
            $record->username       = $value['username'];
            $record->email          = $value['email'];
            $record->name           = $value['name'];
            $record->password       = $value['password'];
            $record->position_id    = $value['position_id'];
            $record->status         = $value['status'];
            $record->save();
            $record->roles()->sync($value['role_ids']);
        }
        // $this->command->info('----------------------------------');
        // $this->command->info('Email : ' . $user->email);
        // $this->command->info('Password : password');
        // $this->command->info('----------------------------------');
        // $this->command->info('For data dummy, run: php artisan db:seed --class=DummyAllSeeder');
        // $this->command->info('----------------------------------');
    }
}
