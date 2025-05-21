@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Kelas - {{ $kelas->nama }}</h1>

        <form method="POST" action="{{ route('admin.kelas.update', $kelas->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Basic Info --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                    <input type="text" name="nama" value="{{ $kelas->nama }}" class="w-full border rounded px-3 py-2"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Semester</label>
                    <select name="semester" class="w-full border rounded px-3 py-2" required>
                        @for ($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ $kelas->semester == $i ? 'selected' : '' }}>
                                Semester {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tipe Semester</label>
                <select name="tipe_semester" class="w-full border rounded px-3 py-2" required>
                    <option value="ganjil" {{ $kelas->tipe_semester == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="genap" {{ $kelas->tipe_semester == 'genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Dosen Wali</label>
                <select name="dosen_id" class="w-full border rounded px-3 py-2">
                    <option value="">Tanpa Dosen Wali (Kelas Tidak Aktif)</option>
                    @foreach ($dosen as $d)
                        <option value="{{ $d->id }}" {{ $kelas->dosen_id == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">
                    * Menghapus dosen wali akan menonaktifkan kelas dan memindahkan semua mahasiswa
                </p>
            </div>

            @if (!$kelas->active)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
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
                                Kelas ini tidak aktif karena tidak memiliki dosen wali.
                                Mahasiswa tidak dapat ditambahkan sampai dosen wali ditugaskan.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Disable mahasiswa management if kelas not active --}}
                <div class="opacity-50 pointer-events-none">
            @endif

            {{-- Mahasiswa Management --}}
            <div class="border rounded p-4">
                <h2 class="text-lg font-semibold mb-4">Manajemen Mahasiswa</h2>
                <div class="grid grid-cols-2 gap-6">
                    {{-- Current Mahasiswa --}}
                    <div>
                        <h3 class="font-medium mb-2">Mahasiswa di Kelas ({{ $kelas->mahasiswa->count() }})</h3>
                        <select name="current_mahasiswa[]" id="current_mahasiswa" multiple
                            class="w-full border rounded px-3 py-2 h-64">
                            @foreach ($kelas->mahasiswa as $mhs)
                                <option value="{{ $mhs->id }}">{{ $mhs->name }} ({{ $mhs->nrp }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Available Mahasiswa --}}
                    <div>
                        <h3 class="font-medium mb-2">Mahasiswa Tersedia</h3>
                        <select name="available_mahasiswa[]" id="available_mahasiswa" multiple
                            class="w-full border rounded px-3 py-2 h-64">
                            @foreach ($availableMahasiswa->whereNotIn('id', $kelas->mahasiswa->pluck('id')) as $mhs)
                                <option value="{{ $mhs->id }}">{{ $mhs->name }} ({{ $mhs->nrp }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Control Buttons --}}
                <div class="flex justify-center gap-4 mt-4">
                    <button type="button" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                        onclick="moveSelectedOptions('available_mahasiswa', 'current_mahasiswa')">
                        ← Tambah ke Kelas
                    </button>
                    <button type="button" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
                        onclick="moveSelectedOptions('current_mahasiswa', 'available_mahasiswa')">
                        Keluarkan dari Kelas →
                    </button>
                </div>
            </div>

            @if (!$kelas->active)
    </div>
    @endif

    <div class="flex justify-between">
        <a href="{{ route('admin.kelas.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Simpan Perubahan
        </button>
    </div>
    </form>
    </div>

    @push('scripts')
        <script>
            function moveSelectedOptions(fromId, toId) {
                const fromSelect = document.getElementById(fromId);
                const toSelect = document.getElementById(toId);

                // Get all selected options
                const selectedOptions = Array.from(fromSelect.selectedOptions);

                if (selectedOptions.length === 0) {
                    alert('Pilih mahasiswa terlebih dahulu');
                    return;
                }

                // Move each selected option
                selectedOptions.forEach(option => {
                    // Create new option in target select
                    const newOption = new Option(option.text, option.value);
                    toSelect.add(newOption);
                    // Remove from source select
                    fromSelect.remove(option.index);
                });
            }

            // Select all options in current_mahasiswa before form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                const currentMahasiswa = document.getElementById('current_mahasiswa');
                if (currentMahasiswa.options.length === 0) {
                    e.preventDefault();
                    alert('Kelas harus memiliki minimal 1 mahasiswa');
                    return;
                }
                Array.from(currentMahasiswa.options).forEach(option => {
                    option.selected = true;
                });
            });
        </script>
    @endpush
@endsection
