<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting\Globals\MenuFlow;

class MenuFlowApprovalSeeder extends Seeder
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
                "menu_id" => 2,
                "role_id" => 2,
                "type" => 1,
                "order" => 1
                ],
                [ 
                "menu_id" => 3,
                "role_id" => 2,
                "type" => 1,
                "order" => 1
                ],
                [ 
                "menu_id" => 5,
                "role_id" => 2,
                "type" => 1,
                "order" => 1
                ],
                [ 
                "menu_id" => 6,
                "role_id" => 2,
                "type" => 1,
                "order" => 1
                ],
                [ 
                "menu_id" => 8,
                "role_id" => 2,
                "type" => 1,
                "order" => 1
                ]
        ];

        foreach ($data as $val) {
            $record = MenuFlow::firstOrNew([
                'menu_id' => $val['menu_id'],
                'role_id' => $val['role_id'],
                'type' => $val['type'],
                'order' => $val['order'],
            ]);
            $record->save();
        }
    }
}
