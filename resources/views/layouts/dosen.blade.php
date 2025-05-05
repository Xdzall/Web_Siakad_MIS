<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dosen Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex min-h-screen bg-gray-100">
    <aside class="w-64 bg-[#142358] text-white p-6 space-y-8">
        <div class="text-center">
            <p class="text-lg font-semibold">Dosen</p>
        </div>
        <nav class="space-y-4">
            <a href="{{ route('dosen.dashboard') }}" class="block py-2 px-4 rounded hover:bg-[#4e81c8]">🏠 Dashboard</a>
            <a href="{{ route('dosen.jadwal') }}" class="block py-2 px-4 rounded hover:bg-[#4e81c8]">🏠 Jadwal Kuliah</a>
            <a href="{{ route('dosen.frs') }}" class="block py-2 px-4 rounded hover:bg-[#4e81c8]">📑 FRS</a>
            <a href="{{ route('dosen.nilai') }}" class="block py-2 px-4 rounded hover:bg-[#4e81c8]">📊 Nilai</a>
            <a href="#" class="block py-2 px-4 text-red-400 hover:bg-red-500 hover:text-white">⛔ Logout</a>
        </nav>
    </aside>
    <main class="flex-1 p-8">
        @yield('content')
    </main>
</body>
</html>
