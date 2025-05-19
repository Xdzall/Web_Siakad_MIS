@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Data Mahasiswa</h1>
            <a href="{{ route('admin.mahasiswa.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Tambah Mahasiswa
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th class="py-3 px-4 border">NRP</th>
                        <th class="py-3 px-4 border">Nama</th>
                        <th class="py-3 px-4 border">Email</th>
                        <th class="py-3 px-4 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswa as $m)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border">{{ $m->nrp }}</td>
                            <td class="py-2 px-4 border">{{ $m->name }}</td>
                            <td class="py-2 px-4 border">{{ $m->email }}</td>
                            <td class="py-2 px-4 border text-center">
                                <a href="{{ route('admin.mahasiswa.edit', $m->id) }}"
                                    class="text-blue-600 hover:underline">Edit</a> |
                                <form action="{{ route('admin.mahasiswa.destroy', $m->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin hapus mahasiswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:underline bg-transparent border-0 p-0 m-0 cursor-pointer">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-3 px-4 text-center text-gray-500">Tidak ada data Mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
