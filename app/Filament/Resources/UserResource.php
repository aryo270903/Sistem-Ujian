<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nomor_induk')
                    ->label('Nomor Induk')
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(20)
                    ->unique('users', 'nomor_induk', ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Siswa')
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255),
                Forms\Components\Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-Laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(fn (string $context): bool => $context === 'create'),
                Forms\Components\TextInput::make('nik')
                    ->label('NIK Siswa')
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(16)
                    ->unique('users', 'nik', ignoreRecord: true),
                Forms\Components\TextInput::make('nisn')
                    ->label('NISN')
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(10)
                    ->unique('users', 'nisn', ignoreRecord: true),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(100),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->required(fn (string $context): bool => $context === 'create')
                    ->displayFormat('d-m-Y')
                    ->format('Y-m-d'), 
                Forms\Components\Textarea::make('alamat')
                    ->label('Alamat')
                    ->required(fn (string $context): bool => $context === 'create'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255)
                    ->unique('users', 'email', ignoreRecord: true)
                    ->label('Email')
                    ->placeholder('Masukkan alamat email'),
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_induk')->label('Nomor Induk')->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->label('Role')->searchable(),
                Tables\Columns\TextColumn::make('name')->label('Nama Siswa')->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')->label('Jenis Kelamin'),
                Tables\Columns\TextColumn::make('nik')->label('NIK'),
                Tables\Columns\TextColumn::make('nisn')->label('NISN'),
                Tables\Columns\TextColumn::make('tempat_lahir')->label('Tempat Lahir'),
                Tables\Columns\TextColumn::make('tanggal_lahir')->label('Tanggal Lahir')->date('d-m-Y'),
                Tables\Columns\TextColumn::make('alamat')->label('Alamat')->limit(50),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Diperbarui')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter berdasarkan role
                Tables\Filters\SelectFilter::make('roles')
                    ->label('Role')
                    ->options(function () {
                        return \Spatie\Permission\Models\Role::pluck('name', 'name')->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('roles', function (Builder $query) use ($data) {
                                $query->where('name', $data['value']);
                            });
                        }
                    }),
            ])            
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Unduh Kartu Ujian')
                    ->color('success')
                    ->url(fn (User $record): string => route('download.card', $record->id))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('download')
                    ->label('Unduh Kartu Ujian')
                    ->color('success')
                    ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                        $ids = $records->pluck('id')->implode(',');
                        return redirect()->route('download.cards', ['ids' => $ids]);
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}