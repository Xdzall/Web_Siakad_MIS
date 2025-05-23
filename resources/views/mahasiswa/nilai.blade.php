@extends('layouts.mahasiswa')

@section('content')
<h1 class="text-2xl font-bold mb-4">Nilai Akademik</h1>
<p class="mb-6">Berikut ini adalah nilai mata kuliah Anda.</p>

<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Kuliah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosen</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Angka</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Huruf</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($nilai as $n)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $n->matakuliah->kode }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $n->matakuliah->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $n->matakuliah->dosen->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $n->matakuliah->sks }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $n->nilai_angka }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $n->nilai_huruf == 'A' ? 'bg-green-100 text-green-800' : 
                                   ($n->nilai_huruf == 'B' ? 'bg-blue-100 text-blue-800' : 
                                    ($n->nilai_huruf == 'C' ? 'bg-yellow-100 text-yellow-800' : 
                                     ($n->nilai_huruf == 'D' ? 'bg-orange-100 text-orange-800' : 
                                      'bg-red-100 text-red-800'))) }}">
                                {{ $n->nilai_huruf }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada nilai yang diinput oleh dosen
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-gray-50">
                    <th colspan="3" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IPK</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 tracking-wider" colspan="3">
                        {{ number_format($ipk, 2) }}
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="mt-6 bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-lg font-semibold mb-4">Keterangan Nilai</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div class="border rounded-lg p-4 bg-green-50">
            <div class="flex justify-between items-center">
                <span class="text-green-800 font-medium">A</span>
                <span class="text-green-800">Sangat Baik</span>
            </div>
            <div class="mt-2 text-sm text-green-600">Nilai: 85-100</div>
            <div class="mt-1 text-sm text-green-600">Bobot: 4.0</div>
        </div>
        
        <div class="border rounded-lg p-4 bg-blue-50">
            <div class="flex justify-between items-center">
                <span class="text-blue-800 font-medium">B</span>
                <span class="text-blue-800">Baik</span>
            </div>
            <div class="mt-2 text-sm text-blue-600">Nilai: 70-84</div>
            <div class="mt-1 text-sm text-blue-600">Bobot: 3.0</div>
        </div>
        
        <div class="border rounded-lg p-4 bg-yellow-50">
            <div class="flex justify-between items-center">
                <span class="text-yellow-800 font-medium">C</span>
                <span class="text-yellow-800">Cukup</span>
            </div>
            <div class="mt-2 text-sm text-yellow-600">Nilai: 55-69</div>
            <div class="mt-1 text-sm text-yellow-600">Bobot: 2.0</div>
        </div>
        
        <div class="border rounded-lg p-4 bg-orange-50">
            <div class="flex justify-between items-center">
                <span class="text-orange-800 font-medium">D</span>
                <span class="text-orange-800">Kurang</span>
            </div>
            <div class="mt-2 text-sm text-orange-600">Nilai: 40-54</div>
            <div class="mt-1 text-sm text-orange-600">Bobot: 1.0</div>
        </div>
        
        <div class="border rounded-lg p-4 bg-red-50">
            <div class="flex justify-between items-center">
                <span class="text-red-800 font-medium">E</span>
                <span class="text-red-800">Gagal</span>
            </div>
            <div class="mt-2 text-sm text-red-600">Nilai: 0-39</div>
            <div class="mt-1 text-sm text-red-600">Bobot: 0.0</div>
        </div>
    </div>
</div>
@endsection