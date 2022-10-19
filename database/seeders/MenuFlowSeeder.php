<?php

namespace Database\Seeders;

use App\Models\Setting\Globals\Menu;
use Illuminate\Database\Seeder;

class MenuFlowSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // // Example
            // [
            //     'module'   => 'example',
            //     'submenu'=> [
            //         [
            //             'module'   => 'example_crud',
            //         ],
            //     ]
            // ],
            // Work Manage
            [
                'module'   => 'work-manage',
                'submenu'=> [
                    [
                        'module'   => 'work-manage.work-req',
                    ],
                    [
                        'module'   => 'work-manage.work-order',
                    ],
                ]
            ],
        ];

        // $this->command->getOutput()->progressStart($this->countActions($data));
        $this->generate($data);
        // $this->command->getOutput()->progressFinish();
    }

    public function generate($data)
    {
        ini_set("memory_limit", -1);
        $exists = [];
        $order = 1;
        foreach ($data as $row) {
            // $this->command->getOutput()->progressAdvance();
            $menu = Menu::firstOrNew(['module' => $row['module']]);
            $menu->order = $order;
            $menu->save();
            $exists[] = $menu->id;
            $order++;
            if (!empty($row['submenu'])) {
                foreach ($row['submenu'] as $val) {
                    // $this->command->getOutput()->progressAdvance();
                    $submenu = $menu->child()->firstOrNew(['module' => $val['module']]);
                    $submenu->order = $order;
                    $submenu->save();
                    $exists[] = $submenu->id;
                    $order++;
                }
            }
        }
        Menu::whereNotIn('id', $exists)->delete();
    }

    public function countActions($data)
    {
        $count = 0;
        foreach ($data as $row) {
            $count++;
            if (!empty($row['submenu'])) {
                $count += count($row['submenu']);
            }
        }
        return $count;
    }
}
