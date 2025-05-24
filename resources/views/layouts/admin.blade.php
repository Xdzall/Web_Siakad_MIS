<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="flex min-h-screen bg-gray-100">
    <aside class="w-64 bg-[#142358] text-white p-6 flex flex-col h-full fixed">
        <div class="text-center mb-8">
            <p class="text-lg font-semibold">Admin</p>
        </div>

        <nav class="space-y-4 flex-grow">
            <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-2 py-2 px-4 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
            </a>

            <a href="{{ route('admin.mahasiswa.index') }}"
            class="flex items-center gap-2 py-2 px-4 rounded {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
                <i data-lucide="users" class="w-5 h-5"></i> Mahasiswa
            </a>

            <a href="{{ route('admin.dosen.index') }}"
            class="flex items-center gap-2 py-2 px-4 rounded {{ request()->routeIs('admin.dosen.*') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
                <i data-lucide="user-cog" class="w-5 h-5"></i> Dosen
            </a>

            <a href="{{ route('admin.matakuliah.index') }}"
            class="flex items-center gap-2 py-2 px-4 rounded {{ request()->routeIs('admin.matakuliah.*') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
                <i data-lucide="book-open" class="w-5 h-5"></i> Mata Kuliah
            </a>

            <a href="{{ route('admin.kelas.index') }}"
            class="flex items-center gap-2 py-2 px-4 rounded {{ request()->routeIs('admin.kelas.*') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
                <i data-lucide="school" class="w-5 h-5"></i> Kelas
            </a>
            
            <a href="{{ route('admin.jadwal.index') }}"
            class="flex items-center gap-2 py-2 px-4 rounded {{ request()->routeIs('admin.jadwal.*') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
                <i data-lucide="calendar" class="w-5 h-5"></i> Jadwal
            </a>

            <a href="{{ route('profile.edit') }}"
            class="flex items-center gap-2 py-2 px-4 rounded {{ request()->routeIs('profile.edit') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
                <i data-lucide="settings" class="w-5 h-5"></i> Profile
            </a>
        </nav>

        <div class="mt-auto pt-6 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="flex items-center gap-2 py-2 px-4 text-red-400 hover:bg-red-500 hover:text-white w-full text-left rounded">
                    <i data-lucide="log-out" class="w-5 h-5"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 ml-64">
        @yield('content')
    </main>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>