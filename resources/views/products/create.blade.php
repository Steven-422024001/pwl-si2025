@extends('layouts.app')

@section('title', 'Add New Product - Mofu Cafe')

@section('content')
<div class="container-fluid bg-light p-4 rounded-4" style="min-height: 100vh;">
    <div class="bg-white shadow-sm rounded-4 p-4">
        <h4 class="fw-bold mb-4">Add New Product</h4>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                {{-- Gambar Produk --}}
                <div class="col-md-4 text-center">
                    <div class="border rounded-4 shadow-sm p-3 bg-light mb-4">
                        <div class="text-muted small fst-italic">No image selected</div>
                    </div>

                    <div class="form-group">
                        <label class="fw-semibold">Upload Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                        @error('image')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Form Detail --}}
                <div class="col-md-8">

                    <div class="mb-3">
                        <label for="product_category_id" class="fw-semibold">Category</label>
                        <select class="form-control" id="product_category_id" name="product_category_id">
                            <option value="">-- Select Category Product --</option>
                            @foreach ($data['categories'] as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('product_category_id')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="supplier_id" class="fw-semibold">Supplier</label>
                        <select class="form-control" id="supplier_id" name="supplier_id">
                            <option value="">-- Select Supplier --</option>
                            @foreach ($data['suppliers'] as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               name="title" value="{{ old('title') }}"
                               placeholder="Enter Product Title">
                        @error('title')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  name="description" rows="5"
                                  placeholder="Enter Product Description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Price</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                   name="price" value="{{ old('price') }}"
                                   placeholder="Enter Product Price">
                            @error('price')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Stock</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                   name="stock" value="{{ old('stock') }}"
                                   placeholder="Enter Product Stock">
                            @error('stock')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-secondary px-4 rounded-3">Save</button>
                        <button type="reset" class="btn btn-warning px-4 rounded-3 text-white">Reset</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4 rounded-3">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- CKEditor versi terbaru --}}
<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>
@endsection