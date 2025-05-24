<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Matakuliah;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
        
        if (Kelas::count() == 0) {
            $dosen = User::role('dosen')->first();
            
            if (!$dosen) {
                // Jika belum ada dosen, buat dosen baru
                $dosen = User::create([
                    'name' => 'Dosen Wali',
                    'email' => 'dosen@it.lecturer.pens.ac.id',
                    'password' => bcrypt('dosen123'),
                    'nip' => '198501012010011001',
                    'is_wali' => true
                ]);
                $dosen->assignRole('dosen');
            }
            
            // Buat kelas-kelas
            $kelasList = [
                ['nama' => 'TI-1A', 'semester' => 1, 'tipe_semester' => 'ganjil'],
                ['nama' => 'TI-1B', 'semester' => 1, 'tipe_semester' => 'ganjil'],
                ['nama' => 'TI-2A', 'semester' => 2, 'tipe_semester' => 'genap'],
                ['nama' => 'TI-2B', 'semester' => 2, 'tipe_semester' => 'genap'],
            ];
            
            foreach ($kelasList as $kelas) {
                Kelas::create([
                    'nama' => $kelas['nama'],
                    'dosen_id' => $dosen->id,
                    'active' => true,
                    'semester' => $kelas['semester'],
                    'tipe_semester' => $kelas['tipe_semester']
                ]);
            }
        }
        
        // 4. Buat matakuliah jika belum ada
        if (Matakuliah::count() == 0) {
            $matakuliahs = [
                ['kode' => 'TI1101', 'nama' => 'Algoritma Pemrograman', 'semester' => 1, 'sks' => 4],
                ['kode' => 'TI1102', 'nama' => 'Matematika Diskrit', 'semester' => 1, 'sks' => 3],
                ['kode' => 'TI1103', 'nama' => 'Sistem Digital', 'semester' => 1, 'sks' => 3],
                ['kode' => 'TI2101', 'nama' => 'Struktur Data', 'semester' => 2, 'sks' => 4],
                ['kode' => 'TI2102', 'nama' => 'Basis Data', 'semester' => 2, 'sks' => 3],
                ['kode' => 'TI2103', 'nama' => 'Pemrograman Web', 'semester' => 2, 'sks' => 3],
            ];
            
            foreach ($matakuliahs as $mk) {
                Matakuliah::create([
                    'kode' => $mk['kode'],
                    'nama' => $mk['nama'],
                    'semester' => $mk['semester'],
                    'sks' => $mk['sks']
                ]);
            }
        }
        
        // 5. Jalankan JadwalKuliahSeeder yang sudah diperbarui
        $this->call(JadwalKuliahSeeder::class);
    }
}