<?php

namespace App\Filament\Customer\Resources\UserQueueResource\Pages;

use App\Filament\Customer\Resources\UserQueueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListUserQueues extends ListRecords
{
    protected static string $resource = UserQueueResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\CahirOverviewResource\Widgets\ChairOverview::class,
            \App\Filament\Resources\WaitingQueueSummaryResource\Widgets\WaitingQueueSummary::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\Action::make('Daftar Antrian')
                ->label('Daftar Antrian Cepat')
                ->action(function () {
                    $user = Auth::user();

                    // Cek apakah user sudah punya antrian yang belum selesai
                    $existingQueue = \App\Models\Queue::where('user_id', $user->id)
                        ->whereNotIn('status', ['selesai', 'batal'])
                        ->first();

                    if ($existingQueue) {
                        \Filament\Notifications\Notification::make()
                            ->title('Gagal Mendaftar')
                            ->body('Anda sudah memiliki antrian yang belum selesai.')
                            ->danger()
                            ->send();

                        return;
                    }

                    $lastQueue = \App\Models\Queue::orderByDesc('nomor_antrian')->first();
                    $nextNomorAntrian = $lastQueue ? $lastQueue->nomor_antrian + 1 : 1;

                    \App\Models\Queue::create([
                        'user_id' => $user->id,
                        'nomor_antrian' => $nextNomorAntrian,
                        'status' => 'menunggu',
                        'is_validated' => false,
                    ]);

                    \Filament\Notifications\Notification::make()
                        ->title('Berhasil Mendaftar')
                        ->body('Anda berhasil mendaftar antrian dengan nomor: ' . $nextNomorAntrian)
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->color('primary')
                ->icon('heroicon-o-plus'),

            Actions\Action::make('Daftar Antrian dengan Chapster')
                ->label('Daftar Antrian dengan Chapster')
                ->modalHeading('Daftar Antrian dengan Chapster')
                ->modalDescription('Pilih chapster yang Anda inginkan untuk mendaftar antrian.')
                ->form([
                    \Filament\Forms\Components\Select::make('requested_chapster_id')
                        ->label('Pilih Chapster')
                        ->options(
                            \App\Models\User::whereHas('employee')
                                ->with('employee')
                                ->get()
                                ->mapWithKeys(function ($user) {
                                    $employee = $user->employee;
                                    if (!$employee) {
                                        return [];
                                    }
                                    $photoUrl = $employee->photo ?? null;
                                    $label = e($user->name);
                                    if ($photoUrl) {
                                        $label = '<span style="display:flex;align-items:center;">'
                                            . '<img src="' . asset('storage/' . $photoUrl) . '" alt="Foto" style="height:24px;width:24px;object-fit:cover;border-radius:50%;margin-right:8px;">'
                                            . '<span>' . $label . '</span>'
                                            . '</span>';
                                    }
                                    // Use employee id as the key
                                    return [$employee->id => $label];
                                })
                        )
                        ->searchable()
                        ->required()
                        ->allowHtml(),
                ])
                ->action(function (array $data) {
                    $user = Auth::user();

                    // Cek apakah user sudah punya antrian yang belum selesai
                    $existingQueue = \App\Models\Queue::where('user_id', $user->id)
                        ->whereNotIn('status', ['selesai', 'batal'])
                        ->first();

                    if ($existingQueue) {
                        \Filament\Notifications\Notification::make()
                            ->title('Gagal Mendaftar')
                            ->body('Anda sudah memiliki antrian yang belum selesai.')
                            ->danger()
                            ->send();
                        return;
                    }

                    $lastQueue = \App\Models\Queue::orderByDesc('nomor_antrian')->first();
                    $nextNomorAntrian = $lastQueue ? $lastQueue->nomor_antrian + 1 : 1;

                    \App\Models\Queue::create([
                        'user_id' => $user->id,
                        'barber_table_id' => null,
                        'nomor_antrian' => $nextNomorAntrian,
                        'status' => 'menunggu',
                        'is_validated' => false,
                        // Save employee id as requested_chapster_id
                        'requested_chapster_id' => $data['requested_chapster_id'],
                    ]);

                    \Filament\Notifications\Notification::make()
                        ->title('Berhasil Mendaftar')
                        ->body('Anda berhasil mendaftar antrian dengan nomor: ' . $nextNomorAntrian)
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->color('success')
                ->icon('heroicon-o-user-plus'),
        ];
    }
}
