<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Siakad MIS</title>
    <meta name="description" content="Sistem Informasi Akademik MIS PENS" />
    <link href="./output.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-50">
    <header>
        <nav style="background-color:#4169E1" class="px-4 lg:px-6 py-2.5 text-white shadow-md">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <div class="flex items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/id/4/44/Logo_PENS.png" class="mr-3 h-6 sm:h-9"
                        alt="Pens Logo" />
                    <span class="self-center text-xl font-semibold whitespace-nowrap text-white">Siakad MIS</span>
                </div>
                @if (Route::has('login'))
                    <div class="flex items-center lg:order-2">
                        @auth
                            <a href="{{ url('/MIS') }}"
                                class="font-semibold text-white hover:text-gray-200 focus:outline focus:outline-2 focus:rounded-sm focus:outline-white">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-white text-[#142358] hover:bg-gray-100 font-medium rounded-lg text-lg px-5 py-2.5 mr-2 border border-white shadow-md">
                                Log in
                            </a>
                        @endauth
                @endif
            </div>
            <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-white hover:text-gray-300 lg:p-0">Home</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-white hover:text-gray-300 lg:p-0">About</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-white hover:text-gray-300 lg:p-0">Services</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-white hover:text-gray-300 lg:p-0">FAQ</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-white hover:text-gray-300 lg:p-0">Contact</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Konten Akademik Landing Page -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Hero Section -->
        <section class="text-center mb-16">
            <h1 class="text-4xl font-bold text-[#142358] mb-4">Selamat Datang di Siakad MIS PENS</h1>
            <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                Sistem Informasi Akademik untuk mendukung kemudahan pengelolaan data perkuliahan, pengajuan KRS,
                pengumuman akademik, dan monitoring nilai mahasiswa.
            </p>
        </section>

        <!-- Program Studi -->
        <section class="mb-16">
            <h2 class="text-2xl font-semibold text-[#4169E1] mb-6">Program Studi</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white rounded-lg shadow-md border border-gray-200">
                    <h3 class="text-xl font-bold mb-2">Teknik Informatika</h3>
                    <p>Program studi yang fokus pada pengembangan perangkat lunak, jaringan komputer, dan teknologi
                        informasi.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-md border border-gray-200">
                    <h3 class="text-xl font-bold mb-2">Teknik Elektro</h3>
                    <p>Program studi yang mempelajari kelistrikan, elektronika, dan sistem kontrol.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-md border border-gray-200">
                    <h3 class="text-xl font-bold mb-2">Manajemen Bisnis</h3>
                    <p>Program studi yang mengajarkan pengelolaan bisnis, pemasaran, dan kewirausahaan.</p>
                </div>
            </div>
        </section>

        <!-- Pengumuman Akademik -->
        <section class="mb-16">
            <h2 class="text-2xl font-semibold text-[#4169E1] mb-6">Pengumuman Akademik</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>20 Mei 2025: Pendaftaran KRS semester ganjil dibuka mulai 25 Mei 2025.</li>
                <li>10 Juni 2025: Jadwal Ujian Tengah Semester dapat diakses melalui dashboard.</li>
                <li>15 Juni 2025: Pengumuman beasiswa prestasi akademik semester genap.</li>
            </ul>
        </section>

        <!-- Fitur Sistem -->
        <section class="mb-16">
            <h2 class="text-2xl font-semibold text-[#4169E1] mb-6">Fitur Utama Sistem</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-[#4169E1] text-white rounded-lg p-6 shadow-md text-center">
                    <h3 class="text-xl font-semibold mb-2">Jadwal Kuliah</h3>
                    <p>Akses jadwal perkuliahan yang terupdate sesuai program studi.</p>
                </div>
                <div class="bg-[#4169E1] text-white rounded-lg p-6 shadow-md text-center">
                    <h3 class="text-xl font-semibold mb-2">Nilai Akademik</h3>
                    <p>Melihat hasil nilai ujian dan evaluasi akademik secara transparan.</p>
                </div>
                <div class="bg-[#4169E1] text-white rounded-lg p-6 shadow-md text-center">
                    <h3 class="text-xl font-semibold mb-2">FRS Online</h3>
                    <p>Mengkonfirmasi FRS secara online.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-[#4169E1] text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold mb-4">Kontak Akademik</h2>
            <p class="mb-2">Jika ada pertanyaan atau membutuhkan bantuan, silakan hubungi kami:</p>
            <ul class="space-y-2">
                <li>Email: <a href="mailto:akademik@pens.ac.id" class="underline hover:text-gray-300">akademik@pens.ac.id</a></li>
                <li>Telepon: +62 31 5941234</li>
                <li>Alamat: Kampus PENS, Jl. Raya ITS, Surabaya</li>
            </ul>
        </div>
    </footer>

    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>
