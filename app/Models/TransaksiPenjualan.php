<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransaksiPenjualan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_kasir',
        'nama_pembeli',
        'email_pembeli',
        'metode_pembayaran',
        'total_harga',
    ];

    /**
     * Nama tabel yang digunakan.
     */
    protected $table = 'transaksi_penjualan';

    /**
     * Relasi one-to-many ke DetailTransaksiPenjualan.
     */
    public function details(): HasMany
    {
        return $this->hasMany(DetailTransaksiPenjualan::class, 'id_transaksi_penjualan');
    }
}