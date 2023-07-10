<?php

namespace Database\Seeders;

use App\Models\Master\BiayaLain;
use Illuminate\Database\Seeder;

class KomponenBiayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [  
            [ 
            "name" => "Komponen Biaya 1",
            "description" => null
            ],
            [ 
            "name" => "Komponen Biaya 2",
            "description" => null
            ],
            [ 
            "name" => "Komponen Biaya 3",
            "description" => null
            ]
        ];

        foreach ($data as $val) {
            $record          = BiayaLain::firstOrNew(['name' => $val['name']]);
            $record->description = $val['description'];
            $record->save();
        }
    }
}
