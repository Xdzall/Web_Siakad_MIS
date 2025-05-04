<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
   
    public function run(): void
    {
        Permission::create(['name' => 'tambah-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'hapus-user']);
        Permission::create(['name' => 'lihat-user']);

        Permission::create(['name' => 'tambah-matakuliah']);
        Permission::create(['name' => 'edit-matakuliah']);
        Permission::create(['name' => 'hapus-matakuliah']);
        Permission::create(['name' => 'lihat-matakuliah']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'mahasiswa']);

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo(['tambah-user', 'edit-user', 'hapus-user', 'lihat-user']);

        $roleMahasiswa = Role::findByName('mahasiswa');
        $roleMahasiswa->givePermissionTo(['tambah-matakuliah', 'edit-matakuliah', 'hapus-matakuliah', 'lihat-matakuliah']);

    }
}