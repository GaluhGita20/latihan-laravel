<?php

namespace Database\Seeders;

use App\Models\Master\Plant;
use Illuminate\Database\Seeder;

class PlantSeeder extends Seeder
{
    public function run()
    {
        $data = [  
            [ 
            "name" => "Plant 1",
            "description" => null
            ],
            [ 
            "name" => "Plant 2",
            "description" => null
            ],
            [ 
            "name" => "Plant 3",
            "description" => null
            ]
        ];

        foreach ($data as $val) {
            $record          = Plant::firstOrNew(['name' => $val['name']]);
            $record->description = $val['description'];
            $record->save();
        }
    }
}
