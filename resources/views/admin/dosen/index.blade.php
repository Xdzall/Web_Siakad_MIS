@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Data Dosen</h1>
        
        <div class="mb-4">
            <a href="" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Dosen</a>
        </div>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b">NIP</th>
                    <th class="py-2 px-4 border-b">Nama</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Action</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
@endsection