<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TryoutResource\Pages;
use App\Filament\Resources\TryoutResource\RelationManagers;
use App\Models\Tryout;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Auth;
use Carbon\Carbon;
use Filament\Tables\Actions\ExportAction;
use App\Filament\Exports\TryoutExporter;
use Filament\Tables\Actions\Action;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Response; 

class TryoutResource extends Resource
{
    protected static ?string $model = Tryout::class;
    protected static ?string $pluralLabel = 'Hasil Ulangan';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('package_id')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('duration')
                ->required()
                ->numeric(),
            Forms\Components\DateTimePicker::make('started_at'),
            Forms\Components\DateTimePicker::make('finished_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(function (Builder $query) {
            $is_super_admin = Auth::user()->hasRole('super_admin');

            if (!$is_super_admin) {
                $query->where('user_id', Auth::user()->id);
            }

            $query->withSum('tryOutAnswers as score', 'score')
            ->orderBy('score', 'desc');
        })
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Siswa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('package.name')
                    ->label('Mata Pelajaran')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('started_at')
                    ->label('Waktu Mulai Ujian')
                    ->getStateUsing(fn ($record) => \Carbon\Carbon::parse($record->started_at)->timezone('Asia/Jakarta')->format('d M Y H:i'))
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('finished_at')
                    ->label('Waktu Berakhir Ujian')
                    ->getStateUsing(fn ($record) => \Carbon\Carbon::parse($record->finished_at)->timezone('Asia/Jakarta')->format('d M Y H:i'))
                    ->sortable(),
                    Tables\Columns\TextColumn::make('score')
                    ->label('Nilai')
                    ->getStateUsing(function ($record) {
                        $totalQuestions = $record->package->questions->count();
                        $totalScore = $record->tryOutAnswers->sum('score');
                        return $totalQuestions > 0 ? $totalScore / ($totalQuestions / 10) : 0;
                    })
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
            ])
            ->headerActions([
                Action::make('Export CSV')
                ->action(function () {
                    $fileName = 'export_tryout_' . now()->format('YmdHis') . '.csv';
            
                    $headers = [
                        'Content-Type' => 'text/csv',
                        'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                    ];
            
                    $tryouts = \App\Models\Tryout::with(['user', 'package', 'tryOutAnswers'])->get();
            
                    $callback = function () use ($tryouts) {
                        $handle = fopen('php://output', 'w');
            
                        // Header CSV
                        fputcsv($handle, ['Nama Siswa', 'Mata Pelajaran', 'Waktu Mulai Ujian', 'Waktu Berakhir Ujian', 'Nilai']);
            
                        foreach ($tryouts as $tryout) {
                            fputcsv($handle, [
                                $tryout->user->name ?? 'Tidak ada nama',
                                $tryout->package->name ?? 'Tidak ada mata pelajaran',
                                $tryout->started_at,
                                $tryout->finished_at,
                                $tryout->tryOutAnswers->sum('score'),
                            ]);
                        }
            
                        fclose($handle);
                    };
            
                    return Response::stream($callback, 200, $headers);
                }),
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
            'index' => Pages\ListTryouts::route('/'),
            'create' => Pages\CreateTryout::route('/create'),
        ];
    }
}
