<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DummyAllSeeder extends Seeder
{
    public function run()
    {
        $this->call(\Database\Seeders\Dummy\DummyStructSeeder::class);
        $this->call(\Database\Seeders\Dummy\DummyUserSeeder::class);
    }
}
