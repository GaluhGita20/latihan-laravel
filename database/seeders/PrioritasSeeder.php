<?php

namespace Database\Seeders;

use App\Models\Master\PrioritasAset;
use Illuminate\Database\Seeder;

class PrioritasSeeder extends Seeder
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
            "name" => "Prioritas 1",
            "description" => null
            ],
            [ 
            "name" => "Prioritas 2",
            "description" => null
            ],
            [ 
            "name" => "Prioritas 3",
            "description" => null
            ]
        ];

        foreach ($data as $val) {
            $record          = PrioritasAset::firstOrNew(['name' => $val['name']]);
            $record->description = $val['description'];
            $record->save();
        }
    }
}
