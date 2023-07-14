<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            /** Example **/
            // [
            //     'name'          => 'settings.reportex',
            //     'action'        => ['view', 'create', 'edit', 'delete', 'approve'],
            // ],

            /** DASHBOARD **/
            [
                'name'          => 'dashboard',
                'action'        => ['view'],
            ],

            /** EXAMPLE **/
            [
                'name'          => 'example.crud',
                'action'        => ['view', 'create', 'edit', 'delete', 'approve'],
            ],
            
            // PURCHASE
            [
                'name'          => 'purchasing.purchase-order',
                'action'        => ['view', 'create', 'edit', 'delete', 'approve'],
            ],
            [
                'name'          => 'purchasing.good-receipt',
                'action'        => ['view', 'create', 'edit', 'delete', 'approve'],
            ],

            /** MAINTENANCE PLAN **/
            [
                'name'          => 'rencana-pemeliharaan.jadwal',
                'action'        => ['view', 'create', 'edit', 'delete', 'approve', 'history'],
            ], // track-approve, history
            [
                'name'          => 'rencana-pemeliharaan.biaya',
                'action'        => ['view', 'edit', 'delete', 'detail', 'approve', 'history'],
            ], 
            // track-approve, history

            /** WORK MANAGEMENT **/
            [
                'name'          => 'work-manage.work-req',
                'action'        => ['view', 'create', 'edit', 'delete', 'approve'],
            ],
            [
                'name'          => 'work-manage.work-order',
                'action'        => ['view', 'create', 'edit', 'delete', 'approve'],
            ],

            /** ADMIN CONSOLE **/
            [
                'name'          => 'master',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],
            [
                'name'          => 'master',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],
            [
                'name'          => 'master.org',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],
            [
                'name'          => 'master.org.unit',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],
            [
                'name'          => 'master.org.bagian',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],
            [
                'name'          => 'master.org.subbagian',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],
            [
                'name'          => 'master.example',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],
            [
                'name'          => 'master.geo',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],
            [
                'name'          => 'master.geo.province',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],
            [
                'name'          => 'master.geo.city',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],
            [
                'name'          => 'master.geo.district',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],
            [
                'name'          => 'setting',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],

            /* Work Management */
            [
                'name'          => 'work_order',
                'action'        => ['view', 'create', 'edit', 'delete'],
            ],

            /** Example **/
            // [
            //     'name'           => 'setting.reportex',
            //     'action'         => ['view', 'create', 'edit', 'delete', 'approve'],
            // ],
        ];

        // $this->command->getOutput()->progressStart($this->countActions($permissions));
        $this->generate($permissions);
        
        $ROLES = [
            [
                'name'  => 'Administrator',
                'PERMISSIONS'   => [
                    'dashboard'                 => ['view'],
                    'master'                    => ['view', 'create', 'edit', 'delete'],
                    'setting'                   => ['view', 'create', 'edit', 'delete'],
                ],
            ],
            [
                'name'  => 'Manajer',
                'PERMISSIONS'   => [
                    
                ],
             ],
             [
                 'name'  => 'Officer',
                'PERMISSIONS'   => [

                ],
                
            ],
        ];
        foreach ($ROLES as $role) {
            $record = Role::firstOrNew(['name' => $role['name']]);
            $record->name = $role['name'];
            $record->save();
            $perms = [];
            foreach ($role['PERMISSIONS'] as $module => $actions) {
                foreach ($actions as $action) {
                    $perms[] = $module . '.' . $action;
                }
            }
            $perm_ids = Permission::whereIn('name', $perms)->pluck('id');
            // dd($perm_ids);
            $record->syncPermissions($perm_ids);
        }
    }

    public function generate($permissions)
    {
        // Role
        $admin = Role::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Administrator',
            ]
        );

        $perms_ids = [];
        foreach ($permissions as $row) {
            foreach ($row['action'] as $key => $val) {
                // $this->command->getOutput()->progressAdvance();

                $name = $row['name'] . '.' . trim($val);
                $perms = Permission::firstOrCreate(compact('name'));
                $perms_ids[] = $perms->id;

                if (!$admin->hasPermissionTo($perms->name)) {
                    $admin->givePermissionTo($perms);
                }
            }
        }

        Permission::whereNotIn('id', $perms_ids)->delete();

        // Clear Perms Cache
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function countActions($data)
    {
        $count = 0;
        foreach ($data as $row) {
            $count += count($row['action']);
        }

        return $count;
    }
}
