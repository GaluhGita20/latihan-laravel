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
                'level'         => 'root',
                'name'          => config('base.company.name'),
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'code'          => 1001,
                'type'          => null,
            ],
            // // Level BOC
            // [
            //     'level'         => 'boc',
            //     'name'          => 'Dewan Komisaris',
            //     'phone'         => config('base.company.phone'),
            //     'address'       => config('base.company.address'),
            //     'parent_code'   => 1001,
            //     'code'          => 1101,
            //     'type'          => null,
            // ],
            // [
            //     'level'         => 'boc',
            //     'name'          => 'Komite Audit',
            //     'phone'         => config('base.company.phone'),
            //     'address'       => config('base.company.address'),
            //     'parent_code'   => 1001,
            //     'code'          => 1102,
            //     'type'          => null,
            // ],
            // // Level BOD
            [
                'level'         => 'bod',
                'name'          => 'Direktur Utama',
                'phone'         => config('base.company.phone'),
                'address'       => config('base.company.address'),
                'parent_code'   => 1001,
                'code'          => 2001,
                'type'          => 'presdir',
            ],
            // // Level Division
            // [
            //     'level'         => 'division',
            //     'name'          => 'Divisi Audit Internal',
            //     'phone'         => config('base.company.phone'),
            //     'address'       => config('base.company.address'),
            //     'parent_code'   => 2001,
            //     'code'          => 3001,
            //     'type'          => 'ia',
            // ],
            // [
            //     'level'         => 'division',
            //     'name'          => 'Divisi Teknologi Informasi',
            //     'phone'         => config('base.company.phone'),
            //     'address'       => config('base.company.address'),
            //     'parent_code'   => 2001,
            //     'code'          => 3002,
            //     'type'          => 'it',
            // ],
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
