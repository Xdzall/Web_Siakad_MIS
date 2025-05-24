@extends('layouts.dosen')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Dashboard Dosen</h1>
            <div class="text-sm text-gray-600">
                {{ now()->format('l, d F Y') }}
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-2">Selamat datang, {{ Auth::user()->name }}</h2>
            <p class="text-gray-600">Berikut adalah ringkasan aktivitas akademik Anda.</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Jadwal Mengajar Card -->
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Jadwal Mengajar</p>
                        <p class="text-xl font-bold">
                            {{ App\Models\JadwalKuliah::where('dosen_id', Auth::id())->count() }}
                        </p>
                    </div>
                    <div class="rounded-full bg-blue-100 p-3">
                        <i data-lucide="calendar-days" class="h-6 w-6 text-blue-500"></i>
                    </div>
                </div>
                <a href="{{ route('dosen.jadwal') }}" class="mt-4 inline-block text-sm text-blue-600 hover:underline">
                    Lihat Jadwal
                </a>
            </div>

            <!-- Kelas Card -->
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Kelas Diampu</p>
                        <p class="text-xl font-bold">
                            {{ App\Models\JadwalKuliah::where('dosen_id', Auth::id())->distinct('kelas_id')->count('kelas_id') }}
                        </p>
                    </div>
                    <div class="rounded-full bg-green-100 p-3">
                        <i data-lucide="school" class="h-6 w-6 text-green-500"></i>
                    </div>
                </div>
                <a href="{{ route('dosen.nilai') }}" class="mt-4 inline-block text-sm text-green-600 hover:underline">
                    Input Nilai
                </a>
            </div>

            <!-- Matakuliah Card -->
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Mata Kuliah</p>
                        <p class="text-xl font-bold">
                            {{ App\Models\JadwalKuliah::where('dosen_id', Auth::id())->distinct('matakuliah_id')->count('matakuliah_id') }}
                        </p>
                    </div>
                    <div class="rounded-full bg-purple-100 p-3">
                        <i data-lucide="book-open" class="h-6 w-6 text-purple-500"></i>
                    </div>
                </div>
                <span class="mt-4 inline-block text-sm text-gray-500">
                    Total Mata Kuliah
                </span>
            </div>

            <!-- FRS Validation Card (Only for dosen wali) -->
            @if(Auth::user()->is_wali)
                <div class="bg-white rounded-lg shadow p-5 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">FRS Menunggu</p>
                            <p class="text-xl font-bold">
                                @php
                                    $kelas = App\Models\Kelas::where('dosen_id', Auth::id())->where('active', true)->first();
                                    $pendingFrs = $kelas ? App\Models\FrsSubmission::where('kelas_id', $kelas->id)
                                        ->where('status', 'pending')->count() : 0;
                                @endphp
                                {{ $pendingFrs }}
                            </p>
                        </div>
                        <div class="rounded-full bg-yellow-100 p-3">
                            <i data-lucide="clipboard-check" class="h-6 w-6 text-yellow-500"></i>
                        </div>
                    </div>
                    <a href="{{ route('dosen.frs') }}" class="mt-4 inline-block text-sm text-yellow-600 hover:underline">
                        Validasi FRS
                    </a>
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-5 border-l-4 border-indigo-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Mahasiswa</p>
                            <p class="text-xl font-bold">
                                @php
                                    $kelasIds = App\Models\JadwalKuliah::where('dosen_id', Auth::id())->pluck('kelas_id');
                                    $totalStudents = App\Models\User::whereHas('kelas', function($q) use ($kelasIds) {
                                        $q->whereIn('id', $kelasIds);
                                    })->count();
                                @endphp
                                {{ $totalStudents }}
                            </p>
                        </div>
                        <div class="rounded-full bg-indigo-100 p-3">
                            <i data-lucide="users" class="h-6 w-6 text-indigo-500"></i>
                        </div>
                    </div>
                    <span class="mt-4 inline-block text-sm text-gray-500">
                        Total Mahasiswa
                    </span>
                </div>
            @endif
        </div>

        <!-- Jadwal Hari Ini -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold">Jadwal Mengajar Hari Ini</h2>
            </div>
            <div class="p-6">
                @php
                    $today = strtolower(now()->locale('id')->dayName);
                    $dayMap = [
                        'monday' => 'Senin',
                        'tuesday' => 'Selasa',
                        'wednesday' => 'Rabu',
                        'thursday' => 'Kamis',
                        'friday' => 'Jumat',
                        'saturday' => 'Sabtu',
                        'sunday' => 'Minggu'
                    ];
                    $todayIndonesian = $dayMap[$today] ?? $today;
                    
                    $jadwalHariIni = App\Models\JadwalKuliah::where('dosen_id', Auth::id())
                        ->where('hari', $todayIndonesian)
                        ->with(['matakuliah', 'kelas'])
                        ->orderBy('waktu')
                        ->get();
                @endphp

                @if($jadwalHariIni->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Kuliah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruang</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($jadwalHariIni as $jadwal)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $jadwal->waktu }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $jadwal->matakuliah->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $jadwal->kelas->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $jadwal->ruang }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-500">Tidak ada jadwal mengajar untuk hari ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection