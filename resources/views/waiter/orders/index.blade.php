@extends('layouts.main')

@section('title', 'Kelola Pesanan Pelanggan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Pesanan</h4>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-xl">
                                <thead>
                                    <tr>
                                        <th>ID Pesanan</th>
                                        <th>Pelanggan</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i') }}</td>
                                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = '';
                                                    switch ($order->status) {
                                                        case 'Pending':
                                                            $badgeClass = 'bg-warning text-dark';
                                                            break;
                                                        case 'Diproses':
                                                            $badgeClass = 'bg-info';
                                                            break;
                                                        case 'Selesai':
                                                            $badgeClass = 'bg-success';
                                                            break;
                                                        case 'Cancelled':
                                                            $badgeClass = 'bg-danger';
                                                            break;
                                                        default:
                                                            $badgeClass = 'bg-secondary';
                                                            break;
                                                    }
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $order->status }}</span>
                                            </td>
                                            <td class="text-nowrap">
                                                <div class="dropdown dropup">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        type="button" id="dropdownMenuButton-{{ $order->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton-{{ $order->id }}">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="openDetailOrderModal({{ $order->id }})">Detail</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="openUpdateStatusModal({{ $order->id }}, '{{ $order->status }}')">Update
                                                                Status</a>
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

    <div class="modal fade" id="detailOrderModal" tabindex="-1" aria-labelledby="detailOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white p-3">
                    <h5 class="modal-title" id="detailOrderModalLabel">Detail Pesanan #<span
                            id="detailOrderIdHeader"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary">Informasi Pesanan</h6>
                            <p class="mb-1"><strong>ID Pesanan:</strong> <span id="detailOrderId"></span></p>
                            <p class="mb-1"><strong>Pelanggan:</strong> <span id="detailOrderCustomer"></span></p>
                            <p class="mb-1"><strong>Tanggal:</strong> <span id="detailOrderDate"></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Status & Catatan</h6>
                            <p class="mb-1"><strong>Status:</strong> <span id="detailOrderStatus" class="badge"></span>
                            </p>
                            <p class="mb-1"><strong>Total:</strong> <span id="detailOrderTotalAmount"
                                    class="fw-bold text-success fs-4"></span></p>
                            <p class="mb-1"><strong>Catatan Pelanggan:</strong> <span id="detailOrderNotes"></span></p>
                        </div>
                    </div>

                    <h6 class="mb-3 text-primary">Item yang Dipesan:</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Menu</th>
                                    <th>Qty</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="detailOrderItemsTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="updateStatusModalLabel">Update Status Pesanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateStatusForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="updateOrderId" name="id">
                        <div class="mb-3">
                            <label for="orderStatus" class="form-label">Status Pesanan</label>
                            <select class="form-select" id="orderStatus" name="status">
                                <option value="Pending">Pending</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Cancelled">Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDetailOrderModal(id) {
            fetch('{{ url('orders-waiter') }}/' + id)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('detailOrderIdHeader').textContent = data.id;
                    document.getElementById('detailOrderId').textContent = '#' + data.id;
                    document.getElementById('detailOrderCustomer').textContent = data.user.name || 'N/A';
                    document.getElementById('detailOrderDate').textContent = new Date(data.order_date).toLocaleString(
                        'id-ID');
                    document.getElementById('detailOrderTotalAmount').textContent = 'Rp ' + parseFloat(data
                        .total_amount).toLocaleString('id-ID');

                    const statusBadge = document.getElementById('detailOrderStatus');
                    statusBadge.textContent = data.status;
                    let badgeClass = '';
                    switch (data.status) {
                        case 'Pending':
                            badgeClass = 'bg-warning text-dark';
                            break;
                        case 'Diproses':
                            badgeClass = 'bg-info';
                            break;
                        case 'Selesai':
                            badgeClass = 'bg-success';
                            break;
                        case 'Cancelled':
                            badgeClass = 'bg-danger';
                            break;
                        default:
                            badgeClass = 'bg-secondary';
                            break;
                    }
                    statusBadge.className = `badge ${badgeClass}`;

                    document.getElementById('detailOrderNotes').textContent = data.notes || '-';

                    const itemsTableBody = document.getElementById('detailOrderItemsTableBody');
                    itemsTableBody.innerHTML = '';
                    if (data.order_items && data.order_items.length > 0) {
                        data.order_items.forEach(item => {
                            const row = `
                                <tr>
                                    <td>${item.menu ? item.menu.item_name : 'N/A'}</td>
                                    <td>${item.quantity}</td>
                                    <td>Rp ${parseFloat(item.price_at_order).toLocaleString('id-ID')}</td>
                                    <td>Rp ${(parseFloat(item.price_at_order) * item.quantity).toLocaleString('id-ID')}</td>
                                </tr>
                            `;
                            itemsTableBody.innerHTML += row;
                        });
                    } else {
                        itemsTableBody.innerHTML =
                            '<tr><td colspan="4" class="text-center text-muted">Tidak ada item dalam pesanan ini.</td></tr>';
                    }

                    var detailOrderModal = new bootstrap.Modal(document.getElementById('detailOrderModal'));
                    detailOrderModal.show();
                })
                .catch(error => console.error('Error fetching order details:', error));
        }

        function openUpdateStatusModal(id, currentStatus) {
            document.getElementById('updateOrderId').value = id;
            document.getElementById('orderStatus').value = currentStatus;
            document.getElementById('updateStatusForm').action = '{{ route('orders-waiter.update', '') }}/' + id;
            var myModal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
            myModal.show();
        }
    </script>
@endsection
