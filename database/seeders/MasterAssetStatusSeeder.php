<?php

namespace Database\Seeders;

use App\Models\Master\StatusAset;
use Illuminate\Database\Seeder;

class MasterAssetStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assetstatus = [
            [
                'name'          => 'Status Aset 1',
            ],
            [
                'name'          => 'Status Aset 2',
            ],
            [
                'name'          => 'Status Aset 3',
            ],
        ];

        $this->generate($assetstatus);
    }

    public function generate($assetstatus)
    {
        ini_set("memory_limit", -1);

        foreach ($assetstatus as $val) {
            $assetstatus = StatusAset::firstOrNew(['name' => $val['name']]);
            $assetstatus->name    = $val['name'];
            $assetstatus->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
