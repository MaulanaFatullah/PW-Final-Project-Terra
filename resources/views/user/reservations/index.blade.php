@extends('layouts.main')

@section('title', 'Daftar Reservasi Saya')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">Reservasi Saya</h1>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#createReservationModal">
                        <i class="bi bi-plus-circle"></i> Buat Reservasi Baru
                    </button>
                </div>
                <hr class="mt-2">
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if($reservations->isEmpty())
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-calendar-x display-4 text-muted"></i>
                            <h4 class="mt-3">Belum Ada Reservasi</h4>
                            <p class="text-muted">Anda belum memiliki reservasi apapun</p>
                            <button type="button" class="btn btn-success mt-2" data-bs-toggle="modal"
                                data-bs-target="#createReservationModal">
                                <i class="bi bi-plus-circle"></i> Buat Reservasi Pertama
                            </button>
                        </div>
                    </div>
                @else
                    <div class="row">
                        @foreach ($reservations as $reservation)
                            <div class="col-lg-6 mb-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-{{ $reservation->status === 'Pending' ? 'warning' : ($reservation->status === 'Dikonfirmasi' ? 'success' : 'secondary') }} text-white">
                                                {{ $reservation->status }}
                                            </span>
                                            <span class="ms-2 text-muted small">#{{ $reservation->id }}</span>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton-{{ $reservation->id }}"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton-{{ $reservation->id }}">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                        onclick="openDetailReservationModal({{ $reservation->id }})">
                                                        <i class="bi bi-eye me-2"></i>Detail
                                                    </a>
                                                </li>
                                                @if ($reservation->status === 'Pending')
                                                    <li>
                                                        <form
                                                            action="{{ route('reservations-user.update', $reservation->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="Cancelled">
                                                            <button type="submit"
                                                                class="dropdown-item text-danger">
                                                                <i class="bi bi-x-circle me-2"></i>Batalkan
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center h-100 mb-3">
                                            <div>
                                                <h5 class="mb-1">
                                                    <i class="bi bi-calendar-date text-primary me-2"></i>
                                                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }}
                                                </h5>
                                                <p class="text-muted mb-0">
                                                    <i class="bi bi-clock text-primary me-2"></i>
                                                    {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }} WIB
                                                </p>
                                            </div>
                                            <div class="text-end">
                                                <div class="display-5 text-primary">
                                                    {{ $reservation->number_of_guests }}
                                                </div>
                                                <small class="text-muted">Jumlah Tamu</small>
                                            </div>
                                        </div>
                                        @if($reservation->table_number)
                                            <div class="alert alert-success py-2 mb-0">
                                                <i class="bi bi-check-circle-fill me-2"></i>
                                                Meja #{{ $reservation->table_number }} telah dipesan
                                            </div>
                                        @elseif($reservation->status === 'Dikonfirmasi')
                                            <div class="alert alert-info py-2 mb-0">
                                                <i class="bi bi-info-circle-fill me-2"></i>
                                                Nomor meja akan diberikan saat kedatangan
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="createReservationModal" tabindex="-1" aria-labelledby="createReservationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createReservationModalLabel">Buat Reservasi Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createReservationForm" method="POST" action="{{ route('reservations-user.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="createReservationDate" class="form-label">
                                <i class="bi bi-calendar me-1"></i> Tanggal Reservasi
                            </label>
                            <input type="date" class="form-control" id="createReservationDate" name="reservation_date"
                                required min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label for="createReservationTime" class="form-label">
                                <i class="bi bi-clock me-1"></i> Waktu Reservasi
                            </label>
                            <input type="time" class="form-control" id="createReservationTime" name="reservation_time"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="createNumberOfGuests" class="form-label">
                                <i class="bi bi-people me-1"></i> Jumlah Tamu
                            </label>
                            <input type="number" class="form-control" id="createNumberOfGuests" name="number_of_guests"
                                min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="createReservationNotes" class="form-label">
                                <i class="bi bi-pencil me-1"></i> Catatan Tambahan
                            </label>
                            <textarea class="form-control" id="createReservationNotes" name="notes" rows="3" placeholder="Contoh: Meja dekat jendela, alergi makanan tertentu, dll."></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Konfirmasi Reservasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailReservationModal" tabindex="-1" aria-labelledby="detailReservationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="detailReservationModalLabel">Detail Reservasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4 text-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center p-4 mb-3">
                            <i class="bi bi-calendar-check display-4 text-primary" style="font-size: 2rem; position: relative; top: -12px;left: -7px;"></i>
                        </div>
                        <h4 class="mb-1">Reservasi #<span id="detailReservationId"></span></h4>
                        <span class="badge bg-success" id="detailReservationStatus"></span>
                    </div>

                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-calendar-date me-2 text-primary"></i>Tanggal</span>
                            <span class="fw-bold" id="detailReservationDate"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-clock me-2 text-primary"></i>Waktu</span>
                            <span class="fw-bold" id="detailReservationTime"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-people me-2 text-primary"></i>Jumlah Tamu</span>
                            <span class="fw-bold" id="detailReservationNumberOfGuests"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-table me-2 text-primary"></i>Nomor Meja</span>
                            <span class="fw-bold" id="detailReservationTableNumber">-</span>
                        </li>
                        <li class="list-group-item">
                            <p class="mb-1"><i class="bi bi-pencil me-2 text-primary"></i>Catatan</p>
                            <p class="text-muted mb-0" id="detailReservationNotes">-</p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-clock-history me-2 text-primary"></i>Dibuat Pada</span>
                            <span class="text-muted small" id="detailReservationCreatedAt"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-arrow-repeat me-2 text-primary"></i>Diperbarui Pada</span>
                            <span class="text-muted small" id="detailReservationUpdatedAt"></span>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 10px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .badge {
            font-weight: 500;
            letter-spacing: 0.5px;
        }
    </style>

    <script>
        function openDetailReservationModal(id) {
            fetch('{{ url('reservations-user') }}/' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailReservationId').textContent = data.id;
                    document.getElementById('detailReservationDate').textContent = new Date(data.reservation_date)
                        .toLocaleDateString('id-ID', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                    document.getElementById('detailReservationTime').textContent = data.reservation_time.substring(0, 5) + ' WIB';
                    document.getElementById('detailReservationNumberOfGuests').textContent = data.number_of_guests;
                    document.getElementById('detailReservationTableNumber').textContent = data.table_number || '-';

                    const statusBadge = document.getElementById('detailReservationStatus');
                    statusBadge.textContent = data.status;
                    statusBadge.className = 'badge bg-' +
                        (data.status === 'Pending' ? 'warning' :
                         data.status === 'Dikonfirmasi' ? 'success' : 'secondary');

                    document.getElementById('detailReservationNotes').textContent = data.notes || '-';
                    document.getElementById('detailReservationCreatedAt').textContent = new Date(data.created_at)
                        .toLocaleString('id-ID');
                    document.getElementById('detailReservationUpdatedAt').textContent = new Date(data.updated_at)
                        .toLocaleString('id-ID');

                    var detailReservationModal = new bootstrap.Modal(document.getElementById('detailReservationModal'));
                    detailReservationModal.show();
                })
                .catch(error => console.error('Error fetching reservation details:', error));
        }
    </script>
@endsection
