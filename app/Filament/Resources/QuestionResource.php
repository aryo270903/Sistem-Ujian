<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn; 

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;
    protected static ?string $pluralLabel = 'Daftar Soal';
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
    ->schema([
        Forms\Components\Card::make()
            ->schema([
                Forms\Components\Grid::make(1)
                    ->schema([
                        Forms\Components\RichEditor::make('question')
    ->label('Pertanyaan')
    ->toolbarButtons([
        'bold', 'italic', 'strike', 'link', 'orderedList', 'unorderedList',
    ])
    ->required()
    ->afterStateUpdated(function ($state, callable $set) {
        $cleanedText = preg_replace('/&bsp;| /', ' ', $state); // Hapus karakter aneh
        $set('question', $cleanedText);
    }),
                        Forms\Components\Textarea::make('explanation')
                            ->label('Penjelasan')
                            ->required(),
                    
                     // Upload file image for question
                     FileUpload::make('question_image')
                     ->label('Upload Gambar Soal')
                     ->image()
                     ->disk('public') // Store on public disk
                     ->directory('questions') // Store in the 'questions' directory
                     ->nullable(), // Image upload is optional

                    ]),
                Forms\Components\Repeater::make('options')
                    ->label('Pilihan Jawaban')
                    ->relationship('options')
                    ->schema([
                        Forms\Components\Grid::make(2) // ✅ Grid di dalam Repeater agar lebih rapi
                            ->schema([
                                Forms\Components\TextInput::make('option_text')
                                    ->label('Jawaban')
                                    ->required(),

                                Forms\Components\TextInput::make('score')
                                    ->label('Skor')
                                    ->numeric()
                                    ->required(),
                            ]),
                    ])
            ])
    ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('question')
                    ->label('Pertanyaan')
                    ->formatStateUsing(fn ($state) => strip_tags($state))
                    ->html(true),
                Tables\Columns\TextColumn::make('explanation')
                    ->label('Penjelasan')
                    ->html(true),
                Tables\Columns\TextColumn::make('options_count')
                    ->label('Total Jawaban')
                    ->counts('options'),
                    ImageColumn::make('question_image')
                    ->label('Gambar Soal')
                    ->disk('public') // Make sure this is the correct disk
                    ->url(fn ($record) => $record->question_image ? asset('storage/' . $record->question_image) : null) // Display the image URL
                    ->width(100) // Adjust the image width as needed
                    ->height(100), // Adjust the image height as needed

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
