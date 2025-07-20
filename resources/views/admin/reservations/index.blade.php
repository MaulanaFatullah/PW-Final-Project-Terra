@extends('layouts.main')

@section('title', 'Manajemen Reservasi')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Reservasi Meja</h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#createReservationModal">
                            Tambah Reservasi
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-xl" style="margin-top: 40px!important;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Pelanggan</th>
                                        <th>Jumlah Tamu</th>
                                        <th>Meja</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservations as $reservation)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}
                                            </td>
                                            <td>{{ $reservation->user->name ?? 'N/A' }}</td>
                                            <td>{{ $reservation->number_of_guests }}</td>
                                            <td>{{ $reservation->table_number ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = '';
                                                    switch ($reservation->status) {
                                                        case 'Pending':
                                                            $badgeClass = 'bg-warning text-dark';
                                                            break;
                                                        case 'Dikonfirmasi':
                                                            $badgeClass = 'bg-success';
                                                            break;
                                                        case 'Dibatalkan':
                                                            $badgeClass = 'bg-danger';
                                                            break;
                                                        case 'Selesai':
                                                            $badgeClass = 'bg-info';
                                                            break;
                                                        default:
                                                            $badgeClass = 'bg-secondary';
                                                            break;
                                                    }
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $reservation->status }}</span>
                                            </td>
                                            <td class="text-nowrap">
                                                <div class="dropdown dropup">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton-{{ $reservation->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton-{{ $reservation->id }}">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="openDetailModal({{ $reservation->id }})">Detail</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="openEditModal({{ $reservation->id }}, '{{ $reservation->reservation_date }}', '{{ $reservation->reservation_time }}', {{ $reservation->number_of_guests }}, '{{ $reservation->table_number ?? '' }}', '{{ $reservation->status }}', '{{ $reservation->notes ?? '' }}')">Ubah</a>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('reservations.destroy', $reservation->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus reservasi ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item">Hapus</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createReservationModal" tabindex="-1" aria-labelledby="createReservationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createReservationModalLabel">Tambah Reservasi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createReservationForm" method="POST" action="{{ route('reservations.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="createUser" class="form-label">Pelanggan</label>
                            <select class="form-select" id="createUser" name="user_id" required>
                                <option value="">Pilih Pelanggan</option>
                                @foreach (\App\Models\User::whereHas('role', function ($q) {
            $q->where('name', 'user');
        })->get() as $user)
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="createReservationDate" class="form-label">Tanggal Reservasi</label>
                            <input type="date" class="form-control" id="createReservationDate" name="reservation_date"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="createReservationTime" class="form-label">Waktu Reservasi</label>
                            <input type="time" class="form-control" id="createReservationTime" name="reservation_time"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="createNumberOfGuests" class="form-label">Jumlah Tamu</label>
                            <input type="number" class="form-control" id="createNumberOfGuests" name="number_of_guests"
                                min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="createTableNumber" class="form-label">Nomor Meja (Opsional)</label>
                            <input type="text" class="form-control" id="createTableNumber" name="table_number">
                        </div>
                        <div class="mb-3">
                            <label for="createStatus" class="form-label">Status</label>
                            <select class="form-select" id="createStatus" name="status" required>
                                <option value="Pending">Pending</option>
                                <option value="Dikonfirmasi">Dikonfirmasi</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="createNotes" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" id="createNotes" name="notes" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editReservationModal" tabindex="-1" aria-labelledby="editReservationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editReservationModalLabel">Edit Reservasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editReservationForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editReservationId" name="id">
                        <div class="mb-3">
                            <label for="editReservationDate" class="form-label">Tanggal Reservasi</label>
                            <input type="date" class="form-control" id="editReservationDate" name="reservation_date"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editReservationTime" class="form-label">Waktu Reservasi</label>
                            <input type="time" class="form-control" id="editReservationTime" name="reservation_time"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editNumberOfGuests" class="form-label">Jumlah Tamu</label>
                            <input type="number" class="form-control" id="editNumberOfGuests" name="number_of_guests"
                                min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTableNumber" class="form-label">Nomor Meja (Opsional)</label>
                            <input type="text" class="form-control" id="editTableNumber" name="table_number">
                        </div>
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-select" id="editStatus" name="status" required>
                                <option value="Pending">Pending</option>
                                <option value="Dikonfirmasi">Dikonfirmasi</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editNotes" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" id="editNotes" name="notes" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailReservationModal" tabindex="-1" aria-labelledby="detailReservationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailReservationModalLabel">Detail Reservasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID Reservasi:</strong> <span id="detailReservationId"></span></p>
                    <p><strong>Pelanggan:</strong> <span id="detailReservationCustomer"></span></p>
                    <p><strong>Tanggal Reservasi:</strong> <span id="detailReservationDate"></span></p>
                    <p><strong>Waktu Reservasi:</strong> <span id="detailReservationTime"></span></p>
                    <p><strong>Jumlah Tamu:</strong> <span id="detailNumberOfGuests"></span></p>
                    <p><strong>Nomor Meja:</strong> <span id="detailTableNumber"></span></p>
                    <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                    <p><strong>Catatan:</strong> <span id="detailNotes"></span></p>
                    <p><strong>Dibuat Pada:</strong> <span id="detailCreatedAt"></span></p>
                    <p><strong>Diperbarui Pada:</strong> <span id="detailUpdatedAt"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, date, time, guests, table, status, notes) {
            document.getElementById('editReservationDate').value = date;

            const formattedTime = time.substring(0, 5);
            document.getElementById('editReservationTime').value = formattedTime;
            document.getElementById('editNumberOfGuests').value = guests;
            document.getElementById('editTableNumber').value = table;
            document.getElementById('editStatus').value = status;
            document.getElementById('editNotes').value = notes;
            document.getElementById('editReservationId').value = id;
            document.getElementById('editReservationForm').action = '{{ route('reservations.update', '') }}/' +
            id;
            var myModal = new bootstrap.Modal(document.getElementById('editReservationModal'));
            myModal.show();
        }

        function openDetailModal(id) {
            fetch('{{ url('reservations') }}/' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailReservationId').textContent = data.id;
                    document.getElementById('detailReservationCustomer').textContent = data.user.name || 'N/A';
                    document.getElementById('detailReservationDate').textContent = new Date(data.reservation_date)
                        .toLocaleDateString('id-ID', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                    document.getElementById('detailReservationTime').textContent = data.reservation_time.substring(0,
                    5);
                    document.getElementById('detailNumberOfGuests').textContent = data.number_of_guests;
                    document.getElementById('detailTableNumber').textContent = data.table_number || '-';
                    document.getElementById('detailStatus').textContent = data.status;
                    document.getElementById('detailNotes').textContent = data.notes || '-';
                    document.getElementById('detailCreatedAt').textContent = new Date(data.created_at).toLocaleString(
                        'id-ID');
                    document.getElementById('detailUpdatedAt').textContent = new Date(data.updated_at).toLocaleString(
                        'id-ID');

                    var detailModal = new bootstrap.Modal(document.getElementById('detailReservationModal'));
                    detailModal.show();
                })
                .catch(error => console.error('Error fetching reservation details:', error));
        }
    </script>
@endsection
