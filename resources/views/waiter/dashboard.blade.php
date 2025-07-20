@extends('layouts.main')

@section('title', 'Dashboard Pelayan')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-0">Dashboard Pelayan</h1>
                <hr class="mt-2">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-bell display-4 text-primary mb-3"></i>
                        <h5 class="card-title text-muted">Pesanan Aktif</h5>
                        <p class="card-text fs-2 fw-bold text-dark">{{ $totalActiveOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-check2-all display-4 text-success mb-3"></i>
                        <h5 class="card-title text-muted">Pesanan Selesai Hari Ini</h5>
                        <p class="card-text fs-2 fw-bold text-dark">{{ $totalOrdersCompletedToday }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-calendar-range display-4 text-info mb-3"></i>
                        <h5 class="card-title text-muted">Reservasi Mendatang</h5>
                        <p class="card-text fs-2 fw-bold text-dark">{{ $totalUpcomingReservations }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-dark text-white p-3">
                        <h5 class="card-title mb-0">Pesanan Aktif Terbaru</h5>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-group list-group-flush">
                            @forelse($newOrders as $order)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>#{{ $order->id }} - {{ \Carbon\Carbon::parse($order->created_at)->format('H:i') }}</span>
                                    <span class="badge bg-{{ $order->status === 'Pending' ? 'warning' : 'info' }}">{{ $order->status }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted">Tidak ada pesanan aktif.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('orders-waiter.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Pesanan</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-dark text-white p-3">
                        <h5 class="card-title mb-0">Reservasi Mendatang Terbaru</h5>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-group list-group-flush">
                            @forelse($upcomingReservations as $reservation)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M') }} pukul {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}
                                        <br><small class="text-muted">Untuk {{ $reservation->number_of_guests }} tamu</small>
                                    </span>
                                    <span class="badge bg-{{ $reservation->status === 'Pending' ? 'warning' : 'success' }}">{{ $reservation->status }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted">Tidak ada reservasi mendatang.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer text-end">
                        {{-- <a href="{{ route('reservations-waiter.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Reservasi</a> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white p-3">
                        <h5 class="card-title mb-0">Distribusi Status Pesanan</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center p-4">
                        <canvas id="orderStatusPieChart" style="max-height: 300px; max-width: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const pieCtx = document.getElementById('orderStatusPieChart').getContext('2d');
        const pieChartLabels = @json($pieChartLabels);
        const pieChartData = @json($pieChartData);
        const pieChartBackgroundColors = @json($pieChartBackgroundColors);

        const orderStatusPieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieChartLabels,
                datasets: [{
                    data: pieChartData,
                    backgroundColor: pieChartBackgroundColors,
                    hoverOffset: 4
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
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed + ' pesanan';
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
