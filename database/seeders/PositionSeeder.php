<?php

namespace Database\Seeders;

use App\Models\Master\Org\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $position = [
            [ 
                "location_id" => 2,
                "name" => "Direktur utama",
                "code" => 1001
            ],
            [ 
                "location_id" => 3,
                "name" => "Direktur keuangan",
                "code" => 1002
            ],
            [ 
                "location_id" => 6,
                "name" => "Kepala divisi human capital",
                "code" => 1003
            ],
            [ 
                "location_id" => 5,
                "name" => "Kepala divisi pemeliharaan",
                "code" => 1004
            ],
            [ 
                "location_id" => 4,
                "name" => "Kepala divisi produksi",
                "code" => 1005
            ],
            [ 
                "location_id" => 10,
                "name" => "Kepala departemen administrasi SDM",
                "code" => 1006
            ],
            [ 
                "location_id" => 7,
                "name" => "Kepala departemen pemeliharaan alat berat",
                "code" => 1007
            ],
            [ 
                "location_id" => 8,
                "name" => "Kepala departemen pemeliharaan mesin",
                "code" => 1008
            ],
            [ 
                "location_id" => 9,
                "name" => "Kepala departemen training",
                "code" => 1009
            ]
        ];

        $this->generate($position);
    }

    public function generate($position)
    {
        ini_set("memory_limit", -1);

        foreach ($position as $val) {
            $position              = Position::firstOrNew(['code' => $val['code']]);
            $position->location_id = $val['location_id'];
            $position->name        = $val['name'];
            $position->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
