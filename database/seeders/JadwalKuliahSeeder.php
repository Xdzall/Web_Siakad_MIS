<?php

namespace Database\Seeders;

use App\Models\Matakuliah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalKuliahSeeder extends Seeder
{
    public function run()
    {
        // Buat matakuliah dummy terlebih dahulu jika belum ada
        if (Matakuliah::count() == 0) {
            $matakuliah = Matakuliah::create([
                'kode' => 'TEMP001',
                'nama' => 'Temporary Course',
                'semester' => 1,
                'sks' => 3,
            ]);
            $matakuliahId = $matakuliah->id;
        } else {
            $matakuliahId = Matakuliah::first()->id;
        }
        
        $jadwals = [
            ['hari' => 'Senin', 'waktu' => '08:00 - 09:40'],
            ['hari' => 'Senin', 'waktu' => '10:00 - 11:40'],
            ['hari' => 'Senin', 'waktu' => '13:00 - 14:40'],
            ['hari' => 'Selasa', 'waktu' => '08:00 - 09:40'],
            ['hari' => 'Selasa', 'waktu' => '10:00 - 11:40'],
            ['hari' => 'Rabu', 'waktu' => '13:00 - 14:40'],
            ['hari' => 'Kamis', 'waktu' => '08:00 - 09:40'],
            ['hari' => 'Kamis', 'waktu' => '10:00 - 11:40'],
            ['hari' => 'Jumat', 'waktu' => '13:00 - 14:40'],
        ];

        foreach ($jadwals as $jadwal) {
            DB::table('jadwal_kuliahs')->insert([
                'hari' => $jadwal['hari'],
                'waktu' => $jadwal['waktu'],
                'matakuliah_id' => $matakuliahId,  // Tambahkan ini
                'dosen_id' => 1,                   
                'kelas_id' => 1,                   
                'ruang' => 'R' . rand(101, 110),   
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}