<?php

namespace Database\Seeders\Dummy;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Setting\Globals\Menu;
use App\Models\Master\Org\Struct;
use App\Models\Master\Org\Position;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = bcrypt('password');

        // Direktur Utama
        if ($struct = Struct::presdir()->first()) {
            $position = $struct->positions()->where('name', $struct->nanme)->first();
            if (!$position) {
                $position = $struct->positions()
                    ->create(
                        [
                            'name' => $struct->name,
                            'code' => (new Position)->getNewCode(),
                        ]
                    );
            }

            $email = 'dirut@email.com';
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => 'User ' . $position->name,
                    'username' => explode('@', $email)[0],
                    'password' => $password,
                    'position_id' => $position->id,
                ]
            );

            $role = Role::firstOrCreate(['name' => 'Direktur Utama']);
            $perms = Permission::where('name', 'NOT LIKE', '%master%')
                ->where('name', 'NOT LIKE', '%setting%')
                ->where('name', 'NOT LIKE', '%create%')
                ->where('name', 'NOT LIKE', '%edit%')
                ->where('name', 'NOT LIKE', '%delete%')
                ->pluck('id')
                ->toArray();
            $role->permissions()->sync($perms);
            $user->assignRole($role);
        }

        // Direktur
        foreach (Struct::director()->get() as $struct) {
            $position = $struct->positions()->where('name', $struct->nanme)->first();
            if (!$position) {
                $position = $struct->positions()
                    ->create(
                        [
                            'name' => $struct->name,
                            'code' => (new Position)->getNewCode(),
                        ]
                    );
            }

            $email = strtolower($position->name);
            $email = str_replace('direktur', 'dir', $email);
            $email = str_replace([' ', '/', ',', '-'], '.', $email);
            $email = $email . '@email.com';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => 'User ' . $position->name,
                    'username' => explode('@', $email)[0],
                    'password' => $password,
                    'position_id' => $position->id,
                ]
            );

            $role = Role::firstOrCreate(['name' => $position->name]);
            $perms = Permission::where('name', 'NOT LIKE', '%master%')
                ->where('name', 'NOT LIKE', '%setting%')
                ->where('name', 'NOT LIKE', '%create%')
                ->where('name', 'NOT LIKE', '%edit%')
                ->where('name', 'NOT LIKE', '%delete%')
                ->pluck('id')
                ->toArray();
            $role->permissions()->sync($perms);
            $user->assignRole($role);
        }

        // Kepala Divisi / Cabang
        $objects = Struct::whereIn('level', ['division', 'branch'])
            ->orderBy('level')
            ->orderBy('name')
            ->get();
        foreach ($objects as $struct) {
            $position = $struct->positions()->where('name', $struct->nanme)->first();
            if (!$position) {
                $position = $struct->positions()
                    ->create(
                        [
                            'name' => 'Kepala ' . $struct->name,
                            'code' => (new Position)->getNewCode(),
                        ]
                    );
            }

            $email = strtolower($position->name);
            $email = str_replace(['kepala divisi', 'kepala cabang', 'kepala kantor cabang'], ['kadiv', 'kacab', 'kacab'], $email);
            $email = str_replace([' ', '/', ',', '-'], '.', $email);
            $email = $email . '@email.com';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => 'User ' . $position->name,
                    'username' => explode('@', $email)[0],
                    'password' => $password,
                    'position_id' => $position->id,
                ]
            );

            $role = Role::firstOrCreate(['name' => 'Kepala ' . $struct->show_level]);
            $perms = Permission::whereIn(
                'name',
                []
            )
                ->pluck('id')
                ->toArray();
            $role->permissions()->sync($perms);
            $user->assignRole($role);
        }

        // Flow Approval
        foreach (Menu::doesntHave('child')->get() as $menu) {
            $role = Role::firstOrCreate(['name' => 'Direktur Utama']);
            $menu->flows()
                ->firstOrCreate(
                    ['role_id' => $role->id],
                    [
                        'type' => 1,
                        'order' => 1,
                    ]
                );
        }

        // Clear Perms Cache
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
