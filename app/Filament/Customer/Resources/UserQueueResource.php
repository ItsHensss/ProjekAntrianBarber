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

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('customer.nama')
                    ->label('Pelanggan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('produk.judul')
                    ->label('Produk')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_antrian')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'menunggu' => 'warning',
                        'selesai' => 'success',
                        'batal' => 'danger',
                        default => 'secondary',
                    }),
                Tables\Columns\IconColumn::make('is_validated')
                    ->label('Validated')
                    ->sortable()
                    ->boolean(),
                // tampilkan cabang
                Tables\Columns\TextColumn::make('tenant.name')
                    ->label('Cabang')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('requested_chapster_id')
                    ->label('Chapster')
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking_date')
                    ->label('Tanggal Booking')
                    ->date('l, d F Y')
                    ->sortable(),
            ])
            ->filters([
                //antrian saya
                Filter::make('my_queue')
                    ->label('Antrian Saya')
                    ->query(function (Builder $query) {
                        // Ambil customer_id dari user yang sedang login
                        $customerId = optional(Auth::user()->customer)->id;
                        if ($customerId) {
                            return $query->where('customer_id', $customerId);
                        }
                        // Jika user tidak punya customer, munculkan alert
                        session()->flash('danger', 'Customer ID tidak ada, harap register sebagai customer.');
                        // Kembalikan query tanpa mengubah apapun (filter tidak aktif)
                        return $query->whereRaw('1 = 0');
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
                    ->label('Cancel')
                    ->action(function (Queue $record) {
                        $record->update(['status' => 'batal']);
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-x-circle')
                    ->visible(function (Queue $record) {
                        $customer = optional(Auth::user())->customer;
                        if (!$customer) {
                            return false;
                        }
                        // Sembunyikan jika status sudah selesai atau is_validated belum true
                        if ($record->status === 'batal' || $record->status === 'selesai') {
                            return false;
                        }
                        return $record->customer_id === $customer->id;
                    }),
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

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canView($record): bool
    {
        return true;
    }
}
