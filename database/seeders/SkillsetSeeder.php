<?php

namespace Database\Seeders;

use App\Models\Master\Skillset;
use Illuminate\Database\Seeder;

class SkillsetSeeder extends Seeder
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
                'name'          => 'Skillset 1',
                'description'   => null
                
            ],
            [
                'name'          => 'Skillset 2',
                'description'   => null
            ],
            [
                'name'          => 'Skillset 3',
                'description'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis volutpat, sapien a sagittis pellentesque, tellus sem cursus orci, id euismod risus justo sit amet nisl. Morbi nec tincidunt massa. Nullam tristique viverra massa non cursus. Integer eget massa ut elit maximus suscipit.'
            ],
            [
                'name'          => 'Skillset 4',
                'description'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis volutpat, sapien a sagittis pellentesque, tellus sem cursus orci, id euismod risus justo sit amet nisl. Morbi nec tincidunt massa. Nullam tristique viverra massa non cursus. Integer eget massa ut elit maximus suscipit. Mauris id bibendum est. Curabitur congue mauris nisl, non pellentesque mauris convallis id. Phasellus eget consequat nibh, a viverra erat. Morbi vel ipsum vel nisl volutpat facilisis ac ut neque. Aenean dapibus gravida sapien in tincidunt. In et metus lorem. Proin ut quam felis. Integer turpis felis, accumsan id erat eu, rhoncus porta ligula.'
            ],
        ];

        $this->generate($skillset);
    }

    public function generate($skillset)
    {
        ini_set("memory_limit", -1);

        foreach ($skillset as $val) {
            $skillset = Skillset::firstOrNew(['name' => $val['name']]);
            $skillset->name    = $val['name'];
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
