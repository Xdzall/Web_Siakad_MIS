@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Matakuliah</h1>

        <form method="POST" action="{{ route('admin.matakuliah.update', $matakuliah->id) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700">Kode Matakuliah</label>
                <input type="text" name="kode" value="{{ $matakuliah->kode }}" class="w-full border rounded px-3 py-2"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Matakuliah</label>
                <input type="text" name="nama" value="{{ $matakuliah->nama }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="kelas_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}" {{ $matakuliah->kelas_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Semester</label>
                <select name="semester" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Semester</option>
                    @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ $matakuliah->semester == $i ? 'selected' : '' }}>
                            Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Dosen Pengajar</label>
                <select name="dosen_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Dosen</option>
                    @foreach ($dosen as $d)
                        <option value="{{ $d->id }}" {{ $matakuliah->dosen_id == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">SKS</label>
                <input type="number" name="sks" value="{{ $matakuliah->sks }}"
                    class="w-full border rounded px-3 py-2" min="1" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Jadwal</label>
                <select name="jadwal_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Jadwal</option>
                    @foreach ($jadwal as $j)
                        <option value="{{ $j->id }}" {{ $matakuliah->jadwal_id == $j->id ? 'selected' : '' }}>
                            {{ $j->hari }} - {{ $j->waktu }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Ruang</label>
                <input type="text" name="ruang" value="{{ $matakuliah->ruang }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="flex justify-between items-center">
                <a href="{{ route('admin.matakuliah.index') }}"
                    class="text-sm text-gray-600 hover:underline">← Kembali</a>
                <button type="submit"
                    class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
    <script>
        // Add event listener when document is ready
        document.addEventListener('DOMContentLoaded', function() {
            const tipeSelect = document.getElementById('tipe_semester');

            // Add change event listener
            tipeSelect.addEventListener('change', function() {
                const semesterSelect = document.getElementById('semester');
                const tipe = this.value;

                // Clear current options
                semesterSelect.innerHTML = '<option value="">Pilih Semester</option>';

                // Add appropriate semester options
                if (tipe === 'ganjil') {
                    for (let i = 1; i <= 8; i += 2) {
                        semesterSelect.innerHTML += `<option value="${i}">Semester ${i}</option>`;
                    }
                } else if (tipe === 'genap') {
                    for (let i = 2; i <= 8; i += 2) {
                        semesterSelect.innerHTML += `<option value="${i}">Semester ${i}</option>`;
                    }
                }
            });
        });
    </script>

@endsection