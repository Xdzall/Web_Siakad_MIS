@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Kelas</h1>
        <form method="POST" action="{{ route('admin.kelas.update', $kelas->id) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                <input type="text" name="nama" class="w-full border rounded px-3 py-2" required
                    value="{{ old('nama', $kelas->nama) }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Dosen Wali</label>
                <select name="dosen_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Dosen Wali --</option>
                    @foreach ($dosen as $d)
                        @if ($d->is_wali)
                            <option value="{{ $d->id }}" {{ $kelas->dosen_id == $d->id ? 'selected' : '' }}>
                                {{ $d->name }} (Dosen Wali)
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Mahasiswa</label>
                <select name="mahasiswa[]" class="w-full border rounded px-3 py-2" multiple>
                    @foreach ($mahasiswa as $mhs)
                        <option value="{{ $mhs->id }}" {{ $kelas->mahasiswa->contains($mhs->id) ? 'selected' : '' }}>
                            {{ $mhs->name }} ({{ $mhs->nrp }})
                        </option>
                    @endforeach
                </select>
                <small class="text-gray-500">Tekan Ctrl (atau Cmd) untuk memilih lebih dari satu mahasiswa.</small>
            </div>
            <div class="flex justify-between items-center">
                <a href="{{ route('admin.kelas.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
                <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
