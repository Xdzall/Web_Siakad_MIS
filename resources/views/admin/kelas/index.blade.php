@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Kelas</h1>
        <a href="{{ route('admin.kelas.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Tambah Kelas
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="py-3 px-4 border">Nama Kelas</th>
                    <th class="py-3 px-4 border">Dosen Pengampu</th>
                    <th class="py-3 px-4 border">Jumlah Mahasiswa</th>
                    <th class="py-3 px-4 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kelas as $k)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border">{{ $k->nama }}</td>
                        <td class="py-2 px-4 border">{{ $k->dosen->name ?? '-' }}</td>
                        <td class="py-2 px-4 border">{{ $k->mahasiswa->count() }}</td>
                        <td class="py-2 px-4 border text-center">
                            <a href="{{ route('admin.kelas.show', $k->id) }}" class="text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-3 px-4 text-center text-gray-500">Tidak ada data kelas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection