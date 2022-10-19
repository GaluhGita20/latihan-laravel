<?php

namespace Database\Seeders;

use App\Models\Master\KondisiAset;
use Illuminate\Database\Seeder;

class MasterKondisiAsetSeeder extends Seeder
{
    public function run()
    {
        $kondisiAset = [
            [
                'name'          => 'Kondisi Aset 1',
            ],
            [
                'name'          => 'Kondisi Aset 2',
            ],
            [
                'name'          => 'Kondisi Aset 3',
            ],
        ];

        $this->generate($kondisiAset);
    }

    public function generate($kondisiAset)
    {
        ini_set("memory_limit", -1);

        foreach ($kondisiAset as $val) {
            $kondisiAset = KondisiAset::firstOrNew(['name' => $val['name']]);
            $kondisiAset->name    = $val['name'];
            $kondisiAset->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
