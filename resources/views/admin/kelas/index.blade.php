@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Kelas</h1>
            <a href="{{ route('admin.kelas.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Tambah Kelas
            </a>
        </div>

        {{-- Add Filter Form --}}
        <div class="mb-6">
            <form action="{{ route('admin.kelas.index') }}" method="GET" class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                        <select name="semester" class="w-full border rounded px-3 py-2" onchange="this.form.submit()">
                            <option value="">Semua Semester</option>
                            @for ($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>
                                    Semester {{ $i }}
                                </option>
                            @endfor
                        </select>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            {{-- filepath: c:\laragon\www\Web_Siakad_MIS\resources\views\admin\kelas\index.blade.php --}}
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 border">Nama Kelas</th>
                        <th class="py-3 px-4 border">Semester</th>
                        <th class="py-3 px-4 border">Dosen Wali</th>
                        <th class="py-3 px-4 border">Jumlah Mahasiswa</th>
                        <th class="py-3 px-4 border">Status</th>
                        <th class="py-3 px-4 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kelas as $k)
                        <tr class="hover:bg-gray-50 {{ !$k->active ? 'bg-red-50' : '' }}">
                            <td class="py-2 px-4 border">{{ $k->nama }}</td>
                            <td class="py-2 px-4 border">Semester {{ $k->semester }}</td>
                            <td class="py-2 px-4 border">
                                {{ $k->dosen ? $k->dosen->name : '-' }}
                            </td>
                            <td class="py-2 px-4 border text-center">
                                {{ $k->mahasiswa->count() }} Mahasiswa
                            </td>
                            <td class="py-2 px-4 border">
                                @if ($k->active)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Aktif</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border text-center">
                                <a href="{{ route('admin.kelas.edit', $k->id) }}"
                                    class="text-blue-600 hover:underline">Manage Kelas</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-3 px-4 text-center text-gray-500">Tidak ada data kelas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
