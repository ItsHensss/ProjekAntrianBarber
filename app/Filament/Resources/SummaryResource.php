<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SummaryResource\Pages;
use App\Models\Queue;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SummaryResource extends Resource
{
    protected static ?string $model = Queue::class;
    protected static ?string $tenantOwnershipRelationshipName = 'tenant';
    protected static ?string $label = 'Ringkasan';
    protected static ?string $pluralLabel = 'Ringkasan';
    protected static ?string $slug = 'summary';
    protected static ?string $navigationLabel = 'Ringkasan';

    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $modelLabel = 'Ringkasan';


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function canAccess(): bool
    {
        return Auth::user()?->can('view_any_summary');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\SummaryReport::route('/'),
        ];
    }
}
