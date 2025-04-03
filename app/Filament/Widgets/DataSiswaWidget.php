<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DataSiswaWidget extends Widget
{
    protected static string $view = 'filament.widgets.data-siswa-widget';

    public $data = [];

    protected function getHeading(): string
    {
        return 'Data Siswa';
    }

    public function mount()
    {
        $user = auth()->user();

        $this->data = [
            'nomor_induk' => $user->nomor_induk ?? 'Tidak Ada',
            'name' => $user->name ?? 'Tidak Ada Nama',
            'jenis_kelamin' => $user->jenis_kelamin ?? 'Tidak Ada',
            'nik' => $user->nik ?? 'Tidak Ada',
            'nisn' => $user->nisn ?? 'Tidak Ada',
            'tempat_lahir' => $user->tempat_lahir ?? 'Tidak Ada',
            'tanggal_lahir' => $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d-m-Y') : 'Tidak Ada',
            'alamat' => $user->alamat ?? 'Tidak Ada',
        ];
    }

    public function getData(): array
    {
        return $this->data;
    }
}
