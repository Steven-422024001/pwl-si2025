<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category_product;
use App\Models\TransaksiPenjualan;
use App\Models\DetailTransaksiPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

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
        'nama_pembeli'      => 'nullable|string|max:100', // <-- DIUBAH (tambah validasi)
        'email_pembeli'     => 'required|email',          // <-- DIUBAH (tambah validasi)
        'metode_pembayaran' => 'required|in:Cash,QRIS,Card',
        'products'          => 'required|array|min:1',
        'products.*.id'     => 'required|integer|exists:products,id',
        'products.*.jumlah'   => 'required|integer|min:1',
    ]);

    $transaksi = null;

    DB::transaction(function () use ($request, &$transaksi) { 
        $transaksi = new TransaksiPenjualan();
        $transaksi->nama_kasir = $request->nama_kasir;
        $transaksi->nama_pembeli = $request->nama_pembeli;
        $transaksi->email_pembeli = $request->email_pembeli; 
        $transaksi->metode_pembayaran = $request->metode_pembayaran;
        $transaksi->total_harga = 0;
        $transaksi->save(); // Transaksi disimpan pertama kali untuk dapat ID

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
        $transaksi->save(); // Simpan lagi untuk update total_harga
    });
    if ($transaksi) {
        $this->kirimEmailTransaksi($transaksi->email_pembeli, $transaksi->id);
    }
    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat dan email terkirim!');
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
            'nama_kasir'        => 'required|string|max:50',
            'nama_pembeli'      => 'nullable|string|max:100', 
            'email_pembeli'     => 'required|email',         
            'metode_pembayaran' => 'required|in:Cash,QRIS,Card',
            'products'          => 'nullable|array',
            'products.*.id'     => 'required_with:products|integer|exists:products,id',
            'products.*.jumlah'   => 'required_with:products|integer|min:1',
        ]);
        
        $transaksi = TransaksiPenjualan::findOrFail($id);

        DB::transaction(function () use ($request, $transaksi) { 
            
       
            $transaksi->update([
                'nama_kasir'        => $request->nama_kasir,
                'nama_pembeli'      => $request->nama_pembeli,
                'email_pembeli'     => $request->email_pembeli, 
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

        // --- (PERUBAHAN 4: Panggil email SETELAH transaksi DB selesai) ---
        $this->kirimEmailTransaksi($transaksi->email_pembeli, $transaksi->id);

        // --- (Ubah pesan sukses) ---
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui dan email terkirim!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $transaksi = TransaksiPenjualan::findOrFail($id);
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    
  private function kirimEmailTransaksi($to, $id)
{
    $transaksi = TransaksiPenjualan::with('details')->find($id);

    if (!$transaksi) {
        return; // Hentikan jika tidak ada
    }

    $data_email = [
        'transaksi' => $transaksi,
        'details'   => $transaksi->details,
    ];

    Mail::send('emails.template_transaksi', $data_email, function ($message) use ($to, $transaksi) {
        
        $subjectEmail = "Transaksi Details: {$transaksi->nama_pembeli} - dengan total tagihan RP " . number_format($transaksi->total_harga, 2, ',', '.');

        $message->to($to)
                ->subject($subjectEmail);
    });
    }
}