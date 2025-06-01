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

        for ($i = 1; $i <= 5000; $i++) {
            Queue::create([
                'customer_id' => Arr::random($customers),
                'produk_id' => Arr::random($produkIds),
                'tenant_id' => 1, // cabang utama
                'nomor_antrian' => $i,
                'status' => Arr::random(['menunggu', 'selesai', 'batal']),
                'is_validated' => (bool)rand(0, 1),
                'requested_chapster_id' => Arr::random(['dani', 'umum']),
                'booking_date' => Carbon::now()->subDays(rand(0, 30)),
            ]);
        }
    }
}