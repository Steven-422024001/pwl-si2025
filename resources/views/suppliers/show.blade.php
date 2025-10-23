@extends('layouts.app')

@section('title', 'Supplier Details - ' . $supplier->supplier_name)

@section('content')
<div class="content-card">
    {{-- Header Halaman --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h5 class="fw-bold mb-1">Supplier Details</h5>
            <p class="text-muted mb-0">Viewing details for: {{ $supplier->supplier_name }}</p>
        </div>
        <div>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Back to List</a>
            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-primary">Edit Supplier</a>
        </div>
    </div>

    {{-- Detail Konten --}}
    <div class="row">
        <div class="col-md-6">
            <div class="mb-4">
                <label class="form-label text-muted small text-uppercase">Supplier Name</label>
                <p class="fs-5 fw-semibold">{{ $supplier->supplier_name }}</p>
            </div>
            <div class="mb-4">
                <label class="form-label text-muted small text-uppercase">Contact Name (PIC)</label>
                <p class="fs-5">{{ $supplier->contact_name ?: '-' }}</p>
            </div>
             <div class="mb-4">
                <label class="form-label text-muted small text-uppercase">Phone</label>
                <p class="fs-5">{{ $supplier->phone }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-4">
                <label class="form-label text-muted small text-uppercase">Status</label>
                <p class="fs-5">
                    @if($supplier->status == 'Active')
                        <span class="badge bg-success-subtle text-success-emphasis rounded-pill fs-6">{{ $supplier->status }}</span>
                    @elseif($supplier->status == 'Idle')
                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill fs-6">{{ $supplier->status }}</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill fs-6">{{ $supplier->status }}</span>
                    @endif
                </p>
            </div>
            <div class="mb-4">
                <label class="form-label text-muted small text-uppercase">Address</label>
                <p class="fs-5">{{ $supplier->address ?: '-' }}</p>
            </div>
        </div>
    </div>
    
    <hr class="my-3">
    
    <div>
        <label class="form-label text-muted small text-uppercase">Notes</label>
        <div class="bg-light p-3 rounded border">
            {!! $supplier->notes ?: '<em>No notes provided.</em>' !!}
        </div>
    </div>
</div>
@endsection