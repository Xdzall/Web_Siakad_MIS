@extends('layouts.dosen')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Validasi FRS - {{ $kelas->nama }}</h1>
            <div>
                <span class="text-sm text-gray-600 mr-3">Semester: <strong>{{ $kelas->semester }}</strong> ({{ $kelas->tipe_semester == 'ganjil' ? 'Ganjil' : 'Genap' }})</span>
                <span class="text-sm text-gray-600">Total Mahasiswa: {{ $kelas->mahasiswa->count() }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Daftar Mata Kuliah --}}
        <div class="grid gap-6">
            @forelse ($kelas->matakuliah as $mk)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-semibold text-lg">{{ $mk->nama }}</h3>
                            <p class="text-sm text-gray-600">Kode: {{ $mk->kode }} | SKS: {{ $mk->sks }} | Semester: {{ $mk->semester }} ({{ $mk->semester % 2 == 1 ? 'Ganjil' : 'Genap' }})</p>
                        </div>
                        <div class="text-right text-sm font-medium">
                            Pengambil:
                            {{ $frsSubmissions[$mk->id]->count() ?? 0 }} / {{ $kelas->mahasiswa->count() }}
                        </div>
                    </div>

                    @if (!empty($frsSubmissions[$mk->id]) && $frsSubmissions[$mk->id]->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">NRP</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Nama</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Status</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($frsSubmissions[$mk->id] as $frs)
                                        <tr>
                                            <td class="px-4 py-2">{{ $frs->mahasiswa->nrp }}</td>
                                            <td class="px-4 py-2">{{ $frs->mahasiswa->name }}</td>
                                            <td class="px-4 py-2">
                                                @switch($frs->status)
                                                    @case('approved')
                                                        <span class="text-green-600">Disetujui</span>
                                                    @break

                                                    @case('rejected')
                                                        <span class="text-red-600">Ditolak</span>
                                                        @if ($frs->rejection_reason)
                                                            <p class="text-xs text-red-500">{{ $frs->rejection_reason }}</p>
                                                        @endif
                                                    @break

                                                    @default
                                                        <span class="text-yellow-600">Menunggu</span>
                                                @endswitch
                                            </td>
                                            <td class="px-4 py-2">
                                                <div class="flex gap-2">
                                                    @if ($frs->status === 'pending' || $frs->status === null)
                                                        {{-- Hanya tombol Setujui --}}
                                                        <form action="{{ route('dosen.frs.validate') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="frs_id"
                                                                value="{{ $frs->id }}">
                                                            <input type="hidden" name="status" value="approved">
                                                            <button type="submit"
                                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                                                                Setujui
                                                            </button>
                                                        </form>
                                                    @elseif ($frs->status === 'approved')
                                                        {{-- Jika sudah disetujui, tampilkan tombol Tolak --}}
                                                        <form action="{{ route('dosen.frs.validate') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="frs_id"
                                                                value="{{ $frs->id }}">
                                                            <input type="hidden" name="status" value="rejected">
                                                            <input type="hidden" name="reason"
                                                                value="Dibatalkan oleh dosen">
                                                            <button type="submit"
                                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                                                Tolak
                                                            </button>
                                                        </form>
                                                    @elseif ($frs->status === 'rejected')
                                                        {{-- Jika ditolak, tampilkan tombol Setujui --}}
                                                        <form action="{{ route('dosen.frs.validate') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="frs_id"
                                                                value="{{ $frs->id }}">
                                                            <input type="hidden" name="status" value="approved">
                                                            <button type="submit"
                                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                                                                Setujui
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                            <p class="text-sm text-yellow-700">
                                Belum ada mahasiswa yang mengambil mata kuliah ini.
                            </p>
                        </div>
                    @endif
                </div>
                @empty
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                        <p class="text-sm text-yellow-700">Belum ada matakuliah yang terdaftar untuk kelas ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endsection