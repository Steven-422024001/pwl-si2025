<?php

// app/Models/DetailTransaksiPenjualan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksiPenjualan extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_transaksi_penjualan',
        'id_product',
        'jumlah_pembelian',
        'subtotal_harga',
    ];

    /**
     * Mendefinisikan nama tabel secara eksplisit
     */
    protected $table = 'detail_transaksi_penjualan';

    /**
     * Relasi "belongs-to": Setiap detail PASTI milik SATU Transaksi.
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'id_transaksi_penjualan');
    }

    /**
     * Relasi "belongs-to": Setiap detail merujuk ke SATU Produk.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}