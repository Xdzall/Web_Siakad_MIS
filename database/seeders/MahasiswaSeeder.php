<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        $mahasiswaRole = Role::where('name', 'mahasiswa')->first();
        $kelas = Kelas::all();
        
        // Pastikan ada kelas tersedia
        if ($kelas->isEmpty()) {
            // Ambil dosen pertama sebagai wali kelas
            $dosen = User::role('dosen')->where('is_wali', true)->first();
            
            if (!$dosen) {
                // Jika tidak ada dosen, buat kelas tanpa dosen (tidak disarankan)
                $dosen_id = null;
            } else {
                $dosen_id = $dosen->id;
            }
            
            $kelas = Kelas::create([
                'nama' => 'TI-1A',
                'dosen_id' => $dosen_id,
                'active' => true,
                'semester' => 1,
                'tipe_semester' => 'ganjil'
            ]);
            $kelas = collect([$kelas]);
        }
        
        // Data dummy mahasiswa
        $mahasiswa = [
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@it.student.pens.ac.id',
                'nrp' => '3122500001',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Bintang Saputra',
                'email' => 'bintang@it.student.pens.ac.id',
                'nrp' => '3122500002',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Citra Dewi',
                'email' => 'citra@it.student.pens.ac.id',
                'nrp' => '3122500003',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Dian Kusuma',
                'email' => 'dian@it.student.pens.ac.id',
                'nrp' => '3122500004',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Eko Nugroho',
                'email' => 'eko@it.student.pens.ac.id',
                'nrp' => '3122500005',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Fajar Ramadhan',
                'email' => 'fajar@it.student.pens.ac.id',
                'nrp' => '3122500006',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Gina Safitri',
                'email' => 'gina@it.student.pens.ac.id',
                'nrp' => '3122500007',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Hadi Prasetyo',
                'email' => 'hadi@it.student.pens.ac.id',
                'nrp' => '3122500008',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Indah Permata',
                'email' => 'indah@it.student.pens.ac.id',
                'nrp' => '3122500009',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Joko Widodo',
                'email' => 'joko@it.student.pens.ac.id',
                'nrp' => '3122500010',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Kartika Sari',
                'email' => 'kartika@it.student.pens.ac.id',
                'nrp' => '3122500011',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Lukman Hakim',
                'email' => 'lukman@it.student.pens.ac.id',
                'nrp' => '3122500012',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Maya Putri',
                'email' => 'maya@it.student.pens.ac.id',
                'nrp' => '3122500013',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Naufal Hidayat',
                'email' => 'naufal@it.student.pens.ac.id',
                'nrp' => '3122500014',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Olivia Mutiara',
                'email' => 'olivia@it.student.pens.ac.id',
                'nrp' => '3122500015',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Putra Wijaya',
                'email' => 'putra@it.student.pens.ac.id',
                'nrp' => '3122500016',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Qori Amalia',
                'email' => 'qori@it.student.pens.ac.id',
                'nrp' => '3122500017',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Reza Firmansyah',
                'email' => 'reza@it.student.pens.ac.id',
                'nrp' => '3122500018',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Sinta Dewi',
                'email' => 'sinta@it.student.pens.ac.id',
                'nrp' => '3122500019',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Taufik Rahman',
                'email' => 'taufik@it.student.pens.ac.id',
                'nrp' => '3122500020',
                'semester' => 1,
                'kelas_id' => $kelas->where('semester', 1)->first()->id ?? $kelas->first()->id,
                'password' => Hash::make('password123')
            ],
        ];
        
        foreach ($mahasiswa as $data) {
            $user = User::create($data);
            $user->assignRole($mahasiswaRole);
        }
    }
}