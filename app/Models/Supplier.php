<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * Secara eksplisit memberitahu Laravel untuk menggunakan tabel 'supplier'.
     *
     * @var string
     */
    protected $table = 'supplier';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'supplier_name',
        'contact_name',
        'phone',
        'address',
        'notes',
        'status'
    ];

    public function get_supplier(){
        // Karena tabel supplier tidak perlu join, kita hanya select semua datanya
        $sql = $this->select("supplier.*");
        return $sql;
    }

    /**
     * storeSupplier
     *
     * @param  mixed $request
     * @return void
     */
    public static function storeSupplier($request)
    {
        // Simpan supplier baru menggunakan mass assignment
        return self::create([
            'supplier_name' => $request->supplier_name,
            'contact_name'  => $request->contact_name,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'notes'         => $request->notes
        ]);
    }

    /**
     * updateSupplier
     *
     * @param  mixed $id
     * @param  mixed $request
     * @return void
     */
    public static function updateSupplier($id, $request)
    {
        $supplier = self::find($id);

        if ($supplier) {
            $data = [
                'supplier_name' => $request['supplier_name'],
                'contact_name'  => $request['contact_name'],
                'phone'         => $request['phone'],
                'address'       => $request['address'],
                'notes'         => $request['notes'],
            ];

            $supplier->update($data);
            return $supplier;
        } else {
            return "tidak ada data yang diupdate";
        }
    }
}