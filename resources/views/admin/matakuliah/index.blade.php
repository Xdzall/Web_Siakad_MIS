@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Matakuliah</h1>
            <a href="{{ route('admin.matakuliah.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Tambah Matakuliah
            </a>
        </div>

        {{-- Filter Form --}}
        <div class="mb-6">
            <form action="{{ route('admin.matakuliah.index') }}" method="GET" class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select name="kelas" class="w-full border rounded px-3 py-2" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}" {{ request('kelas') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
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

        {{-- Tabel Matakuliah --}}
        <div class="overflow-x-auto bg-white rounded-xl shadow ring-1 ring-gray-200">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-blue-600 text-white text-xs uppercase sticky top-0 z-10">
                    <tr>
                        <th class="py-3 px-6 text-left">Kode</th>
                        <th class="py-3 px-6 text-left">Matakuliah</th>
                        <th class="py-3 px-6 text-left">Dosen</th>
                        <th class="py-3 px-6 text-center">SKS</th>
                        <th class="py-3 px-6 text-center">Jadwal</th>
                        <th class="py-3 px-6 text-center">Ruang</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($matakuliah as $mk)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="py-4 px-6 whitespace-nowrap">{{ $mk->kode }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">{{ $mk->nama }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">{{ $mk->dosen->name }}</td>
                            <td class="py-4 px-6 text-center">{{ $mk->sks }}</td>
                            <td class="py-4 px-6 text-center">
                                {{ $mk->jadwalKuliah->hari }} - {{ $mk->jadwalKuliah->waktu }}
                            </td>
                            <td class="py-4 px-6 text-center">{{ $mk->ruang }}</td>
                            <td class="py-4 px-6 text-center space-x-3">
                                <a href="{{ route('admin.matakuliah.edit', $mk->id) }}"
                                    class="text-blue-600 hover:underline font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('admin.matakuliah.destroy', $mk->id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Yakin hapus matakuliah ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:underline font-medium bg-transparent border-0 p-0 m-0 cursor-pointer">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 px-6 text-center text-gray-500">
                                Tidak ada data matakuliah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
