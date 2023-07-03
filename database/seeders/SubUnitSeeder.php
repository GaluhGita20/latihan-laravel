<?php

namespace Database\Seeders;

use App\Models\Master\SubUnit;
use Illuminate\Database\Seeder;

class SubUnitSeeder extends Seeder
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
            "equipment_id" => 1,
            "name" => "Sub unit 1",
            "description" => null
            ],
            [ 
            "equipment_id" => 1,
            "name" => "Sub unit 2",
            "description" => null
            ],
            [ 
            "equipment_id" => 2,
            "name" => "Sub unit 3",
            "description" => null
            ],
            [ 
            "equipment_id" => 2,
            "name" => "Sub unit 4",
            "description" => null
            ],
            [ 
            "equipment_id" => 3,
            "name" => "Sub unit 5",
            "description" => null
            ],
            [ 
            "equipment_id" => 3,
            "name" => "Sub unit 6",
            "description" => null
            ]
        ];

        foreach ($data as $val) {
            $record          = SubUnit::firstOrNew(['name' => $val['name']]);
            $record->equipment_id = $val['equipment_id'];
            $record->description = $val['description'];
            $record->save();
        }
    }
}
