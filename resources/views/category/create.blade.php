@extends('layouts.app')

@section('title', 'Add New Category')
@section('page-title', 'Add New Category')

@section('content')
<div class="content-card">
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Add New Category</h5>
            <p class="text-muted mb-0">Buat kategori baru untuk produk Anda.</p>
        </div>
        <a href="{{ route('category.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    {{-- Form --}}
    <form id="categoryForm" action="{{ route('category.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">CATEGORY NAME</label>
            <input 
                type="text" 
                class="form-control @error('name') is-invalid @enderror" 
                id="name" 
                name="name" 
                value="{{ old('name') }}" 
                placeholder="e.g., Coffee, Non-Coffee, Pastry">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-semibold">DESCRIPTION</label>
            <textarea 
                class="form-control @error('description') is-invalid @enderror" 
                name="description" 
                id="description" 
                rows="5" 
                placeholder="Masukkan deskripsi singkat mengenai kategori ini">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-4 border-top pt-4">
            <button type="submit" class="btn btn-primary">SAVE CATEGORY</button>
            <a href="{{ route('category.index') }}" class="btn btn-secondary">CANCEL</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>
@endsection
