<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LokasiResource\Pages;
use App\Filament\Resources\LokasiResource\RelationManagers;
use App\Models\Lokasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class LokasiResource extends Resource
{
    protected static ?string $model = Lokasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $tenantOwnershipRelationshipName = 'tenant';
    protected static ?string $label = 'Lokasi';
    protected static ?string $pluralLabel = 'Lokasi';
    protected static ?string $recordTitleAttribute = 'nama_cabang';
    protected static ?string $modelLabel = 'Lokasi';
    protected static ?string $pluralModelLabel = 'Lokasi';


    protected static ?string $slug = 'lokasi';
    protected static ?string $navigationLabel = 'Lokasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_cabang')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kota')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telepon')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
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
                Tables\Columns\TextColumn::make('nama_cabang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
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
            'index' => Pages\ListLokasis::route('/'),
            'create' => Pages\CreateLokasi::route('/create'),
            'edit' => Pages\EditLokasi::route('/{record}/edit'),
        ];
    }
}
