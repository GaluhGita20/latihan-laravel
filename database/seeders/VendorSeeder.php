<?php

namespace Database\Seeders;

use App\Models\Master\VendorAset;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
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
            "city_id" => 3601,
            "code" => "001.VENDOR",
            "name" => "Nama vendor 1",
            "alamat" => "Alamat vendor 1",
            "kodepos" => "12345",
            "telepon" => "28812039882",
            "email" => "vendor1@email.com",
            "pic" => "PIC Vendor 1",
            "website" => "www.vendor1.com"
            ],
            [ 
            "city_id" => 5103,
            "code" => "002.VENDOR",
            "name" => "Nama vendor 2",
            "alamat" => "Alamat vendor 2",
            "kodepos" => "22334",
            "telepon" => "1289081239",
            "email" => "vendor2@email.com",
            "pic" => "PIC Vendor 2",
            "website" => "www.vendor2.com"
            ]
        ];

        foreach ($data as $val) {
            $record          = VendorAset::firstOrNew(['code' => $val['code']]);
            $record->city_id = $val['city_id'];
            $record->name = $val['name'];
            $record->alamat = $val['alamat'];
            $record->kodepos = $val['kodepos'];
            $record->telepon = $val['telepon'];
            $record->email = $val['email'];
            $record->pic = $val['pic'];
            $record->website = $val['website'];
            $record->save();
        }
    }
}
