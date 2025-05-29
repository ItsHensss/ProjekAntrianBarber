<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Queue;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\GlobalSearch\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\QueueResource\Pages;
use App\Filament\Resources\QueueResource\Pages\EditQueue;
use App\Filament\Resources\QueueResource\Pages\ListQueues;
use App\Filament\Resources\QueueResource\Pages\CreateQueue;
use App\Models\Customer;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;

class QueueResource extends Resource
{
    protected static ?string $model = Queue::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static null|string $tenantOwnershipRelationshipName = 'tenant';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Toggle::make('is_new_customer')
                    ->label('Pelanggan Baru?')
                    ->default(false)
                    ->reactive(),

                Select::make('customer_id')
                    ->label('Pilih Pelanggan')
                    ->searchable()
                    ->options(fn() => Customer::pluck('nama', 'id'))
                    ->visible(fn(Get $get) => !$get('is_new_customer'))
                    ->required(fn(Get $get) => !$get('is_new_customer')),

                TextInput::make('nama')
                    ->label('Nama Pelanggan')
                    ->required(fn(Get $get) => $get('is_new_customer'))
                    ->visible(fn(Get $get) => $get('is_new_customer')),

                TextInput::make('nomor')
                    ->label('Nomor Pelanggan')
                    ->numeric()
                    ->required(fn(Get $get) => $get('is_new_customer'))
                    ->visible(fn(Get $get) => $get('is_new_customer')),

                Forms\Components\Select::make('produk_id')
                    ->label('Produk')
                    ->options(function () {
                        $tenantId = Auth::user()?->teams->first()?->id;
                        return \App\Models\Produk::where('tenant_id', $tenantId)->pluck('judul', 'id');
                    })
                    ->required(),

                Forms\Components\TextInput::make('status')
                    ->readOnly()
                    ->default('menunggu')
                    ->required(),

                Forms\Components\Hidden::make('is_validated')
                    ->default(true),

                Forms\Components\Select::make('requested_chapster_id')
                    ->label('Requested Chapster')
                    ->options([
                        'umum' => 'Umum',
                        'dani' => 'Dani',
                    ])
                    ->required(),

                DatePicker::make('booking_date')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $lastQueue = \App\Models\Queue::whereDate('booking_date', $state)
                            ->orderByDesc('nomor_antrian')
                            ->first();

                        $nextNumber = $lastQueue ? $lastQueue->nomor_antrian + 1 : 1;

                        $set('nomor_antrian', $nextNumber);
                    }),

                TextInput::make('nomor_antrian')
                    ->required()
                    ->numeric()
                    ->readOnly()
                    ->hint('Akan otomatis terisi jika tanggal booking sudah terisi'),

                Forms\Components\Hidden::make('tenant_id')
                    ->default(fn() => Auth::user()?->teams->first()?->id)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                Tables\Columns\TextColumn::make('requested_chapster_id')
                    ->label('Chapster')
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking_date')
                    ->label('Tanggal Booking')
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
                // filter antrian hari ini
                Filter::make('today')
                    ->label('Antrian Hari Ini')
                    ->default(true)
                    ->query(function (Builder $query) {
                        return $query->whereDate('booking_date', now()->toDateString());
                    }),
                //filter chapster
                Tables\Filters\SelectFilter::make('requested_chapster_id')
                    ->label('Chapster')
                    ->options([
                        'umum' => 'Umum',
                        'dani' => 'Dani',
                    ]),
                // Filter untuk status antrian
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'selesai' => 'Selesai',
                        'batal' => 'Batal',
                    ]),
                // Filter tanggal booking
                Filter::make('booking_date')
                    ->form([
                        DatePicker::make('date'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['date'])) {
                            return $query->whereDate('booking_date', $data['date']);
                        }
                        return $query;
                    }),

                // Filter untuk menampilkan semua data (tidak difilter tanggal)
                Filter::make('Semua Antrian')
                    ->label('Tampilkan Semua Antrian')
                    ->query(fn(Builder $query) => $query),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ActionGroup::make([
                    // action to validate the queue
                    Tables\Actions\Action::make('validate')
                        ->label('Validate')
                        ->action(function (Queue $record) {
                            $record->update(['is_validated' => true]);
                        })
                        ->requiresConfirmation()
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->disabled(fn(Queue $record) => $record->is_validated || $record->status === 'batal'),
                    // action selesai
                    Tables\Actions\Action::make('selesai')
                        ->label('Selesai')
                        ->action(function (Queue $record) {
                            $record->update(['status' => 'selesai']);
                        })
                        ->requiresConfirmation()
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->disabled(
                            fn(Queue $record) =>
                            !$record->is_validated ||
                                $record->status === 'selesai' ||
                                $record->status === 'batal'
                        ),
                    // action batalkan
                    Tables\Actions\Action::make('batalkan')
                        ->label('Batalkan')
                        ->action(function (Queue $record) {
                            $record->update(['status' => 'batal']);
                        })
                        ->requiresConfirmation()
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->disabled(
                            fn(Queue $record) =>
                            !$record->is_validated ||
                                $record->status === 'batal' ||
                                $record->status === 'selesai'
                        ),
                ])->label('Aksi Lain')->icon('heroicon-o-cog')->color('white'),
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
            'index' => Pages\ListQueues::route('/'),
            'create' => Pages\CreateQueue::route('/create'),
            'edit' => Pages\EditQueue::route('/{record}/edit'),
        ];
    }
}
