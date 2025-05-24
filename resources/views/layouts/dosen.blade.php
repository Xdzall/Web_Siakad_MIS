<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dosen Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>

<body class="flex min-h-screen bg-gray-100">
    <aside class="w-64 bg-[#142358] text-white p-6 flex flex-col h-full fixed">
        <div class="text-center mb-8">
            <p class="text-lg font-semibold">Dosen</p>
        </div>
        <nav class="space-y-4 flex-grow">
            <a href="{{ route('dosen.dashboard') }}"
            class="flex items-center gap-2 py-2 px-4 rounded {{ request()->routeIs('dosen.dashboard') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
                <i data-lucide="home" class="w-5 h-5"></i> Dashboard
            </a>

            <a href="{{ route('dosen.jadwal') }}"
            class="flex items-center gap-2 py-2 px-4 rounded {{ request()->routeIs('dosen.jadwal') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
                <i data-lucide="calendar-days" class="w-5 h-5"></i> Jadwal Mengajar
            </a>

            {{-- Only show FRS menu for dosen wali --}}
            @if (auth()->user()->is_wali)
            <a href="{{ route('dosen.frs') }}"
            class="flex items-center gap-2 py-2 px-4 rounded {{ request()->routeIs('dosen.frs') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
                <i data-lucide="clipboard-check" class="w-5 h-5"></i> Validasi FRS
            </a>
            @endif

            <a href="{{ route('dosen.nilai') }}"
            class="flex items-center gap-2 py-2 px-4 rounded {{ request()->routeIs('dosen.nilai') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
                <i data-lucide="file-bar-chart" class="w-5 h-5"></i> Input Nilai
            </a>

            <a href="{{ route('profile.edit') }}" 
            class="flex items-center gap-2 py-2 px-4 rounded {{ request()->routeIs('profile.edit') ? 'bg-[#4e81c8] text-white' : 'hover:bg-[#4e81c8]' }}">
                <i data-lucide="user-cog" class="w-5 h-5"></i> Profil
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