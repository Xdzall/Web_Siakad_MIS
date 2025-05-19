@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Matakuliah</h1>

        <form method="POST" action="{{ route('admin.matakuliah.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Kode Matakuliah</label>
                <input type="text" name="kode" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Matakuliah</label>
                <input type="text" name="nama" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Dosen Pengajar</label>
                <select name="dosen_id" class="w-full border rounded px-3 py-2" required>
                    <option value="" disabled selected>-- Pilih Dosen --</option>
                    <!-- Data dosen akan diisi nanti -->
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="kelas" class="w-full border rounded px-3 py-2" required>
                    <option value="" disabled selected>-- Pilih Kelas --</option>
                    <!-- Data kelas akan diisi nanti -->
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">SKS</label>
                <input type="number" name="sks" class="w-full border rounded px-3 py-2" required min="1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Jadwal</label>
                <select name="jadwal" class="w-full border rounded px-3 py-2" required>
                    <option value="" disabled selected>-- Pilih Jadwal --</option>
                    <!-- Data jadwal akan diisi nanti -->
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Ruang</label>
                <select name="ruang" class="w-full border rounded px-3 py-2" required>
                    <option value="" disabled selected>-- Pilih Ruang --</option>
                    <!-- Data ruang akan diisi nanti -->
                </select>
            </div>
            <div class="flex justify-between items-center">
                <a href="{{ route('admin.matakuliah.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
                <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
