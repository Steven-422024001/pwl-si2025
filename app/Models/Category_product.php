<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_product extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan.
     */
    protected $table = 'category_product';

    /**
     * Atribut yang bisa diisi (mass assignable).
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relasi: satu kategori punya banyak produk.
     * Ini diperlukan agar withCount('products') berfungsi.
     */
    public function products()
    {
        // Ganti 'product_category_id' dengan nama foreign key yang sesuai di tabel 'products'
        return $this->hasMany(Product::class, 'product_category_id');
    }

    /**
     * Ambil semua kategori produk.
     */
    public function get_category_product()
    {
        return $this->select('*');
    }

    /**
     * Simpan data kategori baru.
     */
    public function storeCategory($request)
    {
        return $this->create([
            'name'        => $request->name,
            'description' => $request->description
        ]);
    }

    /**
     * Update data kategori.
     */
    public function updateCategory($id, $request)
    {
        $category = $this->findOrFail($id);

        return $category->update([
            'name'        => $request->name,
            'description' => $request->description
        ]);
    }
}
