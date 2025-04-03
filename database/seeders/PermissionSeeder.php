<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder {
    public function run(): void {
        // Daftar permission yang dibutuhkan
        $permissions = [
            'view_any_otp',
            'view_otp',
            'create_otp',
            'update_otp',
            'delete_otp',
            'delete_any_otp',
            'restore_otp',
            'force_delete_otp',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Ambil role super_admin
        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        // Pastikan role memiliki semua permission
        $role->syncPermissions($permissions);
    }
}
