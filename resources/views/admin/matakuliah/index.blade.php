@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Data Matakuliah</h1>
        
        <div class="mb-4">
            <a href="{{ route('admin.matakuliah.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ Tambah Matakuliah</a>
        </div>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b">Kode</th>
                    <th class="py-2 px-4 border-b">Matakuliah</th>
                    <th class="py-2 px-4 border-b">Dosen Pengajar</th>
                    <th class="py-2 px-4 border-b">Kelas</th>
                    <th class="py-2 px-4 border-b">SKS</th>
                    <th class="py-2 px-4 border-b">Jadwal</th>
                    <th class="py-2 px-4 border-b">Ruang</th>
                    <th class="py-2 px-4 border-b">Action</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
@endsection