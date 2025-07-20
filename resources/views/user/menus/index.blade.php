@extends('layouts.main')

@section('title', 'Daftar Menu Restoran')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">Menu Restoran</h1>
                    <button class="btn btn-primary position-relative" onclick="updateCartModal()">
                        <i class="bi bi-cart-fill"></i> Lihat Pesanan
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            id="cartBadge">
                            0
                            <span class="visually-hidden">items in cart</span>
                        </span>
                    </button>
                </div>
                <hr class="mt-2">
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="btn-group flex-wrap" role="group">
                    <button type="button" class="btn btn-outline-primary filter-btn active"
                        data-category="all">Semua</button>
                    @foreach ($categories as $category)
                        <button type="button" class="btn btn-outline-primary filter-btn"
                            data-category="{{ Str::slug($category) }}">{{ $category }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row" id="menuContainer">
            @foreach ($menus as $menu)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4 menu-card" data-category="{{ Str::slug($menu->category) }}">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-img-top position-relative overflow-hidden"
                            style="height: 180px; background-color: #f8f9fa;">
                            @if ($menu->image_url)
                                <img src="{{ $menu->image_url }}" class="img-fluid h-100 w-100 object-fit-cover"
                                    alt="{{ $menu->item_name }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <i class="bi bi-image-fill display-4 text-muted"></i>
                                </div>
                            @endif
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-{{ $menu->is_available ? 'success' : 'danger' }}">
                                    {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column p-3">
                            <span class="badge bg-secondary text-white mb-2">{{ $menu->category }}</span>
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0 me-2 text-dark">{{ $menu->item_name }}</h5>
                                <span class="text-primary fw-bold fs-5">Rp
                                    {{ number_format($menu->price, 0, ',', '.') }}</span>
                            </div>
                            <p class="card-text text-muted small flex-grow-1 mb-3">
                                {{ Str::limit($menu->description, 80, '...') }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                <div>
                                    <button class="btn btn-sm btn-outline-info me-1"
                                        onclick="openDetailMenuModal({{ $menu->id }})">
                                        <i class="bi bi-info-circle"></i>
                                    </button>
                                    @if ($menu->is_available)
                                        <button class="btn btn-sm btn-primary"
                                            onclick="addToCart({{ $menu->id }}, '{{ $menu->item_name }}', {{ $menu->price }})">
                                            <i class="bi bi-cart-plus"></i> Pesan
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>
                                            <i class="bi bi-slash-circle"></i> Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="detailMenuModal" tabindex="-1" aria-labelledby="detailMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="detailMenuModalLabel">Detail Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-4">
                        <img id="detailMenuImage" src="" class="img-fluid rounded shadow-sm"
                            style="max-height: 200px; object-fit: cover;" alt="Menu Image">
                    </div>
                    <div class="mb-3">
                        <h4 class="text-center" id="detailMenuItemName"></h4>
                    </div>
                    <div class="mb-3">
                        <p class="text-muted" id="detailMenuDescription"></p>
                    </div>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Harga</span>
                            <span class="fw-bold text-primary fs-5" id="detailMenuPrice"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Kategori</span>
                            <span class="badge bg-secondary text-white fs-6" id="detailMenuCategory"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Status</span>
                            <span class="badge fs-6" id="detailMenuIsAvailable"></span>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="orderModalLabel">Keranjang Pesanan Anda</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="orderForm" method="POST" action="{{ route('orders-user.store') }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="cartTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Harga</th>
                                        <th>Kuantitas</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="3" class="text-end">Total:</th>
                                        <th id="cartTotal" class="text-primary fs-5">Rp 0</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="mb-3">
                            <label for="orderNotes" class="form-label">Catatan Pesanan (opsional)</label>
                            <textarea class="form-control" id="orderNotes" name="notes" rows="3"
                                placeholder="Contoh: Pedas, tanpa bawang, dll."></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="confirmOrderBtn">
                                <i class="bi bi-check-circle-fill"></i> Konfirmasi Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        document.addEventListener('DOMContentLoaded', function() {
            updateCartBadge();

            document.querySelectorAll('.filter-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove(
                        'active'));
                    this.classList.add('active');
                    const category = this.dataset.category;
                    filterMenus(category);
                });
            });
        });

        function filterMenus(category) {
            document.querySelectorAll('.menu-card').forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function updateCartBadge() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cartBadge').textContent = totalItems;
        }

        function openDetailMenuModal(id) {
            fetch('{{ url('menus-user') }}/' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailMenuItemName').textContent = data.item_name;
                    document.getElementById('detailMenuDescription').textContent = data.description ||
                        'Tidak ada deskripsi.';
                    document.getElementById('detailMenuPrice').textContent = 'Rp ' + parseFloat(data.price)
                        .toLocaleString('id-ID');
                    document.getElementById('detailMenuCategory').textContent = data.category || 'Tidak Berkategori';
                    const isAvailableBadge = document.getElementById('detailMenuIsAvailable');
                    if (data.is_available) {
                        isAvailableBadge.textContent = 'Tersedia';
                        isAvailableBadge.className = 'badge bg-success fs-6';
                    } else {
                        isAvailableBadge.textContent = 'Tidak Tersedia';
                        isAvailableBadge.className = 'badge bg-danger fs-6';
                    }
                    const menuImage = document.getElementById('detailMenuImage');
                    if (data.image_url) {
                        menuImage.src = data.image_url;
                    } else {
                        menuImage.src =
                            'https://via.placeholder.com/200?text=No+Image'; // Placeholder jika tidak ada gambar
                    }

                    var detailMenuModal = new bootstrap.Modal(document.getElementById('detailMenuModal'));
                    detailMenuModal.show();
                })
                .catch(error => console.error('Error fetching menu details:', error));
        }

        function addToCart(menuId, itemName, price) {
            const existingItemIndex = cart.findIndex(item => item.menu_id === menuId);

            if (existingItemIndex > -1) {
                cart[existingItemIndex].quantity++;
            } else {
                cart.push({
                    menu_id: menuId,
                    item_name: itemName,
                    price: price,
                    quantity: 1
                });
            }
            updateCartBadge();
            // Optional: Show a toast notification or temporary message "Added to cart"
            alert(`${itemName} ditambahkan ke keranjang!`); // Ganti dengan notifikasi yang lebih baik
        }

        function updateQuantity(index, change) {
            cart[index].quantity += change;
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
            updateCartModalTable();
            updateCartBadge();
        }

        function removeItem(index) {
            cart.splice(index, 1);
            updateCartModalTable();
            updateCartBadge();
        }

        function updateCartModal() {
            updateCartModalTable(); // Panggil fungsi untuk memperbarui isi tabel keranjang
            var orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
            orderModal.show();
        }

        function updateCartModalTable() {
            const cartTableBody = document.querySelector('#cartTable tbody');
            cartTableBody.innerHTML = '';
            let totalAmount = 0;
            const confirmOrderBtn = document.getElementById('confirmOrderBtn');

            if (cart.length === 0) {
                cartTableBody.innerHTML =
                    '<tr><td colspan="5" class="text-center text-muted py-4">Keranjang Anda kosong. Tambahkan menu dari daftar.</td></tr>';
                confirmOrderBtn.disabled = true; // Disable tombol jika keranjang kosong
            } else {
                confirmOrderBtn.disabled = false; // Enable tombol jika ada item
                cart.forEach((item, index) => {
                    const subtotal = item.price * item.quantity;
                    totalAmount += subtotal;

                    const row = `
                        <tr>
                            <td>${item.item_name}</td>
                            <td>Rp ${item.price.toLocaleString('id-ID')}</td>
                            <td>
                                <div class="input-group input-group-sm" style="width: 120px;">
                                    <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(${index}, -1)">-</button>
                                    <input type="text" class="form-control text-center" value="${item.quantity}" readonly>
                                    <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(${index}, 1)">+</button>
                                    <input type="hidden" name="items[${index}][menu_id]" value="${item.menu_id}">
                                    <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                                </div>
                            </td>
                            <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    cartTableBody.innerHTML += row;
                });
            }

            document.getElementById('cartTotal').textContent = 'Rp ' + totalAmount.toLocaleString('id-ID');
        }
    </script>
@endsection
