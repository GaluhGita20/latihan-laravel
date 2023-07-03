<?php

namespace Database\Seeders;

use App\Models\Master\System;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
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
            "plant_id" => 1,
            "name" => "System 1",
            "description" => null
            ],
            [ 
            "plant_id" => 1,
            "name" => "System 2",
            "description" => null
            ],
            [ 
            "plant_id" => 2,
            "name" => "System 3",
            "description" => null
            ],
            [ 
            "plant_id" => 2,
            "name" => "System 4",
            "description" => null
            ],
            [ 
            "plant_id" => 3,
            "name" => "System 5",
            "description" => null
            ],
            [ 
            "plant_id" => 3,
            "name" => "System 6",
            "description" => null
            ]
        ];

        foreach ($data as $val) {
            $record          = System::firstOrNew(['name' => $val['name']]);
            $record->plant_id = $val['plant_id'];
            $record->description = $val['description'];
            $record->save();
        }
    }
}
