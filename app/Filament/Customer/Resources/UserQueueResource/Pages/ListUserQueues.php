<?php

namespace App\Filament\Customer\Resources\UserQueueResource\Pages;

use App\Filament\Customer\Resources\UserQueueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Auth;
use App\Models\Queue;
use App\Models\Tenant;
use App\Models\Produk;
use Filament\Notifications\Notification;

class ListUserQueues extends ListRecords
{
    protected static string $resource = UserQueueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\Action::make('Daftar Antrian')
                ->label('Daftar Antrian')
                ->form([
                    Select::make('tenant_id')
                        ->label('Pilih Tenant')
                        ->options(fn() => Tenant::pluck('name', 'id'))
                        ->reactive()
                        ->required(),

                    Select::make('requested_chapster_id')
                        ->label('Pilih Chapster')
                        ->options(function (callable $get) {
                            $tenantId = $get('tenant_id');
                            // Tampilkan "dani" hanya jika tenant_id = 1 (cabang utama)
                            if ($tenantId == 1) {
                                return [
                                    'umum' => 'Umum',
                                    'dani' => 'Dani',
                                ];
                            }
                            return ['umum' => 'Umum'];
                        })
                        ->required()
                        ->reactive(),

                    Select::make('produk_id')
                        ->label('Pilih Produk')
                        ->options(function (callable $get) {
                            $tenantId = $get('tenant_id');
                            return Produk::where('tenant_id', $tenantId)->pluck('judul', 'id');
                        })
                        ->required()
                        ->reactive(),

                    DatePicker::make('booking_date')
                        ->label('Tanggal Booking')
                        ->required()
                        ->minDate(now()),
                ])
                ->action(function (array $data) {
                    $user = Auth::user();

                    // Cek antrian yang masih aktif
                    $existingQueue = Queue::where('user_id', $user->id)
                        ->whereNotIn('status', ['selesai', 'batal'])
                        ->first();

                    if ($existingQueue) {
                        Notification::make()
                            ->title('Gagal Mendaftar')
                            ->body('Anda sudah memiliki antrian yang belum selesai.')
                            ->danger()
                            ->send();
                        return;
                    }

                    $today = now()->toDateString();
                    $lastQueueToday = Queue::whereDate('booking_date', $today)
                        ->orderByDesc('nomor_antrian')
                        ->first();
                    $nextNomorAntrian = $lastQueueToday ? $lastQueueToday->nomor_antrian + 1 : 1;

                    Queue::create([
                        'user_id' => $user->id,
                        'tenant_id' => $data['tenant_id'],
                        'produk_id' => $data['produk_id'],
                        'requested_chapster_id' => $data['requested_chapster_id'],
                        'booking_date' => $data['booking_date'],
                        'nomor_antrian' => $nextNomorAntrian,
                        'status' => 'menunggu',
                        'is_validated' => false,
                    ]);

                    Notification::make()
                        ->title('Berhasil Mendaftar')
                        ->body('Berhasil mendaftar dengan nomor antrian: ' . $nextNomorAntrian)
                        ->success()
                        ->send();
                })
                ->modalHeading('Pendaftaran Antrian Cepat')
                ->modalSubmitActionLabel('Daftar')
                ->color('primary'),
        ];
    }
}