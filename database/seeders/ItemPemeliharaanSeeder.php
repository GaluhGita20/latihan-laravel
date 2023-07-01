<?php

namespace Database\Seeders;

use App\Models\Master\ItemPemeliharaan;
use Illuminate\Database\Seeder;

class ItemPemeliharaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skillset = [
            [
                'name'          => 'Item Pemeliharaan 1',
                'description'   => null,
                'tipe_pemeliharaan_id' => 1
            ],
            [
                'name'          => 'Item Pemeliharaan 2',
                'description'   => null,
                'tipe_pemeliharaan_id' => 1
            ],
            [
                'name'          => 'Item Pemeliharaan 3',
                'description'   => null,
                'tipe_pemeliharaan_id' => 2
            ],
            [
                'name'          => 'Item Pemeliharaan 4',
                'description'   => null,
                'tipe_pemeliharaan_id' => 2
            ],
            [
                'name'          => 'Item Pemeliharaan 5',
                'description'   => null,
                'tipe_pemeliharaan_id' => 3
            ],
            [
                'name'          => 'Item Pemeliharaan 6',
                'description'   => null,
                'tipe_pemeliharaan_id' => 3
            ],
        ];

        $this->generate($skillset);
    }

    public function generate($skillset)
    {
        ini_set("memory_limit", -1);

        foreach ($skillset as $val) {
            $skillset = ItemPemeliharaan::firstOrNew(['name' => $val['name']]);
            $skillset->name    = $val['name'];
            $skillset->tipe_pemeliharaan_id    = $val['tipe_pemeliharaan_id'] ?? null;
            $skillset->description    = $val['description'] ?? null;
            $skillset->save();
        }
    }

    public function countActions($data)
    {
        $count = count($data);

        return $count;
    }
}
