<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalKuliahSeeder extends Seeder
{
    public function run()
    {
        DB::table('jadwal_kuliahs')->insert([
            ['hari' => 'Senin',  'mata_kuliah' => 'Praktek Kecerdasan Buatan', 'waktu' => '08.00 - 11.20'],
            ['hari' => 'Selasa', 'mata_kuliah' => 'Flutter',                    'waktu' => '09.00 - 10.40'],
            ['hari' => 'Rabu',   'mata_kuliah' => 'Flutter',                    'waktu' => '09.00 - 10.40'],
            ['hari' => 'Kamis',  'mata_kuliah' => 'Flutter',                    'waktu' => '09.00 - 10.40'],
            ['hari' => 'Jumat',  'mata_kuliah' => 'Flutter',                    'waktu' => '09.00 - 10.40'],
            ['hari' => 'Selasa', 'mata_kuliah' => 'Pemrograman Web',           'waktu' => '10.50 - 12.30'],
            ['hari' => 'Kamis',  'mata_kuliah' => 'Algoritma dan Struktur Data','waktu' => '13.00 - 14.40'],
            ['hari' => 'Senin',  'mata_kuliah' => 'Flutter',                    'waktu' => '09.00 - 10.40'],
            ['hari' => 'Jumat',  'mata_kuliah' => 'Flutter',                    'waktu' => '09.00 - 10.40'],
        ]);
    }
}
