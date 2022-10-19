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
            [
                'name'          => 'Tipe Aset 1',
            ],
            [
                'name'          => 'Tipe Aset 2',
            ],
            [
                'name'          => 'Tipe Aset 3',
            ],
        ];

        $this->generate($tipeAssets);
    }
    public function generate($tipeAssets)
    {
        ini_set("memory_limit", -1);

        foreach ($tipeAssets as $val) {
            $tipeAsset = TipeAset::firstOrNew(['name' => $val['name']]);
            $tipeAsset->name    = $val['name'];
            $tipeAsset->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
