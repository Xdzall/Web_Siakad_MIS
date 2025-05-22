@extends('layouts.dosen')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Entry Nilai</h1>
    <p class="mb-6">Selamat datang di sistem informasi akademik sebagai dosen.</p>

    <div class="flex justify-between items-center mb-4">
        <div class="text-xl font-semibold">Semester 2</div>
        {{-- <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Tambah Mahasiswa
        </a> --}}
    </div>

    @php
        $namaMahasiswa = [
            'M. Aldo', 'Richardous', 'Alex', 'Gabriella', 'Sinta', 'Michael',
            'Valerie', 'Dewi', 'Jonathan', 'Nadia', 'Kevin', 'Clara'
        ];

        $mahasiswa = [];
        foreach ($namaMahasiswa as $index => $nama) {
            $mahasiswa[] = [
                'id' => $index,
                'nrp' => '41240001' + $index,
                'nama' => $nama,
                'nilai' => null
            ];
        }
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($mahasiswa as $mhs)
            <div class="bg-white shadow rounded-xl p-4 space-y-2">
                <div>
                    <div class="text-sm text-gray-500">NRP</div>
                    <div class="font-bold text-lg text-gray-800">{{ $mhs['nrp'] }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-500">Nama</div>
                    <div class="font-bold text-lg text-gray-800">{{ $mhs['nama'] }}</div>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-sm text-gray-500">Nilai</div>
                        <div id="nilai-text-{{ $mhs['id'] }}"
                             class="{{ $mhs['nilai'] ? 'text-green-600' : 'text-red-500' }} font-semibold">
                            {{ $mhs['nilai'] ?? 'Belum Terisi' }}
                        </div>
                    </div>
                    <button onclick="openModal({{ $mhs['id'] }}, '{{ $mhs['nama'] }}')"
                            class="text-blue-600 hover:text-blue-800 flex items-center gap-1 text-sm">
                        <i data-lucide="edit" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-lg font-bold mb-4">Edit Nilai <span id="modal-nama" class="text-blue-600"></span></h2>
            <form id="nilai-form">
                <input type="hidden" id="mahasiswa-id">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Nilai</label>
                <select id="nilai-dropdown" class="w-full border px-3 py-2 rounded mb-4" required>
                    <option value="">-- Pilih Nilai --</option>
                    @foreach (['A', 'B', 'C', 'D', 'E'] as $nilai)
                        <option value="{{ $nilai }}">{{ $nilai }}</option>
                    @endforeach
                </select>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lucide Icon Init -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>
        lucide.createIcons();

        function openModal(id, nama) {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal-nama').innerText = '(' + nama + ')';
            document.getElementById('mahasiswa-id').value = id;
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            document.getElementById('nilai-dropdown').value = '';
        }

        document.getElementById('nilai-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('mahasiswa-id').value;
            const nilai = document.getElementById('nilai-dropdown').value;

            // Update nilai di tampilan
            const nilaiElement = document.getElementById('nilai-text-' + id);
            nilaiElement.innerText = nilai;
            nilaiElement.classList.remove('text-red-500');
            nilaiElement.classList.add('text-green-600');

            // Tutup modal
            closeModal();
        });
    </script>
@endsection
