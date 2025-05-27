<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class lokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lokasis')->insert([
            [
                'nama_cabang' => 'Barber Sidoarjo Pahlawan',
                'alamat' => 'Jl. Pahlawan No. 1, Sidoarjo',
                'kota' => 'Sidoarjo',
                'telepon' => '031-1234567',
                'email' => 'sidoarjopahlawan@barber.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_cabang' => 'Barber Sidoarjo Diponegoro',
                'alamat' => 'Jl. Diponegoro No. 10, Sidoarjo',
                'kota' => 'Sidoarjo',
                'telepon' => '031-2345678',
                'email' => 'sidoarjodiponegoro@barber.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}