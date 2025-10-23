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
        Schema::create('transaksi_penjualan', function (Blueprint $table) {
            $table->id(); // int, autoincrement, primary key
            $table->string('nama_kasir', 50);
            $table->text('nama_pembeli')->nullable(); // Boleh kosong
            $table->decimal('total_harga', 10, 2); // Total harga akhir
            $table->string('metode_pembayaran', 20)->nullable();
            $table->timestamp('tanggal_transaksi')->useCurrent(); // Otomatis diisi waktu saat ini
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_penjualan');
    }
};