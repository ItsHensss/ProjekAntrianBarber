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

    protected static ?string $navigationIcon = 'heroicon-o-camera';
    protected static null|string $tenantOwnershipRelationshipName = 'tenant';
    protected static ?string $label = 'Foto Interior';
    protected static ?string $pluralLabel = 'Foto Interior';
    protected static ?string $slug = 'foto-interior';
    protected static ?string $navigationLabel = 'Foto Interior';
    protected static ?string $recordTitleAttribute = 'judul';
    protected static ?string $modelLabel = 'Foto Interior';
    protected static ?string $pluralModelLabel = 'Foto Interior';

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
                Forms\Components\Hidden::make('tenant_id')
                    ->default(fn() => Auth::user()?->teams->first()?->id)
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
