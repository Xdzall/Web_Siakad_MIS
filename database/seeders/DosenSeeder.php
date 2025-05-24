<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DosenSeeder extends Seeder
{
    public function run()
    {
        $dosenRole = Role::where('name', 'dosen')->first();
        
        $dosen = [
            [
                'name' => 'Dr. Budi Santoso, S.Kom, M.Kom',
                'email' => 'budi@it.lecturer.pens.ac.id',
                'nip' => '198501012010011001',
                'is_wali' => true,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Dr. Siti Rahayu, S.T, M.Eng',
                'email' => 'siti@it.lecturer.pens.ac.id', 
                'nip' => '198702022011012002',
                'is_wali' => true,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Prof. Ahmad Wijaya, Ph.D',
                'email' => 'ahmad@it.lecturer.pens.ac.id',
                'nip' => '197503032005011003', 
                'is_wali' => false,
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Dr. Dewi Putri, S.Kom, M.T',
                'email' => 'dewi@it.lecturer.pens.ac.id',
                'nip' => '198604042012012004',
                'is_wali' => true, 
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Rudi Hermawan, S.T, M.Kom',
                'email' => 'rudi@it.lecturer.pens.ac.id',
                'nip' => '199005052015011005',
                'is_wali' => false,
                'password' => Hash::make('password123')
            ],
        ];
        
        foreach ($dosen as $data) {
            $user = User::create($data);
            $user->assignRole($dosenRole);
        }
    }
}