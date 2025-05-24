@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Jadwal Kuliah</h1>
            <a href="{{ route('admin.jadwal.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Tambah Jadwal
            </a>
        </div>

        {{-- Filter Form --}}
        <div class="mb-6">
            <form action="{{ route('admin.jadwal.index') }}" method="GET" class="flex gap-4">
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
                    <select name="hari" class="w-full border rounded px-3 py-2" onchange="this.form.submit()">
                        <option value="">Semua Hari</option>
                        <option value="Senin" {{ request('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ request('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ request('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ request('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ request('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    </select>
                </div>
            </form>
        </div>

        {{-- Tabel Jadwal --}}
        <div class="overflow-x-auto bg-white rounded-xl shadow ring-1 ring-gray-200">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-blue-600 text-white text-xs uppercase sticky top-0 z-10">
                    <tr>
                        <th class="py-3 px-6 text-left">Matakuliah</th>
                        <th class="py-3 px-6 text-left">Dosen</th>
                        <th class="py-3 px-6 text-center">Kelas</th>
                        <th class="py-3 px-6 text-center">Hari</th>
                        <th class="py-3 px-6 text-center">Waktu</th>
                        <th class="py-3 px-6 text-center">Ruang</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($jadwal as $j)
                        <tr class="hover:bg-gray-50 transition-all duration-200">
                            <td class="py-4 px-6 whitespace-nowrap">{{ $j->matakuliah->kode }} -
                                {{ $j->matakuliah->nama ?? 'Belum ada matakuliah' }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">{{ $j->dosen->name ?? 'Belum ada dosen' }}</td>
                            <td class="py-4 px-6 text-center">{{ $j->kelas->nama ?? 'Belum ada kelas' }}</td>
                            <td class="py-4 px-6 text-center">{{ $j->hari }}</td>
                            <td class="py-4 px-6 text-center">{{ $j->waktu }}</td>
                            <td class="py-4 px-6 text-center">{{ $j->ruang }}</td>
                            <td class="py-4 px-6 text-center space-x-3">
                                <a href="{{ route('admin.jadwal.edit', $j->id) }}"
                                    class="text-blue-600 hover:underline font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('admin.jadwal.destroy', $j->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin hapus jadwal ini?')">
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
                                Tidak ada data jadwal kuliah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
