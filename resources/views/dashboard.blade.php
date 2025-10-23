@extends('layouts.app')

@section('title', 'Dashboard - Mofu Cafe')

@section('content')
<style>
    /* ====== DASHBOARD STYLING ====== */
    body {
        background-color: #f8f9fc;
        font-family: 'Poppins', sans-serif;
    }

    /* Sambutan */
    h5.fw-bold {
        color: #1e293b;
    }

    .card.kpi-card {
        border-radius: 16px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .card.kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
    }

    /* Icon bulat di KPI */
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
    }

    /* Kartu konten utama */
    .content-card {
        border-radius: 20px;
        border: none;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    }

    /* Grafik */
    .chart-container {
        position: relative;
        height: 350px;
        max-height: 350px;
    }

    /* List Aktivitas */
    .list-group-item {
        border: none;
        border-bottom: 1px solid #f1f5f9;
        padding: 12px 0;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }

    .fw-semibold {
        color: #1e293b;
    }

    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.8em;
    }

    /* Warna badge lembut */
    .bg-success-subtle {
        background-color: #d1fae5 !important;
    }

    .text-success-emphasis {
        color: #065f46 !important;
    }

    /* Responsif */
    @media (max-width: 768px) {
        .icon-circle {
            width: 45px;
            height: 45px;
            font-size: 20px;
        }
    }
</style>

{{-- Header Sambutan --}}
<div class="mb-4">
    <h5 class="fw-bold">Selamat Datang, Admin Mofu! 👋</h5>
    <p class="text-muted">Berikut adalah ringkasan aktivitas di Mofu Cafe hari ini.</p>
</div>



{{-- KPI Cards --}}
<div class="row">
    <div class="col-md-6 col-lg-3 mb-4">
        <a href="{{ route('transaksi.index') }}" class="text-decoration-none">
            <div class="card kpi-card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-circle bg-success text-white">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Pendapatan Hari Ini</h6>
                        <h4 class="card-title mb-0 text-dark">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <a href="{{ route('transaksi.index') }}" class="text-decoration-none">
            <div class="card kpi-card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-circle bg-primary text-white">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Transaksi Hari Ini</h6>
                        <h4 class="card-title mb-0 text-dark">{{ $jumlahTransaksiHariIni }} Transaksi</h4>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <a href="{{ route('products.index') }}" class="text-decoration-none">
            <div class="card kpi-card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-circle bg-warning text-white">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Total Produk</h6>
                        <h4 class="card-title mb-0 text-dark">{{ $totalProduk }} Jenis</h4>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <a href="{{ route('suppliers.index') }}" class="text-decoration-none">
            <div class="card kpi-card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-circle bg-danger text-white">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Total Supplier</h6>
                        <h4 class="card-title mb-0 text-dark">{{ $totalSupplier }} Supplier</h4>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

{{-- Konten Utama: Grafik dan Aktivitas Terbaru --}}
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card content-card h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold">Pendapatan 7 Hari Terakhir</h5>
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card content-card h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3">Aktivitas Terbaru</h5>
                <ul class="list-group list-group-flush">
                    @forelse($aktivitasTerbaru as $aktivitas)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <p class="fw-semibold mb-0">Transaksi #{{ $aktivitas->id }}</p>
                                <small class="text-muted">{{ count($aktivitas->details) }} item oleh {{ $aktivitas->nama_kasir }}</small>
                            </div>
                            <span class="badge bg-success-subtle text-success-emphasis rounded-pill">
                                Rp {{ number_format($aktivitas->total_harga, 0, ',', '.') }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item px-0">Tidak ada aktivitas terbaru.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Pendapatan',
                data: @json($chartData),
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.parsed.y !== null) {
                                label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection