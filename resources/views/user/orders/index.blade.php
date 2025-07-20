@extends('layouts.main')

@section('title', 'Riwayat Pesanan Saya')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">Riwayat Pesanan</h1>
                </div>
                <hr class="mt-2">
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if ($orders->isEmpty())
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-bag-x display-4 text-muted"></i>
                            <h4 class="mt-3">Belum Ada Pesanan</h4>
                            <p class="text-muted">Anda belum membuat pesanan apapun</p>
                        </div>
                    </div>
                @else
                    <div class="row">
                        @foreach ($orders as $order)
                            <div class="col-lg-6 mb-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            @php
                                                $badgeClass = '';
                                                switch ($order->status) {
                                                    case 'Pending':
                                                        $badgeClass = 'bg-warning text-dark';
                                                        break;
                                                    case 'Diproses':
                                                        $badgeClass = 'bg-info text-white';
                                                        break;
                                                    case 'Selesai':
                                                        $badgeClass = 'bg-success text-white';
                                                        break;
                                                    case 'Cancelled':
                                                        $badgeClass = 'bg-danger text-white';
                                                        break;
                                                    default:
                                                        $badgeClass = 'bg-secondary text-white';
                                                        break;
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ $order->status }}
                                            </span>
                                            <span class="ms-2 text-muted small">#{{ $order->id }}</span>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton-{{ $order->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton-{{ $order->id }}">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                        onclick="openDetailOrderModal({{ $order->id }})">
                                                        <i class="bi bi-eye me-2"></i>Detail Pesanan
                                                    </a>
                                                </li>
                                                @if ($order->status === 'Pending')
                                                    <li>
                                                        <form action="{{ route('orders-user.update', $order->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="Cancelled">
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="bi bi-x-circle me-2"></i>Batalkan Pesanan
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
                                                    {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i') }}
                                                </h5>
                                                <p class="text-muted mb-0">
                                                    <i class="bi bi-basket text-primary me-2"></i>
                                                    {{ $order->order_items_count }} item
                                                </p>
                                            </div>
                                            <div class="text-end">
                                                <div class="display-5 text-success">
                                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                                </div>
                                                <small class="text-muted">Total Pembayaran</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailOrderModal" tabindex="-1" aria-labelledby="detailOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white p-3">
                    <h5 class="modal-title" id="detailOrderModalLabel">Detail Pesanan #<span
                            id="detailOrderIdHeader"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div
                                    class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center p-3 me-3">
                                    <i class="bi bi-receipt-cutoff display-5 text-primary" style="position: relative; top: -7px;left: -3px;font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Informasi Pesanan</h6>
                                    <p class="mb-0 text-muted small">ID: #<span id="detailOrderId"></span></p>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-calendar-date me-2 text-primary"></i>Tanggal</span>
                                    <span class="fw-bold" id="detailOrderDate"></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-info-circle me-2 text-primary"></i>Status</span>
                                    <span class="fw-bold"><span id="detailOrderStatus" class="badge"></span></span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div
                                    class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center p-3 me-3">
                                    <i class="bi bi-cash-coin display-5 text-success" style="position: relative; top: -5px;left: -3px;font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Pembayaran</h6>
                                    <p class="mb-0 text-muted small">Total pesanan</p>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-currency-dollar me-2 text-primary"></i>Total</span>
                                    <span class="fw-bold text-success" id="detailOrderTotalAmount"></span>
                                </li>
                                <li class="list-group-item">
                                    <p class="mb-1"><i class="bi bi-pencil me-2 text-primary"></i>Catatan</p>
                                    <p class="text-muted mb-0" id="detailOrderNotes">-</p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="d-flex align-items-center">
                            <i class="bi bi-list-check text-primary me-2"></i>
                            Item Pesanan
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Menu</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="detailOrderItemsTableBody">
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th class="text-end text-success" id="detailOrderModalTotal"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer p-3">
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
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .list-group-item {
            border-left: 0;
            border-right: 0;
        }

        .list-group-item:first-child {
            border-top: 0;
        }

        .list-group-item:last-child {
            border-bottom: 0;
        }
    </style>

    <script>
        function openDetailOrderModal(id) {
            fetch('{{ url('orders-user') }}/' + id)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('detailOrderIdHeader').textContent = data.id;
                    document.getElementById('detailOrderId').textContent = data.id;
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
                            badgeClass = 'bg-info text-white';
                            break;
                        case 'Selesai':
                            badgeClass = 'bg-success text-white';
                            break;
                        case 'Cancelled':
                            badgeClass = 'bg-danger text-white';
                            break;
                        default:
                            badgeClass = 'bg-secondary text-white';
                            break;
                    }
                    statusBadge.className = `badge ${badgeClass}`;

                    document.getElementById('detailOrderNotes').textContent = data.notes || '-';

                    const itemsTableBody = document.getElementById('detailOrderItemsTableBody');
                    itemsTableBody.innerHTML = '';
                    let totalAmount = 0;

                    if (data.order_items && data.order_items.length > 0) {
                        data.order_items.forEach(item => {
                            const subtotal = parseFloat(item.price_at_order) * item.quantity;
                            totalAmount += subtotal;

                            const row = `
                                <tr>
                                    <td>${item.menu ? item.menu.item_name : 'N/A'}</td>
                                    <td class="text-center">${item.quantity}</td>
                                    <td class="text-end">Rp ${parseFloat(item.price_at_order).toLocaleString('id-ID')}</td>
                                    <td class="text-end">Rp ${subtotal.toLocaleString('id-ID')}</td>
                                </tr>
                            `;
                            itemsTableBody.innerHTML += row;
                        });
                    } else {
                        itemsTableBody.innerHTML =
                            '<tr><td colspan="4" class="text-center text-muted">Tidak ada item dalam pesanan ini.</td></tr>';
                    }

                    document.getElementById('detailOrderModalTotal').textContent = 'Rp ' + totalAmount.toLocaleString(
                        'id-ID');

                    var detailOrderModal = new bootstrap.Modal(document.getElementById('detailOrderModal'));
                    detailOrderModal.show();
                })
                .catch(error => console.error('Error fetching order details:', error));
        }
    </script>
@endsection
