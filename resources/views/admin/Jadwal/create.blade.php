@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Jadwal Kuliah</h1>

        <form method="POST" action="{{ route('admin.jadwal.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
                <select name="matakuliah_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Mata Kuliah</option>
                    @foreach ($matakuliah as $mk)
                        <option value="{{ $mk->id }}">{{ $mk->kode }} - {{ $mk->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Dosen Pengajar</label>
                <select name="dosen_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Dosen</option>
                    @foreach ($dosen as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="kelas_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Hari</label>
                <select name="hari" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Hari</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Waktu</label>
                <select name="waktu" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Waktu</option>
                    <option value="08:00 - 09:40">08:00 - 09:40</option>
                    <option value="09:45 - 11:25">09:45 - 11:25</option>
                    <option value="11:30 - 13:10">11:30 - 13:10</option>
                    <option value="13:15 - 14:55">13:15 - 14:55</option>
                    <option value="15:00 - 16:40">15:00 - 16:40</option>
                    <option value="16:45 - 18:25">16:45 - 18:25</option>
                    <option value="18:30 - 20:10">18:30 - 20:10</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Ruang</label>
                <input type="text" name="ruang" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('admin.jadwal.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
                <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
