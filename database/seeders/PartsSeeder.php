<?php

namespace Database\Seeders;

use App\Models\Master\Parts;
use Illuminate\Database\Seeder;

class PartsSeeder extends Seeder
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
            "komponen_id" => 1,
            "name" => "Parts 1",
            "description" => null
            ],
            [ 
            "komponen_id" => 1,
            "name" => "Parts 2",
            "description" => null
            ],
            [ 
            "komponen_id" => 2,
            "name" => "Parts 3",
            "description" => null
            ],
            [ 
            "komponen_id" => 1,
            "name" => "Parts 4",
            "description" => null
            ],
        ];

        foreach ($data as $val) {
            $record          = Parts::firstOrNew(['name' => $val['name']]);
            $record->komponen_id = $val['komponen_id'];
            $record->description = $val['description'];
            $record->save();
        }
    }
}
