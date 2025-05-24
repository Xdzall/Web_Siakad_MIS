@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded p-4 shadow">
                <h2 class="font-medium text-blue-800">Total Mahasiswa</h2>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalMahasiswa }}</p>
            </div>

            <div class="bg-green-50 border-l-4 border-green-500 rounded p-4 shadow">
                <h2 class="font-medium text-green-800">Total Dosen</h2>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalDosen }}</p>
            </div>

            <div class="bg-purple-50 border-l-4 border-purple-500 rounded p-4 shadow">
                <h2 class="font-medium text-purple-800">Matakuliah</h2>
                <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalMatakuliah }}</p>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded p-4 shadow">
                <h2 class="font-medium text-yellow-800">FRS</h2>
                <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $totalFrs }}</p>
            </div>
        </div>

        <div class="mt-8">
            <div class="bg-white border rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Distribusi User</h2>
                <div class="w-full h-64">
                    <canvas id="userPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('userPieChart').getContext('2d');

        // pie chart
        const userPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($userData['labels']) !!},
                datasets: [{
                    data: {!! json_encode($userData['counts']) !!},
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
