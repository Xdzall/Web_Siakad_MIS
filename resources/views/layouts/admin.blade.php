<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex min-h-screen bg-gray-100">
    <aside class="w-64 bg-[#142358] text-white p-6 flex flex-col h-screen">
        <div class="text-center mb-8">
            <p class="text-lg font-semibold">Admin</p>
        </div>
        

        <nav class="space-y-4 flex-grow">
            <a href="{{ route('admin.index') }}" 
            class="block py-2 px-4 rounded {{ request()->routeIs('admin.index') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
            🏠 Overview
            </a>
            
            <a href="{{ route('admin.mahasiswa') }}" 
            class="block py-2 px-4 rounded {{ request()->routeIs('admin.mahasiswa') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
            🧑‍🎓 Mahasiswa
            </a>
            
            <a href="{{ route('admin.dosen') }}" 
            class="block py-2 px-4 rounded {{ request()->routeIs('admin.dosen') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
            👨‍🏫 Dosen
            </a>
            
            <a href="{{ route('admin.matakuliah') }}" 
            class="block py-2 px-4 rounded {{ request()->routeIs('admin.matakuliah') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
            📚 Matakuliah
            </a>
            
            <a href="{{ route('admin.frs') }}" 
            class="block py-2 px-4 rounded {{ request()->routeIs('admin.frs') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
            📑 FRS
            </a>
        </nav>
        
        <div class="mt-auto pt-6 border-t border-gray-700">
            <a href="#" class="block py-2 px-4 rounded text-red-400 hover:bg-red-500 hover:text-white">
                ⛔ Logout
            </a>
        </div>
    </aside>
    
    <main class="flex-1 p-8 overflow-auto">
        @yield('content')
    </main>
</body>
</html>