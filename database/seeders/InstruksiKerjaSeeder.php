<?php

namespace Database\Seeders;

use App\Models\Master\InstruksiKerja;
use Illuminate\Database\Seeder;

class InstruksiKerjaSeeder extends Seeder
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
            "name" => "Instruksi kerja plant 1",
            "description" => null
            ],
            [ 
            "tipe_aset" => "plant",
            "aset_id" => 1,
            "name" => "Instruksi kerja plant 2",
            "description" => null
            ],
            [ 
            "tipe_aset" => "system",
            "aset_id" => 1,
            "name" => "Instruksi kerja system 1",
            "description" => null
            ],
            [ 
            "tipe_aset" => "system",
            "aset_id" => 1,
            "name" => "Instruksi kerja system 2",
            "description" => null
            ],
            [ 
            "tipe_aset" => "system",
            "aset_id" => 2,
            "name" => "Instruksi kerja system 3",
            "description" => null
            ],
            [ 
            "tipe_aset" => "system",
            "aset_id" => 2,
            "name" => "Instruksi kerja system 4",
            "description" => null
            ],
            [ 
            "tipe_aset" => "plant",
            "aset_id" => 2,
            "name" => "Instruksi kerja plant 3",
            "description" => null
            ],
            [ 
            "tipe_aset" => "plant",
            "aset_id" => 2,
            "name" => "Instruksi kerja plant 4",
            "description" => null
            ]
        ];

        foreach ($data as $val) {
            $record          = InstruksiKerja::firstOrNew(['name' => $val['name']]);
            $record->tipe_aset = $val['tipe_aset'];
            $record->aset_id = $val['aset_id'];
            $record->description = $val['description'] ?? null;
            $record->save();
        }
    }
}
