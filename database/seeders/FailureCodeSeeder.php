<?php

namespace Database\Seeders;

use App\Models\Master\FailureCode;
use Illuminate\Database\Seeder;

class FailureCodeSeeder extends Seeder
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
            "tipe_aset" => "plant",
            "aset_id" => 1,
            "name" => "Failure code aset 1",
            "description" => null
            ],
            [ 
            "tipe_aset" => "plant",
            "aset_id" => 1,
            "name" => "Failure code aset 2",
            "description" => null
            ],
            [ 
            "tipe_aset" => "plant",
            "aset_id" => 2,
            "name" => "Failure code aset 3",
            "description" => null
            ],
            [ 
            "tipe_aset" => "plant",
            "aset_id" => 2,
            "name" => "Failure code aset 4",
            "description" => null
            ],
            [ 
            "tipe_aset" => "system",
            "aset_id" => 1,
            "name" => "Failure code system 1",
            "description" => null
            ],
            [ 
            "tipe_aset" => "system",
            "aset_id" => 1,
            "name" => "Failure code system 2",
            "description" => null
            ],
            [ 
            "tipe_aset" => "system",
            "aset_id" => 2,
            "name" => "Failure code system 3",
            "description" => null
            ],
            [ 
            "tipe_aset" => "system",
            "aset_id" => 2,
            "name" => "Failure code system 4",
            "description" => null
            ]
        ];

        foreach ($data as $val) {
            $record          = FailureCode::firstOrNew(['name' => $val['name']]);
            $record->tipe_aset = $val['tipe_aset'] ?? null;
            $record->aset_id = $val['aset_id'] ?? null;
            $record->description = $val['description'] ?? null;
            $record->save();
        }
    }
}
