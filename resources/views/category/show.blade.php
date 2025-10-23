@extends('layouts.app')

@section('title', 'Category Details')
@section('page-title', 'Category Details')

@section('content')
<div class="content-card">
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Category Details</h5>
        </div>
        <div>
            <a href="{{ route('category.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary">
                <i class="fas fa-pencil-alt me-1"></i> Edit Category
            </a>
        </div>
    </div>

    {{-- Detail Konten --}}
    <div class="mb-4">
        <label class="form-label text-muted small text-uppercase">Category Name</label>
        <p class="fs-4 fw-semibold">{{ $category->name }}</p>
    </div>
    
    <div>
        <label class="form-label text-muted small text-uppercase">Description</label>
        <div class="bg-light p-3 rounded border">
            {!! $category->description ?: '<em>No description provided.</em>' !!}
        </div>
    </div>
</div>
@endsection
