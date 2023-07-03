<?php

namespace Database\Seeders;

use App\Models\Master\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
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
            "system_id" => 1,
            "name" => "Equipment 1",
            "description" => null
            ],
            [ 
            "system_id" => 1,
            "name" => "Equipment 2",
            "description" => null
            ],
            [ 
            "system_id" => 2,
            "name" => "Equipment 3",
            "description" => null
            ],
            [ 
            "system_id" => 2,
            "name" => "Equipment 4",
            "description" => null
            ],
            [ 
            "system_id" => 3,
            "name" => "Equipment 5",
            "description" => null
            ],
            [ 
            "system_id" => 3,
            "name" => "Equipment 6",
            "description" => null
            ],
            [ 
            "system_id" => 4,
            "name" => "Equipment 7",
            "description" => null
            ],
            [ 
            "system_id" => 4,
            "name" => "Equipment 8",
            "description" => null
            ]
        ];

        foreach ($data as $val) {
            $record          = Equipment::firstOrNew(['name' => $val['name']]);
            $record->system_id = $val['system_id'];
            $record->description = $val['description'];
            $record->save();
        }
    }
}
