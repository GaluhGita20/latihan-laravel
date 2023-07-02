<?php

namespace Database\Seeders;

use App\Models\Master\Org\Struct;
use Illuminate\Database\Seeder;

class StructSeeder extends Seeder
{
    public function run()
    {
        $structs = [
            // type => 1:presdir, 2:direktur, 3:ia division, 4:it division
            // Level Root
            [ 
                "parent_id" => null,
                "level" => "root",
                "type" => null,
                "name" => "Pragma Informatika",
                "code" => 1001,
                "phone" => "08119050707",
                "email" => "zacky@pragmainf.id",
                "address" => "Komplek bumi panyawangan Jl. Garcinia I No. 34",
                "website" => "pragmainf.id",
                "city_id" => 3204
            ],
            [ 
                "parent_id" => 1,
                "level" => "bod",
                "type" => null,
                "name" => "Direktur utama",
                "code" => 2001,
                "phone" => "08119050707",
                "email" => null,
                "address" => "Komplek bumi panyawangan Jl. Garcinia I No. 34",
                "website" => null,
                "city_id" => null
            ],
            [ 
                "parent_id" => 2,
                "level" => "bod",
                "type" => null,
                "name" => "Direktur keuangan",
                "code" => 2002,
                "phone" => "08119050707",
                "email" => null,
                "address" => "Komplek bumi panyawangan Jl. Garcinia I No. 34",
                "website" => null,
                "city_id" => null
            ],
            [ 
                "parent_id" => 3,
                "level" => "division",
                "type" => null,
                "name" => "Divisi produksi",
                "code" => 4001,
                "phone" => "08119050707",
                "email" => null,
                "address" => "Komplek bumi panyawangan Jl. Garcinia I No. 34",
                "website" => null,
                "city_id" => null
            ],
            [ 
                "parent_id" => 3,
                "level" => "division",
                "type" => null,
                "name" => "Divisi pemeliharaan",
                "code" => 4002,
                "phone" => "08119050707",
                "email" => null,
                "address" => "Komplek bumi panyawangan Jl. Garcinia I No. 34",
                "website" => null,
                "city_id" => null
            ],
            [ 
                "parent_id" => 3,
                "level" => "division",
                "type" => null,
                "name" => "Divisi human capital",
                "code" => 4003,
                "phone" => "08119050707",
                "email" => null,
                "address" => "Komplek bumi panyawangan Jl. Garcinia I No. 34",
                "website" => null,
                "city_id" => null
            ],
            [ 
                "parent_id" => 5,
                "level" => "department",
                "type" => null,
                "name" => "Departemen pemeliharaan alat berat",
                "code" => 5001,
                "phone" => null,
                "email" => null,
                "address" => null,
                "website" => null,
                "city_id" => null
            ],
            [ 
                "parent_id" => 5,
                "level" => "department",
                "type" => null,
                "name" => "Departemen pemeliharaan mesin",
                "code" => 5002,
                "phone" => null,
                "email" => null,
                "address" => null,
                "website" => null,
                "city_id" => null
            ],
            [ 
                "parent_id" => 6,
                "level" => "department",
                "type" => null,
                "name" => "Departemen training",
                "code" => 5003,
                "phone" => null,
                "email" => null,
                "address" => null,
                "website" => null,
                "city_id" => null
            ],
            [ 
                "parent_id" => 6,
                "level" => "department",
                "type" => null,
                "name" => "Departemen administrasi SDM",
                "code" => 5004,
                "phone" => null,
                "email" => null,
                "address" => null,
                "website" => null,
                "city_id" => null
            ]
        ];

        // $this->command->getOutput()->progressStart($this->countActions($structs));
        $this->generate($structs);
        // $this->command->getOutput()->progressFinish();
    }

    public function generate($structs)
    {
        ini_set("memory_limit", -1);

        foreach ($structs as $val) {
            // $this->command->getOutput()->progressAdvance();
            $struct = Struct::firstOrNew(['code' => $val['code']]);
            $struct->parent_id   = $val['parent_id'];
            $struct->city_id   = $val['city_id'];
            $struct->level   = $val['level'];
            $struct->name    = $val['name'];
            $struct->type    = $val['type'] ?? null;
            $struct->phone   = $val['phone'] ?? null;
            $struct->address = $val['address'] ?? null;
            $struct->website = $val['website'] ?? null;
            $struct->email = $val['email'] ?? null;
            if (!empty($val['parent_code'])) {
                if ($parent = Struct::where('code', $val['parent_code'])->first()) {
                    $struct->parent_id = $parent->id;
                }
            }
            $struct->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
