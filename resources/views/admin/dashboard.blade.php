@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-4">Bảng điều khiển</h1>

    <div class="row">
        <!-- Bar Chart -->
        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header text-center fw-bold">Biểu đồ số lượng</div>
                <div class="card-body">
                    <canvas id="barChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header text-center fw-bold">Tỷ lệ dữ liệu</div>
                <div class="card-body">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const chartData = JSON.parse('{!! json_encode($chartData) !!}');

        // =============================== 1. BAR CHART ===============================
        new Chart(document.getElementById("barChart"), {
            type: 'bar',
            data: {
                labels: ["Phim", "Người dùng", "Đơn hàng", "Rạp", "Combo"],
                datasets: [{
                    label: "Số lượng",
                    data: [
                        chartData.movies,
                        chartData.users,
                        chartData.orders,
                        chartData.theaters,
                        chartData.combos
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom"
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // =============================== 2. PIE CHART ===============================
        new Chart(document.getElementById("pieChart"), {
            type: 'pie',
            data: {
                labels: ["Phim", "Người dùng", "Đơn hàng", "Rạp", "Combo"],
                datasets: [{
                    data: [
                        chartData.movies,
                        chartData.users,
                        chartData.orders,
                        chartData.theaters,
                        chartData.combos
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(153, 102, 255, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom"
                    }
                }
            }
        });
    </script>
@endsection
