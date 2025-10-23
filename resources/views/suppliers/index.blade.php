@extends('layouts.app')

@section('title', 'Supplier Management - Mofu Cafe')
@section('page-title', 'Supplier Management')

@push('styles')
<style>
    .summary-card {
        background-color: #fff;
        border: 2px solid var(--mofu-light-border);
        border-radius: 0.75rem;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .summary-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.75rem;
    }
    .summary-value {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
    }
    .summary-title {
        font-size: 0.9rem;
        color: var(--mofu-text-muted);
    }

    /* Varian Warna */
    .summary-card--total .summary-icon { background-color: #e0f3ff; border: 3px solid #bde6ff; color: #007bff; }
    .summary-card--total .summary-value { color: #007bff; }

    .summary-card--active .summary-icon { background-color: #e6fffa; border: 3px solid #b3f5e9; color: #1abc9c; }
    .summary-card--active .summary-value { color: #1abc9c; }

    .summary-card--idle .summary-icon { background-color: #fff8e1; border: 3px solid #ffecb3; color: #f39c12; }
    .summary-card--idle .summary-value { color: #f39c12; }

    .summary-card--inactive .summary-icon { background-color: #f1f2f6; border: 3px solid #dfe4ea; color: #576574; }
    .summary-card--inactive .summary-value { color: #576574; }
</style>
@endpush

@section('content')

    {{-- Bagian 1: Ringkasan Status (KPI Cards) --}}
    <div class="row mb-5">
        {{-- Card Total Suppliers --}}
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="summary-card summary-card--total">
                <div class="summary-icon">
                    <i class="fas fa-truck-field"></i>
                </div>
                <div>
                    <p class="summary-title mb-1">Total Suppliers</p>
                    <h3 class="summary-value">{{ $totalSuppliers }}</h3>
                </div>
            </div>
        </div>
        {{-- Card Active Suppliers --}}
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="summary-card summary-card--active">
                <div class="summary-icon">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <p class="summary-title mb-1">Active Suppliers</p>
                    <h3 class="summary-value">{{ $activeCount }}</h3>
                </div>
            </div>
        </div>
        {{-- Card Idle Suppliers --}}
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="summary-card summary-card--idle">
                <div class="summary-icon">
                    <i class="fas fa-pause"></i>
                </div>
                <div>
                    <p class="summary-title mb-1">Idle Suppliers</p>
                    <h3 class="summary-value">{{ $idleCount }}</h3>
                </div>
            </div>
        </div>
        {{-- Card Inactive Suppliers --}}
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="summary-card summary-card--inactive">
                <div class="summary-icon">
                    <i class="fas fa-times"></i>
                </div>
                <div>
                    <p class="summary-title mb-1">Inactive Suppliers</p>
                    <h3 class="summary-value">{{ $inactiveCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian 2: Tabel Data --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h5 class="card-title mb-0 fw-bold">All Suppliers</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('suppliers.create') }}" class="btn btn-add-new">
                    <i class="fas fa-plus"></i> Add Supplier
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-3">SUPPLIER NAME</th>
                        <th scope="col">PHONE</th>
                        <th scope="col">STATUS</th>
                        <th scope="col">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr>
                            <td class="ps-3">{{ $supplier->supplier_name }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>
                                @if($supplier->status == 'Active')
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill">{{ $supplier->status }}</span>
                                @elseif($supplier->status == 'Idle')
                                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">{{ $supplier->status }}</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">{{ $supplier->status }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 action-buttons">
                                    <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-sm btn-dark" title="Show"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">Data Suppliers belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Showing {{ $suppliers->firstItem() }} to {{ $suppliers->lastItem() }} of {{ $suppliers->total() }} results
            </div>
            <div>
                {!! $suppliers->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Notifikasi dari session (setelah create/update)
        @if(session('success'))
            Swal.fire({
                icon: "success", title: "BERHASIL", text: "{{ session('success') }}",
                showConfirmButton: false, timer: 2000
            });
        @elseif(session('error'))
            Swal.fire({
                icon: "error", title: "GAGAL", text: "{{ session('error') }}",
                showConfirmButton: false, timer: 2000
            });
        @endif

        // Konfirmasi hapus untuk setiap form dengan class '.form-delete'
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