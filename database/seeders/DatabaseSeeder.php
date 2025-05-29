<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Jalankan seeder operationalSeeder
        $this->call([
            lokasiSeeder::class,
        ]);

        $names = [
            'Budi Santoso',
            'Siti Aminah',
            'Agus Prabowo',
            'Dewi Lestari',
            'Rina Marlina',
            'Andi Wijaya',
            'Fitriani Putri',
            'Joko Susilo',
            'Sri Wahyuni',
            'Eko Saputra',
        ];

        $users = collect();

        foreach ($names as $name) {
            $user = User::factory()->create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '', $name)) . '@example.com',
                'password' => bcrypt('password'),
            ]);

            $users->push($user->id);
        }

        $tenant = Tenant::create([
            'name' => 'cabang utama',
            'slug' => 'cabang-utama'
        ]);

        $tenant2 = Tenant::create([
            'name' => 'cabang kedua',
            'slug' => 'cabang-kedua'
        ]);

        $tenant->users()->attach($users);
        $tenant2->users()->attach($users);

        // operational
        $hari = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        ];

        foreach ($hari as $index => $nama_hari) {
            if ($nama_hari === 'Sabtu' || $nama_hari === 'Minggu') {
                $jam_buka = '10:00:00';
                $jam_tutup = '15:00:00';
            } else {
                $jam_buka = '09:00:00';
                $jam_tutup = '18:00:00';
            }

            DB::table('operationals')->insert([
                'tenant_id' => $tenant->id,
                'day' => $nama_hari,
                'open_time' => $jam_buka,
                'close_time' => $jam_tutup,
                'is_open' => true,
            ]);
        }
    }
}