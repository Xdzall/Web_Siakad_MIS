@extends('layouts.dosen')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Validasi FRS - {{ $kelas->nama }}</h1>
            <div class="text-sm text-gray-600">
                Total Mahasiswa: {{ $kelas->mahasiswa->count() }}
            </div>
        </div>

        {{-- Matakuliah List --}}
        <div class="grid gap-6">
            @if ($kelas->matakuliah->isNotEmpty())
                @foreach ($kelas->matakuliah as $mk)
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $mk->nama }}</h3>
                                <p class="text-sm text-gray-600">Kode: {{ $mk->kode }} | SKS: {{ $mk->sks }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-medium">Pengambil:
                                    {{ isset($frsSubmissions[$mk->id]) ? $frsSubmissions[$mk->id]->count() : 0 }} /
                                    {{ $kelas->mahasiswa->count() }}
                                </div>
                            </div>
                        </div>

                        @if (isset($frsSubmissions[$mk->id]) && $frsSubmissions[$mk->id]->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">NRP</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Nama</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Status</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($frsSubmissions[$mk->id] as $frs)
                                            <tr>
                                                <td class="px-4 py-2">{{ $frs->mahasiswa->nrp }}</td>
                                                <td class="px-4 py-2">{{ $frs->mahasiswa->name }}</td>
                                                <td class="px-4 py-2">
                                                    @if (!$frs->status)
                                                        <span class="text-yellow-600">Menunggu</span>
                                                    @elseif($frs->status === 'approved')
                                                        <span class="text-green-600">Disetujui</span>
                                                    @else
                                                        <span class="text-red-600">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2">
                                                    @if (!$frs->status)
                                                        <button onclick="openValidationModal('{{ $frs->id }}')"
                                                            class="text-blue-600 hover:underline">
                                                            Validasi
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
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
                                            Belum ada mahasiswa yang mengambil mata kuliah ini.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
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
                                Belum ada matakuliah yang terdaftar untuk kelas ini.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Validation Modal --}}
    <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Validasi FRS</h3>
            <form action="{{ route('dosen.frs.validate') }}" method="POST">
                @csrf
                <input type="hidden" name="frs_id" id="frs_id">

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Status</label>
                    <select name="status" class="w-full border rounded px-3 py-2" onchange="toggleReasonField(this.value)">
                        <option value="approved">Setujui</option>
                        <option value="rejected">Tolak</option>
                    </select>
                </div>

                <div id="reasonField" class="mb-4 hidden">
                    <label class="block text-sm font-medium mb-2">Alasan Penolakan</label>
                    <textarea name="reason" class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeValidationModal()"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
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
            function openValidationModal(frsId) {
                document.getElementById('frs_id').value = frsId;
                document.getElementById('validationModal').classList.remove('hidden');
                document.getElementById('validationModal').classList.add('flex');
            }

            function closeValidationModal() {
                document.getElementById('validationModal').classList.add('hidden');
                document.getElementById('validationModal').classList.remove('flex');
            }

            function toggleReasonField(status) {
                const reasonField = document.getElementById('reasonField');
                reasonField.classList.toggle('hidden', status === 'approved');
            }
        </script>
    @endpush
@endsection
