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
            Customer::create([
                'nama' => $faker->name,
                'nomor' => $faker->phoneNumber,
                'user_id' => null,
            ]);
        }
    }
}
