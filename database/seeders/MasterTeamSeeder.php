<?php

namespace Database\Seeders;

use App\Models\Master\Team;
use Illuminate\Database\Seeder;

class MasterTeamSeeder extends Seeder
{
    public function run()
    {
        $team = [
            // type => 1:presdir, 2:direktur, 3:ia division, 4:it division
            // Level Root
            [
                'name'          => 'baoa',
            ],
            [
                'name'          => 'jaag',
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

        // $this->command->getOutput()->progressStart($this->countActions($biayaLain));
        $this->generate($team);
        // $this->command->getOutput()->progressFinish();
    }

    public function generate($team)
    {
        ini_set("memory_limit", -1);

        foreach ($team as $val) {
            // $this->command->getOutput()->progressAdvance();
            $team = Team::firstOrNew(['name' => $val['name']]);
           // $team->level   = $val['level'];
            $team->name    = $val['name'];
            $team->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
