<?php

namespace App\Filament\Exports;

use App\Models\Tryout;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;


class TryoutExporter extends Exporter
{
    protected static ?string $model = Tryout::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('user.name')->label('Nama Siswa'),
            ExportColumn::make('package.name')->label('Mata Pelajaran'),
            ExportColumn::make('started_at')->label('Waktu Mulai Ujian'),
            ExportColumn::make('finished_at')->label('Waktu Berakhir Ujian'),
        ];
    }

    public static function queue(): bool
    {
        return false; // Menonaktifkan queue agar ekspor langsung dieksekusi
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your tryout export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
