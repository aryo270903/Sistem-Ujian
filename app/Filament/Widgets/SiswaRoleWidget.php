<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\User;
use App\Models\AppRole;

class SiswaRoleWidget extends BaseWidget
{
    // Properti heading tidak boleh static
    protected ?string $heading = 'Statistik Pengguna';

    protected function getCards(): array
    {
        // Menghitung jumlah semua pengguna
        $userCount = User::count();

        // Menghitung jumlah pengguna dengan role siswa
        $siswaCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'siswa');
        })->count();

        // Menghitung jumlah pengguna dengan role guru
        $guruCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'guru');
        })->count();

        return [
            Card::make('Jumlah Siswa', $siswaCount)
                ->description('Siswa Yang Terdaftar')
                ->icon('heroicon-o-user-group')
                ->color('success'),
            Card::make('Jumlah Guru', $guruCount)
                ->description('Guru Yang Terdaftar')
                ->icon('heroicon-o-academic-cap')
                ->color('primary'),
        ];
    }
}
