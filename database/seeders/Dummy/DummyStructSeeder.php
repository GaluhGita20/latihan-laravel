<?php

namespace Database\Seeders\Dummy;

use App\Models\Master\Org\Struct;
use App\Models\Master\Org\Position;
use Illuminate\Database\Seeder;

class DummyStructSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $structs = [
            // Bod
            'bod' => [
                ['name'=>'Direktur Pemasaran'],
                ['name'=>'Direktur Umum'],
                ['name'=>'Direktur Kepatuhan'],
            ],
            // Division
            'division' => [
                ['name'=>'Divisi Manajemen Risiko', 'parent'=>'Direktur Kepatuhan'],
                ['name'=>'Divisi Trisuri', 'parent'=>'Direktur Kepatuhan'],
                ['name'=>'Divisi Humas', 'parent'=>'Direktur Umum'],
                ['name'=>'Divisi Pengembangan', 'parent'=>'Direktur Pemasaran'],
                ['name'=>'Divisi Perkreditan', 'parent'=>'Direktur Pemasaran'],
            ],
            // Branch
            'branch' => [
                [
                    'name'=>'Cabang Utama',
                    'phone'=>'(0274) 561614',
                    'address'=>'Jl. Tentara Pelajar No. 7 Yogyakarta',
                ],[
                    'name'=>'Cabang Sleman',
                    'phone'=>'(0274) 868866',
                    'address'=>'Jl. Magelang km 11 Tridadi, Sleman',
                ],[
                    'name'=>'Cabang Bantul',
                    'phone'=>'(0274) 367011',
                    'address'=>'Jl. Jendral Sudirman No. 2A Bantul',
                ],[
                    'name'=>'Cabang Wates',
                    'phone'=>'(0274) 773352',
                    'address'=>'Jl. Stasiun No.1 Wates',
                ],[
                    'name'=>'Cabang Wonosari',
                    'phone'=>'(0274) 391801',
                    'address'=>'Jl. Brigjend Katamso 4, Wonosari',
                ],
            ],
        ];

        if ($presdir = Struct::presdir()->first()) {
            foreach ($structs as $level => $values) {
                foreach ($values as $val) {
                    if (!empty($val['parent']) && Struct::where('name', $val['parent'])->exists()) {
                        $parent = Struct::where('name', $val['parent'])->first();
                    } else {
                        $parent = $presdir;
                    }

                    $parent->child()
                        ->firstOrCreate([
                            'level' => $level,
                            'name' => $val['name'],
                        ],[
                            'code' => (new Struct)->getNewCode($level),
                            'phone' => $val['phone'] ?? $presdir->phone,
                            'address' => $val['address'] ?? $presdir->address,
                        ]);
                }
            }
        }
    }
}
