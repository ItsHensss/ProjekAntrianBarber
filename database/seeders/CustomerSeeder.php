<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 100; $i++) {
            // Buat user baru
            $user = \App\Models\User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'), // default password
            ]);

            // Buat customer dengan user_id
            Customer::create([
                'nama' => $user->name,
                'nomor' => $faker->phoneNumber,
                'user_id' => $user->id,
            ]);
        }
    }
}
