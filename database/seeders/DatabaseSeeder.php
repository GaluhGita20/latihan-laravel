<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProvinceTableSeeder::class);
        $this->call(CityTableSeeder::class);
        // $this->call(DistrictTableSeeder::class);
        $this->call(MenuFlowSeeder::class);
        $this->call(StructSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);

        // Dummy
        $this->call(DummyAllSeeder::class);
        $this->call(MasterTipeMaintenanceSeeder::class);
    }
}
