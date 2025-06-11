<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Models\Queue;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TransaksiResource extends Resource
{
    protected static ?string $model = Queue::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $tenantOwnershipRelationshipName = 'tenant';
    protected static ?string $label = 'Transaksi';
    protected static ?string $pluralLabel = 'Transaksi';
    protected static ?string $slug = 'transaksi';
    protected static ?string $navigationLabel = 'Transaksi';
    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $modelLabel = 'Transaksi';
    protected static ?string $pluralModelLabel = 'Transaksi';

    // public static function canViewAny(): bool
    // {
    //     return true;
    // }

    // public static function canView($record): bool
    // {
    //     return true;
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\TransaksiReport::route('/'),
        ];
    }
}
