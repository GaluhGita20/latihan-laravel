<?php

namespace Database\Seeders;

use App\Models\Master\TipeAset;
use Illuminate\Database\Seeder;

class MasterTipeAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipeAssets = [
            // type => 1:presdir, 2:direktur, 3:ia division, 4:it division
            // Level Root
            [
                'name'          => 'rapli bct',
            ],
            [
                'name'          => 'rapli bch',
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
            // [
            //     'level'         => 'bod',
            //     'name'          => 'Direktur Utama',
            //     'phone'         => config('base.company.phone'),
            //     'address'       => config('base.company.address'),
            //     'parent_code'   => 1001,
            //     'code'          => 2001,
            //     'type'          => 'presdir',
            // ],
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
        $this->generate($tipeAssets);
        // $this->command->getOutput()->progressFinish();
    }
    public function generate($tipeAssets)
    {
        ini_set("memory_limit", -1);

        foreach ($tipeAssets as $val) {
            // $this->command->getOutput()->progressAdvance();
            $tipeAsset = TipeAset::firstOrNew(['name' => $val['name']]);
            // $tipeAsset->level   = $val['level'];
            $tipeAsset->name    = $val['name'];
            // $tipeAsset->type    = $val['type'] ?? null;
            // $tipeAsset->phone   = $val['phone'] ?? null;
            // $tipeAsset->address = $val['address'] ?? null;
            $tipeAsset->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
