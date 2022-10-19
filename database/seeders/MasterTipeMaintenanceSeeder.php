<?php

namespace Database\Seeders;

use App\Models\Master\TipeMaintenance;
use Illuminate\Database\Seeder;

class MasterTipeMaintenanceSeeder extends Seeder
{
    public function run()
    {
        $tipeMaintenance = [
            [
                'name'          => 'Tipe Maintenance 1',
            ],
            [
                'name'          => 'Tipe Maintenance 2',
            ],
            [
                'name'          => 'Tipe Maintenance 3',
            ],
        ];

        $this->generate($tipeMaintenance);
    }

    public function generate($tipeMaintenance)
    {
        ini_set("memory_limit", -1);

        foreach ($tipeMaintenance as $val) {
            // $this->command->getOutput()->progressAdvance();
            $tipeMaintenance = TipeMaintenance::firstOrNew(['name' => $val['name']]);
            // $kondisiAset->level   = $val['level'];
            $tipeMaintenance->name    = $val['name'];
            $tipeMaintenance->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
