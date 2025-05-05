@extends('layouts.dosen')

@section('content')
    <h1 class="text-2xl font-bold mb-4">FRS Dosen</h1>
    <p class="mb-6">Selamat datang di sistem informasi akademik sebagai dosen.</p>

    <!-- FRS List -->
    <div class="space-y-4">
        @foreach([['label' => 'MW', 'jumlah' => '25 / 60'], ['label' => 'MPI', 'jumlah' => '22 / 30'], ['label' => 'MPI', 'jumlah' => '30 / 30']] as $i => $frs)
        <div class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-500">{{ $frs['label'] }}</p>
                <p class="font-bold">Praktek Kecerdasan Buatan</p>
                <p class="text-sm text-gray-500">Senin 08.00 - 09.40</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-blue-900">{{ $frs['jumlah'] }}</p>
                <button 
                    class="bg-green-100 text-green-600 rounded-full p-2 hover:bg-green-200 approve-btn"
                    data-id="btn{{ $i }}"
                    id="btn{{ $i }}"
                >
                    &#10004;
                </button>
                <p class="text-green-600 font-semibold hidden" id="approved{{ $i }}">Disetujui</p>
            </div>
        </div>
        @endforeach
    </div>

    <script>
        document.querySelectorAll('.approve-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                this.classList.add('hidden');
                document.getElementById('approved' + id.replace('btn', '')).classList.remove('hidden');
            });
        });
    </script>
@endsection
