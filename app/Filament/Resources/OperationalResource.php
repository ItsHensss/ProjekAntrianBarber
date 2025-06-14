<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OperationalResource\Pages;
use App\Filament\Resources\OperationalResource\RelationManagers;
use App\Models\Operational;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class OperationalResource extends Resource
{
    protected static ?string $model = Operational::class;
    protected static null|string $tenantOwnershipRelationshipName = 'tenant';


    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $label = 'Operational';
    protected static ?string $pluralLabel = 'Operational';
    protected static ?string $slug = 'operational';
    protected static ?string $navigationLabel = 'Operational';
    protected static ?string $recordTitleAttribute = 'day';
    protected static ?string $modelLabel = 'Operational';
    protected static ?string $pluralModelLabel = 'Operational';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('day')
                    ->label('Hari')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('open_time')
                    ->label('Jam Buka')
                    ->required(),
                Forms\Components\TextInput::make('close_time')
                    ->label('Jam Tutup')
                    ->required(),
                Forms\Components\Toggle::make('is_open')
                    ->label('Buka?')
                    ->required(),
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
                Tables\Columns\TextColumn::make('day')
                    ->label('Hari')
                    ->searchable(),
                Tables\Columns\TextColumn::make('open_time')
                    ->label('Jam Buka'),
                Tables\Columns\TextColumn::make('close_time')
                    ->label('Jam Tutup'),
                Tables\Columns\IconColumn::make('is_open')
                    ->label('Buka?')
                    ->boolean(),
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
            'index' => Pages\ListOperationals::route('/'),
            'create' => Pages\CreateOperational::route('/create'),
            'edit' => Pages\EditOperational::route('/{record}/edit'),
        ];
    }
}
