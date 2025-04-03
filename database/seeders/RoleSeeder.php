<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder {
    public function run(): void {
        // DB::table('roles')->insertOrIgnore([
        //     [
        //         'id' => 1,
        //         'name' => 'super_admin',
        //         'guard_name' => 'web',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ]
        // ]);
    }
}
