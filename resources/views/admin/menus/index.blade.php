@extends('layouts.main')

@section('title', 'Daftar Menu')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Menu Restoran</h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createMenuModal">
                            Tambah Menu
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
                                        <th>Gambar</th>
                                        <th>Nama Item</th>
                                        <th>Harga</th>
                                        <th>Kategori</th>
                                        <th>Ketersediaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($menu->image_url)
                                                    <img src="{{ asset($menu->image_url) }}" alt="{{ $menu->item_name }}"
                                                        class="img-thumbnail"
                                                        style="width: 80px; height: 80px; object-fit: cover;">
                                                @else
                                                    <i class="bi bi-image-fill text-muted" style="font-size: 3rem;"></i>
                                                @endif
                                            </td>
                                            <td>{{ $menu->item_name }}</td>
                                            <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                            <td>{{ $menu->category }}</td>
                                            <td>
                                                @if ($menu->is_available)
                                                    <span class="badge bg-success">Tersedia</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Tersedia</span>
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                <div class="dropdown dropup">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton-{{ $menu->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton-{{ $menu->id }}">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="openDetailModal({{ $menu->id }})">Detail</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                                onclick="openEditModal({{ $menu->id }}, '{{ $menu->item_name }}', '{{ $menu->description }}', {{ $menu->price }}, '{{ $menu->category }}', {{ $menu->is_available ? 'true' : 'false' }}, '{{ $menu->image_url ?? '' }}')">Ubah</a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('menus.destroy', $menu->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
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

    <div class="modal fade" id="createMenuModal" tabindex="-1" aria-labelledby="createMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMenuModalLabel">Tambah Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createMenuForm" method="POST" action="{{ route('menus.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="createItemName" class="form-label">Nama Item</label>
                            <input type="text" class="form-control" id="createItemName" name="item_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="createDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="createDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="createMenuImage" class="form-label">Gambar Menu</label>
                            <input type="file" class="form-control" id="createMenuImage" name="menu_image"
                                accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="createPrice" class="form-label">Harga</label>
                            <input type="number" step="0.01" class="form-control" id="createPrice" name="price"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="createCategory" class="form-label">Kategori</label>
                            <select class="form-select" id="createCategory" name="category">
                                <option value="">Pilih Kategori</option>
                                <option value="Makanan Utama">Makanan Utama</option>
                                <option value="Makanan Pembuka">Makanan Pembuka</option>
                                <option value="Makanan Penutup">Makanan Penutup</option>
                                <option value="Minuman Dingin">Minuman Dingin</option>
                                <option value="Minuman Panas">Minuman Panas</option>
                                <option value="Snack">Snack</option>
                                <option value="Paket Hemat">Paket Hemat</option>
                                <option value="Lain-lain">Lain-lain</option>
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="createIsAvailable" name="is_available"
                                value="1" checked>
                            <label class="form-check-label" for="createIsAvailable">
                                Tersedia
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMenuModalLabel">Edit Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editMenuForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editMenuId" name="id">
                        <div class="mb-3">
                            <label for="editItemName" class="form-label">Nama Item</label>
                            <input type="text" class="form-control" id="editItemName" name="item_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editMenuImage" class="form-label">Gambar Menu (Biarkan kosong jika tidak ingin
                                mengubah)</label>
                            <input type="file" class="form-control" id="editMenuImage" name="menu_image"
                                accept="image/*">
                            <small class="text-muted mt-1">Gambar saat ini: <a id="currentMenuImageLink" href="#"
                                    target="_blank">Lihat</a></small>
                            <img id="currentMenuImagePreview" src="" alt="Current Menu Image"
                                class="img-thumbnail mt-2" style="max-width: 150px; display: none;">
                        </div>
                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Harga</label>
                            <input type="number" step="0.01" class="form-control" id="editPrice" name="price"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategory" class="form-label">Kategori</label>
                            <select class="form-select" id="editCategory" name="category">
                                <option value="">Pilih Kategori</option>
                                <option value="Makanan Utama">Makanan Utama</option>
                                <option value="Makanan Pembuka">Makanan Pembuka</option>
                                <option value="Makanan Penutup">Makanan Penutup</option>
                                <option value="Minuman Dingin">Minuman Dingin</option>
                                <option value="Minuman Panas">Minuman Panas</option>
                                <option value="Snack">Snack</option>
                                <option value="Paket Hemat">Paket Hemat</option>
                                <option value="Lain-lain">Lain-lain</option>
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="editIsAvailable" name="is_available"
                                value="1">
                            <label class="form-check-label" for="editIsAvailable">
                                Tersedia
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailMenuModal" tabindex="-1" aria-labelledby="detailMenuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailMenuModalLabel">Detail Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img id="detailMenuImage" src="" alt="Menu Image" class="img-fluid rounded shadow-sm"
                            style="max-height: 200px; object-fit: cover;">
                    </div>
                    <p><strong>Nama Item:</strong> <span id="detailItemName"></span></p>
                    <p><strong>Deskripsi:</strong> <span id="detailDescription"></span></p>
                    <p><strong>Harga:</strong> <span id="detailPrice"></span></p>
                    <p><strong>Kategori:</strong> <span id="detailCategory"></span></p>
                    <p><strong>Ketersediaan:</strong> <span id="detailIsAvailable"></span></p>
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
        function openEditModal(id, itemName, description, price, category, isAvailable, imageUrl) {
            document.getElementById('editItemName').value = itemName;
            document.getElementById('editDescription').value = description;
            document.getElementById('editPrice').value = price;
            document.getElementById('editCategory').value = category;
            document.getElementById('editIsAvailable').checked = isAvailable;
            document.getElementById('editMenuId').value = id;
            document.getElementById('editMenuForm').action = '{{ route('menus.update', '') }}/' +
            id;

            const currentImageLink = document.getElementById('currentMenuImageLink');
            const currentImagePreview = document.getElementById('currentMenuImagePreview');
            if (imageUrl) {
                currentImageLink.href = '{{ asset('') }}' + imageUrl;
                currentImageLink.style.display = 'inline';
                currentImagePreview.src = '{{ asset('') }}' + imageUrl;
                currentImagePreview.style.display = 'block';
            } else {
                currentImageLink.href = '#';
                currentImageLink.style.display = 'none';
                currentImagePreview.style.display = 'none';
            }

            var myModal = new bootstrap.Modal(document.getElementById('editMenuModal'));
            myModal.show();
        }

function openDetailModal(id) {
            fetch('{{ url('menus') }}/' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailItemName').textContent = data.item_name;
                    document.getElementById('detailDescription').textContent = data.description || '-';
                    document.getElementById('detailPrice').textContent = 'Rp ' + parseFloat(data.price).toLocaleString(
                        'id-ID');
                    document.getElementById('detailCategory').textContent = data.category || '-';
                    document.getElementById('detailIsAvailable').textContent = data.is_available ? 'Tersedia' :
                        'Tidak Tersedia';
                    document.getElementById('detailCreatedAt').textContent = new Date(data.created_at).toLocaleString(
                        'id-ID');
                    document.getElementById('detailUpdatedAt').textContent = new Date(data.updated_at).toLocaleString(
                        'id-ID');

                    const detailMenuImage = document.getElementById('detailMenuImage');
                    if (data.image_url) {
                        detailMenuImage.src = '{{ asset('') }}' + data.image_url.substring(1); 
                    } else {
                        detailMenuImage.src =
                            'https://via.placeholder.com/200?text=No+Image';
                    }

                    var detailModal = new bootstrap.Modal(document.getElementById('detailMenuModal'));
                    detailModal.show();
                })
                .catch(error => console.error('Error fetching menu details:', error));
        }
    </script>
@endsection
