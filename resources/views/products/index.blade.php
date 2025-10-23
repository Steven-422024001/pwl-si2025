@extends('layouts.app')

@section('title', 'Daftar Produk')
@section('page-title', 'Product Management')

@push('styles')
{{-- CSS untuk tampilan grid kartu produk --}}
<style>
    /* Styling untuk Grid Container */
    .product-grid {
        display: grid;
        /* Membuat kolom responsif: minimal 250px, dan akan mengisi ruang yang ada */
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 24px; /* Jarak antar kartu */
    }

    /* Styling untuk setiap Kartu Produk */
    .product-card {
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        display: flex;
        flex-direction: column; /* Menyusun item di dalam kartu secara vertikal */
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    /* Styling Gambar */
    .product-image-container {
        width: 100%;
        height: 200px; /* Tinggi gambar dibuat seragam */
        padding: 10px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; /* Agar gambar tidak gepeng atau terpotong */
    }

    /* Styling Info Produk */
    .product-info {
        padding: 16px;
        flex-grow: 1; /* Membuat bagian ini mengisi ruang kosong di kartu */
        display: flex;
        flex-direction: column;
    }

    .product-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #212529;
        /* Mencegah judul yang terlalu panjang merusak layout */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 12px;
    }

    .product-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: auto; /* Mendorong meta ke bagian bawah info */
    }

    /* Styling Tombol Aksi */
    .product-actions {
        padding: 16px;
        border-top: 1px solid #e9ecef;
        background-color: #f8f9fa;
    }
</style>
@endpush


@section('content')
<div class="content-card">
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Product Overview</h5>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Product
        </a>
    </div>

    {{-- Grid untuk menampilkan kartu produk --}}
    <div class="product-grid">
        @forelse ($products as $product)
            {{-- Ini adalah satu kartu produk --}}
            <div class="product-card">
                {{-- Bagian Gambar --}}
                <div class="product-image-container">
                    <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->title }}">
                </div>

                {{-- Bagian Info Produk --}}
                <div class="product-info">
                    <h5 class="product-title" title="{{ $product->title }}">{{ $product->title }}</h5>
                    <p class="product-price">{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</p>
                    <div class="product-meta">
                        <span><strong>Stok:</strong> {{ $product->stock }}</span>
                        <span>{{ $product->product_category_name ?? 'N/A' }}</span>
                    </div>
                </div>

                {{-- Bagian Tombol Aksi --}}
                <div class="product-actions">
                    <form onsubmit="return false;" action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-flex gap-2 form-delete">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-dark btn-sm flex-grow-1">SHOW</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm flex-grow-1">EDIT</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm flex-grow-1 btn-delete">HAPUS</button>
                    </form>
                </div>
            </div>
        @empty
            {{-- Pesan jika tidak ada produk, dibuat full width --}}
            <div class="alert alert-secondary text-center" style="grid-column: 1 / -1;">
                Data produk kosong.
            </div>
        @endforelse
    </div>

    {{-- Paginasi (Tidak diubah) --}}
    @if ($products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {!! $products->links('pagination::bootstrap-5') !!}
        </div>
    @endif
</div>
@endsection

@section('scripts')
{{-- Kode Javascript SweetAlert (Tidak diubah) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Notifikasi sukses atau gagal
    @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "BERHASIL",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "GAGAL",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    // Konfirmasi hapus data
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.form-delete').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin hapus data ini?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    });
</script>
@endsection