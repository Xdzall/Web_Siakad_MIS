@extends('layouts.dosen')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Input Nilai Mahasiswa</h1>

    <div class="mb-8 bg-white p-6 rounded-lg shadow">
        <form action="{{ route('dosen.nilai') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Pilih Kelas</label>
                <select name="kelas_id" class="w-full border rounded px-3 py-2" onchange="this.form.submit()">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasYangDiampu as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if (request('kelas_id'))
                <div>
                    <label class="block text-sm font-medium mb-2">Pilih Matakuliah</label>
                    <select name="matakuliah_id" class="w-full border rounded px-3 py-2" onchange="this.form.submit()">
                        <option value="">-- Pilih Matakuliah --</option>
                        @foreach ($matakuliah as $mk)
                            <option value="{{ $mk->id }}" {{ request('matakuliah_id') == $mk->id ? 'selected' : '' }}>
                                {{ $mk->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </form>
    </div>

    @if (request('matakuliah_id') && $selectedMatakuliah)
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Input Nilai: {{ $selectedMatakuliah->nama }}</h2>
            <p class="text-sm text-gray-600">Kelas: {{ $selectedKelas->nama }}</p>
        </div>

        @if ($mahasiswa->isEmpty())
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Belum ada mahasiswa yang terdaftar dan disetujui pada mata kuliah ini.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($mahasiswa as $mhs)
                    <div id="card-{{ $mhs->id }}"
                        class="bg-white shadow rounded-lg p-4 border-l-4 {{ $mhs->nilai && $mhs->nilai->first() ? 'border-green-500' : 'border-yellow-500' }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="block text-sm text-gray-500">Mahasiswa</span>
                                <h3 class="font-semibold">{{ $mhs->name }}</h3>
                                <span class="text-sm text-gray-500">{{ $mhs->nrp }}</span>
                            </div>
                            <button onclick="openInputModal({{ $mhs->id }}, '{{ $mhs->name }}')"
                                class="text-blue-600 hover:text-blue-800">
                                <i data-lucide="edit" class="w-5 h-5"></i>
                            </button>
                        </div>

                        <div class="mt-4">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Nilai Angka:</span>
                                <span id="nilai-angka-{{ $mhs->id }}" class="font-semibold">
                                    {{ $mhs->nilai && $mhs->nilai->first() ? $mhs->nilai->first()->nilai_angka : 'Belum ada' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Nilai Huruf:</span>
                                <span id="nilai-huruf-{{ $mhs->id }}"
                                    class="font-semibold {{ $mhs->nilai && $mhs->nilai->first() ? ($mhs->nilai->first()->nilai_huruf == 'E' ? 'text-red-600' : 'text-green-600') : 'text-gray-400' }}">
                                    {{ $mhs->nilai && $mhs->nilai->first() ? $mhs->nilai->first()->nilai_huruf : 'Belum ada' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    <!-- Modal Input Nilai -->
    <div id="modal-input-nilai" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Input Nilai <span id="modal-mahasiswa-name"></span></h3>

            <form id="nilai-form">
                <input type="hidden" id="mahasiswa-id">

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Nilai (0-100)</label>
                    <input type="number" id="nilai-input" class="w-full border rounded px-3 py-2" min="0"
                        max="100" required>
                    <p class="mt-1 text-sm text-gray-500">
                        ≥ 90: A, ≥ 80: B, ≥ 70: C, ≥ 60: D, < 60: E </p>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let selectedMatakuliahId = {{ $selectedMatakuliah ? $selectedMatakuliah->id : 'null' }};

            function openInputModal(mahasiswaId, name) {
                const modal = document.getElementById('modal-input-nilai');
                document.getElementById('modal-mahasiswa-name').innerText = name;
                document.getElementById('mahasiswa-id').value = mahasiswaId;

                // Pre-fill nilai jika sudah ada
                const nilaiEl = document.getElementById('nilai-angka-' + mahasiswaId);
                const currentNilai = nilaiEl.innerText.trim();
                if (currentNilai !== 'Belum ada') {
                    document.getElementById('nilai-input').value = currentNilai;
                } else {
                    document.getElementById('nilai-input').value = '';
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeModal() {
                const modal = document.getElementById('modal-input-nilai');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            document.getElementById('nilai-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const mahasiswaId = document.getElementById('mahasiswa-id').value;
                const nilaiAngka = document.getElementById('nilai-input').value;

                // AJAX request untuk menyimpan nilai
                fetch('{{ route('dosen.nilai.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            mahasiswa_id: mahasiswaId,
                            matakuliah_id: selectedMatakuliahId,
                            nilai_angka: nilaiAngka
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update nilai di card
                            document.getElementById('nilai-angka-' + mahasiswaId).innerText = nilaiAngka;
                            document.getElementById('nilai-huruf-' + mahasiswaId).innerText = data.nilai_huruf;

                            // Update card border
                            document.getElementById('card-' + mahasiswaId).classList.remove('border-yellow-500');
                            document.getElementById('card-' + mahasiswaId).classList.add('border-green-500');

                            // Update text color
                            const nilaiHurufEl = document.getElementById('nilai-huruf-' + mahasiswaId);
                            nilaiHurufEl.classList.remove('text-gray-400');
                            if (data.nilai_huruf === 'E') {
                                nilaiHurufEl.classList.add('text-red-600');
                                nilaiHurufEl.classList.remove('text-green-600');
                            } else {
                                nilaiHurufEl.classList.add('text-green-600');
                                nilaiHurufEl.classList.remove('text-red-600');
                            }

                            closeModal();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menyimpan nilai');
                    });
            });
        </script>
    @endpush
@endsection
