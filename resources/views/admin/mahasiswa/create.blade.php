@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Mahasiswa</h1>

        <form method="POST" action="{{ route('admin.mahasiswa.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">NRP</label>
                <input type="text" name="nrp" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="flex">
                    <input type="text" name="email_prefix" class="w-full border rounded px-3 py-2" required>
                    <span class="bg-gray-300 p-3 border rounded-r-lg text-gray-700">@it.student.pens.ac.id</span>
                </div>
                <input type="hidden" id="email" name="email">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Semester</label>
                <input type="number" name="semester" class="w-full border rounded px-3 py-2" min="1" max="8"
                    required>
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
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="w-full border rounded px-3 py-2 pr-10"
                        required>
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-gray-500"
                        onclick="togglePassword()">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </span>
                </div>
            </div>

            <script>
                function togglePassword() {
                    const input = document.getElementById('password');
                    const icon = document.getElementById('eyeIcon');
                    const isHidden = input.type === 'password';

                    input.type = isHidden ? 'text' : 'password';
                    icon.innerHTML = isHidden ?
                        `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                   d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 013.252-4.592m1.755-1.108A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.21 5.147M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                   d="M3 3l18 18" />` :
                        `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                   d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                   d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
                }
            </script>
            <div class="flex justify-between items-center">
                <a href="{{ route('admin.mahasiswa.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
                <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
