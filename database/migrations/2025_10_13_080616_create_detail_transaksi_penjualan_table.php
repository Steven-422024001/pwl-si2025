<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_transaksi_penjualan', function (Blueprint $table) {
            $table->id(); // int, autoincrement, primary key
            
            // Kolom Foreign Key ke tabel transaksi_penjualan
            $table->foreignId('id_transaksi_penjualan')
                  ->constrained('transaksi_penjualan')
                  ->onDelete('cascade'); // Jika transaksi dihapus, detailnya ikut terhapus

            // Kolom Foreign Key ke tabel products
            $table->foreignId('id_product')
                  ->constrained('products'); // Asumsi nama tabel produk adalah 'products'
            
            $table->integer('jumlah_pembelian');
            $table->decimal('subtotal_harga', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi_penjualan');
    }
};