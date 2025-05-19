@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Data Dosen</h1>
            <a href="{{ route('admin.dosen.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Tambah Dosen
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th class="py-3 px-4 border">NIP</th>
                        <th class="py-3 px-4 border">Nama</th>
                        <th class="py-3 px-4 border">Email</th>
                        <th class="py-3 px-4 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dosen as $d)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border">{{ $d->nip }}</td>
                            <td class="py-2 px-4 border">{{ $d->name }}</td>
                            <td class="py-2 px-4 border">{{ $d->email }}</td>
                            <td class="py-2 px-4 border text-center">
                                <a href="{{ route('admin.dosen.edit', $d->id) }}"
                                    class="text-blue-600 hover:underline">Edit</a> |
                                <form action="{{ route('admin.dosen.destroy', $d->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin hapus dosen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:underline bg-transparent border-0 p-0 m-0 cursor-pointer">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-3 px-4 text-center text-gray-500">Tidak ada data dosen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
