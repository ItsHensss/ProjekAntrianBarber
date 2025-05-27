<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\UserQueueResource\Pages;
use App\Models\Queue;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
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
                Tables\Columns\TextColumn::make('nomor_antrian')
                    ->label('Nomor Antrian')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('barber_table.nama')
                    ->label('Meja/Kursi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.full_name')
                    ->label('Chapster')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'menunggu' => 'Menunggu',
                        'dipanggil' => 'Dipanggil',
                        'selesai' => 'Selesai',
                        'batal' => 'Dibatalkan',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'menunggu' => 'primary',
                        'dipanggil' => 'warning',
                        'selesai' => 'success',
                        'batal' => 'danger',
                        default => 'secondary',
                    })
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_validated')
                    ->label('Validasi Admin')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('5s')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'dipanggil' => 'Dipanggil',
                        'selesai' => 'Selesai',
                    ]),

                Tables\Filters\TernaryFilter::make('is_validated')
                    ->label('Validasi Admin')
                    ->trueLabel('Sudah divalidasi')
                    ->falseLabel('Belum divalidasi'),

                Tables\Filters\Filter::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Dari'),
                        Forms\Components\DatePicker::make('created_until')->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['created_from'], fn($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([]);
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
