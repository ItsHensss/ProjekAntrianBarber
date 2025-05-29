<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\UserQueueResource\Pages;
use App\Models\Queue;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UserQueueResource extends Resource
{
    protected static ?string $model = Queue::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Antrian';
    protected static ?string $pluralLabel = 'Antrian';
    protected static ?string $slug = 'antrian';
    protected static ?string $navigationLabel = 'Antrian';
    protected static ?string $recordTitleAttribute = 'nomor_antrian';
    protected static ?string $modelLabel = 'Antrian';
    protected static ?string $pluralModelLabel = 'Antrian';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('produk_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_antrian')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\IconColumn::make('is_validated')
                    ->boolean(),
                Tables\Columns\TextColumn::make('requested_chapster_id'),
                Tables\Columns\TextColumn::make('booking_date')
                    ->date('l, d F Y')
                    ->sortable(),
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
                //antrian saya
                Filter::make('my_queue')
                    ->label('Antrian Saya')
                    ->query(function (Builder $query) {
                        return $query->where('user_id', Auth::id());
                    }),
                Filter::make('today')
                    ->label('Antrian Hari Ini')
                    ->default(true)
                    ->query(function (Builder $query) {
                        return $query->whereDate('booking_date', now()->toDateString());
                    }),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'selesai' => 'Selesai',
                        'batal' => 'Batal',
                    ]),
                Tables\Filters\Filter::make('booking_date')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Dari'),
                        Forms\Components\DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn($q, $date) => $q->whereDate('booking_date', '>=', $date))
                            ->when($data['until'], fn($q, $date) => $q->whereDate('booking_date', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('batalkan')
                    ->label('Batalkan')
                    ->action(function (Queue $record) {
                        $record->update(['status' => 'batal']);
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-x-circle'),
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
            'index' => Pages\ListUserQueues::route('/'),
        ];
    }
}
