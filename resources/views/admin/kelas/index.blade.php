@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Kelas</h1>
            <a href="{{ route('admin.kelas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Tambah Kelas
            </a>
        </div>

        {{-- Filter Semester --}}
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

        {{-- Tabel Kelas --}}
        <div class="overflow-x-auto bg-white rounded-xl shadow ring-1 ring-gray-200">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-blue-600 text-white text-xs uppercase sticky top-0 z-10">
                    <tr>
                        <th class="py-3 px-6 text-left">Nama Kelas</th>
                        <th class="py-3 px-6 text-left">Semester</th>
                        <th class="py-3 px-6 text-left">Dosen Wali</th>
                        <th class="py-3 px-6 text-center">Jumlah Mahasiswa</th>
                        <th class="py-3 px-6 text-center">Status</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($kelas as $k)
                        <tr class="hover:bg-gray-50 transition-all duration-200 {{ !$k->active ? 'bg-red-50' : '' }}">
                            <td class="py-4 px-6 whitespace-nowrap">{{ $k->nama }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">Semester {{ $k->semester }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                {{ $k->dosen ? $k->dosen->name : '-' }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $k->mahasiswa->count() }} Mahasiswa
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if ($k->active)
                                    <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('admin.kelas.edit', $k->id) }}" class="text-blue-600 hover:underline font-medium">
                                    Manage Kelas
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 px-6 text-center text-gray-500">Tidak ada data kelas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
