<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category_product;
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TransaksiController extends Controller
{
    public function index(): View
    {
        $pendapatanHariIni = TransaksiPenjualan::whereDate('created_at', today())->sum('total_harga');
        $jumlahTransaksiHariIni = TransaksiPenjualan::whereDate('created_at', today())->count();
        $transaksis = TransaksiPenjualan::with('details.product')->latest()->paginate(8);
        return view('transaksi.index', compact('transaksis', 'pendapatanHariIni', 'jumlahTransaksiHariIni'));
    }

    public function create(): View
    {
        $products = Product::orderBy('title')->get();
        $categories = Category_product::all(); // Mengambil data kategori untuk filter
        return view('transaksi.create', compact('products', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_kasir'        => 'required|string|max:50',
            'metode_pembayaran' => 'required|in:Cash,QRIS,Card',
            'products'          => 'required|array|min:1',
            'products.*.id'     => 'required|integer|exists:products,id',
            'products.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $transaksi = new TransaksiPenjualan();
            $transaksi->nama_kasir = $request->nama_kasir;
            $transaksi->nama_pembeli = $request->nama_pembeli;
            $transaksi->metode_pembayaran = $request->metode_pembayaran;
            $transaksi->total_harga = 0;
            $transaksi->save();
            $grandTotal = 0;
            foreach ($request->products as $productData) {
                $product = Product::find($productData['id']);
                $subtotal = $product->price * $productData['jumlah'];
                $transaksi->details()->create([
                    'id_product' => $product->id,
                    'jumlah_pembelian' => $productData['jumlah'],
                    'subtotal_harga' => $subtotal,
                ]);
                $grandTotal += $subtotal;
            }
            $transaksi->total_harga = $grandTotal;
            $transaksi->save();
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat!');
    }

    public function show(string $id): View
    {
        $transaksi = TransaksiPenjualan::with('details.product')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(string $id): View
    {
        $transaksi = TransaksiPenjualan::with('details.product')->findOrFail($id);
        $products = Product::orderBy('title')->get(); // Semua produk untuk ditambahkan
        $categories = Category_product::all(); // Semua kategori untuk filter
        return view('transaksi.edit', compact('transaksi', 'products', 'categories'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'nama_kasir' => 'required|string|max:50',
            'metode_pembayaran' => 'required|in:Cash,QRIS,Card',
            'products' => 'nullable|array', // Products bisa jadi kosong jika semua dihapus
            'products.*.id' => 'required_with:products|integer|exists:products,id',
            'products.*.jumlah' => 'required_with:products|integer|min:1',
        ]);
        
        DB::transaction(function () use ($request, $id) {
            $transaksi = TransaksiPenjualan::with('details')->findOrFail($id);
            // Update header
            $transaksi->update([
                'nama_kasir' => $request->nama_kasir,
                'nama_pembeli' => $request->nama_pembeli,
                'metode_pembayaran' => $request->metode_pembayaran
            ]);

            // Sinkronisasi item detail
            $transaksi->details()->delete(); // Hapus semua item lama
            $grandTotal = 0;

            if ($request->has('products')) {
                foreach ($request->products as $productData) {
                    $product = Product::find($productData['id']);
                    $subtotal = $product->price * $productData['jumlah'];
                    $transaksi->details()->create([
                        'id_product' => $product->id,
                        'jumlah_pembelian' => $productData['jumlah'],
                        'subtotal_harga' => $subtotal,
                    ]);
                    $grandTotal += $subtotal;
                }
            }
            
            // Update total harga
            $transaksi->total_harga = $grandTotal;
            $transaksi->save();
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }
    
    public function destroy(string $id): RedirectResponse
    {
        $transaksi = TransaksiPenjualan::findOrFail($id);
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}