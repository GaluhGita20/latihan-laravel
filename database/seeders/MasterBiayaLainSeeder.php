<?php

namespace Database\Seeders;

use App\Models\Master\BiayaLain;
use Illuminate\Database\Seeder;

class MasterBiayaLainSeeder extends Seeder
{
    public function run()
    {
        $biayaLain = [
            [
                'name'          => 'Biaya Lain 1',
            ],
            [
                'name'          => 'Biaya Lain 2',
            ],
            [
                'name'          => 'Biaya Lain 3',
            ],
        ];

        $this->generate($biayaLain);
    }

    public function generate($biayaLain)
    {
        ini_set("memory_limit", -1);

        foreach ($biayaLain as $val) {
            $biayaLain = BiayaLain::firstOrNew(['name' => $val['name']]);
            $biayaLain->name    = $val['name'];
            $biayaLain->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
