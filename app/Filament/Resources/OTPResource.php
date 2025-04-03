<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OTPResource\Pages;
use App\Models\OTP;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\User;
use Filament\Notifications\Notification;
use Carbon\Carbon;

class OTPResource extends Resource
{
    protected static ?string $model = OTP::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    
    protected static ?string $navigationLabel = 'Manajemen OTP';
    
    protected static ?string $navigationGroup = 'Autentikasi';
    
    protected static ?int $navigationSort = 1;
    
    public static function canViewAny(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Siswa')
                ->options(User::whereHas('roles', function ($query) {
                    $query->where('name', 'siswa');
                })->pluck('name', 'id'))
                ->searchable()
                ->required(),
            Forms\Components\TextInput::make('otp')
                ->label('OTP')
                ->required(),
            Forms\Components\DateTimePicker::make('expires_at')
                ->label('Kedaluwarsa')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Siswa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('otp')
                    ->label('OTP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Kedaluwarsa')
                    ->dateTime('Y-m-d H:i:s'), // Format waktu WIB
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('generateOtp')
                    ->label('Generate OTP for All Siswa')
                    ->action(function () {
                        // Cek apakah user saat ini memiliki role super_admin
                        if (!auth()->user()->hasRole('super_admin')) {
                            Notification::make()
                                ->title('Akses Ditolak')
                                ->body('Hanya Super Admin yang dapat melakukan tindakan ini.')
                                ->danger()
                                ->send();
                            return;
                        }
            
                        // Buat OTP sekali saja
                        $otp = rand(100000, 999999); 
            
                        // Ambil semua user dengan role siswa
                        $siswaUsers = User::whereHas('roles', function ($query) {
                            $query->where('name', 'siswa');
                        })->get();
            
                        foreach ($siswaUsers as $siswa) {
                            OTP::updateOrCreate(
                                ['user_id' => $siswa->id],
                                [
                                    'otp' => $otp,
                                    // Menggunakan WIB saat pembuatan OTP
                                    'expires_at' => Carbon::now('Asia/Jakarta')->addMinutes(5),
                                ]
                            );
                        }
            
                        Notification::make()
                            ->title('Berhasil')
                            ->body('OTP berhasil dibuat untuk semua siswa.')
                            ->success()
                            ->send();
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
            'index' => Pages\ListOTPS::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
