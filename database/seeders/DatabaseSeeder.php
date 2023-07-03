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
        $this->call(PositionSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(MasterAssetStatusSeeder::class);
        $this->call(MasterTipeAssetSeeder::class);
        $this->call(MasterTipeMaintenanceSeeder::class);
        $this->call(MasterBiayaLainSeeder::class);
        $this->call(MasterKondisiAsetSeeder::class);
        $this->call(MasterTeamSeeder::class);
        $this->call(SkillsetSeeder::class);
        $this->call(ItemPemeliharaanSeeder::class);

        // Struktur Aset
        $this->call(PlantSeeder::class);
        $this->call(SystemSeeder::class);
        $this->call(EquipmentSeeder::class);
        $this->call(SubUnitSeeder::class);
        $this->call(KomponenSeeder::class);
    }
}
