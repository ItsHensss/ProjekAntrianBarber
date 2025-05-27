<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FotoInteriorResource\Pages;
use App\Filament\Resources\FotoInteriorResource\RelationManagers;
use App\Models\FotoInterior;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class FotoInteriorResource extends Resource
{
    protected static ?string $model = FotoInterior::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static null|string $tenantOwnershipRelationshipName = 'teams';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required(),
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
                //tambahkan relasi ke team dan ambil langsung team yang sekarang digunakan
                Forms\Components\Hidden::make('team_id')
                    ->default(fn() => Auth::user()?->current_team_id)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFotoInteriors::route('/'),
            'create' => Pages\CreateFotoInterior::route('/create'),
            'edit' => Pages\EditFotoInterior::route('/{record}/edit'),
        ];
    }
}