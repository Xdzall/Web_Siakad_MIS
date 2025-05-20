<?php
use Illuminate\Database\Seeder;
use App\Models\JadwalKuliah;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'Senin 08:00-09:40',
            'Senin 10:00-11:40',
            'Senin 13:00-14:40',
            'Senin 15:00-16:40',
            'Selasa 08:00-09:40',
            'Selasa 10:00-11:40',
            'Selasa 13:00-14:40',
            'Selasa 15:00-16:40',
            'Rabu 08:00-09:40',
            'Rabu 10:00-11:40',
            'Rabu 13:00-14:40',
            'Rabu 15:00-16:40',
            'Kamis 08:00-09:40',
            'Kamis 10:00-11:40',
            'Kamis 13:00-14:40',
            'Kamis 15:00-16:40',
            'Jumat 08:00-09:40',
            'Jumat 10:00-11:40',
            'Jumat 13:00-14:40',
            'Jumat 15:00-16:40',
        ];

        foreach ($data as $jadwal) {
            [$hari, $waktu] = explode(' ', $jadwal, 2);
            JadwalKuliah::create([
                'hari' => $hari,
                'waktu' => $waktu,
            ]);
        }
    }
}