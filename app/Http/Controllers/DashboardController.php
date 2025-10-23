<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard dengan data ringkasan.
     */
    public function index()
    {
        // 1. Data untuk KPI Cards
        $pendapatanHariIni = TransaksiPenjualan::whereDate('created_at', today())->sum('total_harga');
        $jumlahTransaksiHariIni = TransaksiPenjualan::whereDate('created_at', today())->count();
        $totalProduk = Product::count();
        $totalSupplier = Supplier::count();

        // 2. Data untuk Grafik Penjualan 7 Hari Terakhir
        $salesData = TransaksiPenjualan::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_harga) as total')
            )
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Proses data untuk Chart.js
        $chartLabels = [];
        $chartData = [];
        // Inisialisasi 7 hari dengan pendapatan 0
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('D, d M'); // Format: Tue, 14 Oct
            $chartData[$date] = 0;
        }
        foreach ($salesData as $data) {
            $chartData[$data->date] = $data->total;
        }
        $chartData = array_values($chartData);


        // 3. Data untuk Aktivitas Terbaru
        $aktivitasTerbaru = TransaksiPenjualan::with('details.product')
            ->latest()
            ->take(5) // Ambil 5 transaksi terakhir
            ->get();

        // 4. Kirim semua data ke view
        return view('dashboard', compact(
            'pendapatanHariIni',
            'jumlahTransaksiHariIni',
            'totalProduk',
            'totalSupplier',
            'chartLabels',
            'chartData',
            'aktivitasTerbaru'
        ));
    }
}