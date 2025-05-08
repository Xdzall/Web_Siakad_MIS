@extends('layouts.dosen')

@section('content')
<h1 class="text-2xl font-bold mb-4">Jadwal Dosen</h1>
<p class="mb-6">Selamat datang di sistem informasi akademik sebagai dosen.</p>

@php
    // Group by hari dan konversi ke array
    $grouped = $jadwal->groupBy('hari');

    // Urutkan hari secara manual
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

    // Pastikan setiap hari memiliki koleksi kosong jika tidak ada jadwal
    foreach ($days as $day) {
        if (!isset($grouped[$day])) {
            $grouped[$day] = collect();
        }
    }

    // Hitung jumlah maksimum jadwal pada satu hari
    $maxRows = collect($days)->map(fn($d) => $grouped[$d]->count())->max();
@endphp

<div class="overflow-x-auto">
    <table class="table-auto border-collapse w-full text-center">
        <thead>
            <tr class="bg-gray-100">
                @foreach ($days as $day)
                    <th class="border px-4 py-2">{{ $day }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < $maxRows; $i++)
                <tr>
                    @foreach ($days as $day)
                        @php
                            $item = $grouped[$day][$i] ?? null;
                        @endphp
                        <td class="border px-4 py-4 text-gray-700">
                            @if ($item)
                                {{ $item->mata_kuliah }}<br>
                                <span class="text-sm text-gray-500">{{ $item->waktu }}</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endfor
        </tbody>
    </table>
</div>
@endsection