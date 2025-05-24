@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Jadwal Kuliah</h1>

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-medium">Error!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <p class="font-medium">Ada kesalahan pada input:</p>
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.jadwal.update', $jadwal->id) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
                <select name="matakuliah_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Mata Kuliah</option>
                    @foreach ($matakuliah as $mk)
                        <option value="{{ $mk->id }}" {{ $jadwal->matakuliah_id == $mk->id ? 'selected' : '' }}>
                            {{ $mk->kode }} - {{ $mk->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Dosen Pengajar</label>
                <select name="dosen_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Dosen</option>
                    @foreach ($dosen as $d)
                        <option value="{{ $d->id }}" {{ $jadwal->dosen_id == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="kelas_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}" {{ $jadwal->kelas_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Hari</label>
                <select name="hari" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Hari</option>
                    <option value="Senin" {{ $jadwal->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ $jadwal->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ $jadwal->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ $jadwal->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ $jadwal->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Waktu</label>
                <select name="waktu" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Waktu</option>
                    <option value="08:00 - 09:40" {{ $jadwal->waktu == '08:00 - 09:40' ? 'selected' : '' }}>08:00 - 09:40
                    </option>
                    <option value="09:45 - 11:25" {{ $jadwal->waktu == '09:45 - 11:25' ? 'selected' : '' }}>09:45 - 11:25
                    </option>
                    <option value="11:30 - 13:10" {{ $jadwal->waktu == '11:30 - 13:10' ? 'selected' : '' }}>11:30 - 13:10
                    </option>
                    <option value="13:15 - 14:55" {{ $jadwal->waktu == '13:15 - 14:55' ? 'selected' : '' }}>13:15 - 14:55
                    </option>
                    <option value="15:00 - 16:40" {{ $jadwal->waktu == '15:00 - 16:40' ? 'selected' : '' }}>15:00 - 16:40
                    </option>
                    <option value="16:45 - 18:25" {{ $jadwal->waktu == '16:45 - 18:25' ? 'selected' : '' }}>16:45 - 18:25
                    </option>
                    <option value="18:30 - 20:10" {{ $jadwal->waktu == '18:30 - 20:10' ? 'selected' : '' }}>18:30 - 20:10
                    </option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Ruang</label>
                <input type="text" name="ruang" value="{{ $jadwal->ruang }}" class="w-full border rounded px-3 py-2"
                    required>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('admin.jadwal.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
                <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
