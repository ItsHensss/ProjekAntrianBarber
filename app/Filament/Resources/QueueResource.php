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
use App\Models\User;
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
                Forms\Components\Toggle::make('is_new_customer')
                    ->label('Pelanggan Baru?')
                    ->default(false),

                Forms\Components\Select::make('user_id')
                    ->label('Pilih Pelanggan')
                    ->options(fn() => User::whereNull('current_team_id')->pluck('name', 'id'))
                    ->visible(fn(Get $get) => !$get('is_new_customer'))
                    ->required(fn(Get $get) => !$get('is_new_customer')),

                Forms\Components\TextInput::make('name')
                    ->label('Nama Pelanggan')
                    ->required(fn(Get $get) => $get('is_new_customer'))
                    ->visible(fn(Get $get) => $get('is_new_customer')),

                Forms\Components\TextInput::make('email')
                    ->label('Email Pelanggan')
                    ->email()
                    ->required(fn(Get $get) => $get('is_new_customer'))
                    ->visible(fn(Get $get) => $get('is_new_customer')),

                Forms\Components\Select::make('produk_id')
                    ->label('Produk')
                    ->options(\App\Models\Produk::pluck('nama', 'id'))
                    ->required(),

                Forms\Components\TextInput::make('nomor_antrian')
                    ->required()
                    ->numeric()
                    ->default(function () {
                        $today = now()->toDateString();
                        $lastQueueToday = Queue::whereDate('booking_date', $today)
                            ->orderByDesc('nomor_antrian')
                            ->first();
                        return $lastQueueToday ? $lastQueueToday->nomor_antrian + 1 : 1;
                    }),

                Forms\Components\TextInput::make('status')
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

                Forms\Components\DatePicker::make('booking_date'),

                Forms\Components\Hidden::make('tenant_id')
                    ->default(fn() => Auth::user()?->teams->first()?->id)
                    ->required(),
            ])
            ->afterCreate(function (Queue $record, array $data) {
                if ($data['is_new_customer']) {
                    $newUser = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                    ]);
                    $record->update(['user_id' => $newUser->id]);
                }
            });
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
                // filter antrian hari ini
                Filter::make('today')
                    ->label('Antrian Hari Ini')
                    ->default(true)
                    ->query(function (Builder $query) {
                        return $query->whereDate('booking_date', now()->toDateString());
                    }),
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
                //action to validate the queue
                Tables\Actions\Action::make('validate')
                    ->label('Validate')
                    ->action(function (Queue $record) {
                        $record->update(['is_validated' => true]);
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check-circle'),
                // action selesai
                Tables\Actions\Action::make('selesai')
                    ->label('Selesai')
                    ->action(function (Queue $record) {
                        $record->update(['status' => 'selesai']);
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check'),
                // action batalkan
                Tables\Actions\Action::make('batalkan')
                    ->label('Batalkan')
                    ->action(function (Queue $record) {
                        $record->update(['status' => 'batal']);
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-x-circle'),
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