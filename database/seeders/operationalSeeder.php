<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class operationalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
                'day' => $nama_hari,
                'open_time' => $jam_buka,
                'close_time' => $jam_tutup,
                'is_open' => true,
            ]);
        }
    }
}
