@extends('layouts.dosen')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard Dosen</h1>
    <p class="mb-6">Selamat datang di sistem informasi akademik sebagai dosen.</p>

    <div class="text-xl font-semibold mb-4">Semester 2</div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @for ($i = 0; $i < 12; $i++)
            <div class="bg-white shadow rounded-xl p-4">
                <div class="text-sm text-gray-500">NRP</div>
                <div class="flex justify-between items-center">
                    <div class="font-bold text-lg text-gray-800 mb-2">Nama</div>
                    <div class="text-lg text-gray-800">Edit Nilai</div>
                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-sm text-gray-500">Nilai</div>
                        <div class="text-red-500 font-semibold">Belum Terisi</div>
                    </div>
                    <button class="text-blue-600 hover:text-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endfor
    </div>
@endsection
