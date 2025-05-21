@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Matakuliah</h1>
        <a href="{{ route('admin.matakuliah.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
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
                    @foreach($kelas as $k)
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
                    @for($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>
                            Semester {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-3 px-4 border-b">Kode</th>
                    <th class="py-3 px-4 border-b">Matakuliah</th>
                    {{-- <th class="py-3 px-4 border-b">Kelas</th> --}}
                    {{-- <th class="py-3 px-4 border-b">Semester</th> --}}
                    <th class="py-3 px-4 border-b">Dosen</th>
                    <th class="py-3 px-4 border-b">SKS</th>
                    <th class="py-3 px-4 border-b">Jadwal</th>
                    <th class="py-3 px-4 border-b">Ruang</th>
                    <th class="py-3 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($matakuliah as $mk)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $mk->kode }}</td>
                        <td class="py-2 px-4 border-b">{{ $mk->nama }}</td>
                        {{-- <td class="py-2 px-4 border-b">{{ $mk->kelas->nama }}</td>
                        <td class="py-2 px-4 border-b">Semester {{ $mk->semester }}</td> --}}
                        <td class="py-2 px-4 border-b">{{ $mk->dosen->name }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $mk->sks }}</td>
                        <td class="py-2 px-4 border-b">{{ $mk->jadwalKuliah->hari }} - {{ $mk->jadwalKuliah->waktu }}</td>
                        <td class="py-2 px-4 border-b">{{ $mk->ruang }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <a href="{{ route('admin.matakuliah.edit', $mk->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-4 text-center text-gray-500">
                            Tidak ada data matakuliah.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection