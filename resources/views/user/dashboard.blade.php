@extends('layouts.main')

@section('title', 'Dashboard Pelanggan')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-0">Dashboard Pelanggan</h1>
                <hr class="mt-2">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-receipt-cutoff display-4 text-primary mb-3"></i>
                        <h5 class="card-title text-muted">Total Pesanan Saya</h5>
                        <p class="card-text fs-2 fw-bold text-dark">{{ $totalMyOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-hourglass-split display-4 text-warning mb-3"></i>
                        <h5 class="card-title text-muted">Pesanan Pending Saya</h5>
                        <p class="card-text fs-2 fw-bold text-dark">{{ $totalMyPendingOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-check-circle display-4 text-success mb-3"></i>
                        <h5 class="card-title text-muted">Pesanan Selesai Saya</h5>
                        <p class="card-text fs-2 fw-bold text-dark">{{ $totalMyCompletedOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-calendar-event display-4 text-info mb-3"></i>
                        <h5 class="card-title text-muted">Total Reservasi Saya</h5>
                        <p class="card-text fs-2 fw-bold text-dark">{{ $totalMyReservations }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-calendar-minus display-4 text-danger mb-3"></i>
                        <h5 class="card-title text-muted">Reservasi Pending Saya</h5>
                        <p class="card-text fs-2 fw-bold text-dark">{{ $totalMyPendingReservations }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-currency-dollar display-4 text-success mb-3"></i>
                        <h5 class="card-title text-muted">Total Pengeluaran Saya</h5>
                        <p class="card-text fs-2 fw-bold text-dark">Rp {{ number_format($totalMySpent, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white p-3">
                        <h5 class="card-title mb-0">Tren Pengeluaran Saya (6 Bulan Terakhir)</h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="monthlySpentChart" style="max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('monthlySpentChart').getContext('2d');
        const chartData = @json($chartData);

        const monthlySpentChart = new Chart(ctx, {
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
                                return 'Rp ' + value.toLocaleString('id-ID');
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
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
