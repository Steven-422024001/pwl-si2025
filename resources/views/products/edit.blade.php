@extends('layouts.app')

@section('title', 'Edit Product - ' . $data['product']->title)

@section('content')
<div class="container-fluid bg-light p-4 rounded-4" style="min-height: 100vh;">
    <div class="bg-white shadow-sm rounded-4 p-4">
        <h4 class="fw-bold mb-4">Edit Product</h4>
        <p class="text-muted mb-4">You are editing: <strong>{{ $data['product']->title }}</strong></p>

        <form action="{{ route('products.update', $data['product']->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Gambar Produk --}}
                <div class="col-md-4 text-center">
                    <div class="border rounded-4 shadow-sm p-3 bg-light mb-4">
                        @if ($data['product']->image)
                            <img 
                                src="{{ asset('storage/images/' . $data['product']->image) }}" 
                                alt="{{ $data['product']->title }}" 
                                class="img-fluid rounded-3" 
                                style="max-height: 250px; object-fit: contain;">
                        @else
                            <div class="text-muted small fst-italic">No image available</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="fw-semibold">Change Image</label>
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
                            @foreach ($product['categories'] as $category)
                                <option value="{{ $category->id }}" 
                                    @if(old('product_category_id', $data['product']->product_category_id) == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
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
                            @foreach ($product['suppliers_'] as $supplier)
                                <option value="{{ $supplier->id }}" 
                                    @if(old('supplier_id', $data['product']->supplier_id) == $supplier->id) selected @endif>
                                    {{ $supplier->supplier_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               name="title" value="{{ old('title', $data['product']->title) }}" 
                               placeholder="Enter Product Title">
                        @error('title')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                   <div class="mb-3">
                        <label class="fw-semibold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                name="description" rows="5"
                                placeholder="Enter Product Description">{{ strip_tags(old('description', $data['product']->description)) }}</textarea>
                        @error('description')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Price</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   name="price" value="{{ old('price', $data['product']->price) }}" 
                                   placeholder="Enter Product Price">
                            @error('price')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Stock</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   name="stock" value="{{ old('stock', $data['product']->stock) }}" 
                                   placeholder="Enter Product Stock">
                            @error('stock')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-secondary px-4 rounded-3">Update</button>
                        <button type="reset" class="btn btn-warning px-4 rounded-3 text-white">Reset</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4 rounded-3">Cancel</a>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>
@endsection