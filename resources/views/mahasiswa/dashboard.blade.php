@extends('layouts.mahasiswa')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard Mahasiswa</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Profil</h2>
                <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:underline text-sm">Edit</a>
            </div>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">Nama</p>
                    <p class="font-medium">{{ Auth::user()->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">NRP</p>
                    <p class="font-medium">{{ Auth::user()->nrp }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium">{{ Auth::user()->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Semester</p>
                    <p class="font-medium">{{ Auth::user()->semester }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kelas</p>
                    <p class="font-medium">{{ Auth::user()->kelas ? Auth::user()->kelas->nama : '-' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">FRS</h2>
                <a href="{{ route('mahasiswa.frs') }}" class="text-blue-600 hover:underline text-sm">Lihat Detail</a>
            </div>
            @php
                $totalMatkul = \App\Models\FrsSubmission::where('mahasiswa_id', Auth::id())->count();
                $approvedMatkul = \App\Models\FrsSubmission::where('mahasiswa_id', Auth::id())
                    ->where('status', 'approved')
                    ->count();
                $pendingMatkul = \App\Models\FrsSubmission::where('mahasiswa_id', Auth::id())
                    ->where('status', 'pending')
                    ->count();
                $rejectedMatkul = \App\Models\FrsSubmission::where('mahasiswa_id', Auth::id())
                    ->where('status', 'rejected')
                    ->count();
            @endphp

            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Matakuliah:</span>
                    <span class="font-medium">{{ $totalMatkul }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Disetujui:</span>
                    <span class="text-green-600 font-medium">{{ $approvedMatkul }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Menunggu:</span>
                    <span class="text-yellow-600 font-medium">{{ $pendingMatkul }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Ditolak:</span>
                    <span class="text-red-600 font-medium">{{ $rejectedMatkul }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Nilai</h2>
                <a href="{{ route('mahasiswa.nilai') }}" class="text-blue-600 hover:underline text-sm">Lihat Detail</a>
            </div>
            @php
                $nilai = \App\Models\Nilai::where('mahasiswa_id', Auth::id())->get();
                $totalSks = 0;
                $totalBobot = 0;

                foreach ($nilai as $n) {
                    $bobot = 0;
                    switch ($n->nilai_huruf) {
                        case 'A':
                            $bobot = 4;
                            break;
                        case 'B':
                            $bobot = 3;
                            break;
                        case 'C':
                            $bobot = 2;
                            break;
                        case 'D':
                            $bobot = 1;
                            break;
                        default:
                            $bobot = 0;
                    }

                    $totalSks += $n->matakuliah->sks;
                    $totalBobot += $bobot * $n->matakuliah->sks;
                }

                $ipk = $totalSks > 0 ? $totalBobot / $totalSks : 0;
            @endphp

            <div class="flex items-center justify-center mb-4">
                <div class="text-center">
                    <p class="text-xs text-gray-500">IPK</p>
                    <p class="text-5xl font-bold text-blue-600">{{ number_format($ipk, 2) }}</p>
                </div>
            </div>

            <div class="text-center text-gray-500 text-sm">
                Total: {{ $nilai->count() }} matakuliah
            </div>
        </div>
    </div>
@endsection
