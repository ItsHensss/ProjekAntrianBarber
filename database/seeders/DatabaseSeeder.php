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

        // panggil shield seeder
        $this->call([
            ShieldSeeder::class,
            CustomerSeeder::class,
            queueSeeder::class,
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

        // seeder user baru
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $chapster = User::factory()->create([
            'name' => 'Chapster',
            'email' => 'chapster@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $users->push($admin->id);
        $users->push($chapster->id);


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

        // seeder lokasi
        DB::table('lokasis')->insert([
            [
                'nama_cabang' => 'Barber Sidoarjo Pahlawan',
                'alamat' => 'Jl. Pahlawan No. 1, Sidoarjo',
                'kota' => 'Sidoarjo',
                'telepon' => '031-1234567',
                'email' => 'sidoarjopahlawan@barber.com',
                'tenant_id' => $tenant->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_cabang' => 'Barber Sidoarjo Diponegoro',
                'alamat' => 'Jl. Diponegoro No. 10, Sidoarjo',
                'kota' => 'Sidoarjo',
                'telepon' => '031-2345678',
                'email' => 'sidoarjodiponegoro@barber.com',
                'tenant_id' => $tenant2->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        //seeder produk
        DB::table('produks')->insert([
            [
                'id' => 1,
                'image' => '01JWD7CAHWB24JMDY0TVQ1F14Y.jpg',
                'judul' => 'Potong',
                'harga' => 35000,
                'deskripsi' => null,
                'tenant_id' => 1,
                'created_at' => '2025-05-29 05:14:01',
                'updated_at' => '2025-05-29 05:14:01',
            ],
            [
                'id' => 2,
                'image' => '01JWD7D29ATVEZJ6S2W67VS9TQ.jpg',
                'judul' => 'Potong + Keramas',
                'harga' => 60000,
                'deskripsi' => null,
                'tenant_id' => 1,
                'created_at' => '2025-05-29 05:14:25',
                'updated_at' => '2025-05-29 05:14:25',
            ],
            [
                'id' => 3,
                'image' => '01JWD7DWQ90Q78BDP5M4MS05EZ.jpg',
                'judul' => 'Keramas',
                'harga' => 25000,
                'deskripsi' => null,
                'tenant_id' => 1,
                'created_at' => '2025-05-29 05:14:52',
                'updated_at' => '2025-05-29 05:14:52',
            ],
        ]);

        DB::table('produks')->insert([
            [
                'id' => 4,
                'image' => '01JWD7CAHWB24JMDY0TVQ1F14Y.jpg',
                'judul' => 'Potong',
                'harga' => 35000,
                'deskripsi' => null,
                'tenant_id' => 2,
                'created_at' => '2025-05-29 05:14:01',
                'updated_at' => '2025-05-29 05:14:01',
            ],
            [
                'id' => 5,
                'image' => '01JWD7D29ATVEZJ6S2W67VS9TQ.jpg',
                'judul' => 'Potong + Keramas',
                'harga' => 60000,
                'deskripsi' => null,
                'tenant_id' => 2,
                'created_at' => '2025-05-29 05:14:25',
                'updated_at' => '2025-05-29 05:14:25',
            ],
            [
                'id' => 6,
                'image' => '01JWD7DWQ90Q78BDP5M4MS05EZ.jpg',
                'judul' => 'Keramas',
                'harga' => 25000,
                'deskripsi' => null,
                'tenant_id' => 2,
                'created_at' => '2025-05-29 05:14:52',
                'updated_at' => '2025-05-29 05:14:52',
            ],
        ]);
    }
}
