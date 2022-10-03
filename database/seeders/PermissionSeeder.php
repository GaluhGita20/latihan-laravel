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

            /** Example **/
            // [
            //     'name'           => 'setting.reportex',
            //     'action'         => ['view', 'create', 'edit', 'delete', 'approve'],
            // ],
        ];

        // $this->command->getOutput()->progressStart($this->countActions($permissions));
        $this->generate($permissions);
        // $this->command->getOutput()->progressFinish();
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
