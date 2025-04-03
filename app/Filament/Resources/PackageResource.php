<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Filament\Resources\PackageResource\RelationManagers;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use App\Models\Question;
use App\Models\PackageQuestion;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;
    protected static ?string $pluralLabel = 'Mata Pelajaran';
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('duration')
                                ->label('Durasi (dalam menit)')
                                ->required()
                                ->numeric(),
                            // Tambahkan field tanggal dan jam
                            Forms\Components\DatePicker::make('date')
                                ->label('Tanggal Pelaksanaan')
                                ->required(),
                            Forms\Components\TimePicker::make('time')
                                ->label('Jam Pelaksanaan')
                                ->required(),
                            Forms\Components\TimePicker::make('end_time')->label('Jam Selesai')->required(),
                        ])
                ]),
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\Repeater::make('questions')
                            ->relationship('questions')
                            ->schema([
                                Forms\Components\Select::make('question_id')
                                    ->relationship('question', 'question')
                                    ->label('Soal')
                                    ->options(function () {
                                        $questions = Question::all();
                                        $options = [];
                        
                                        foreach ($questions as $question) {
                                            $isUsed = PackageQuestion::where('question_id', $question->id)->exists();
                                            if (!$isUsed) {
                                                $options[$question->id] = strip_tags($question->question); // Hilangkan tag HTML
                                            }
                                        }
                        
                                        return $options;
                                    })
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->getOptionLabelFromRecordUsing(fn ($record) => strip_tags($record->question)) // Menghapus tag HTML
                                    ->required()
                                    ->searchable() // Mengaktifkan fitur pencarian
                                    ->placeholder('Pilih atau cari soal...')
                                    ->preload() // Menampilkan opsi secara langsung tanpa menunggu pencarian
                                    ->maxItems(50) // Menampilkan maksimal 50 opsi, selebihnya bisa dicari
                            ])
                        ])
                ])
        ]);
    
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Durasi (dalam menit)')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal Pelaksanaan')
                    ->getStateUsing(fn ($record) => \Carbon\Carbon::parse($record->date)->timezone('Asia/Jakarta')->format('d M Y'))
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('time')
                    ->label('Jam Pelaksanaan')
                    ->getStateUsing(fn ($record) => \Carbon\Carbon::parse($record->time)->timezone('Asia/Jakarta')->format('H:i'))
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Jam Selesai')
                    ->getStateUsing(fn ($record) => 
                        \Carbon\Carbon::parse($record->time)->addMinutes($record->duration)->timezone('Asia/Jakarta')->format('H:i')
                    )
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('questions_count')
                    ->counts('questions')
                    ->label('Jumlah Soal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Kerjakan')
    ->url(fn (Package $record) => route('do-tryout', $record))
    ->color('success')
    ->icon('heroicon-o-paper-airplane')
    ->hidden(fn (Package $record) =>
        Carbon::now('Asia/Jakarta')->lessThan(
            Carbon::createFromFormat('Y-m-d H:i:s', $record->date . ' ' . $record->time, 'Asia/Jakarta')
        ) ||
        Carbon::now('Asia/Jakarta')->greaterThanOrEqualTo($record->getEndTime()) || // Cek jika waktu sudah lewat
        \App\Models\Tryout::where('user_id', auth()->id())->where('package_id', $record->id)->exists()
    )
    ->disabled(fn (Package $record) =>
        $record->isExpired()
    ),

                ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
