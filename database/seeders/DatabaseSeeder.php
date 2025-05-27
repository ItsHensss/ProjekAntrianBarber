<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            operationalSeeder::class,
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

        $tenant->users()->attach($users);
    }
}