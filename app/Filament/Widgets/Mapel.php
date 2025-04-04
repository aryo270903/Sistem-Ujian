<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Package;
use Carbon\Carbon;

class Mapel extends BaseWidget
{
    protected static ?string $heading = 'Ulangan Hari Ini';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Package::query()->whereDate('date', Carbon::today())
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Mapel'),
                Tables\Columns\TextColumn::make('duration')->label('Durasi'),
                Tables\Columns\TextColumn::make('date')->label('Tanggal Ulangan')->date(),
                Tables\Columns\TextColumn::make('time')->label('Waktu Mulai'),
                Tables\Columns\TextColumn::make('end_time')->label('Waktu Selesai'),
            ]);
    }
}
