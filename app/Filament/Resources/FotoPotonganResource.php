<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FotoPotonganResource\Pages;
use App\Filament\Resources\FotoPotonganResource\RelationManagers;
use App\Models\FotoPotongan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class FotoPotonganResource extends Resource
{
    protected static ?string $model = FotoPotongan::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $tenantOwnershipRelationshipName = 'tenant';
    protected static ?string $label = 'Foto Potongan';
    protected static ?string $pluralLabel = 'Foto Potongan';
    protected static ?string $slug = 'foto-potongan';
    protected static ?string $navigationLabel = 'Foto Potongan';
    protected static ?string $recordTitleAttribute = 'judul';
    protected static ?string $modelLabel = 'Foto Potongan';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->label('Foto Potongan')
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
            ->defaultSort('created_at', 'desc')

            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto Potongan')
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
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
            'index' => Pages\ListFotoPotongans::route('/'),
            'create' => Pages\CreateFotoPotongan::route('/create'),
            'edit' => Pages\EditFotoPotongan::route('/{record}/edit'),
        ];
    }
}
