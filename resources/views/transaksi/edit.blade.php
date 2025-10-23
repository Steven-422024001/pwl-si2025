@extends('layouts.app')
@section('title', 'Edit Transaksi #' . $transaksi->id)

@push('styles')
<style>
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
    .product-card { cursor: pointer; transition: transform 0.2s; }
    .product-card:hover { transform: scale(1.05); }
    .product-card img { height: 100px; object-fit: cover; }
    .bill-item { border-bottom: 1px solid #eee; }
</style>
@endpush

@section('content')
<form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" id="transaction-form">
    @csrf
    @method('PUT')
    <div class="row">
        {{-- Kolom Kiri: Pilihan Menu --}}
        <div class="col-lg-7">
            <div class="content-card">
                <h5 class="fw-bold">Choose Menu</h5>
                <div class="nav nav-pills mb-3">
                    <button class="nav-link active" type="button">All Menu</button>
                    @foreach($categories as $category)
                        <button class="nav-link" type="button">{{ $category->category_name }}</button>
                    @endforeach
                </div>
                <div class="product-grid">
                    @foreach($products as $product)
                    <div class="card product-card" onclick="addToBill({{ $product->id }}, '{{ $product->title }}', {{ $product->price }})">
                        <img src="{{ asset('storage/images/' . $product->image) }}" class="card-img-top">
                        <div class="card-body p-2">
                            <h6 class="card-title small fw-bold mb-1">{{ $product->title }}</h6>
                            <p class="card-text small text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Detail Tagihan --}}
        <div class="col-lg-5">
            <div class="content-card">
                <h5 class="fw-bold mb-3">Bill Details</h5>
                <div class="mb-3">
                    <label for="nama_kasir" class="form-label small">Nama Kasir</label>
                    <input type="text" class="form-control" id="nama_kasir" name="nama_kasir" value="{{ old('nama_kasir', $transaksi->nama_kasir) }}" required>
                </div>
                <div class="mb-3">
                    <label for="nama_pembeli" class="form-label small">Nama Pembeli (Opsional)</label>
                    <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" value="{{ old('nama_pembeli', $transaksi->nama_pembeli) }}">
                </div>
                <hr>
                <div id="bill-items"></div>
                <div class="border-top pt-3 mt-3">
                    <div class="d-flex justify-content-between">
                        <span>Total Price:</span>
                        <span id="grand-total" class="fw-bold">Rp 0</span>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="metode_pembayaran" class="form-label small">Metode Pembayaran</label>
                    <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                        <option value="Cash" {{ $transaksi->metode_pembayaran == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="QRIS" {{ $transaksi->metode_pembayaran == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                        <option value="Card" {{ $transaksi->metode_pembayaran == 'Card' ? 'selected' : '' }}>Card</option>
                    </select>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary">Update Transaction</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    let bill = {};
    const billItemsContainer = document.getElementById('bill-items');
    const grandTotalEl = document.getElementById('grand-total');
    const form = document.getElementById('transaction-form');
    
    // Inisialisasi bill dengan data yang sudah ada
    @foreach($transaksi->details as $detail)
        bill[{{ $detail->product->id }}] = {
            id: {{ $detail->product->id }},
            title: '{{ $detail->product->title }}',
            price: {{ $detail->product->price }},
            jumlah: {{ $detail->jumlah_pembelian }}
        };
    @endforeach

    // Panggil renderBill() saat halaman dimuat untuk menampilkan item yang sudah ada
    document.addEventListener('DOMContentLoaded', function() {
        renderBill();
    });

    // Fungsi addToBill, updateQuantity, dan renderBill sama persis dengan di create.blade.php
    function addToBill(id, title, price) { /* ... (Sama seperti di create) ... */ }
    function updateQuantity(id, amount) { /* ... (Sama seperti di create) ... */ }
    function renderBill() { /* ... (Sama seperti di create) ... */ }

    // Salin-tempel fungsi lengkap dari create.blade.php ke sini
    function addToBill(id, title, price) {
        if (bill[id]) {
            bill[id].jumlah++;
        } else {
            bill[id] = { id, title, price, jumlah: 1 };
        }
        renderBill();
    }

    function updateQuantity(id, amount) {
        if (bill[id]) {
            bill[id].jumlah += amount;
            if (bill[id].jumlah <= 0) {
                delete bill[id];
            }
        }
        renderBill();
    }

    function renderBill() {
        billItemsContainer.innerHTML = '';
        let grandTotal = 0;
        const productIds = Object.keys(bill);

        if (productIds.length === 0) {
            billItemsContainer.innerHTML = '<p class="text-center text-muted">Belum ada item dipilih.</p>';
        } else {
            productIds.forEach((id, index) => {
                const item = bill[id];
                const subtotal = item.price * item.jumlah;
                grandTotal += subtotal;

                const itemHtml = `
                    <div class="d-flex justify-content-between align-items-center py-2 bill-item">
                        <div>
                            <p class="fw-bold mb-0">${item.title}</p>
                            <small class="text-muted">Rp ${item.price.toLocaleString('id-ID')}</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${id}, -1)">-</button>
                            <span class="mx-2">${item.jumlah}</span>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${id}, 1)">+</button>
                        </div>
                    </div>
                    <input type="hidden" name="products[${index}][id]" value="${item.id}">
                    <input type="hidden" name="products[${index}][jumlah]" value="${item.jumlah}">
                `;
                billItemsContainer.innerHTML += itemHtml;
            });
        }
        grandTotalEl.textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }
</script>
@endsection