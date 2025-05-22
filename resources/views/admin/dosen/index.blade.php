@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Data Dosen</h1>
            <a href="{{ route('admin.dosen.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Tambah Dosen
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded-xl shadow ring-1 ring-gray-200">
    <table class="min-w-full text-sm text-left text-gray-700">
        <thead class="bg-blue-600 text-white text-xs uppercase sticky top-0 z-10">
            <tr>
                <th class="py-3 px-6 text-left">NIP</th>
                <th class="py-3 px-6 text-left">Nama</th>
                <th class="py-3 px-6 text-left">Email</th>
                <th class="py-3 px-6 text-center">Status Wali</th>
                <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($dosen as $d)
                <tr class="hover:bg-gray-50 transition-all duration-200">
                    <td class="py-4 px-6 whitespace-nowrap">{{ $d->nip }}</td>
                    <td class="py-4 px-6 whitespace-nowrap">{{ $d->name }}</td>
                    <td class="py-4 px-6 whitespace-nowrap">{{ $d->email }}</td>
                    <td class="py-4 px-6 text-center">
                        @if ($d->is_wali)
                            <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                Dosen Wali
                            </span>
                        @else
                            <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                                Dosen Biasa
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center space-x-3">
                        <a href="{{ route('admin.dosen.edit', $d->id) }}" class="text-blue-600 hover:underline font-medium">Edit</a>
                        <form action="{{ route('admin.dosen.destroy', $d->id) }}" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus dosen ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium bg-transparent border-0 p-0 m-0 cursor-pointer">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-6 px-6 text-center text-gray-500">Tidak ada data dosen.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

    </div>
@endsection
