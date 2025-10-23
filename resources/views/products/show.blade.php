@extends('layouts.app')

@section('title', 'Product Details - ' . $product->product_name)

@section('content')
<div class="container-fluid bg-light p-4 rounded-4" style="min-height: 100vh;">
    <div class="bg-white shadow-sm rounded-4 p-4">
        <h4 class="fw-bold mb-4">Product Details</h4>
        <p class="text-muted mb-4">Viewing details for<strong>{{ $product->product_name }}</strong></p>

        <div class="row mb-4">
            {{-- Gambar Produk --}}
            <div class="col-md-4 text-center">
                <div class="border rounded-4 shadow-sm p-3 bg-light">
                    @if ($product->image)
                        <img 
                            src="{{ asset('storage/images/' . $product->image) }}" 
                            alt="{{ $product->product_name }}" 
                            class="img-fluid rounded-3" 
                            style="max-height: 250px; object-fit: contain;"
                        >
                    @else
                        <div class="text-muted small fst-italic">No image available</div>
                    @endif
                </div>
            </div>

            {{-- Detail Produk --}}
            <div class="col-md-8">
                <div class="mb-3">
                    <h5 class="fw-bold text-capitalize">{{ $product->product_name }}</h5>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">CATEGORY</label>
                    <p class="fw-semibold text-dark">{{ $product->product_category_name }}</p>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">SUPPLIER</label>
                    <p class="fw-semibold text-dark">{{ $product->supplier_name }}</p>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">PRICE</label>
                    <p class="fw-semibold text-dark">Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">DESCRIPTION</label>
                    <div class="p-2 bg-light rounded border">{!! $product->description !!}</div>
                </div>

                <div class="mb-4">
                    <label class="text-muted small">STOCK</label>
                    <p class="fw-semibold text-dark">{{ $product->stock }}</p>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary rounded-3 px-4">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection