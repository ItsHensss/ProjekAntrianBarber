<?php

namespace App\Filament\Customer\Resources\UserQueueResource\Pages;

use App\Filament\Customer\Resources\UserQueueResource;
use App\Models\Customer;
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
                        ->minDate(today())
                        ->default(now()),
                ])
                ->action(function (array $data) {
                    $user = Auth::user();

                    // ✅ Cek apakah customer sudah ada
                    $customer = Customer::where('user_id', $user->id)->first();

                    // ✅ Jika belum ada, buat customer baru
                    if (!$customer) {
                        $customer = Customer::create([
                            'user_id' => $user->id,
                            'nama' => $user->name,
                            // Tambahkan kolom lain jika diperlukan, misal 'alamat' => '', dll
                        ]);
                    }

                    // ❗ Cek antrian aktif
                    $existingQueue = Queue::where('customer_id', $user->customer->id)
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

                    // ✅ Hitung nomor antrian berdasarkan tanggal booking
                    $bookingDate = $data['booking_date'];
                    $lastQueue = Queue::whereDate('booking_date', $bookingDate)
                        ->orderByDesc('nomor_antrian')
                        ->first();
                    $nextNomorAntrian = $lastQueue ? $lastQueue->nomor_antrian + 1 : 1;

                    // ✅ Buat data antrian
                    Queue::create([
                        'customer_id' => $customer->id,
                        'user_id' => $user->id,
                        'tenant_id' => $data['tenant_id'],
                        'produk_id' => $data['produk_id'],
                        'requested_chapster_id' => $data['requested_chapster_id'],
                        'booking_date' => $bookingDate,
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
        ];
    }
}