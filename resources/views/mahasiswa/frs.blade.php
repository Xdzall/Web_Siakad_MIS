@extends('layouts.mahasiswa')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Formulir Rencana Studi (FRS)</h1>
            <div class="text-sm text-gray-600">
                Semester: {{ $user->semester }}
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Pilih Matakuliah</h2>

            <form action="{{ route('mahasiswa.frs.store') }}" method="POST" class="mb-6">
                @csrf
                <div class="flex gap-4">
                    <select name="matakuliah_id" class="flex-1 border rounded px-3 py-2" required>
                        <option value="">-- Pilih Matakuliah --</option>
                        @foreach ($matakuliahList as $jadwal)
                            @if (!isset($frsSubmissions[$jadwal->matakuliah->id]))
                                <option value="{{ $jadwal->matakuliah->id }}">
                                    {{ $jadwal->matakuliah->nama }} ({{ $jadwal->matakuliah->sks }} SKS) - 
                                    {{ $jadwal->dosen->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Tambahkan
                    </button>
                </div>
            </form>

            <h3 class="font-medium text-lg mb-3">Daftar Matakuliah Terpilih</h3>

            @if ($frsSubmissions->isEmpty())
                <p class="text-gray-500 italic">Belum ada matakuliah yang dipilih</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Kode</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Matakuliah</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">SKS</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Jadwal</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Dosen</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $totalSks = 0; @endphp
                            @foreach ($frsSubmissions as $frs)
                                @php $totalSks += $frs->matakuliah->sks; @endphp
                                <tr>
                                    <td class="px-4 py-2">{{ $frs->matakuliah->kode }}</td>
                                    <td class="px-4 py-2">{{ $frs->matakuliah->nama }}</td>
                                    <td class="px-4 py-2">{{ $frs->matakuliah->sks }}</td>
                                    <td class="px-4 py-2">
                                    @if($frs->matakuliah->jadwalKuliah->count() > 0)
                                        {{ $frs->matakuliah->jadwalKuliah->first()->hari }},
                                        {{ $frs->matakuliah->jadwalKuliah->first()->waktu }}
                                    @else
                                        Tidak terjadwal
                                    @endif
                                    </td>
                                    <td class="px-4 py-2">
                                    @if($frs->matakuliah->jadwalKuliah->count() > 0)
                                        {{ $frs->matakuliah->jadwalKuliah->first()->dosen->name ?? 'Belum ditentukan' }}
                                    @else
                                        Belum ditentukan
                                    @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($frs->status === 'pending')
                                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                                                Menunggu
                                            </span>
                                        @elseif($frs->status === 'approved')
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                                Disetujui
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">
                                                Ditolak
                                            </span>
                                            @if ($frs->rejection_reason)
                                                <p class="text-xs text-red-600 mt-1">{{ $frs->rejection_reason }}</p>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($frs->status !== 'approved')
                                            <form action="{{ route('mahasiswa.frs.destroy') }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="matakuliah_id"
                                                    value="{{ $frs->matakuliah_id }}">
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-sm">Terkunci</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-50">
                                <td colspan="2" class="px-4 py-2 font-medium">Total SKS</td>
                                <td class="px-4 py-2 font-medium">{{ $totalSks }}</td>
                                <td colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>

        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        FRS yang telah disetujui tidak dapat dihapus. Hubungi Admin jika ada perubahan.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
