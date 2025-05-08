@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>
        
        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded p-4 shadow">
                <h2 class="font-medium text-blue-800">Total Mahasiswa</h2>
                <p class="text-3xl font-bold text-blue-600 mt-2"></p>
            </div>
            
            <div class="bg-green-50 border-l-4 border-green-500 rounded p-4 shadow">
                <h2 class="font-medium text-green-800">Total Dosen</h2>
                <p class="text-3xl font-bold text-green-600 mt-2"></p>
            </div>
            
            <div class="bg-purple-50 border-l-4 border-purple-500 rounded p-4 shadow">
                <h2 class="font-medium text-purple-800">Matakuliah</h2>
                <p class="text-3xl font-bold text-purple-600 mt-2"></p>
            </div>
            
            <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded p-4 shadow">
                <h2 class="font-medium text-yellow-800">FRS</h2>
                <p class="text-3xl font-bold text-yellow-600 mt-2"></p>
            </div>
        </div>
    </div>
@endsection