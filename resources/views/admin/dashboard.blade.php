@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-0">Dashboard Admin</h1>
                <hr class="mt-2">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-receipt-cutoff display-4 text-primary mb-3"></i>
                        <h5 class="card-title text-muted">Total Pesanan</h5>
                        <p class="card-text fs-2 fw-bold text-dark">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-hourglass-split display-4 text-warning mb-3"></i>
                        <h5 class="card-title text-muted">Pesanan Pending</h5>
                        <p class="card-text fs-2 fw-bold text-dark">{{ $totalPendingOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-calendar-check display-4 text-success mb-3"></i>
                        <h5 class="card-title text-muted">Total Reservasi</h5>
                        <p class="card-text fs-2 fw-bold text-dark">{{ $totalReservations }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-person-circle display-4 text-info mb-3"></i>
                        <h5 class="card-title text-muted">Total Pelanggan</h5>
                        <p class="card-text fs-2 fw-bold text-dark">{{ $totalCustomers }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white p-3">
                        <h5 class="card-title mb-0">Tren Pesanan & Reservasi (6 Bulan Terakhir)</h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="monthlyActivityChart" style="max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('monthlyActivityChart').getContext('2d');
        const chartData = @json($chartData);

        const monthlyActivityChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                }
            }
        });
    </script>
@endsection
