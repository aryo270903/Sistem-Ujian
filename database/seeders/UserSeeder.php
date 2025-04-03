<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder {
    public function run(): void {
        // Pastikan role "super_admin" ada
        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        // Buat user hanya jika belum ada
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nomor_induk' => '000001',
                'name' => 'Super Admin',
                'jenis_kelamin' => 'L', // L untuk Laki-laki, P untuk Perempuan
                'nik' => '1234567890123456',
                'nisn' => '9876543210',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => Carbon::createFromFormat('d-m-Y', '01-01-1980'),
                'alamat' => 'Jl. Merdeka No. 1, Jakarta',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );        

        // Pastikan user memiliki role
        if (!$user->hasRole('super_admin')) {
            $user->assignRole($role);
        }
    }
}
