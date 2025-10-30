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
        Schema::table('transaksi_penjualan', function (Blueprint $table) {
            // INI UNTUK MENAMBAHKAN KOLOM
            $table->string('email_pembeli')->nullable()->after('nama_pembeli');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_penjualan', function (Blueprint $table) {
            // INI UNTUK MENGHAPUS KOLOM JIKA DI-ROLLBACK
            $table->dropColumn('email_pembeli');
        });
    }
};