@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Data Matakuliah</h1>

        <div class="mb-4">
            <a href="{{ route('admin.matakuliah.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ Tambah Matakuliah</a>
        </div>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-3 px-4 border-b text-left">Kode</th>
                    <th class="py-3 px-4 border-b text-left">Matakuliah</th>
                    <th class="py-3 px-4 border-b text-left">Dosen Pengajar</th>
                    <th class="py-3 px-4 border-b text-center">Kelas</th>
                    <th class="py-3 px-4 border-b text-center">SKS</th>
                    <th class="py-3 px-4 border-b text-center">Jadwal</th>
                    <th class="py-3 px-4 border-b text-center">Ruang</th>
                    <th class="py-3 px-4 border-b text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($matakuliah as $mk)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $mk->kode }}</td>
                        <td class="py-2 px-4 border-b">{{ $mk->nama }}</td>
                        <td class="py-2 px-4 border-b">{{ $mk->dosen->name ?? '-' }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $mk->kelasRelasi->nama ?? '-' }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $mk->sks }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            @if ($mk->jadwalKuliah)
                                {{ $mk->jadwalKuliah->hari }} - {{ $mk->jadwalKuliah->waktu }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b text-center">{{ $mk->ruang }}</td>
                        <td class="py-2 px-4 border-b text-center space-x-2">
                            <a href="{{ route('admin.matakuliah.edit', $mk->id) }}"
                                class="inline-block text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('admin.matakuliah.destroy', $mk->id) }}" method="POST"
                                class="inline-block" onsubmit="return confirm('Yakin hapus matakuliah ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-4 text-center text-gray-500">
                            Tidak ada data matakuliah.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
