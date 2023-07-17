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
                    "name" => "PT. Pragma Informatika",
                    "code" => 1001,
                    "phone" => "0811 9050 707",
                    "address" => "Komplek Bumi Panyawangan Jl. Garcinia I No. 34 Ds. Cimekar Kec. Cileunyi",
                    "province" => "JAWA BARAT",
                    "city" => "KAB. BANDUNG",
                    "website" => "https://pragmainf.id",
                    "email" => "zacky.pragma@gmail.com"
                ],

            // Level BOD
                [ 
                    "parent_id" => 1,
                    "level" => "bod",
                    "type" => null,
                    "name" => "Direktur Utama",
                    "code" => 2001,
                    "phone" => "0811 9050 707",
                    "address" => "Komplek Bumi Panyawangan Jl. Garcinia I No. 34 Ds. Cimekar Kec. Cileunyi",
                    "province" => "JAWA BARAT",
                    "city" => "KAB. BANDUNG",
                    "website" => null,
                    "email" => null
                ],
                [ 
                    "parent_id" => 1,
                    "level" => "bod",
                    "type" => null,
                    "name" => "Direktur",
                    "code" => 2002,
                    "phone" => "0811 9050 707",
                    "address" => "Komplek Bumi Panyawangan Jl. Garcinia I No. 34 Ds. Cimekar Kec. Cileunyi",
                    "province" => "JAWA BARAT",
                    "city" => "KAB. BANDUNG",
                    "website" => null,
                    "email" => null
                ],

                // Level Unit
                [ 
                    "parent_id" => null,
                    "level" => "unit",
                    "type" => null,
                    "name" => "Inkaba",
                    "code" => 4008,
                    "phone" => null,
                    "address" => null,
                    "province" => null,
                    "city" => null,
                    "website" => null,
                    "email" => null
                ],
                [ 
                    "parent_id" => null,
                    "level" => "unit",
                    "type" => null,
                    "name" => "Saripetojo Bandung",
                    "code" => 4009,
                    "phone" => null,
                    "address" => null,
                    "province" => null,
                    "city" => null,
                    "website" => null,
                    "email" => null
                ],
                [ 
                    "parent_id" => null,
                    "level" => "unit",
                    "type" => null,
                    "name" => "Saripetojo Sukabumi",
                    "code" => 4010,
                    "phone" => null,
                    "address" => null,
                    "province" => null,
                    "city" => null,
                    "website" => null,
                    "email" => null
                ],
                [ 
                    "parent_id" => null,
                    "level" => "unit",
                    "type" => null,
                    "name" => "Saripetojo Cirebon",
                    "code" => 4011,
                    "phone" => null,
                    "address" => null,
                    "province" => null,
                    "city" => null,
                    "website" => null,
                    "email" => null
                ],
                [ 
                    "parent_id" => null,
                    "level" => "unit",
                    "type" => null,
                    "name" => "BMC",
                    "code" => 4012,
                    "phone" => null,
                    "address" => null,
                    "province" => null,
                    "city" => null,
                    "website" => null,
                    "email" => null
                ],
                [ 
                    "parent_id" => null,
                    "level" => "unit",
                    "type" => null,
                    "name" => "AMDK",
                    "code" => 4013,
                    "phone" => null,
                    "address" => null,
                    "province" => null,
                    "city" => null,
                    "website" => null,
                    "email" => null
                ],

                // Level Divisi
                [ 
                    "parent_id" => 3,
                    "level" => "division",
                    "type" => null,
                    "name" => "Divisi Sales",
                    "code" => 4001,
                    "phone" => "0811 9050 707",
                    "address" => "Komplek Bumi Panyawangan Jl. Garcinia I No. 34 Ds. Cimekar Kec. Cileunyi",
                    "province" => "JAWA BARAT",
                    "city" => "KAB. BANDUNG",
                    "website" => null,
                    "email" => null
                ],

                // Level Departemen
                [ 
                    "parent_id" => 10,
                    "level" => "department",
                    "type" => null,
                    "name" => "Departemen sales 1",
                    "code" => 5001,
                    "phone" => null,
                    "address" => null,
                    "province" => null,
                    "city" => null,
                    "website" => null,
                    "email" => null
                ],
                [ 
                    "parent_id" => 10,
                    "level" => "department",
                    "type" => null,
                    "name" => "Departemen sales 2",
                    "code" => 5002,
                    "phone" => null,
                    "address" => null,
                    "province" => null,
                    "city" => null,
                    "website" => null,
                    "email" => null
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
            $struct->level   = $val['level'];
            $struct->parent_id = $val['parent_id'];
            $struct->name    = $val['name'];
            $struct->type    = $val['type'] ?? null;
            $struct->phone   = $val['phone'] ?? null;
            $struct->address = $val['address'] ?? null;
            $struct->city    = $val['city'] ?? null;
            $struct->province = $val['province'] ?? null;
            $struct->website = $val['website'] ?? null;
            $struct->email   = $val['email'] ?? null;
            $struct->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
