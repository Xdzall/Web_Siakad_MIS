@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Kelas: {{ $kelas->nama }}</h1>
            <a href="{{ route('admin.kelas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Kembali
            </a>
        </div>

        <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Informasi Dasar Kelas --}}
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Informasi Kelas</h2>
                    
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $kelas->nama) }}" 
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                        <select name="semester" id="semester" 
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            @for ($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ old('semester', $kelas->semester) == $i ? 'selected' : '' }}>
                                    Semester {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="tipe_semester" class="block text-sm font-medium text-gray-700 mb-1">Tipe Semester</label>
                        <select name="tipe_semester" id="tipe_semester" 
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="ganjil" {{ old('tipe_semester', $kelas->tipe_semester) == 'ganjil' ? 'selected' : '' }}>
                                Ganjil
                            </option>
                            <option value="genap" {{ old('tipe_semester', $kelas->tipe_semester) == 'genap' ? 'selected' : '' }}>
                                Genap
                            </option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="dosen_id" class="block text-sm font-medium text-gray-700 mb-1">Dosen Wali</label>
                        <select name="dosen_id" id="dosen_id" 
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Dosen Wali --</option>
                            @foreach ($dosen as $d)
                                <option value="{{ $d->id }}" {{ old('dosen_id', $kelas->dosen_id) == $d->id ? 'selected' : '' }}>
                                    {{ $d->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 mt-1">
                            Kelas tanpa dosen wali akan berstatus tidak aktif.
                        </p>
                    </div>
                    
                    <div class="mt-6">
                        <p class="text-sm font-medium text-gray-700 mb-2">Status Kelas:</p>
                        <div class="flex items-center">
                            <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                                {{ $kelas->active ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100' }}">
                                {{ $kelas->active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                            <span class="ml-2 text-xs text-gray-500">
                                (Status bergantung pada ketersediaan Dosen Wali)
                            </span>
                        </div>
                    </div>
                </div>
                
                {{-- Manajemen Mahasiswa --}}
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Manajemen Mahasiswa</h2>
                    
                    @if($kelas->active)
                        <div class="mb-4">
                            <p class="text-sm text-gray-700 mb-2">
                                Pilih mahasiswa yang akan ditambahkan ke kelas ini:
                            </p>
                            
                            <div class="max-h-96 overflow-y-auto border rounded p-2">
                                @forelse($availableMahasiswa as $mahasiswa)
                                    <div class="flex items-center py-2 border-b last:border-b-0">
                                        <input type="checkbox" name="current_mahasiswa[]" id="mahasiswa-{{ $mahasiswa->id }}" 
                                            value="{{ $mahasiswa->id }}" 
                                            {{ $mahasiswa->kelas_id == $kelas->id ? 'checked' : '' }}
                                            class="mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500">
                                        <label for="mahasiswa-{{ $mahasiswa->id }}" class="text-sm text-gray-700">
                                            {{ $mahasiswa->name }} 
                                            <span class="text-gray-500">({{ $mahasiswa->nrp }})</span>
                                            @if($mahasiswa->kelas_id == $kelas->id)
                                                <span class="ml-2 text-xs text-green-600">Saat ini di kelas ini</span>
                                            @elseif($mahasiswa->kelas_id)
                                                <span class="ml-2 text-xs text-red-600">Terdaftar di kelas lain</span>
                                            @endif
                                        </label>
                                    </div>
                                @empty
                                    <p class="py-3 text-center text-gray-500">Tidak ada mahasiswa tersedia.</p>
                                @endforelse
                            </div>
                            <input type="hidden" name="students_processed" value="1">
                        </div>
                    @else
                        <div class="p-4 bg-yellow-50 text-yellow-700 rounded">
                            <p>Kelas tidak aktif. Anda harus menentukan Dosen Wali terlebih dahulu untuk dapat menambahkan mahasiswa.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="flex justify-between mt-8">
                <a href="{{ route('admin.kelas.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    Batal
                </a>
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                    
                    {{-- Delete Button with Confirmation --}}
                    <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Hapus Kelas
                    </button>
                </div>
            </div>
        </form>
        
        {{-- Delete Form (Hidden) --}}
        <form id="delete-form" action="{{ route('admin.kelas.destroy', $kelas->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
    
    <script>
        function confirmDelete() {
            if (confirm('Apakah Anda yakin ingin menghapus kelas ini? Semua mahasiswa akan dikeluarkan dari kelas ini.')) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>
@endsection