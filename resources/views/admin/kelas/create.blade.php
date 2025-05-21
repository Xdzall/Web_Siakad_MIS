@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Kelas</h1>
        <form method="POST" action="{{ route('admin.kelas.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                <input type="text" name="nama" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tipe Semester</label>
                <select name="tipe_semester" id="tipe_semester" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Tipe Semester</option>
                    <option value="ganjil">Ganjil</option>
                    <option value="genap">Genap</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Semester</label>
                <select name="semester" id="semester" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Semester</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Dosen Wali (Opsional)</label>
                <select name="dosen_id" class="w-full border rounded px-3 py-2">
                    <option value="">Tanpa Dosen Wali (Kelas Tidak Aktif)</option>
                    @foreach ($dosen as $d)
                        <option value="{{ $d->id }}">{{ $d->name }} (Dosen Wali)</option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">
                    * Kelas tanpa dosen wali akan berstatus tidak aktif
                </p>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('admin.kelas.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
                <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- Place the script at the bottom of the content section --}}
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
                    [1, 3, 5, 7].forEach(num => {
                        const option = new Option(`Semester ${num}`, num);
                        semesterSelect.add(option);
                    });
                } else if (tipe === 'genap') {
                    [2, 4, 6, 8].forEach(num => {
                        const option = new Option(`Semester ${num}`, num);
                        semesterSelect.add(option);
                    });
                }
            });
        });
    </script>
@endsection
