@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Edit Supplier</h5>
            <p class="text-muted mb-0">Update supplier data for {{ $supplier->supplier_name }}.</p>
        </div>
        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Back to List</a>
    </div>

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                {{-- Kolom Kiri: Input Utama --}}
                <div class="mb-3">
                    <label for="supplier_name" class="form-label fw-semibold">SUPPLIER NAME</label>
                    <input type="text" class="form-control @error('supplier_name') is-invalid @enderror" id="supplier_name" name="supplier_name" value="{{ old('supplier_name', $supplier->supplier_name) }}">
                    @error('supplier_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="contact_name" class="form-label fw-semibold">CONTACT NAME (PIC)</label>
                        <input type="text" class="form-control @error('contact_name') is-invalid @enderror" id="contact_name" name="contact_name" value="{{ old('contact_name', $supplier->contact_name) }}">
                        @error('contact_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label fw-semibold">PHONE</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label fw-semibold">ADDRESS</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $supplier->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                {{-- Kolom Kanan: Status --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">STATUS</label>
                    <div class="btn-group w-100" role="group" aria-label="Status selection">
                        {{-- Menambahkan logika 'checked' untuk memilih status yang sesuai --}}
                        <input type="radio" class="btn-check" name="status" id="status_active" value="Active" autocomplete="off" {{ $supplier->status == 'Active' ? 'checked' : '' }}>
                        <label class="btn btn-outline-success" for="status_active">Active</label>

                        <input type="radio" class="btn-check" name="status" id="status_idle" value="Idle" autocomplete="off" {{ $supplier->status == 'Idle' ? 'checked' : '' }}>
                        <label class="btn btn-outline-warning" for="status_idle">Idle</label>

                        <input type="radio" class="btn-check" name="status" id="status_inactive" value="Inactive" autocomplete="off" {{ $supplier->status == 'Inactive' ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger" for="status_inactive">Inactive</label>
                    </div>
                </div>
                 <div class="mb-3">
                    <label for="notes" class="form-label fw-semibold">NOTES</label>
                    <textarea class="form-control" name="notes" id="notes" rows="4">{{ old('notes', $supplier->notes) }}</textarea>
                </div>
            </div>
        </div>
        
        <div class="mt-4 border-top pt-4">
            <button type="submit" class="btn btn-primary">UPDATE SUPPLIER</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">CANCEL</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
{{-- Script untuk CKEditor jika Anda ingin menggunakannya di sini --}}
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('notes');
</script>
@endsection