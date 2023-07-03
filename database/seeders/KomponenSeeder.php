<?php

namespace Database\Seeders;

use App\Models\Master\Komponen;
use Illuminate\Database\Seeder;

class KomponenSeeder extends Seeder
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
            "sub_unit_id" => 1,
            "name" => "Komponen 1",
            "description" => null
            ],
            [ 
            "sub_unit_id" => 1,
            "name" => "Komponen 2",
            "description" => null
            ],
            [ 
            "sub_unit_id" => 2,
            "name" => "Komponen 3",
            "description" => null
            ],
            [ 
            "sub_unit_id" => 2,
            "name" => "Komponen 4",
            "description" => null
            ],
            [ 
            "sub_unit_id" => 3,
            "name" => "Komponen 5",
            "description" => null
            ],
            [ 
            "sub_unit_id" => 3,
            "name" => "Komponen 6",
            "description" => null
            ]
        ];

        foreach ($data as $val) {
            $record          = Komponen::firstOrNew(['name' => $val['name']]);
            $record->sub_unit_id = $val['sub_unit_id'];
            $record->description = $val['description'];
            $record->save();
        }
    }
}
