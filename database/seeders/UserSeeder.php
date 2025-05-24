<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Dosen;
use App\Models\Mahasiswa;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.pens.ac.id',
            'password' => bcrypt('admin123'),
    ] );

        $admin->assignRole('admin');

    //     $Mahasiswa = Mahasiswa::create([
    //         'name' => 'mahasiswa',
    //         'email' => 'mahasiswa@student.pens.ac.id',
    //         'password' => bcrypt('mahasiswa123'),
    //    ] );

    //     $Mahasiswa->assignRole('mahasiswa');

    //     $dosen = Dosen::create([
    //         'name' => 'dosen',
    //         'email' => 'dosen@dosen.pens.ac.id',
    //         'password' => bcrypt('dosen123'),
    //    ] );

    //     $dosen->assignRole('dosen');


    }
}
