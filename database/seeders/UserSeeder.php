<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        $Mahasiswa = User::create([
            'name' => 'mahaiswa',
            'email' => 'mahasiswa@student.pens.ad.id',
            'password' => bcrypt('mahasiswa123'),
       ] );

        $Mahasiswa->assignRole('mahasiswa');

        $dosen = User::create([
            'name' => 'dosen',
            'email' => 'dosen@dosen.pens.ad.id',
            'password' => bcrypt('dosen123'),
       ] );

        $dosen->assignRole('dosen');


       
    }
}
