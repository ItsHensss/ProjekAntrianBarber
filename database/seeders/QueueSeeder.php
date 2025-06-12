<?php

namespace Database\Seeders;

use App\Models\Queue;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class QueueSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::pluck('id')->toArray();
        $produkIds = [1, 2, 3]; // Sesuai produk di cabang utama
        $userIds = [1, 2, 3, 4, 5, 6, 7, 8, 9];

        for ($i = 1; $i <= 10000; $i++) {
            Queue::create([
                'customer_id' => Arr::random($customers),
                'produk_id' => Arr::random($produkIds),
                'tenant_id' => 1, // cabang utama
                'user_id' => Arr::random($userIds), // chapster yang melayani, bisa null
                'nomor_antrian' => $i,
                'status' => Arr::random(['menunggu', 'selesai', 'batal']),
                'is_validated' => 1,
                'booking_date' => Carbon::now()->subDays(rand(0, 30)),
            ]);
        }
    }
}