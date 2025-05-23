@extends('layouts.mahasiswa')

@section('content')
<h1 class="text-2xl font-bold mb-4">Jadwal Kuliah</h1>
<p class="mb-6">Berikut adalah jadwal kuliah Anda untuk semester ini.</p>

@php
    // Urutkan hari secara manual
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

    // Pastikan setiap hari memiliki koleksi kosong jika tidak ada jadwal
    foreach ($days as $day) {
        if (!isset($grouped[$day])) {
            $grouped[$day] = collect();
        }
    }

    // Hitung jumlah maksimum jadwal pada satu hari
    $maxRows = collect($grouped)->map->count()->max();
@endphp

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 border">
        <thead>
            <tr class="bg-gray-50">
                @foreach ($days as $day)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border">
                        {{ $day }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @for ($i = 0; $i < $maxRows; $i++)
                <tr>
                    @foreach ($days as $day)
                        <td class="px-6 py-4 border">
                            @if (isset($grouped[$day][$i]))
                                <div class="bg-blue-50 p-3 rounded-lg">
                                    <div class="font-medium text-blue-900">
                                        {{ $grouped[$day][$i]['mata_kuliah'] }}
                                    </div>
                                    <div class="text-sm text-blue-700">
                                        {{ $grouped[$day][$i]['waktu'] }}
                                    </div>
                                    <div class="text-sm text-blue-600">
                                        Ruang: {{ $grouped[$day][$i]['ruang'] }}
                                    </div>
                                    <div class="text-sm text-blue-600">
                                        Dosen: {{ $grouped[$day][$i]['dosen'] }}
                                    </div>
                                </div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endfor
        </tbody>
    </table>
</div>

@if ($grouped->isEmpty() || $grouped->every(function ($item) { return $item->isEmpty(); }))
    <div class="text-center py-8">
        <p class="text-gray-500">Tidak ada jadwal kuliah yang tersedia.</p>
        <p class="text-gray-500 text-sm mt-2">Kemungkinan FRS Anda belum disetujui oleh dosen wali.</p>
    </div>
@endif
@endsection