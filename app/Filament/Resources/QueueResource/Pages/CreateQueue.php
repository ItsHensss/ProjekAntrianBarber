<?php

namespace App\Filament\Resources\QueueResource\Pages;

use App\Filament\Resources\QueueResource;
use App\Models\Customer;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQueue extends CreateRecord
{
    protected static string $resource = QueueResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['is_new_customer']) && $data['is_new_customer']) {
            // Buat user baru
            $newUser = Customer::create([
                'name' => $data['name'],
                'nomor' => $data['nomor'],
            ]);

            // Ganti customer_id dengan ID dari user baru
            $data['customer_id'] = $newUser->id;
        }

        // Pastikan field name dan nomor tidak ikut dimasukkan ke table queue
        unset($data['name'], $data['nomor'], $data['is_new_customer']);

        return $data;
    }
}
